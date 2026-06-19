<?php
// Created by Hanif
defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load the Unit Test Library
        $this->load->library('unit_test');
        // Load the Models we want to test
        $this->load->model('CredentialModel');
        $this->load->model('IncomeModel');
        $this->load->model('TaskModel');
    }

    public function index()
    {
        // Setup simple UI for unit tests
        echo '<h2>Workspace - H - SMC : Unit Testing Suite</h2>';

        // ---------------------------------------------------------
        // 1. Test Credential Model Type Returns
        // ---------------------------------------------------------
        $test_name = 'Test CredentialModel get_all() returns an Array';
        $result = $this->CredentialModel->get_all();
        $this->unit->run(is_array($result), true, $test_name);

        $test_name = 'Test CredentialModel search() returns an Array';
        $result = $this->CredentialModel->search('VM', 'nonexistent_test_string_123');
        $this->unit->run(is_array($result), true, $test_name);

        // ---------------------------------------------------------
        // 2. Test Income Model
        // ---------------------------------------------------------
        $test_name = 'Test IncomeModel get_all() returns an Array';
        $result = $this->IncomeModel->get_all();
        $this->unit->run(is_array($result), true, $test_name);

        // ---------------------------------------------------------
        // 3. Test Task Model
        // ---------------------------------------------------------
        $test_name = 'Test TaskModel get_all() returns an Array';
        $result = $this->TaskModel->get_all();
        $this->unit->run(is_array($result), true, $test_name);

        // Display results
        echo $this->unit->report();
    }
}
