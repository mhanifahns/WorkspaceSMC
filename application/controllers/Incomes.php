<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incomes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('IncomeModel');
        $this->load->library('session');
        $this->load->helper('url');

        // Check if logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
        
        $data['incomes'] = $this->IncomeModel->get_all(); // Optionally filter by year
        
        // Let's filter by year in controller for simplicity
        $filtered_incomes = [];
        $gross_total = 0;
        $tax_total = 0;
        $net_total = 0;
        
        foreach($data['incomes'] as $inc) {
            if (date('Y', strtotime($inc['receive_date'])) == $year) {
                $filtered_incomes[] = $inc;
                $gross_total += $inc['gross_amount'];
                $tax_total += $inc['tax_withheld'];
                $net_total += $inc['net_amount'];
            }
        }
        
        $data['incomes'] = $filtered_incomes;
        $data['selected_year'] = $year;
        $data['gross_total'] = $gross_total;
        $data['tax_total'] = $tax_total;
        $data['net_total'] = $net_total;

        $view_data['content'] = $this->load->view('incomes/index', $data, TRUE);
        $this->load->view('layouts/main', $view_data);
    }

    public function create() {
        if ($this->input->method() == 'post') {
            $gross = str_replace(['.', ','], ['', '.'], $this->input->post('gross_amount'));
            $tax = str_replace(['.', ','], ['', '.'], $this->input->post('tax_withheld'));
            
            $gross = (float)$gross;
            $tax = (float)$tax;
            $net = $gross - $tax;

            $receipt_file = null;
            if (!empty($_FILES['receipt_file']['name'])) {
                $config['upload_path']   = './uploads/receipts/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('receipt_file')) {
                    $upload_data = $this->upload->data();
                    $receipt_file = $upload_data['file_name'];
                }
            }

            $data = array(
                'receive_date' => $this->input->post('receive_date'),
                'client_name' => $this->input->post('client_name'),
                'description' => $this->input->post('description'),
                'gross_amount' => $gross,
                'tax_withheld' => $tax,
                'net_amount' => $net,
                'tax_receipt_number' => $this->input->post('tax_receipt_number'),
                'receipt_file' => $receipt_file,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->IncomeModel->insert($data);
            $this->session->set_flashdata('success', 'Income record added successfully.');
            redirect('incomes');
        }
    }

    public function report() {
        $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
        
        $data['incomes'] = $this->IncomeModel->get_all();
        
        $filtered_incomes = [];
        $gross_total = 0;
        $tax_total = 0;
        
        // Sorting by date ascending for the report
        usort($data['incomes'], function($a, $b) {
            return strtotime($a['receive_date']) - strtotime($b['receive_date']);
        });

        foreach($data['incomes'] as $inc) {
            if (date('Y', strtotime($inc['receive_date'])) == $year) {
                $filtered_incomes[] = $inc;
                $gross_total += $inc['gross_amount'];
                $tax_total += $inc['tax_withheld'];
            }
        }
        
        $data['incomes'] = $filtered_incomes;
        $data['selected_year'] = $year;
        $data['gross_total'] = $gross_total;
        $data['tax_total'] = $tax_total;
        
        // Load the printable report view directly
        $this->load->view('incomes/report', $data);
    }

    public function delete($id) {
        $this->IncomeModel->delete($id);
        $this->session->set_flashdata('success', 'Income record deleted successfully.');
        redirect('incomes');
    }
}
