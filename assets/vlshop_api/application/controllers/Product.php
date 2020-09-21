<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
    }
	public function Batch()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Product_model->Batch($data['data']);
	    echo json_encode($result);
	}
	
}
