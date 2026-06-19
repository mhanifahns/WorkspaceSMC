<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Trigger background crawl if needed
        $this->check_and_trigger_crawl();

        // Fetch counts
        $data['open_tasks'] = $this->db->where('status !=', 'done')->count_all_results('tasks');
        
        $this->db->select_sum('net_amount');
        $net_query = $this->db->get('incomes')->row();
        $data['net_received'] = $net_query->net_amount ? $net_query->net_amount : 0;

        // Fetch news
        $this->db->where('type', 'news');
        $this->db->order_by('pub_date', 'DESC');
        $data['news'] = $this->db->get('news')->result_array();

        // Fetch tenders
        $this->db->where('type', 'tender');
        $this->db->order_by('pub_date', 'DESC');
        $data['tenders'] = $this->db->get('news')->result_array();

        // Settings
        $data['news_rss_url'] = $this->get_setting('news_rss_url', 'https://dev.to/feed/tag/programming');
        $data['tender_keywords'] = $this->get_setting('tender_keywords', 'software|perangkat lunak|sistem');

        // Fetch notifications
        $this->db->where('is_read', 0);
        $this->db->order_by('created_at', 'DESC');
        $data['notifications'] = $this->db->get('notifications')->result_array();

        $view_data['content'] = $this->load->view('home/index', $data, TRUE);
        $this->load->view('layouts/main', $view_data);
    }

    private function get_setting($key, $default) {
        $this->db->where('key_name', $key);
        $row = $this->db->get('system_logs')->row();
        return $row ? $row->value : $default;
    }
    
    private function set_setting($key, $value) {
        $this->db->where('key_name', $key);
        if ($this->db->get('system_logs')->row()) {
            $this->db->where('key_name', $key);
            $this->db->update('system_logs', ['value' => $value]);
        } else {
            $this->db->insert('system_logs', ['key_name' => $key, 'value' => $value]);
        }
    }

    public function save_settings() {
        $news_rss = $this->input->post('news_rss_url');
        $tender_keywords = $this->input->post('tender_keywords');
        
        if ($news_rss) $this->set_setting('news_rss_url', $news_rss);
        if ($tender_keywords) $this->set_setting('tender_keywords', $tender_keywords);
        
        // Force re-crawl
        $this->db->empty_table('news');
        $this->db->where('key_name', 'last_crawl_date');
        $this->db->delete('system_logs');
        
        $this->session->set_flashdata('success', 'Dashboard Settings Saved & Re-crawling Started!');
        redirect('home');
    }

    public function check_news_status() {
        $news_count = $this->db->where('type', 'news')->count_all_results('news');
        $tender_count = $this->db->where('type', 'tender')->count_all_results('news');
        
        $today = date('Y-m-d');
        $this->db->where('key_name', 'last_crawl_date');
        $log = $this->db->get('system_logs')->row();

        $crawl_count = 0;
        $log_date = '';
        if ($log) {
            $parts = explode('|', $log->value);
            $log_date = $parts[0];
            $crawl_count = isset($parts[1]) ? (int)$parts[1] : 1;
        }

        $did_crawl = false;

        // Reset count if new day
        if ($log_date != $today) {
            $crawl_count = 0;
        }

        // Crawl if missing data or count < 30 for today
        if ($news_count == 0 || $tender_count == 0 || $crawl_count < 30) {
            $did_crawl = true;

            // Dynamic RSS URL
            $news_url = $this->get_setting('news_rss_url', 'https://dev.to/feed/tag/programming');
            $this->fetch_and_save_rss($news_url, 'news');

            // Scrape IASP E-Proc
            $this->fetch_and_save_iasp_tenders();

            // Scrape Pengadaan.com API
            $this->fetch_and_save_pengadaan_tenders();
            
            // Update log
            $new_count = $crawl_count + 1;
            $new_value = $today . '|' . $new_count;

            if (!$log) {
                $this->db->insert('system_logs', ['key_name' => 'last_crawl_date', 'value' => $new_value]);
            } else {
                $this->db->where('key_name', 'last_crawl_date');
                $this->db->update('system_logs', ['value' => $new_value]);
            }

            $news_count = $this->db->where('type', 'news')->count_all_results('news');
            $tender_count = $this->db->where('type', 'tender')->count_all_results('news');
        }

        echo json_encode(['ready' => ($news_count > 0 && $tender_count > 0), 'did_crawl' => $did_crawl]);
    }

    private function check_and_trigger_crawl() {
        // Obsolete, logic moved to check_news_status via AJAX
        // This ensures the frontend spinner continues while backend crawls reliably
    }

    // Obsolete CLI function
    public function crawl_background() {
        if (!is_cli()) {
            echo "This method can only be accessed via CLI";
            return;
        }
    }

    private function fetch_and_save_rss($url, $type) {
        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n"
            ]
        ]);
        
        $rss_content = @file_get_contents($url, false, $context);
        if (!$rss_content) return;

        $xml = @simplexml_load_string($rss_content);
        if (!$xml || !isset($xml->channel->item)) return;

        $items = [];
        $count = 0;
        foreach ($xml->channel->item as $item) {
            if ($count >= 50) break; // Limit to 50 items

            $title = (string)$item->title;
            // Clean up format
            $parts = explode(' - ', $title);
            $source = count($parts) > 1 ? array_pop($parts) : 'Dev.to Community';
            $clean_title = implode(' - ', $parts);

            $desc = (string)$item->description;
            $thumbnail = null;
            if (preg_match('/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $desc, $matches)) {
                $thumbnail = $matches[1];
            }

            $link_str = (string)$item->link;
            $this->db->where('link', $link_str);
            if ($this->db->count_all_results('news') > 0) continue;

            $items[] = [
                'title' => $clean_title,
                'link' => $link_str,
                'source' => trim($source),
                'type' => $type,
                'thumbnail' => $thumbnail,
                'pub_date' => date('Y-m-d H:i:s', strtotime((string)$item->pubDate)),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $count++;
        }

        if (!empty($items)) {
            $this->db->insert_batch('news', $items);
        }
    }

    private function fetch_and_save_iasp_tenders() {
        $url = "https://eproc.iasp.id/pengumuman";
        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
            ]
        ]);
        
        $html = @file_get_contents($url, false, $context);
        if (!$html) return;

        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($doc);

        $cards = $xpath->query("//div[contains(@class, 'card mb-5')]");
        
        $items = [];
        $count = 0;
        
        foreach ($cards as $card) {
            if ($count >= 50) break;
            
            $titleNode = $xpath->query(".//div[@class='blog-content']/p", $card)->item(0);
            $dateNode = $xpath->query(".//div[@class='blog-date']/a", $card)->item(0);
            $linkNode = $xpath->query(".//h5[@class='blog-title']/a", $card)->item(0);
            
            if ($titleNode && $linkNode) {
                $title = trim($titleNode->nodeValue);
                
                $keywords = $this->get_setting('tender_keywords', 'software|perangkat lunak|sistem');
                $arr = preg_split('/[,|]/', $keywords);
                $arr = array_filter(array_map('trim', $arr));
                if (empty($arr)) $arr = ['software'];
                
                $regex = '/\b(' . implode('|', array_map(function($k) { return preg_quote($k, '/'); }, $arr)) . ')\b/i';
                if (!preg_match($regex, $title)) continue;
                $date_str = $dateNode ? trim($dateNode->nodeValue) : date('Y-m-d');
                $link = trim($linkNode->getAttribute('href'));
                
                if (strpos($link, 'http') === false) {
                    $link = "https://eproc.iasp.id" . $link;
                }
                
                $this->db->where('link', $link);
                if ($this->db->count_all_results('news') > 0) continue;
                
                $items[] = [
                    'title' => $title,
                    'link' => $link,
                    'source' => 'e-Proc IASP',
                    'type' => 'tender',
                    'pub_date' => date('Y-m-d H:i:s', strtotime($date_str)),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $count++;
            }
        }
        
        if (!empty($items)) {
            $this->db->insert_batch('news', $items);
        }
    }

    private function fetch_and_save_pengadaan_tenders() {
        $url = "https://tender.pengadaan.com/api/v1/tenders?limit=100";
        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
            ]
        ]);
        
        $json = @file_get_contents($url, false, $context);
        if (!$json) return;

        $data = json_decode($json, true);
        if (!$data || !isset($data['data'])) return;

        $items = [];
        $count = 0;
        
        foreach ($data['data'] as $tender) {
            if ($count >= 50) break;
            
            $title = $tender['title'] ?? '';
            $keywords = $this->get_setting('tender_keywords', 'software|perangkat lunak|sistem');
            
            // Convert comma separated or pipes to valid regex
            $arr = preg_split('/[,|]/', $keywords);
            $arr = array_filter(array_map('trim', $arr));
            if (empty($arr)) $arr = ['software'];
            
            $regex = '/\b(' . implode('|', array_map(function($k) { return preg_quote($k, '/'); }, $arr)) . ')\b/i';
            $is_it = preg_match($regex, $title);
            
            if ($is_it) {
                $link = "https://tender.pengadaan.com/tender/" . ($tender['slug'] ?? $tender['id']);
                
                $this->db->where('link', $link);
                if ($this->db->count_all_results('news') > 0) continue;
                
                $date_str = $tender['closingDate'] ?? date('Y-m-d H:i:s');
                
                $items[] = [
                    'title' => substr(trim($title), 0, 490),
                    'link' => $link,
                    'source' => substr(trim($tender['organizerName'] ?? 'Pengadaan.com'), 0, 250),
                    'type' => 'tender',
                    'pub_date' => date('Y-m-d H:i:s', strtotime($date_str)),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $count++;
            }
        }
        
        if (!empty($items)) {
            $this->db->insert_batch('news', $items);
        }
    }

    public function mark_notifications_read() {
        $this->db->empty_table('notifications');
        echo json_encode(['status' => 'ok']);
    }

    public function progressive_crawl() {
        $urls = [
            "https://eproc.telkom.co.id/", "https://eproc.pertamina.com/", "https://eproc.pln.co.id/",
            "https://eproc.bankmandiri.co.id/", "https://e-procurement.bri.co.id/", "https://eproc.bni.co.id/",
            "https://eproc.btn.co.id/", "https://eproc.pegadaian.co.id/", "https://eproc.pelindo.co.id/",
            "https://eproc.ap1.co.id/", "https://eproc.angkasapura2.co.id/", "https://eproc.garuda-indonesia.com/",
            "https://eproc.kai.id/", "https://eproc.jasamarga.co.id/", "https://eproc.waskita.co.id/",
            "https://eproc.wika.co.id/", "https://eproc.adhi.co.id/", "https://eproc.ptpp.co.id/",
            "https://eproc.krakatausteel.com/", "https://eproc.pupuk-indonesia.com/", "https://eproc.semenindonesia.com/",
            "https://eproc.biofarma.co.id/", "https://eproc.kimiafarma.co.id/", "https://eproc.perhutani.co.id/",
            "https://eproc.posindonesia.co.id/", "https://eproc.perumnas.co.id/", "https://eproc.asabri.co.id/",
            "https://eproc.taspen.co.id/", "https://eproc.jasaraharja.co.id/", "https://eproc.bpjsketenagakerjaan.go.id/",
            "https://eproc.bpjs-kesehatan.go.id/", "https://eproc.danamon.co.id/", "https://eproc.bankmega.com/",
            "https://eproc.ojk.go.id/", "https://eproc.bi.go.id/", "https://eproc.lps.go.id/", "https://eproc.idx.co.id/"
        ];
        
        $idx = (int)$this->get_setting('crawler_index', 0);
        if ($idx >= count($urls)) {
            echo json_encode(['status' => 'done']);
            return;
        }
        
        $new_data = false;
        // Crawl next 2
        for ($i = 0; $i < 2; $i++) {
            if ($idx >= count($urls)) break;
            $res = $this->fetch_generic_eproc($urls[$idx]);
            if ($res) $new_data = true;
            $idx++;
        }
        
        $this->set_setting('crawler_index', $idx);
        echo json_encode(['status' => 'ok', 'new_data' => $new_data, 'index' => $idx]);
    }

    private function fetch_generic_eproc($url) {
        $context = stream_context_create([
            'http' => [
                'timeout' => 3, // fast timeout so it doesn't freeze
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
            ],
            'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
        ]);
        
        $html = @file_get_contents($url, false, $context);
        if (!$html) {
            $this->db->insert('notifications', [
                'message' => "Crawler Error: Gagal mengakses atau timeout pada $url"
            ]);
            return false;
        }

        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($doc);

        $links = $xpath->query("//a");
        $items = [];
        $count = 0;
        
        $keywords = $this->get_setting('tender_keywords', 'software|perangkat lunak|sistem');
        $arr = preg_split('/[,|]/', $keywords);
        $arr = array_filter(array_map('trim', $arr));
        if (empty($arr)) $arr = ['software'];
        $regex = '/\b(' . implode('|', array_map(function($k) { return preg_quote($k, '/'); }, $arr)) . ')\b/i';
        
        foreach ($links as $link) {
            if ($count >= 5) break;
            
            $title = trim($link->nodeValue);
            if (strlen($title) < 15) continue;
            
            if (preg_match($regex, $title)) {
                $href = $link->getAttribute('href');
                if (strpos($href, 'http') === false) {
                    $parsed = parse_url($url);
                    $href = rtrim($parsed['scheme'] . '://' . $parsed['host'], '/') . '/' . ltrim($href, '/');
                }
                
                $this->db->where('link', substr($href, 0, 250));
                if ($this->db->count_all_results('news') > 0) continue;

                $items[] = [
                    'title' => substr($title, 0, 490),
                    'link' => substr($href, 0, 250),
                    'source' => parse_url($url, PHP_URL_HOST),
                    'type' => 'tender',
                    'pub_date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $count++;
            }
        }
        
        if (!empty($items)) {
            $this->db->insert_batch('news', $items);
            return true;
        }
        return false;
    }
}
