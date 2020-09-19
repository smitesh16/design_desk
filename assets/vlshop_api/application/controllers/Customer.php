<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
    }

	public function index()
	{
       
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Customer_model->customer_add($data['customer']);
	    echo json_encode($result);
	}

	public function edit()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Customer_model->customer_edit($data['customer']);
	    echo json_encode($result);
	}

	public function add_batch()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Customer_model->add_batch($data['customer']);
	    echo json_encode($result);
	}
}
