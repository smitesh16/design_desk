<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Payment_model');
    }
    public function place_payment()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Payment_model->place_payment($data['payment']);
	    echo json_encode($result);
	}
    public function all_list()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Payment_model->all_list($data['payment']);
	    echo json_encode($result);
	}
}
