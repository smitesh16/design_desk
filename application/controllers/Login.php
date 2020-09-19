<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
        if($this->session->userdata('admin_id')!="")
        {
              header('Location: '.base_url('Dashboard'));
        }
        
		$this->load->view('Login/login_view');
	}
    
    public function admin_login(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
 
        $data = $this->input->post();
        $password=base64_encode($data['password']);
        
        $objarray = array("admin"=>array('user_name'=>$data['user_name'],"password"=>$password));
        $res = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
        if($res['stat'] == 200) {
            if (array_key_exists("remember",$data)){
                $cookie_name = "imas_emp_id";
                $cookie_value = $res['all_list'][0]['user_name'];
                setcookie($cookie_name, $cookie_value, time() + (86400 * 365), "/"); // 86400 = 1 day
                
                $cookie_name1 = "imas_emp_password";
                $cookie_value1 = $password;
                setcookie($cookie_name1, $cookie_value1, time() + (86400 * 365), "/"); // 86400 = 1 day
              }
            $this->session->set_userdata("admin_id",$res['all_list'][0]['admin_id']);
            $this->session->set_flashdata('alert', array('message' => 'Succesfully Logged in','class' => 'auto_msg'));
            header('Location: '.base_url().'Dashboard');
        } else {
            $this->session->set_flashdata('alert', array('message' => 'Invalid User','class' => 'error'));
            header('Location: '.base_url().'Admin');
        }
        
    }
}
