<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends CI_Controller {

	
	public function index()
	{   

		if($this->session->userdata('admin_id')=="")
        {
            header('Location: '.base_url('Admin'));
            die;
        }
		
		$api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/GetEnquiry";
        $objarray = array("enquiry_details"=>array(),"join"=>"enquiry");
        $response = $this->General_model->general_function($objarray,$get_api_url);
      
        $data['enquiry_data'] =  json_decode($response,true);
		 // echo "<pre>"; print_r($data); die;
		$this->load->view('template/header');
		$this->load->view('Enquiry/enquiry',$data);
		$this->load->view('template/footer');
	}

	public function SendEnquiry(){
		$api_url = $this->config->item('api_url');
		$api_url = $api_url."General/Add";
		$obj = $this->input->post();
		$user_id = Userdata('user_id');
		$objarray = array("enquiry"=>array("client_id"=>$user_id,"enquiry_date"=>date('Y-m-d'),"message"=>$obj['message'],"moq"=>$obj['moq'],"territory"=>$obj['territory']));
		$response = $this->General_model->general_function($objarray,$api_url);
		$res = json_decode($response,true);
		if($res['stat'] == 200){
			$enquiry_id = $res['insert_id'];
			$objarray = array("enquiry_details"=>array("enquiry_id"=>$enquiry_id,"product_id"=>$obj['product_id'],"product_quantity"=>1));
			$response1 = $this->General_model->general_function($objarray,$api_url);
		}
		$pdetails = Productdata($obj['product_id']);
		$pdetails['all_list'][0]['message'] = $obj['message'];
		$subject = "Enquiry received – Microcotton Virtual showroom";
       	$to = Userdata('user_email');
       	$viewName = "checkoutTemplate";
       	$mailData = array("Name"=>Userdata('user_name'),"user_name"=>"","user_email"=>"","company"=>"","user_address"=>"","moq"=>"","pdetails"=>$pdetails['all_list']);
       	sendMail($subject,$to,$viewName,$mailData);
       	$mailData = array("Name"=>"Team Microcotton","user_name"=>Userdata('user_name'),"user_email"=>Userdata('user_email'),"company"=>Userdata('company'),"user_address"=>Userdata('user_address'),"moq"=>$obj['moq'],"pdetails"=>$pdetails['all_list']);
       	$to = "geetha.raj@microcotton.com";
       	sendMail($subject,$to,$viewName,$mailData);
		echo $response;
	}
	public function SendBulkEnquiry(){
		$api_url = $this->config->item('api_url');
		$api_url = $api_url."General/Add";
		$remove_url = $this->config->item('api_url')."General/remove";
		$data['cartlist'] = Cartdata();

		$obj = $this->input->post();
		$user_id = Userdata('user_id');
		// pr($data);
		if($data['cartlist']['stat'] == 200){
			$objarray = array("enquiry"=>array("client_id"=>$user_id,"enquiry_date"=>date('Y-m-d'),"message"=>"Bulk Enquery"));
			$response = $this->General_model->general_function($objarray,$api_url);
			$res = json_decode($response,true);
			$pdetails = array();
			if($res['stat'] == 200){
				$enquiry_id = $res['insert_id'];
				for($i = 0; $i<count($data['cartlist']['all_list']); $i++){
					$pdetails[] = $data['cartlist']['all_list'][$i];
					$comment = $obj['cartComment'.$data['cartlist']['all_list'][$i]['product_id']];
					$pdetails[$i]['message'] = $comment;
					$objarray = array("enquiry_details"=>array("enquiry_id"=>$enquiry_id,"product_id"=>$data['cartlist']['all_list'][$i]['product_id'],"product_quantity"=>1,"comment"=>$comment));
					$response1 = $this->General_model->general_function($objarray,$api_url);
				}
				$objarray = array("cart"=>array("client_id"=>$user_id));
   				$response = $this->General_model->general_function($objarray,$remove_url);
			}

			$subject = "Enquiry received – Microcotton Virtual showroom";
	       	$to = Userdata('user_email');
	       	$viewName = "checkoutTemplate";
	       	$mailData = array("Name"=>Userdata('user_name'),"user_name"=>"","user_email"=>"","company"=>"","user_address"=>"","moq"=>"","pdetails"=>$pdetails);
	       	sendMail($subject,$to,$viewName,$mailData);
	       	$mailData = array("Name"=>"Team Microcotton","user_name"=>Userdata('user_name'),"user_email"=>Userdata('user_email'),"company"=>Userdata('company'),"user_address"=>Userdata('user_address'),"moq"=>"","pdetails"=>$pdetails);
	       	$to = "geetha.raj@microcotton.com";
	       	sendMail($subject,$to,$viewName,$mailData);
		}else{
			$response = json_encode(array("stat"=>400,"msg"=>"No item in your cart"));
		}
		
		echo $response;
	}

	public function Addtobag()
	{
		$api_url = $this->config->item('api_url');
		$api_url = $api_url."General/Add";
		$obj = $this->input->post();
		$user_id = Userdata('user_id');
		$objarray = array("cart"=>array("client_id"=>$user_id,"product_id"=>$obj['product_id']));
		$response = $this->General_model->general_function($objarray,$api_url);
		$res = json_decode($response,true);
		if($res['stat'] == 200){
	        $response = json_encode(Cartdata(),true);
		}
		echo $response;	
	}

	public function ShowCart()
	{
		$data['cartlist'] = json_encode(Cartdata(),true);
		$res = View("Pages/cartview",$data);
		je($res);
	}

	public function RemoveCart()
	{
	   $api_url = $this->config->item('api_url');
       $api_url = $api_url."General/remove";
       $objarray = array("cart"=>$this->input->post());
       $response = $this->General_model->general_function($objarray,$api_url);
       $res = Cartcount();
       echo $res;
	}
}
