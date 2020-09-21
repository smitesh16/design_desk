<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->session->sess_destroy();
		$this->load->view('template/uiheader');
        $this->load->view('Pages/signin');
        $this->load->view('template/uifooter');
	}

	public function ShowDiv()
	{
		$viewpage = $this->input->post('viewpage');
		$data['passval'] = $this->input->post('passval');
		$res = View("Pages/".$viewpage,$data);
		je($res);
	}

	public function Login()
	{
	   $api_url = $this->config->item('api_url');
       $api_url = $api_url."General/Get";
       $obj = $this->input->post();
       $obj['password'] = base64_encode($obj['password']);
       $obj['active_status'] = 1;
       $objarray = array("client"=>$obj);
       // je($objarray);
       $response = $this->General_model->general_function($objarray,$api_url);
       $res = json_decode($response,true);
       if($res['stat'] == 200) {
            $this->session->set_userdata("user_id",$res['all_list'][0]['client_id']);
            $this->session->set_userdata("user_name",$res['all_list'][0]['user_name']);
            $this->session->set_userdata("user_email",$res['all_list'][0]['user_email']);
            $this->session->set_userdata("company",$res['all_list'][0]['company']);
            $this->session->set_userdata("user_address",$res['all_list'][0]['user_address']);
        }
       echo $response;
	}

	public function Register()
	{
	   $api_url = $this->config->item('api_url');
       $api_url = $api_url."General/Add";
       $ip = $this->getVisIPAddr();
		$iparr = explode(',', $ip);
       $obj = $this->input->post();
       $newObj = $obj;
       unset($obj['accesscode']);
       $obj['password'] = base64_encode($obj['password']);
       $obj['client_ip_address'] = $iparr[0];
       $objarray = array("client"=>$obj);
       $response = $this->General_model->general_function($objarray,$api_url);
       $res = json_decode($response,true);
       if($res['stat'] == 200) {
       	   $api_url = $this->config->item('api_url');
       	   $api_url = $api_url."General/Get";
       	   $obj1 = $obj;
       	   $obj1['active_status'] = 1;
       	   $objarray = array("client"=>$obj1);
	       $response1 = $this->General_model->general_function($objarray,$api_url);
	       $res1 = json_decode($response1,true);
	       if($res1['stat'] == 200) {
	            $this->session->set_userdata("user_id",$res1['all_list'][0]['client_id']);
	            $this->session->set_userdata("user_name",$res1['all_list'][0]['user_name']);
	            $this->session->set_userdata("user_email",$res1['all_list'][0]['user_email']);
	            $this->session->set_userdata("company",$res1['all_list'][0]['company']);
	            $this->session->set_userdata("user_address",$res1['all_list'][0]['user_address']);
	        }
	    	if($obj['active_status'] != 1){
		       	$subject = "Registration received – Microcotton virtual showroom ";
		       	$to = $obj['user_email'];
		       	$viewName = "registerTemplate";
		       	$mailData = array("Name"=>$obj['user_name']);
		       	// sendMail($subject,$to,$viewName,$mailData);

		       	$subject = "New user request - Microcotton virtual showroom";
		       	$to = "geetha.raj@microcotton.com";
		       	$viewName = "userInfoTemplate";
		       	$mailData = $obj;
		       	// sendMail($subject,$to,$viewName,$mailData);
		    }else{
		       	$subject = "Welcome to Microcotton Virtual Showroom";
		       	$to = $obj['user_email'];
		       	$viewName = "approveuserTemplate";
		       	$mailData = array("Name"=>$obj['user_name']);
		       	// sendMail($subject,$to,$viewName,$mailData);

		       	$subject = "New User via access code: Microcotton Virtual Showroom";
		       	$to = "geetha.raj@microcotton.com";
		       	$viewName = "accesscoderegistrationTemplate";
		       	$mailData = $newObj;
		       	// sendMail($subject,$to,$viewName,$mailData);
	       }
       }
       
       echo $response;
	}

	public function CheckAccesscode()
	{
	   $api_url = $this->config->item('api_url');
       $api_url = $api_url."General/Get";
       $obj = $this->input->post();
       $objarray = array("accesscode"=>$obj);
       $response = $this->General_model->general_function($objarray,$api_url);
	   echo $response;
	}
	public function ForgotPass()
	{
	   $api_url = $this->config->item('api_url');
       $api_url = $api_url."General/Get";
       $obj = $this->input->post();
       $objarray = array("client"=>$obj);
       $response = $this->General_model->general_function($objarray,$api_url);
       $res = json_decode($response,true);
       if($res['stat'] == 200) {
       	$url = $this->config->item('api_url');
       	$api_url = $url."General/Update";
       	$otp = $this->random_strings(8);
       	$obj1 = array("reset_pass_otp"=>$otp);
       	$newobj = array("client"=>$obj1,"where"=>array('client_id'=>$res['all_list'][0]['client_id']));
       	$resupdate = json_decode($this->General_model->general_function($newobj,$api_url),true);

   		$subject = "Reset Password";
       	$to = $obj['user_email'];
       	$viewName = "resetpassTemplate";
       	$mailData = array("Name"=>$res['all_list'][0]['user_name'],"otp"=>$otp);
       	sendMail($subject,$to,$viewName,$mailData);
       }
	   echo $response;
	}
	public function ResetPass()
	{
		$obj = $this->input->post();
		$api_url = $this->config->item('api_url');
		$api_url = $api_url."General/Get";
		$obj = $this->input->post();
		$objarray = array("client"=>array("reset_pass_otp"=>$obj['otp']));
		$response = $this->General_model->general_function($objarray,$api_url);
		$res = json_decode($response,true);
		if($res['stat'] == 200) {
			$url = $this->config->item('api_url');
			$api_url = $url."General/Update";
			$obj1 = array("reset_pass_otp"=>0,"password"=>base64_encode($obj['password']));
			$newobj = array("client"=>$obj1,"where"=>array('reset_pass_otp'=>$obj['otp']));
			$resupdate = json_decode($this->General_model->general_function($newobj,$api_url),true);
			je($resupdate);
		}else{
			echo $response;
		}
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

	public function getVisIpAddr() { 
      
	    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
	        return $_SERVER['HTTP_CLIENT_IP']; 
	    } 
	    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
	        return $_SERVER['HTTP_X_FORWARDED_FOR']; 
	    } 
	    else { 
	        return $_SERVER['REMOTE_ADDR']; 
	    } 
	}
}
