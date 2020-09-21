<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sell extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Sell_model');
    }

	
	public function add_sell()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Sell_model->add_sell($data['sell_list']);
	    echo json_encode($result);
	}

	public function listing()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Sell_model->listing($data['sell_list']);
	    echo json_encode($result);
	}

	public function chalan()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Sell_model->chalan($data['chalan']);
	    echo json_encode($result);
	}
}
