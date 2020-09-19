<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller
{    
	public function __construct()
    {
        parent::__construct();
        $this->load->model('General_model');
    }

	public function index($param1)
	{
        $function_name = strtolower($param1).'_data';
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->General_model->$function_name($data);
	    echo json_encode($result);
	}
    
}