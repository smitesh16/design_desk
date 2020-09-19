<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sell extends CI_Controller {

    public function index()
    {  
       $api_url = $this->config->item('api_url');
    	 $get_api_url = $api_url."Sell/listing";
       $objarray = array("sell_list"=>array());
       $data['sell_list'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);

    	
        $this->load->view('template/header');
		   $this->load->view('Sell/sell',$data);
		   $this->load->view('template/footer');
    }
	public function Add_view()
	{   

		if($this->session->userdata('admin_id')=="")
        {
              header('Location: '.base_url());
        }
		
	    	$api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        $objarray = array("product"=>array());
        $response = $this->General_model->general_function($objarray,$get_api_url);

        $objarr = array("client"=>array());
        $res = $this->General_model->general_function($objarr,$get_api_url);
      
        $data['product_list'] =  json_decode($response,true);
        $data['client_list'] =  json_decode($res,true);
		 
		$this->load->view('template/header');
		$this->load->view('Sell/sell_add',$data);
		$this->load->view('template/footer');
	}

	public function Add_product()
	{
		if($this->session->userdata('admin_id')=="")
        {
              header('Location: '.base_url());
        }
		
		
		   $objarr =$this->input->post('s_list');
		
		    $api_url = $this->config->item('api_url');
        $add_api_url = $api_url."Sell/add_sell";

        $objarray = array("sell_list"=>$objarr);
        /*echo json_encode($objarray);
        die();*/
        $res = $this->General_model->general_function($objarray,$add_api_url);
        echo $res;
       
	}

	public function get_sell()
	{
		$id =$this->input->post('id');

		
		$api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Sell/listing";

        $objarray = array("sell_list"=>array("sell_id"=>$id));
        $res = $this->General_model->general_function($objarray,$get_api_url);

        echo $res;
	}

    public function invoice()
    {
        $id = DecryptID($this->uri->segment(3));
       
        
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Sell/listing";

        $objarray = array("sell_list"=>array("sell_id"=>$id));
        $res = $this->General_model->general_function($objarray,$get_api_url);

        $data['sell_list'] =  json_decode($res,true);
        $data['id']=  $id;
       
        if($data['sell_list']['stat'] == 200){
            $this->load->view('Sell/invoice',$data);
        }else{
            $this->session->set_flashdata('alert', array('message' => "Something wrong. Please try after sometime",'class' => 'error'));
            header('Location: '.base_url().'Sell');
        }
        
    }

    public function chalan()
    {
        $id  = DecryptID($this->uri->segment(3));
        
        $api_url = $this->config->item('api_url');
        
        $update_api_url = $api_url."Sell/chalan";
        $get_api_url = $api_url."Sell/listing";

        $objarray = array("chalan"=>array("sell_id"=>$id));
       
        $res = json_decode($this->General_model->general_function($objarray,$update_api_url),true);
        
         if($res['stat'] == 200)
         {
            $objarray = array("sell_list"=>array("sell_id"=>$id));
            $res = $this->General_model->general_function($objarray,$get_api_url);
            $data['sell_list'] =  json_decode($res,true);

            $data['id']=  $id;
       
            $this->load->view('Sell/chalan',$data);
           
         }
         else
         {
              $this->session->set_flashdata('alert', array('message' => $res['msg'],'class' => 'error'));
              header('Location: '.base_url().'Sell');
         }
        
    }

    public function chalanView()
    {
        $id  = DecryptID($this->uri->segment(3));
        
        $api_url = $this->config->item('api_url');
        
       
        $get_api_url = $api_url."Sell/listing";

        $objarray = array("sell_list"=>array("sell_id"=>$id));
        $res = $this->General_model->general_function($objarray,$get_api_url);
        $data['sell_list'] =  json_decode($res,true);
        $data['id']=  $id;


        if($data['sell_list']['stat'] == 200)
         {
           $this->load->view('Sell/chalan',$data);
           
         }
         else
         {
              $this->session->set_flashdata('alert', array('message' => "Something wrong. Please try after sometime",'class' => 'error'));
              header('Location: '.base_url().'Sell');
         }

    }
	
	
}
