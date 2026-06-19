<?php
// Created by Hanif
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('TaskModel');
        $this->load->library('session');
        $this->load->helper('url');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $project_id = isset($_GET['project']) ? (int)$_GET['project'] : 1;
        
        $data['projects'] = $this->TaskModel->get_projects();
        $data['active_project_id'] = $project_id;
        
        $data['columns'] = $this->TaskModel->get_columns($project_id);
        $tasks = $this->TaskModel->get_by_project($project_id);
        
        // Group tasks by column
        $data['tasks_by_column'] = [];
        foreach($data['columns'] as $col) {
            $data['tasks_by_column'][$col['id']] = [];
        }
        
        foreach($tasks as $t) {
            if(isset($data['tasks_by_column'][$t['column_id']])) {
                $data['tasks_by_column'][$t['column_id']][] = $t;
            }
        }
        
        $view_data['content'] = $this->load->view('tasks/index', $data, TRUE);
        $this->load->view('layouts/main', $view_data);
    }

    public function create_project() {
        if ($this->input->method() == 'post') {
            $name = $this->input->post('name');
            $id = $this->TaskModel->insert_project($name);
            redirect('tasks?project='.$id);
        }
    }

    public function create_column() {
        if ($this->input->method() == 'post') {
            $project_id = $this->input->post('project_id');
            $name = $this->input->post('name');
            $color = $this->input->post('color') ?: '#00FFD1';
            $this->TaskModel->insert_column($project_id, $name, $color);
            redirect('tasks?project='.$project_id);
        }
    }

    public function delete_column($id) {
        $project_id = isset($_GET['project']) ? $_GET['project'] : 1;
        if($this->TaskModel->delete_column($id)) {
            $this->session->set_flashdata('success', 'Category removed.');
        } else {
            $this->session->set_flashdata('error', 'Cannot remove category because it still has active tasks.');
        }
        redirect('tasks?project='.$project_id);
    }

    public function create() {
        if ($this->input->method() == 'post') {
            $data = array(
                'project_id' => $this->input->post('project_id'),
                'column_id' => $this->input->post('column_id'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->TaskModel->insert($data);
            echo json_encode(['success' => true]);
        }
    }

    public function update_status() {
        if ($this->input->method() == 'post') {
            $id = $this->input->post('id');
            $column_id = $this->input->post('column_id');
            $this->TaskModel->update_column($id, $column_id);
            echo json_encode(['success' => true]);
        }
    }

    public function delete($id) {
        $project_id = isset($_GET['project']) ? $_GET['project'] : 1;
        $this->TaskModel->delete($id);
        $this->session->set_flashdata('success', 'Task deleted successfully.');
        redirect('tasks?project='.$project_id);
    }

    public function update() {
        if ($this->input->method() == 'post') {
            $id = $this->input->post('id');
            $data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description')
            );
            $this->TaskModel->update_task($id, $data);
            echo json_encode(['success' => true]);
        }
    }
}
