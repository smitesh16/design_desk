<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

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
	
    public function purchase(){
        
		$this->load->view('template/header');
		$this->load->view('Report/purchase');
		$this->load->view('template/footer');
    }
    
    public function purchase_filter(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Purchase/all_list";
        
        $objarray = array("purchase"=>array("date"=>$this->input->post()));
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }

    public function sell()
    {
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";

        $objarray = array("client"=>array());
        $data['client_list'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
        $this->load->view('template/header');
        $this->load->view('Report/sell',$data);
        $this->load->view('template/footer');
    }

    public function sell_filter(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Sell/listing";
        
        $objarray = array("sell_list"=>array('date'=>$this->input->post()));
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }
    
    public function current_stock()
    {
        
        $this->load->view('template/header');
        $this->load->view('Report/current_stock');
        $this->load->view('template/footer');
    }
    
    public function current_stock_filter(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        
        $objarray = array("product"=>array());
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }
    
    public function stock_in_out()
    {
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        
        $objarray = array("product"=>array());
        $data['product'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
        $this->load->view('template/header',$data);
        $this->load->view('Report/stock_in_out');
        $this->load->view('template/footer');
    }
    
    public function stock_in_out_filter(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Report/stock_in_out_filter";
        
        $objarray = array("daily_stock"=>$this->input->post());
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }

     public function cash()
    {
          
        $this->load->view('template/header');
        $this->load->view('Report/cash');
        $this->load->view('template/footer');
    }

    public function cash_filter()
    {
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Report/cash_filter";
        
        $objarray = array("cash"=>array('date'=>$this->input->post()));
       
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }
    
    public function profit_loss()
    {
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        
        $objarray = array("product"=>array());
        $data['product'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
        $objarray = array("client"=>array());
        $data['client'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
        $this->load->view('template/header',$data);
        $this->load->view('Report/profit_loss');
        $this->load->view('template/footer');
    }
    
    public function profit_loss_filter(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Report/profit_loss_filter";
        
        $objarray = array("profit_loss"=>$this->input->post());
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }

    public function customer_ledger()
    {
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";

        $objarray = array("client"=>array());
        $data['client_list'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);

        $this->load->view('template/header');
        $this->load->view('Report/customer',$data);
        $this->load->view('template/footer');
    }

    public function customer_filter()
    {
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Report/customer_filter";
        
        $objarray = array("customer"=>array('date'=>$this->input->post()));

        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }

    public function return_view()
    {
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";

        $objarray = array("client"=>array());
        $data['client_list'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);

        $this->load->view('template/header');
        $this->load->view('Report/return_view',$data);
        $this->load->view('template/footer');
    }

    public function return_filter()
    {
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."ReturnProduct/all_list";
        
        $objarray = array("return"=>array('date'=>$this->input->post()));
       
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }
}
?>
