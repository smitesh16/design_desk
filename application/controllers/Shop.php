<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

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
		$ip = $this->getVisIPAddr();
		$iparr = explode(',', $ip);
		// echo $ip; die;
		$ipdat = @json_decode(file_get_contents( 
		    "http://www.geoplugin.net/json.gp?ip=" . $iparr[0])); 
		$location = $ipdat->geoplugin_city.",".$ipdat->geoplugin_countryName;
		$obj = array("ip_address"=>$iparr[0],"location"=>$location,"entry_date"=>date('Y-m-d'));
		$objarray = array("analytics"=>$obj);
		$api_url = $this->config->item('api_url');
       	$api_url = $api_url."General/Add";
		$response = $this->General_model->general_function($objarray,$api_url);
		// $this->load->view('template/uiheader');
        $this->load->view('Pages/shop');
        // $this->load->view('template/uifooter');
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
