<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReturnProduct extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('ReturnProduct_model');
    }
    public function sell_wise_product()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->ReturnProduct_model->sell_wise_product($data['sell']);
	    echo json_encode($result);
	}
    public function return_submit()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->ReturnProduct_model->return_submit($data['return_submit']);
	    echo json_encode($result);
	}

	public function all_list()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->ReturnProduct_model->all_list($data['return']);
	    echo json_encode($result);
	}
}
