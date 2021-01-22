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

	public function Token($client_id)
	{
		$objarray = array();
		$api_url = $this->config->item('api_url');
       	$api_url = $api_url."General/create_token";
		$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 20);
		$verified=0;
		// $expdate = date('Y-m-d h:i:s');
		$expdate = date('Y-m-d H:i:s', strtotime('now +1 hour'));
		$objarray['client_id'] = $client_id;
		$objarray['code'] = $code;
		$objarray['verified'] = $verified;
		$objarray['expired'] = $expdate;
		$response = $this->General_model->general_function($objarray,$api_url);
		return $code;	
}

	public function Verifyemail()
		{
			$objarray = array();
			$api_url = $this->config->item('api_url');
			$api_url = $api_url."General/Email_verify";
			$Code = $_GET['code'];
			$Expdate = date('Y-m-d H:i:s', strtotime('now +1 hour'));
			$objarray['code'] = $Code;
			$objarray['expiry'] = $Expdate;
			$response = $this->General_model->general_function($objarray,$api_url);
			// var_dump($response);
			$res = json_decode($response,true);
			// var_dump($res);
			if($res['stat'] == 200)
			{
				$data['verified'] = $res;
				$data['expiry'] = $res;
				$data['email'] = $res;
				$data['clientid'] = $res;
				$data['name'] = $res;
				$this->load->view('Pages/verify',$data);
			}
			else if($res['stat'] == 300)
			{
				$data['verified'] = $res;
				$data['expiry'] = $res;
				$data['email'] = $res;
				$data['clientid'] = $res;
				$data['name'] = $res;
				$this->load->view('Pages/verify',$data);
			}	
			else if($res['stat'] == 400)
			{
				$data['verified'] = $res;
				$data['expiry'] = $res;
				$data['email'] = $res;
				$data['clientid'] = $res;
				$data['name'] = $res;
				$this->load->view('Pages/verify',$data);
			}	
			else
			{
				$data = "Something went wrong!!";
				$this->load->view('Pages/verify',$data);	
			}
			
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
	   $code = $this->Token($res['insert_id']);
	   
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

			// for user registeration

		// 	if($obj['active_status'] != 1){
		//        	$subject = "Registration received – virtual showroom ";
		//        	$to = $obj['user_email'];
		//        	$viewName = "registerTemplate";
		//        	$mailData = array("Name"=>$obj['user_name']);
		//        	sendMail($subject,$to,$viewName,$mailData);

		//        	$subject = "New user request - virtual showroom";
		//        	$to = "geetha.raj@microcotton.com";
		//        	$viewName = "userInfoTemplate";
		//        	$mailData = $obj;
		//        	sendMail($subject,$to,$viewName,$mailData);
		//     }else{
		//        	$subject = "Welcome to  Virtual Showroom";
		//        	$to = $obj['user_email'];
		//        	$viewName = "approveuserTemplate";
		//        	$mailData = array("Name"=>$obj['user_name']);
		//        	sendMail($subject,$to,$viewName,$mailData);

		//        	$subject = "New User via access code: Virtual Showroom";
		//        	$to = "geetha.raj@microcotton.com";
		//        	$viewName = "accesscoderegistrationTemplate";
		//        	$mailData = $newObj;
		//        	sendMail($subject,$to,$viewName,$mailData);
		//    }	
	
	
				if($obj['active_status'] != 1)
				{
					$obj['code'] = $code;
					$subject = "Registration sucessfull, please verify ";
					   $to = $obj['user_email'];
			       	$viewName = "emailverificationTemplate";
					   $mailData = array("Name"=>$obj['user_name'],"Code"=>$code);
			       	sendMail($subject,$to,$viewName,$mailData);
	
			       	// $subject = "New user request - virtual showroom";
			       	// $to = "smitesh@ajency.in";
			       	// $viewName = "userInfoTemplate";
			       	// $mailData = $obj;
			       	// sendMail($subject,$to,$viewName,$mailData);
				} 
		       	// $subject = "Welcome to  Virtual Showroom";
		       	// $to = $obj['user_email'];
		       	// $viewName = "approveuserTemplate";
		       	// $mailData = array("Name"=>$obj['user_name']);
		       	// sendMail($subject,$to,$viewName,$mailData);

		       	// $subject = "New User via access code: Virtual Showroom";
		       	// $to = "smitesh@ajency.in";
		       	// $viewName = "accesscoderegistrationTemplate";
		       	// $mailData = $newObj;
		       	// sendMail($subject,$to,$viewName,$mailData);

       }
       
       echo $response;
	}

	public function ResendEmailVerication()
	{
					// var_dump($_GET);
					$obj = $this->input->get();
					$email = $_GET['email'];
					$userid = $_GET['userid'];
					$username = $_GET['name'];
					$objarray = array();
					$api_url = $this->config->item('api_url');
					$api_url = $api_url."General/create_reverification";
					$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$code = substr(str_shuffle($set), 0, 20);
					$verified=0;
					// // $expdate = date('Y-m-d h:i:s');
					$expdate = date('Y-m-d H:i:s', strtotime('now +1 hour'));
					$objarray['code'] = $code;
					$objarray['verified'] = $verified;
					$objarray['expired'] = $expdate;
					$objarray['email'] = $email;
					$objarray['userid'] = $userid;

					$response = $this->General_model->general_function($objarray,$api_url);
					// var_dump($response);
					$res = json_decode($response,true);

					if($res['stat'] == 200) {
					//send mail code
					$subject = "Verification Link ";
					   $to = $email;
			       	$viewName = "emailverificationTemplate";
					   $mailData = array("Name"=>$obj['name'],"Code"=>$code);
					//    var_dump($to,$mailData);
					
					   // sendMail($subject,$to,$viewName,$mailData);
					}
					else
					{
						echo "Something went Wrong!!";
					}
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
