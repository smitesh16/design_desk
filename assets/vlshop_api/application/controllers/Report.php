<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Report_model');
    }

	
    public function stock_in_out_filter()
	{
       
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Report_model->stock_in_out_filter($data['daily_stock']);
	    echo json_encode($result);
	}
    public function cash_filter()
	{
       
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Report_model->cash_filter($data['cash']);
	    echo json_encode($result);
	}
    public function profit_loss_filter()
	{
       
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Report_model->profit_loss_filter($data['profit_loss']);
	    echo json_encode($result);
	}

	 public function customer_filter()
	{
       
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Report_model->customer_filter($data['customer']);
	    echo json_encode($result);
	}
	

}
