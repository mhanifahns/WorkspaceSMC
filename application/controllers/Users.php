<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');

        // Only allow logged in admins or master account (hanif)
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        if ($this->session->userdata('role') !== 'admin' && $this->session->userdata('username') !== 'hanif') {
            show_error('You do not have permission to access this page.', 403);
        }
    }

    public function index() {
        $view_data['users'] = $this->db->get('users')->result_array();
        $view_data['content'] = $this->load->view('users/index', $view_data, TRUE);
        $this->load->view('layouts/main', $view_data);
    }

    public function save() {
        $id = $this->input->post('id');
        $username = $this->input->post('username');
        $role = $this->input->post('role') ?: 'user';
        $password = $this->input->post('password');

        $data = [
            'username' => $username,
            'role' => $role
        ];

        if ($password) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('users', $data);
        } else {
            if (!$password) {
                // Generate default password if not provided
                $data['password'] = password_hash('password', PASSWORD_DEFAULT);
            }
            $this->db->insert('users', $data);
        }
        echo json_encode(['status' => 'success']);
    }

    public function delete() {
        $id = $this->input->post('id');
        if ($id) {
            $user_to_delete = $this->db->where('id', $id)->get('users')->row();

            if (!$user_to_delete) {
                echo json_encode(['status' => 'error', 'message' => 'User not found.']);
                return;
            }

            if ($user_to_delete->username === 'admin') {
                echo json_encode(['status' => 'error', 'message' => 'Cannot delete the master admin account.']);
                return;
            }

            // Prevent deleting the very last admin
            $admin_count = $this->db->where('role', 'admin')->count_all_results('users');
            if ($user_to_delete->role === 'admin' && $admin_count <= 1) {
                echo json_encode(['status' => 'error', 'message' => 'Cannot delete the last admin.']);
                return;
            }

            $this->db->where('id', $id);
            $this->db->delete('users');
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
