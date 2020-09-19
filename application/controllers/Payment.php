<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

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
		$api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Payment/all_list";
        
        $objarray = array("payment"=>array());
        $data['payment'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
		$this->load->view('template/header',$data);
		$this->load->view('Payment/payment');
		$this->load->view('template/footer');
	}
    
    public function Add(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        
        $objarray = array("client"=>array());
        $data['client'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
		$this->load->view('template/header',$data);
		$this->load->view('Payment/payment_add');
		$this->load->view('template/footer');
    }
    
    public function client_wise_inv(){
        $api_url = $this->config->item('api_url');
        $purchase_api_url = $api_url."General/Get";
        
        $data = $this->input->post();
        $data['outstanding_amount!=']=0;
        $objarray = array("sell"=>$data);
        $res = $this->General_model->general_function($objarray,$purchase_api_url);
        echo $res;
    }
    
    public function place_payment(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Payment/place_payment";
        
        $objarray = array("payment"=>$this->input->post());
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }
    
    public function single_payment(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Payment/all_list";
        
        $objarray = array("payment"=>$this->input->post());
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }
    
    public function voucher()
    {
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Payment/all_list";
        
        $id  = DecryptID($this->uri->segment(3));
        $objarray = array("payment"=>array("payment_id"=>$id));
//       echo json_encode($objarray);die;
        $res = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
         if($res['stat'] == 200)
         {
            $data['payment'] = $res;
            
            $this->load->view('Payment/voucher',$data);
         }
         else
         {
              $this->session->set_flashdata('alert', array('message' => "Something wrong. Please try after sometime",'class' => 'error'));
              header('Location: '.base_url().'Payment');
         }        
    }
    
}
