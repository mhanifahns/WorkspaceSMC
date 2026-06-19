<?php
// Created by Hanif
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_in') && $this->router->fetch_method() != 'logout') {
            redirect('credentials');
        }
    }

    public function index() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            return $this->doLogin();
        }
        $this->load->view('auth/login');
    }

    public function doLogin() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->load->database();
        $this->db->where('username', $username);
        $user = $this->db->get('users')->row();

        if ($user && password_verify($password, $user->password)) {
            $this->session->set_userdata([
                'logged_in' => TRUE,
                'user_id'   => $user->id,
                'username'  => $user->username,
                'role'      => $user->role
            ]);
            redirect('credentials');
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
