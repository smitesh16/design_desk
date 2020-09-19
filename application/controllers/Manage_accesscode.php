<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_accesscode extends CI_Controller {

	
	public function index()
	{   

		if($this->session->userdata('admin_id')=="")
        {
              header('Location: '.base_url('Admin'));
              die;
        }
		
		$api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        $objarray = array("accesscode"=>array());
        $response = $this->General_model->general_function($objarray,$get_api_url);
      
        $data['accesscode_data'] =  json_decode($response,true);
		 
		$this->load->view('template/header');
		$this->load->view('Manage_accesscode/manage_accesscode',$data);
		$this->load->view('template/footer');
	}

	public function Generate()
	{
		$url = $this->config->item('api_url');
       //$api_url = $this->config->item('api_url');
       $api_url = $url."General/Add";
       $objarray['accesscode']= $this->random_strings(8);
        
        $table_attribute="accesscode";
        $obj = array($table_attribute=>$objarray,"check"=>"accesscode");
        $response = json_decode($this->General_model->general_function($obj,$api_url),true);
      
       
       if($response['stat']==200)
       {   
            $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'auto_msg'));
       }
       else 
       {
           if($table_attribute == 'product'){
                if($response['msg'] == "Insert failed. This same value exist"){
                    $this->session->set_flashdata('alert', array('message' => "Part number already exist",'class' => 'error'));
                } else{
                    $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'error'));
                }
           } else{
               $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'error'));
           }
       }
       
        header('Location: '.base_url()."Manage_accesscode");
	}

	public function random_strings($length_of_string) 
	{ 
	  
	    // String of all alphanumeric character 
	    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
	  
	    // Shufle the $str_result and returns substring 
	    // of specified length 
	    return substr(str_shuffle($str_result),  
	                       0, $length_of_string); 
	} 

	public function Update()
    {
       $url = $this->config->item('api_url');
       $api_url = $url."General/Update";
       $objarray=$this->input->post();
       $table_attribute=base64_decode($objarray['table_attribute']);
       $table_id=$objarray[$table_attribute.'_id'];
       // print_r($objarray); die;
       unset($objarray['table_attribute']);
       unset($objarray[$table_attribute.'_id']);

           $obj = array($table_attribute=>$objarray,"where"=>array($table_attribute.'_id'=>$table_id));
        // print_r($obj); die;  
       $response = json_decode($this->General_model->general_function($obj,$api_url),true);
       if($response['stat']==200)
       { 
            $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'auto_msg'));
       }
       else 
       {
            $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'error'));
       }
       
        header('Location: '.base_url()."Manage_accesscode");
       
    }
}
