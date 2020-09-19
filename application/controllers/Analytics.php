<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller {

	
	public function index()
	{   

		if($this->session->userdata('admin_id')=="")
        {
              header('Location: '.base_url('Admin'));
              die;
        }
		
		$api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        $objarray = array("analytics"=>array(),"order_by"=>array("analytics_id"=>"desc"));
        $response = $this->General_model->general_function($objarray,$get_api_url);
      
        $data['analytics_data'] =  json_decode($response,true);
		 // pr($data);
		$this->load->view('template/header');
		$this->load->view('Analytics/analytics',$data);
		$this->load->view('template/footer');
	}

	public function SendAllMail()
	{
		$api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        $objarray = array("analytics"=>array("entry_date"=>date('Y-m-d')));
        $response = $this->General_model->general_function($objarray,$get_api_url);
        $data['analytics_data'] =  json_decode($response,true);
        if($data['analytics_data']['stat'] == 200){
	        $subject = "Analytics Report on ".date('Y-m-d');
	       	$to = 'enquiry@cheersagar.com';
	       	$viewName = "analyticsTemplate";
	       	$mailData = $data['analytics_data']['all_list'];
	       	$res = sendMail($subject,$to,$viewName,$mailData);
			echo json_encode($res,true);
		}
	}

	public function AbandonCart()
	{
		$api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/AbandonCart";
        $objarray = array();
        $response = genPost($objarray,"AbandonCart");//$this->General_model->general_function($objarray,$get_api_url);
        $data['abandon_data'] =  $response;
        // pr($data);
        if($data['abandon_data']['stat'] == 200){
        	for($i = 0; $i<count($data['abandon_data']['data']); $i++){
        		$subject = "Complete Enquiry: Cheer Sagar Virtual Showroom ";
		       	$to = $data['abandon_data']['data'][$i]['user_email'];
		       	$viewName = "abandonTemplate";
		       	$mailData = $data['abandon_data']['data'][$i];
		       	sendMail($subject,'enquiry@cheersagar.com',$viewName,$mailData);
		       	$res = sendMail($subject,$to,$viewName,$mailData);
				
        	}
	        echo json_encode($res,true);
		}
	}
}
