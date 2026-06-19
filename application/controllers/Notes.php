<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $this->load->database();
    }

    public function index() {
        $this->db->order_by('updated_at', 'DESC');
        $data['notes'] = $this->db->get('notes')->result_array();
        
        $view_data['content'] = $this->load->view('notes/index', $data, TRUE);
        $this->load->view('layouts/main', $view_data);
    }

    public function get($id) {
        $this->db->where('id', $id);
        $note = $this->db->get('notes')->row_array();
        echo json_encode($note);
    }

    public function save() {
        $id = $this->input->post('id');
        $data = [
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'cover_image' => $this->input->post('cover_image'),
            'icon' => $this->input->post('icon')
        ];

        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('notes', $data);
            echo json_encode(['status' => 'ok', 'id' => $id]);
        } else {
            $this->db->insert('notes', $data);
            echo json_encode(['status' => 'ok', 'id' => $this->db->insert_id()]);
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('notes');
        echo json_encode(['status' => 'ok']);
    }
}
