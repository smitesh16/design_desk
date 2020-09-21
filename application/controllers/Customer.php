<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	
	public function index()
	{   

		if($this->session->userdata('admin_id')=="")
        {
              header('Location: '.base_url('Admin'));
              die;
        }
		
		$api_url = $this->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        $objarray = array("client"=>array());
        $response = $this->General_model->general_function($objarray,$get_api_url);
      
        $data['client_data'] =  json_decode($response,true);
		 
		$this->load->view('template/header');
		$this->load->view('Customer/customer',$data);
		$this->load->view('template/footer');
	}
	
	public function Add()
	{
        $api_url = $this->config->item('api_url');
        $add_api_url = $api_url."Customer";
        
     

	     $obj      = $this->input->post();
	     $phone    = $this->input->post('contact_number');

	     
	     $type     = $obj['type'];
	     unset($obj['type']);
	     $objarray = array("customer"=>$obj);
	     // print_r($objarray); //die;
	     $res = json_decode($this->General_model->general_function($objarray,$add_api_url),true);
         // print_r($res); die;
	     if($res['stat'] == 200)
	     {
			           
			 $this->session->set_flashdata('alert', array('message' => 'User Added Successfully','class' => 'success_msg_new'));
			 if($type == 'sell_1')
			  {
                header('Location: '.base_url().'Sell/Add_view');
			  }
			 else if($type == 'sell_2')
			  {
                header('Location: '.base_url().'Quotation/Add_view');
			  }
			  else
			  {
			  	header('Location: '.base_url().'Customer');
			  }
		 }
		else if($res['stat'] == 400)
	     {  
              $arr = $res['all_list'];
              $msg = 'The following fields are already added :- \n';
              foreach ($arr as $key => $value) {
              	 $msg .= $key.' : '.$value.'\n'; 
              }

             
			  $this->session->set_flashdata('alert', array('message' => $msg,'class' => 'error'));
			  if($type == 'sell_1')
			  {
                header('Location: '.base_url().'Sell/Add_view');
			  }
			  else if($type == 'sell_2')
			  {
                header('Location: '.base_url().'Quotation/Add_view');
			  }
			  else
			  {
			  	header('Location: '.base_url().'Customer');
			  }
			  
			
		 }
		 else if($res['stat'] == 401)
	     {  
	     	  $this->session->set_flashdata('alert', array('message' => $res['msg'],'class' => 'error'));
			  if($type == 'sell_1')
			  {
                header('Location: '.base_url().'Sell/Add_view');
			  }
			  else if($type == 'sell_2')
			  {
                header('Location: '.base_url().'Quotation/Add_view');
			  }
			  else
			  {
			  	header('Location: '.base_url().'Customer');
			  }
	     }

            

	}

	public function Edit()
	{
        $api_url = $this->config->item('api_url');
        $edit_api_url = $api_url."Customer/edit";
        
     

	     $obj      = $this->input->post();
	     $obj['pan_number'] = "1234567890";
	     $obj['gstin_number'] = "123456789012345";
	     $objarray = array("customer"=>$obj);

	     $res = json_decode($this->General_model->general_function($objarray,$edit_api_url),true);
			
		 
	     if($res['stat'] == 200)
	     {
			 if($obj['active_status'] == 1){
			 	$subject = "Welcome to Microcotton virtual showroom";
		       	$to = $obj['user_email'];
		       	$viewName = "approveuserTemplate";
		       	$mailData = array("Name"=>$obj['user_name']);
		       	sendMail($subject,$to,$viewName,$mailData);
			 }  
			 $this->session->set_flashdata('alert', array('message' => 'Customer Edited Successfully','class' => 'success_msg_new'));
			 header('Location: '.base_url().'Customer');
		 }
		else if($res['stat'] == 400)
	     {   
	     	 $arr = $res['all_list'];
              $msg = 'The following fields are already added :- \n';
              foreach ($arr as $key => $value) {
              	 $msg .= $key.' : '.$value.'\n'; 
              }
			 $this->session->set_flashdata('alert', array('message' => $msg,'class' => 'error'));
			 header('Location: '.base_url().'Customer');
		 }
		  else if($res['stat'] == 401)
	     {  
	     	  $this->session->set_flashdata('alert', array('message' => $res['msg'],'class' => 'error'));
			  header('Location: '.base_url().'Customer');
			  
	     }

            
	}

	public function ResetPass()
		{
	        $api_url = $this->config->item('api_url');
	        $api_url = $api_url."General/Update";
	        
	        $obj      = $this->input->post();
	        // pr($obj);
	        if($obj['password'] != $obj['conf_password']){
	        	$this->session->set_flashdata('alert', array('message' => "Both password is not matched",'class' => 'error'));
				header('Location: '.base_url().'Dashboard');
	        }else{
	        	$newobj = array("admin"=>array("password"=>base64_encode($obj['password'])),"where"=>array('admin_id'=>1));
	        	$resupdate = json_decode($this->General_model->general_function($newobj,$api_url),true);
	        	$this->session->set_flashdata('alert', array('message' => 'Password Reset Successfully','class' => 'success_msg_new'));
				 header('Location: '.base_url().'Dashboard');
	        }
	            
		}


    public function CSVUpload()
    {
        $api_url = $this->config->item('api_url');
        $add_batch_api_url = $api_url."Customer/add_batch";
        

        $extension = pathinfo($_FILES['csv_file']['name'], PATHINFO_EXTENSION);
        if($extension != 'csv')
        {
            $this->session->set_flashdata('alert', array('message' => 'Only CSV file is allowed!','class' => 'error'));
             header('Location: '.base_url().'Customer');
        }
        else
        {
       
		        $csv = $_FILES['csv_file']['tmp_name'];

		        $file =array_map('str_getcsv', file($csv));
		        $arr  =array('company_name','company_address','contact_person','contact_number','pan_number','gstin_number');
		        $flag = 0;

		        for($i=0;$i<count($file[0]);$i++)
		        {
		        	if(!in_array($file[0][$i], $arr))
		        	{   
		        		$flag=1;
		        	}
		        }

 
		     if($flag == 0)
		     {

		        unset($file[0]);
		        $file = array_values($file); 
		        
		        $objarray = array('customer'=>$file);
               /* echo json_encode($objarray);
                die();*/
		        $response = json_decode($this->General_model->general_function($objarray,$add_batch_api_url),true);

		        
		        if($response['stat'] == 200)
		        {   

		        	$msg1='';
		        	$msg2='';
		        	$a = ['company_name','company_address','contact_person','contact_number','pan_number','gstin_number'];
		        	$b = ['company_name','company_address','contact_person','contact_number','pan_number','gstin_number','remarks'];

		        	
		        	
		        	if(!empty($response['update_list'])) {
		        	$f = fopen("update_list.csv", "w");
		        	fputcsv($f,$a);
						foreach ($response['update_list'] as $line) {
						    fputcsv($f, $line);
						}
					  $msg1 = '<a href="'.base_url().'/update_list.csv" download>Click To Download</a>';
					 
					}
					if(!empty($response['error_list'])) {
					$f = fopen("error_list.csv", "w");
					fputcsv($f,$b);
						foreach ($response['error_list'] as $line) {
						    fputcsv($f, $line);
						}
						$msg2 = '<a href="'.base_url().'/error_list.csv" download>Click To Download</a>';
						
		            } 
                    

		            $this->session->set_flashdata('alert', array('message1' => $msg1,'message2' => $msg2,'class' => 'csv_success'));
		        }
		        else
		        {   
		        	
		        	$msg1='';
		        	$msg2='';
		        	$a = ['company_name','company_address','contact_person','contact_number','pan_number','gstin_number'];
		        	$b = ['company_name','company_address','contact_person','contact_number','pan_number','gstin_number','remarks'];
		        	
		        	if(!empty($response['update_list'])) {
		        	$f = fopen("update_list.csv", "w");
		        	fputcsv($f,$a);
						foreach ($response['update_list'] as $line) {
						    fputcsv($f, $line);
						}
					  $msg1 = '<a href="'.base_url().'/update_list.csv" download>Click To Download</a>';
					 
					}
					if(!empty($response['error_list'])) {
					$f = fopen("error_list.csv", "w");
					fputcsv($f,$b);
						foreach ($response['error_list'] as $line) {
						    fputcsv($f, $line);
						}
						$msg2 = '<a href="'.base_url().'/error_list.csv" download>Click To Download</a>';
						
		            } 

		            $this->session->set_flashdata('alert', array('message1' => $msg1,'message2' => $msg2,'class' => 'csv_error'));
                 }
               }
             else
             {
                 $this->session->set_flashdata('alert', array('message' => 'Field Names not Matching in CSV','class' => 'error'));
		        		 
		      }
        
          header('Location: '.base_url().'Customer');
         }
    }
}
