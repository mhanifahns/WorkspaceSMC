<?php
// Created by Hanif
defined('BASEPATH') OR exit('No direct script access allowed');

class Credentials extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('CredentialModel');
    }

    public function index() {
        $category = $this->input->get('category');
        $search = $this->input->get('search');
        
        if (!empty($category) || !empty($search)) {
            $data['credentials'] = $this->CredentialModel->search($category, $search);
        } else {
            $data['credentials'] = $this->CredentialModel->get_all();
        }
        
        $data['active_category'] = $category;
        
        $this->load->view('layouts/main', [
            'content' => $this->load->view('credentials/index', $data, TRUE)
        ]);
    }

    public function create() {
        $this->load->view('layouts/main', [
            'content' => $this->load->view('credentials/create', '', TRUE)
        ]);
    }

    public function store() {
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('label', 'Label', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/main', [
                'content' => $this->load->view('credentials/create', '', TRUE)
            ]);
        } else {
            $data = [
                'category' => $this->input->post('category'),
                'label'    => $this->input->post('label'),
                'host'     => $this->input->post('host'),
                'port'     => $this->input->post('port'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'notes'    => $this->input->post('notes'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->CredentialModel->insert($data);
            $this->session->set_flashdata('success', 'Credential added successfully.');
            redirect('credentials');
        }
    }

    public function edit($id) {
        $data['credential'] = $this->CredentialModel->get_by_id($id);
        
        if (empty($data['credential'])) {
            show_404();
        }

        $this->load->view('layouts/main', [
            'content' => $this->load->view('credentials/edit', $data, TRUE)
        ]);
    }

    public function update($id) {
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('label', 'Label', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['credential'] = $this->CredentialModel->get_by_id($id);
            $this->load->view('layouts/main', [
                'content' => $this->load->view('credentials/edit', $data, TRUE)
            ]);
        } else {
            $data = [
                'category' => $this->input->post('category'),
                'label'    => $this->input->post('label'),
                'host'     => $this->input->post('host'),
                'port'     => $this->input->post('port'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'notes'    => $this->input->post('notes'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->CredentialModel->update($id, $data);
            $this->session->set_flashdata('success', 'Credential updated successfully.');
            redirect('credentials');
        }
    }

    public function delete($id) {
        $this->CredentialModel->delete($id);
        $this->session->set_flashdata('success', 'Credential deleted successfully.');
        redirect('credentials');
    }
}
