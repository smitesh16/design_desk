<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class General extends CI_Controller {
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    
   public function GetSingleData()
    {
       $api_url = $this->config->item('api_url');
       $api_url = $api_url."General/Get";
       $response = $this->General_model->general_function($this->input->post(),$api_url);
       echo $response;
    }
   public function DeleteData()
    {
       $api_url = $this->config->item('api_url');
       $api_url = $api_url."General/remove";
       $response = $this->General_model->general_function($this->input->post(),$api_url);
       echo $response;
    }
   public function AddData()
    {
       $url = $this->config->item('api_url');
       //$api_url = $this->config->item('api_url');
       $api_url = $url."General/Add";
       $objarray=$this->input->post();
       
       $table_attribute=base64_decode($objarray['table_attribute']);
       unset($objarray['table_attribute']);
       
       if($table_attribute == "product"){
          if(!empty($_FILES['product_image']['name'])){
          $extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
          $config['upload_path'] = $this->config->item('upload_path');
          $config['allowed_types'] = 'jpg|jpeg|png';
          $config['file_name'] = time().".".$extension;
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if($this->upload->do_upload('product_image')){
              $uploadData = $this->upload->data();
               $picture = $uploadData['file_name'];
               $objarray['product_image'] = $picture;
          }else{
               $picture = 'upload problem';
              // $picture = '';
          }
          }else{
               $picture = 'Field blank';
              // $picture = '';
          }

          if(!empty($_FILES['category_image']['name'])){
                $extension = pathinfo($_FILES['category_image']['name'], PATHINFO_EXTENSION);
                $config['upload_path'] = $this->config->item('upload_path');
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = time().".".$extension;
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                if($this->upload->do_upload('category_image')){
                    $uploadData = $this->upload->data();
                     $picture = $uploadData['file_name'];
                     $objarray['category_image'] = $picture;
                }else{
                     $picture = 'upload problem';
                    // $picture = '';
                }
                }else{
                     $picture = 'Field blank';
                    // $picture = '';
                }

              $other_images_data = [];
              $count = count($_FILES['other_images']['name']);
        
              for($i=0;$i<$count;$i++){
            
                if(!empty($_FILES['other_images']['name'][$i])){
            
                  $_FILES['file']['name'] = $_FILES['other_images']['name'][$i];
                  $_FILES['file']['type'] = $_FILES['other_images']['type'][$i];
                  $_FILES['file']['tmp_name'] = $_FILES['other_images']['tmp_name'][$i];
                  $_FILES['file']['error'] = $_FILES['other_images']['error'][$i];
                  $_FILES['file']['size'] = $_FILES['other_images']['size'][$i];
                  $extension = pathinfo($_FILES['other_images']['name'][$i], PATHINFO_EXTENSION);
                  $config['upload_path'] =  $this->config->item('upload_path');
                  $config['allowed_types'] = 'jpg|jpeg|png|gif';
                  $config['max_size'] = '5000';
                  $config['file_name'] = time().$i.".".$extension;;
           
                  $this->load->library('upload',$config); 
            
                  if($this->upload->do_upload('file')){
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
           
                    $other_images_data['totalFiles'][] = $filename;
                  }
                  $objarray['other_images'] = implode(',', $other_images_data['totalFiles']);
                }
              }






           // $objarray['product_tags'] =implode(',', $objarray['product_tags']);
           $obj = array($table_attribute=>$objarray,"check"=>"part_number");
       } else{
           $obj = array($table_attribute=>$objarray);
       }
        
       
      // print_r($obj); die;  

       $response = json_decode($this->General_model->general_function($obj,$api_url),true);
      
       
       if($response['stat']==200)
       {   
            $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'auto_msg'));
       }
       else 
       {
           if($table_attribute == 'product'){
                if($response['msg'] == "Insert failed. This same value exist"){
                    $this->session->set_flashdata('alert', array('message' => "Part number already exist",'class' => 'error'));
                } else{
                    $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'error'));
                }
           } else{
               $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'error'));
           }
       }
       
        header('Location: '.base_url().ucfirst($table_attribute));
    }
   public function EditData()
    {
       $url = $this->config->item('api_url');
       $api_url = $url."General/Update";
       $objarray=$this->input->post();
       $table_attribute=base64_decode($objarray['table_attribute']);
       $table_id=$objarray[$table_attribute.'_id'];
       // print_r($objarray); die;
       unset($objarray['table_attribute']);
       unset($objarray[$table_attribute.'_id']);

       if($table_attribute == "product"){
           if(!empty($_FILES['product_image']['name'])){
              $extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
              $config['upload_path'] = $this->config->item('upload_path');
              $config['allowed_types'] = 'jpg|jpeg|png';
              $config['file_name'] = time().".".$extension;
              $this->load->library('upload',$config);
              $this->upload->initialize($config);

              if($this->upload->do_upload('product_image')){
                  $uploadData = $this->upload->data();
                   $picture = $uploadData['file_name'];
                   if($objarray['prev_product_img'] != ''){
                    unlink($this->config->item('upload_path').$objarray['prev_product_img']);
                  }
                   unset($objarray['prev_product_img']);
                   $objarray['product_image'] = $picture;
              }else{
                   $picture = 'upload problem';
                  // $picture = '';
              }
              }else{
                   $picture = 'Field blank';
                  // $picture = '';
              }

              if(!empty($_FILES['category_image']['name'])){
                $extension = pathinfo($_FILES['category_image']['name'], PATHINFO_EXTENSION);
                $config['upload_path'] = $this->config->item('upload_path');
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = time().".".$extension;
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                if($this->upload->do_upload('category_image')){
                    $uploadData = $this->upload->data();
                     $picture = $uploadData['file_name'];
                     if($objarray['prev_category_img'] != ''){
                      unlink($this->config->item('upload_path').$objarray['prev_category_img']);
                     }
                     unset($objarray['prev_category_img']);
                     $objarray['category_image'] = $picture;
                }else{
                     $picture = 'upload problem';
                    // $picture = '';
                }
                }else{
                     $picture = 'Field blank';
                    // $picture = '';
                }

              $other_images_data = [];
              $count = count($_FILES['other_images']['name']);
        
              for($i=0;$i<$count;$i++){
            
                if(!empty($_FILES['other_images']['name'][$i])){
            
                  $_FILES['file']['name'] = $_FILES['other_images']['name'][$i];
                  $_FILES['file']['type'] = $_FILES['other_images']['type'][$i];
                  $_FILES['file']['tmp_name'] = $_FILES['other_images']['tmp_name'][$i];
                  $_FILES['file']['error'] = $_FILES['other_images']['error'][$i];
                  $_FILES['file']['size'] = $_FILES['other_images']['size'][$i];
                  $extension = pathinfo($_FILES['other_images']['name'][$i], PATHINFO_EXTENSION);
                  $config['upload_path'] =  $this->config->item('upload_path');
                  $config['allowed_types'] = 'jpg|jpeg|png|gif';
                  $config['max_size'] = '5000';
                  $config['file_name'] = time().$i.".".$extension;;
           
                  $this->load->library('upload',$config); 
            
                  if($this->upload->do_upload('file')){
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
           
                    $other_images_data['totalFiles'][] = $filename;
                  }
                  $objarray['other_images'] = implode(',', $other_images_data['totalFiles']);
                }
              }


              unset($objarray['prev_product_img']);
              unset($objarray['prev_category_img']);
              // $objarray['product_tags'] =implode(',', $objarray['product_tags']);
               // print_r($objarray); die;
           $obj = array($table_attribute=>$objarray,"where"=>array($table_attribute.'_id'=>$table_id),"check"=>"part_number");
       } else{
           $obj = array($table_attribute=>$objarray,"where"=>array($table_attribute.'_id'=>$table_id));
       }
           
        // print_r($obj); die;  
       $response = json_decode($this->General_model->general_function($obj,$api_url),true);
       // print_r($response); die;  
       if($response['stat']==200)
       { 
            $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'auto_msg'));
       }
       else 
       {
            if($table_attribute == 'product'){
                if($response['msg'] == "Update Failed. This same value exist"){
                    $this->session->set_flashdata('alert', array('message' => "Part number already exist",'class' => 'error'));
                } else{
                    $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'error'));
                }
           } else{
               $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'error'));
           }
       }
       
        header('Location: '.base_url().ucfirst($table_attribute));
       
    }
    public function ChangeStatus()
   {
       $api_url = $this->config->item('api_url');
       $api_url = $api_url."General/Update";
       $objarray=$this->input->post();
       $response = json_decode($this->General_model->general_function($objarray,$api_url),true);
       echo json_encode($response);
   }
    
    public function CSVUpload()
    {
        $api_url = $this->config->item('api_url');
        $add_batch_api_url = $api_url."General/Add_batch";
        
        $objarray=$this->input->post();
        $table_attribute=base64_decode($objarray['table_attribute']);
       
        
        $extension = pathinfo($_FILES[$table_attribute.'_csv_file']['name'], PATHINFO_EXTENSION);
        if($extension != 'csv')
        {
            $this->session->set_flashdata('alert', array('message' => 'Only CSV file is allowed!','class' => 'error'));
            header('Location: '.base_url().ucfirst($table_attribute));
        }

        
        $file_data = $this->excel->get_array($_FILES[$table_attribute."_csv_file"]["tmp_name"]);
        $objarray = array($table_attribute=>$file_data);
        
        $response = json_decode($this->General_model->general_function($objarray,$add_batch_api_url),true);
        if($response['stat'] == 200)
        {
            $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'success'));
        }
        else
        {
            $this->session->set_flashdata('alert', array('message' => $response['msg'],'class' => 'error'));
        }
        
        header('Location: '.base_url().ucfirst($table_attribute));
    }
    
    
}
