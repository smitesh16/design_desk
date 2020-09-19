<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends CI_Controller {

    public function index()
    {  
        $api_url      = $this->config->item('api_url');
        $get_api_url  = $api_url."Quotation/listing";
        $objarray     = array("quotation_list"=>array());
        $data['quotation_list'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);

      
        $this->load->view('template/header');
        $this->load->view('Quotation/quotation',$data);
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
        $this->load->view('Quotation/quotation_add',$data);
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
        $add_api_url = $api_url."Quotation/add_quotation";

        $objarray = array("sell_list"=>$objarr);
        /*echo json_encode($objarray);
        die();*/
        $res = $this->General_model->general_function($objarray,$add_api_url);
        echo $res;
       
  }

  public function get_quotation()
  {
       $id =$this->input->post('id');
       $api_url = $this->config->item('api_url'); 


        $get_api_url = $api_url."Quotation/listing";

        $objarray = array("quotation_list"=>array("quotation_id"=>$id));
        $res = $this->General_model->general_function($objarray,$get_api_url);
       
        echo $res;
  }

    public function invoice()
    {
        $id = DecryptID($this->uri->segment(3));
        
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Quotation/listing";

        $objarray = array("quotation_list"=>array("quotation_id"=>$id));
        $res = $this->General_model->general_function($objarray,$get_api_url);

        $data['sell_list'] =  json_decode($res,true);
        $data['id']=  $id;
        
        if($data['sell_list']['stat'] == 200){
            $this->load->view('Quotation/invoice',$data);
        } else{
            $this->session->set_flashdata('alert', array('message' => "Something wrong. Please try after sometime",'class' => 'error'));
              header('Location: '.base_url().'Quotation');
        }
        
    }

    public function delete()
    {
        $api_url = $this->config->item('api_url');
        $delete_api_url = $api_url."Quotation/delete";

        $id = $this->input->post('id');

        $objarray = array("quotation_list"=>array("quotation_id"=>$id));
        $res = $this->General_model->general_function($objarray,$delete_api_url);
        echo $res;

    }
    public function edit_view()
    {
        $id = DecryptID($this->uri->segment(3));
       
        $api_url = $this->config->item('api_url');
        $quote_api_url = $api_url."Quotation/listing";
        $get_api_url = $api_url."General/Get";
        $objarray = array("product"=>array());
        $response = $this->General_model->general_function($objarray,$get_api_url);

        $objarr = array("client"=>array());
        $res1 = $this->General_model->general_function($objarr,$get_api_url);
      
        $data['product_list'] =  json_decode($response,true);
        $data['client_list'] =  json_decode($res1,true);
     

        $objarray = array("quotation_list"=>array("quotation_id"=>$id));
        $res = $this->General_model->general_function($objarray,$quote_api_url);

        $data['quotation_list'] =  json_decode($res,true);
        $data['id']=  $id;
        
        if($data['quotation_list']['stat'] == 200){
            $this->load->view('template/header');
            $this->load->view('Quotation/quotation_edit',$data);
            $this->load->view('template/footer');
        } else{
            $this->session->set_flashdata('alert', array('message' => "Something wrong. Please try after sometime",'class' => 'error'));
              header('Location: '.base_url().'Quotation');
        }
    }

    public function Edit_product()
    {
        if($this->session->userdata('admin_id')=="")
        {
              header('Location: '.base_url());
        }
        
        
        $objarr =$this->input->post('s_list');
        
        $api_url = $this->config->item('api_url');
        $add_api_url = $api_url."Quotation/edit_quotation";

        $objarray = array("sell_list"=>$objarr);
     
        $res = $this->General_model->general_function($objarray,$add_api_url);
        echo $res;
    }

    
   
  
}
