<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Purchase_model');
    }
    public function all_list()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Purchase_model->all_list($data['purchase']);
	    echo json_encode($result);
	}
	public function place_order()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Purchase_model->place_order($data['data']);
	    echo json_encode($result);
	}
    
    public function Batch()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Purchase_model->Batch($data['data']);
	    echo json_encode($result);
	}
}
