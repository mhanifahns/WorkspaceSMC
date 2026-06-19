<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IncomeModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $this->db->order_by('receive_date', 'DESC');
        $query = $this->db->get('incomes');
        return $query->result_array();
    }

    public function get_yearly_summary($year) {
        $this->db->select_sum('gross_amount');
        $this->db->select_sum('tax_withheld');
        $this->db->select_sum('net_amount');
        $this->db->where('YEAR(receive_date)', $year);
        $query = $this->db->get('incomes');
        return $query->row_array();
    }

    public function insert($data) {
        $this->db->insert('incomes', $data);
        return $this->db->insert_id();
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('incomes');
    }
}
