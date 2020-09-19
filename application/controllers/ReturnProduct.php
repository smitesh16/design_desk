<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReturnProduct extends CI_Controller {

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
        $get_api_url = $api_url."ReturnProduct/all_list";
        
        $objarray = array("return"=>array());
        $data['return'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
		$this->load->view('template/header',$data);
		$this->load->view('ReturnProduct/return_product');
		$this->load->view('template/footer');
	}
    
    public function Add(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        
        $objarray = array("sell"=>array());
        $data['sell'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
		$this->load->view('template/header',$data);
		$this->load->view('ReturnProduct/return_add');
		$this->load->view('template/footer');
    }
    
    public function sell_wise_product(){
        $api_url = $this->config->item('api_url');
        $purchase_api_url = $api_url."ReturnProduct/sell_wise_product";
        
        $objarray = array("sell"=>$this->input->post());
//        echo json_encode($objarray);die;
        $res = $this->General_model->general_function($objarray,$purchase_api_url);
        echo $res;
    }
    
    public function return_submit(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."ReturnProduct/return_submit";
        
        $objarray = array("return_submit"=>$this->input->post());
        
        //echo json_encode($objarray);die;
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }
    
   public function credit_note()
    {
      
        $id  = DecryptID($this->uri->segment(3));
       
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."ReturnProduct/all_list";

        $objarray = array("return"=>array("return_no"=>$id));
        //echo json_encode($objarray);die;
        $res = $this->General_model->general_function($objarray,$get_api_url);

        $data['sell_list'] =  json_decode($res,true);
        $data['id']=  $id;
       
        if($data['sell_list']['stat'] == 200)
         {
           $this->load->view('ReturnProduct/credit_note',$data);
         }
         else
         {
              $this->session->set_flashdata('alert', array('message' => "Something wrong. Please try after sometime",'class' => 'error'));
              header('Location: '.base_url().'ReturnProduct');
         }
        
    }
    
    public function single_return(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."ReturnProduct/all_list";
        
        $objarray = array("return"=>$this->input->post());
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }
    
}
