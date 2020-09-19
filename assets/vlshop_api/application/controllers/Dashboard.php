<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }
	public function index()
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
        $result = $this->Dashboard_model->index($data);
	    echo json_encode($result);
	}
}
