<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TaskModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Projects
    public function get_projects() {
        return $this->db->get('task_projects')->result_array();
    }

    public function insert_project($name) {
        $this->db->insert('task_projects', ['name' => $name]);
        $project_id = $this->db->insert_id();
        
        // Default columns
        $this->db->insert_batch('task_columns', [
            ['project_id' => $project_id, 'name' => 'TO DO', 'position' => 0, 'color' => '#ffeb3b'],
            ['project_id' => $project_id, 'name' => 'IN PROGRESS', 'position' => 1, 'color' => '#2196f3'],
            ['project_id' => $project_id, 'name' => 'DONE', 'position' => 2, 'color' => '#4caf50']
        ]);
        
        return $project_id;
    }

    // Columns
    public function get_columns($project_id) {
        $this->db->where('project_id', $project_id);
        $this->db->order_by('position', 'ASC');
        return $this->db->get('task_columns')->result_array();
    }

    public function insert_column($project_id, $name, $color) {
        $this->db->select_max('position');
        $this->db->where('project_id', $project_id);
        $query = $this->db->get('task_columns')->row();
        $pos = $query->position !== null ? $query->position + 1 : 0;

        $this->db->insert('task_columns', [
            'project_id' => $project_id,
            'name' => $name,
            'color' => $color,
            'position' => $pos
        ]);
        return $this->db->insert_id();
    }

    public function delete_column($column_id) {
        $this->db->where('column_id', $column_id);
        $count = $this->db->count_all_results('tasks');
        if ($count > 0) return false; // Cannot delete if has tasks

        $this->db->where('id', $column_id);
        return $this->db->delete('task_columns');
    }

    // Tasks
    public function get_by_project($project_id) {
        $this->db->where('project_id', $project_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('tasks')->result_array();
    }

    public function insert($data) {
        $this->db->insert('tasks', $data);
        return $this->db->insert_id();
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tasks');
    }

    public function update_column($id, $column_id) {
        $this->db->where('id', $id);
        return $this->db->update('tasks', ['column_id' => $column_id]);
    }

    public function update_task($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tasks', $data);
    }
}
