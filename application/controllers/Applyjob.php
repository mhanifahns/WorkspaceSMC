<?php
// Created by Hanif
defined('BASEPATH') OR exit('No direct script access allowed');

class Applyjob extends CI_Controller {

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

        $view_data['cv_data'] = [
            'en' => $this->get_cv_data('en'),
            'id' => $this->get_cv_data('id')
        ];

        $view_data['content'] = $this->load->view('applyjob/index', $view_data, TRUE);
        $this->load->view('layouts/main', $view_data);
    }

    private function get_cv_data($lang) {
        $this->db->where('lang', $lang);
        $this->db->order_by('id', 'ASC');
        $res = $this->db->get('cv_data')->result_array();
        
        $data = ['basic' => null, 'summary' => null, 'experience' => [], 'education' => [], 'skills' => []];
        foreach($res as $r) {
            $json = json_decode($r['data'], true);
            $json['db_id'] = $r['id'];
            if ($r['section'] == 'basic' || $r['section'] == 'summary') {
                $data[$r['section']] = $json;
            } else {
                $data[$r['section']][] = $json;
            }
        }
        return $data;
    }

    public function save_item() {
        if (!$this->session->userdata('logged_in')) return;
        $id = $this->input->post('id');
        $section = $this->input->post('section');
        $lang = $this->input->post('lang');
        $data = json_decode($this->input->post('data'), true);

        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('cv_data', ['data' => json_encode($data)]);
        } else {
            $this->db->insert('cv_data', [
                'section' => $section,
                'lang' => $lang,
                'data' => json_encode($data)
            ]);
        }
        echo json_encode(['status' => 'success']);
    }

    public function delete_item() {
        if (!$this->session->userdata('logged_in')) return;
        $id = $this->input->post('id');
        if ($id) {
            $this->db->where('id', $id);
            $this->db->delete('cv_data');
        }
        echo json_encode(['status' => 'success']);
    }

    public function export_ats() {
        if (!$this->session->userdata('logged_in')) redirect('login');
        $lang = $this->input->get('lang') ?: 'en';
        $data['cv'] = $this->get_cv_data($lang);
        $this->load->view('applyjob/ats_export', $data);
    }
}
