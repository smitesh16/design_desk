<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

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
        $get_api_url = $api_url."Purchase/all_list";
        
        $objarray = array("purchase"=>array());
        $data['purchase'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
		$this->load->view('template/header',$data);
		$this->load->view('Purchase/purchase');
		$this->load->view('template/footer');
	}
    
    public function Add(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        
        $objarray = array("product"=>array());
        $data['product'] = json_decode($this->General_model->general_function($objarray,$get_api_url),true);
        
		$this->load->view('template/header',$data);
		$this->load->view('Purchase/purchase_add');
		$this->load->view('template/footer');
    }
    
    public function place_order(){
        $api_url = $this->config->item('api_url');
        $purchase_api_url = $api_url."Purchase/place_order";
        
        $data = $this->input->post();
        
        $objarray = array("data"=>$data);
        $res = $this->General_model->general_function($objarray,$purchase_api_url);
        echo $res;
    }
    
    public function single_purchase(){
        $api_url = $this->config->item('api_url');
        $get_api_url = $api_url."Purchase/all_list";
        
        $objarray = array("purchase"=>$this->input->post());
        $res = $this->General_model->general_function($objarray,$get_api_url);
        echo $res;
    }
    
    public function csv_upload(){
        $api_url = $this->config->item('api_url');
        $batch_api_url = $api_url."Purchase/Batch";
        
        $csv = $_FILES['purchase_csv']['tmp_name'];
        $extension = pathinfo($_FILES['purchase_csv']['name'], PATHINFO_EXTENSION);
        if($extension != 'csv')
        {
            $this->session->set_flashdata('alert', array('message' => 'Only CSV file is allowed!','class' => 'error'));
            header('Location: '.base_url().'Purchase');
        }
        else
        {
                $file =array_map('str_getcsv', file($csv));
                if(in_array("Purchase Number",$file[0]) && in_array("Product Part Number",$file[0]) && in_array("Product Quantity",$file[0]) && in_array("Product Price",$file[0]))
                {
                    unset($file[0]);
                    if(count($file)<=100){
                        $objarray = array('data'=>$file);
                        $response = json_decode($this->General_model->general_function($objarray,$batch_api_url),true);
                        
                        if($response['stat'] == 200){
                            $this->session->set_flashdata('alert', array('message' => 'Bulk purchase upload successfully','class' => 'auto_msg'));
                            header('Location: '.base_url().'Purchase');
                        } else{
                            $a = ['Purchase Number','Product Part Number','Product Quantity','Product Price','Remarks'];
                            $f = fopen("purchase_error.csv", "w");
                            fputcsv($f,$a);
                            foreach ($response['data'] as $data) {
                                fputcsv($f, $data);
                            }
                              header("Content-type: text/csv");
                              header("Content-disposition: attachment; filename = purchase_error.csv");
                              readfile(base_url()."/purchase_error.csv");
                        }
                    } else{
                        $this->session->set_flashdata('alert', array('message' => 'Your CSV contain maximum 100 products only','class' => 'error'));
                        header('Location: '.base_url().'Purchase');
                    }
                } 
                else
                {
                    $this->session->set_flashdata('alert', array('message' => 'Some field missing in your CSV','class' => 'error'));
                    header('Location: '.base_url().'Purchase');
                }
        }
    }
    
}
