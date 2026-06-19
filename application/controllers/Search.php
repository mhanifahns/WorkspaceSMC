<?php
// Created by Hanif
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

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

        $q = trim($this->input->get('q'));
        $data = ['query' => $q, 'results' => []];

        if (!empty($q)) {
            // Search Credentials
            $this->db->group_start();
            $this->db->like('label', $q);
            $this->db->or_like('username', $q);
            $this->db->or_like('host', $q);
            $this->db->or_like('category', $q);
            $this->db->or_like('notes', $q);
            $this->db->group_end();
            $creds = $this->db->get('credentials')->result_array();
            foreach($creds as $c) {
                $data['results'][] = [
                    'type' => 'Credential',
                    'icon' => 'fas fa-key',
                    'title' => $c['label'] . ' (' . $c['category'] . ')',
                    'desc' => $c['username'] . ' - ' . $c['host'],
                    'link' => site_url('credentials?category=' . urlencode($c['category']))
                ];
            }

            // Search Tasks
            $this->db->group_start();
            $this->db->like('title', $q);
            $this->db->or_like('description', $q);
            $this->db->or_like('status', $q);
            $this->db->group_end();
            $tasks = $this->db->get('tasks')->result_array();
            foreach($tasks as $t) {
                $data['results'][] = [
                    'type' => 'Task',
                    'icon' => 'fas fa-tasks',
                    'title' => $t['title'] . ' [' . strtoupper($t['status']) . ']',
                    'desc' => substr(strip_tags($t['description']), 0, 100) . '...',
                    'link' => site_url('tasks')
                ];
            }

            // Search Notes
            $this->db->group_start();
            $this->db->like('title', $q);
            $this->db->or_like('content', $q);
            $this->db->group_end();
            $notes = $this->db->get('notes')->result_array();
            foreach($notes as $n) {
                $data['results'][] = [
                    'type' => 'Note',
                    'icon' => 'fas fa-book',
                    'title' => $n['title'],
                    'desc' => substr(strip_tags($n['content']), 0, 100) . '...',
                    'link' => site_url('notes')
                ];
            }
            
            // Search Incomes
            $this->db->group_start();
            $this->db->like('description', $q);
            $this->db->or_like('client_name', $q);
            $this->db->group_end();
            $incomes = $this->db->get('incomes')->result_array();
            foreach($incomes as $inc) {
                $data['results'][] = [
                    'type' => 'Income',
                    'icon' => 'fas fa-file-invoice-dollar',
                    'title' => $inc['client_name'] . ' - Rp ' . number_format($inc['net_amount'], 0, ',', '.'),
                    'desc' => $inc['description'],
                    'link' => site_url('incomes')
                ];
            }
        }

        $view_data['content'] = $this->load->view('search/index', $data, TRUE);
        $this->load->view('layouts/main', $view_data);
    }
}
