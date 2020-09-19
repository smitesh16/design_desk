<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

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
        if($this->session->userdata('admin_id')=="")
        {
              header('Location: '.base_url('Admin'));
              die;
        }
		$api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        
        $objarray = array("product"=>array());
        $data['product'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
		$this->load->view('template/header',$data);
		$this->load->view('Product/product');
		$this->load->view('template/footer');
	}
    
    public function csv_upload()
    {
        $api_url = $this->config->item('api_url');
        $batch_api_url = $api_url."Product/Batch";
        
        $csv = $_FILES['product_csv']['tmp_name'];
        $extension = pathinfo($_FILES['product_csv']['name'], PATHINFO_EXTENSION);

        if($extension != 'csv')
        {   
            $this->session->set_flashdata('alert', array('message' => 'Only CSV file is allowed!','class' => 'error'));
            header('Location: '.base_url().'Product');
        } 
        else
        {
            $file =array_map('str_getcsv', file($csv));
            if(in_array("Product Name",$file[0]) && in_array("Part Number",$file[0]) && in_array("Description",$file[0]) && in_array("HSN Code",$file[0]) && in_array("IGST",$file[0]) && in_array("Default Price",$file[0]))
            {
                unset($file[0]);
                $objarray = array('data'=>$file);
                $response = json_decode($this->General_model->general_function($objarray,$batch_api_url),true);
                if($response['stat'] == 200){
                    $this->session->set_flashdata('alert', array('message' => 'Product upload successfully','class' => 'success'));
                    header('Location: '.base_url().'Product');
                } else{
                    $a = ['Product Name','Part Number','Description','HSN Code','IGST','Default Price','Remarks'];
                    $f = fopen("product_error.csv", "w");
                    fputcsv($f,$a);
                    foreach ($response['data'] as $data) {
                        fputcsv($f, $data);
                    }
                      header("Content-type: text/csv");
                      header("Content-disposition: attachment; filename = product_error.csv");
                      readfile(base_url()."/product_error.csv");
                }
                
            } 
            else
            {
                $this->session->set_flashdata('alert', array('message' => 'Some field missing in your CSV','class' => 'error'));
                header('Location: '.base_url().'Product');
            }
        }
    }

    public function Get($param="")
    {
        if($this->session->userdata('user_id')=="")
        {
              header('Location: '.base_url());
              die;
        }
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        
        $objarray = array("product"=>array('parmalink'=>$param));
        $data['product'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        if($data['product']['stat'] != 200){
             header('Location: '.base_url('ErrorPage'));
              die;
        }
        // echo "<pre>"; print_r($data); die;
        // $this->load->view('template/uiheader',$data);
        $this->load->view('Pages/product',$data);
        // $this->load->view('template/uifooter');
    }
    public function GetAll($param="")
    {
        if($this->session->userdata('user_id')=="")
        {
              header('Location: '.base_url());
              die;
        }
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        
        $objarray = array("product"=>array('category_id'=>$param),"order_by"=>array("product_id"=>"desc"));
        $data['product'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        if($data['product']['stat'] != 200){
             header('Location: '.base_url('ErrorPage'));
              die;
        }
        // echo "<pre>"; print_r($data); die;
        // $this->load->view('template/uiheader',$data);
        $this->load->view('Pages/productlisting',$data);
        // $this->load->view('template/uifooter');
    }
}
