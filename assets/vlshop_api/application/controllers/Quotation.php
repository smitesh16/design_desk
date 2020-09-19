<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Quotation_model');
    }

	
	public function add_quotation()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Quotation_model->add_quotation($data['sell_list']);
	    echo json_encode($result);
	}

	public function edit_quotation()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Quotation_model->edit_quotation($data['sell_list']);
	    echo json_encode($result);
	}

	public function listing()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Quotation_model->listing($data['quotation_list']);
	    echo json_encode($result);
	}

	public function delete()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Quotation_model->delete($data['quotation_list']);
	    echo json_encode($result);
	}

	
}
