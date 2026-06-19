<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CredentialModel extends CI_Model {

    private $table = 'credentials';

    public function get_all() {
        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function search($category = null, $search = null) {
        $this->db->order_by('id', 'DESC');
        if (!empty($category)) {
            $this->db->where('category', $category);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('label', $search);
            $this->db->or_like('host', $search);
            $this->db->or_like('username', $search);
            $this->db->or_like('notes', $search);
            $this->db->group_end();
        }
        return $this->db->get($this->table)->result_array();
    }
}
