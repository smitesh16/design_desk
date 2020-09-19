<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_model extends CI_Model {

   
    public function customer_add($data)
    { 
        if(strlen((string)$data['contact_number']) < 10 && (strlen((string)$data['pan_number']) < 10) && (strlen((string)$data['gstin_number']) < 15))
        {
          $res = array('stat'=>'401','msg'=>'Your contact number :-'.$data['contact_number'].' and pan number :-'.$data['pan_number'].' and gstin number :-'.$data['gstin_number'].' is not valid .');
        }
        else if(strlen((string)$data['contact_number']) < 10 && (strlen((string)$data['pan_number']))< 10)
        {
          $res = array('stat'=>'401','msg'=>'Your contact number :-'.$data['contact_number'].' and pan number :-'.$data['pan_number'].' is not valid .');
        }
        else if(strlen((string)$data['contact_number']) < 10 && (strlen((string)$data['gstin_number']))< 15)
        {
          $res = array('stat'=>'401','msg'=>'Your contact number :-'.$data['contact_number'].' and gstin number :-'.$data['gstin_number'].' is not valid .');
        }
         else if(strlen((string)$data['pan_number']) < 10 && (strlen((string)$data['gstin_number']))< 15)
        {
          $res = array('stat'=>'401','msg'=>'Your pan number :-'.$data['pan_number'].' and gstin number :-'.$data['gstin_number'].' is not valid .');
        }
         else if(strlen((string)$data['contact_number']) < 10)
        {
          $res = array('stat'=>'401','msg'=>'Your contact number :-'.$data['contact_number'].' is not valid .');
        }
        
         else if(strlen((string)$data['pan_number']) < 10)
        {
          $res = array('stat'=>'401','msg'=>'Your PAN number :-'.$data['pan_number'].' is not valid .');
        }
        else if(strlen((string)$data['gstin_number']) < 15)
        {
          $res = array('stat'=>'401','msg'=>'Your GSTIN number :-'.$data['gstin_number'].' is not valid .');
        }
        else
        {
              $arr = [];
              $where  = "(`del_status` = 0 ) AND ";
              $where .= "(`gstin_number` ='".$data['gstin_number']."' OR ";
              $where .= "`pan_number` ='".$data['pan_number']."' OR ";
              $where .= "`contact_number` =".$data['contact_number']." OR ";
              $where .= "`user_email` ='".$data['user_email']."')";
              $this->db->where($where);
              $query = $this->db->get('client_master');
              $res   = $query->result_array();
              $count = $query->num_rows();
             
             if($count > 0)
             {   
               
                for($i=0;$i<$count;$i++)
                {
                  
                   if(trim($data['gstin_number']) == $res[$i]['gstin_number'])
                   {
                       $arr['gstin_number'] = $res[$i]['gstin_number'];
                       $arr['gstin_number'][$i]=$res[$i]['gstin_number'];

                   }
                   if(trim($data['pan_number']) == $res[$i]['pan_number'])
                   {
                       $arr['pan_number'] = $res[$i]['pan_number'];
                       $arr['pan_number'][$i]=$res[$i]['pan_number'];
                   }
                   if(trim($data['contact_number']) == $res[$i]['contact_number'])
                   {
                       $arr['contact_number'] = $res[$i]['contact_number'];
                       $arr['contact_number'][$i]=$res[$i]['contact_number'];
                   }
                   if(trim($data['user_name']) == $res[$i]['user_name'])
                   {
                       $arr['user_name'] = $res[$i]['user_name'];
                       $arr['user_name'][$i]=$res[$i]['user_name'];

                   }
                }
                
                
                 $res = array('stat'=>'400','msg'=>'User Pan Number, Contact Number,  Name,  GST Number, should be unique','all_list'=>$arr);
             }
             else
             {
                
               $query=$this->db->insert('client_master',$data);
               $id= $this->db->insert_id();
               $res = array('stat'=>'200','msg'=>'Customer Added Successfully','last_id'=>$id);

             }
          }

       return $res;

    }

    
    public function customer_edit($data)
    { if(strlen((string)$data['contact_number']) < 10 && (strlen((string)$data['pan_number']) < 10) && (strlen((string)$data['gstin_number']) < 15))
        {
          $res = array('stat'=>'401','msg'=>'Your contact number :-'.$data['contact_number'].' and pan number :-'.$data['pan_number'].' and gstin number :-'.$data['gstin_number'].' is not valid .');
        }
        else if(strlen((string)$data['contact_number']) < 10 && (strlen((string)$data['pan_number']))< 10)
        {
          $res = array('stat'=>'401','msg'=>'Your contact number :-'.$data['contact_number'].' and pan number :-'.$data['pan_number'].' is not valid .');
        }
        else if(strlen((string)$data['contact_number']) < 10 && (strlen((string)$data['gstin_number']))< 15)
        {
          $res = array('stat'=>'401','msg'=>'Your contact number :-'.$data['contact_number'].' and gstin number :-'.$data['gstin_number'].' is not valid .');
        }
         else if(strlen((string)$data['pan_number']) < 10 && (strlen((string)$data['gstin_number']))< 15)
        {
          $res = array('stat'=>'401','msg'=>'Your pan number :-'.$data['pan_number'].' and gstin number :-'.$data['gstin_number'].' is not valid .');
        }
        //  else if(strlen((string)$data['contact_number']) < 10)
        // {
        //   $res = array('stat'=>'401','msg'=>'Your contact number :-'.$data['contact_number'].' is not valid .');
        // }
        
         else if(strlen((string)$data['pan_number']) < 10)
        {
          $res = array('stat'=>'401','msg'=>'Your PAN number :-'.$data['pan_number'].' is not valid .');
        }
        else if(strlen((string)$data['gstin_number']) < 15)
        {
          $res = array('stat'=>'401','msg'=>'Your GSTIN number :-'.$data['gstin_number'].' is not valid .');
        }
        else
        {
              $where  = "(`del_status` = 0 AND ";
              $where .= "`client_id` != ".$data['client_id'].") AND";
              // $where .= "(`gstin_number` ='".$data['gstin_number']."' OR ";
              // $where .= "`pan_number` ='".$data['pan_number']."' OR ";
              // $where .= "(`contact_number` =".$data['contact_number']." OR ";
              $where .= "`user_email` ='".$data['user_email']."'";


             $this->db->where($where);
             $query =$this->db->get('client_master');
             $count = $query->num_rows();
             $res   =$query->result_array();
             
             if($count > 0)
             { 
                for($i=0;$i<$count;$i++)
                {
                  
                   // if(trim($data['gstin_number']) == $res[$i]['gstin_number'])
                   // {
                   //     $arr['gstin_number'] = $res[$i]['gstin_number'];
                   //     $arr['gstin_number'][$i]=$res[$i]['gstin_number'];

                   // }
                   // if(trim($data['pan_number']) == $res[$i]['pan_number'])
                   // {
                   //     $arr['pan_number'] = $res[$i]['pan_number'];
                   //     $arr['pan_number'][$i]=$res[$i]['pan_number'];
                   // }
                   if(trim($data['contact_number']) == $res[$i]['contact_number'])
                   {
                       $arr['contact_number'] = $res[$i]['contact_number'];
                       $arr['contact_number'][$i]=$res[$i]['contact_number'];
                   }
                   if(trim($data['user_name']) == $res[$i]['user_name'])
                   {
                       $arr['user_name'] = $res[$i]['user_name'];
                       $arr['user_name'][$i]=$res[$i]['user_name'];

                   }
                }
               $res = array('stat'=>'400','msg'=>'User Pan Number, Contact Number, Name,  GST Number should be unique','all_list'=>$arr);
             }
             else
             {
                
               $this->db->where('client_id', $data['client_id']);
               $this->db->update('client_master', $data);
               $res = array('stat'=>'200','msg'=>'Customer Updated Successfully');

             }
          }

           return $res;

    }

      public function add_batch($data)
      {   
            $flag= 0;   
            $arr_list = [];
            $update_list = [];
            for($i=0;$i<count($data);$i++)
            {    
               
                 $c_name  =$data[$i][0];
                 $contact =$data[$i][3];
                 $pan     =$data[$i][4];
                 $gst     =$data[$i][5];
                 
             
                 //(strpos(trim($data[$i][0]),"&") !== false || strpos(trim($data[$i][0]),"@") !== false || strpos(trim($data[$i][0]),"#") !== false || strpos(trim($data[$i][0]),".") !== false || strpos(trim($data[$i][0]),"_") !== false || strpos(trim($data[$i][0]),"-") !== false) &&
              
                 if(strlen(trim($data[$i][0]) <= 100) && $data[$i][0] != '')
                 { 
                    
                   
                   if(strlen(trim($data[$i][1])) <= 300 && $data[$i][1] != '')
                   {
                    
                     if(ctype_alpha(trim($data[$i][2])) &&  strlen(trim($data[$i][2])) <= 100 && $data[$i][2] != '')
                     {
                        if(ctype_digit(trim($data[$i][3])) && strlen(trim((string)$data[$i][3])) == 10 && $data[$i][3] != '' )
                        {
                            if(ctype_alnum(trim($data[$i][4])) && strlen(trim($data[$i][4])) == 10 && $data[$i][4] != '' )
                            {
                               if(ctype_alnum(trim($data[$i][5])) && strlen(trim($data[$i][5])) == 15 && $data[$i][5] != '' )
                               {   


                  
                                  /* $this->db->where('del_status',0);
                                   $this->db->where('contact_number',$contact);
                                   $query=$this->db->get('client_master');*/


                                   $where  = "(`del_status` = 0 ) AND ";
                                   $where .= "(`gstin_number` ='".$gst."' OR ";
                                   $where .= "`pan_number` ='".$pan."' OR ";
                                   $where .= "`company_name` ='".$c_name."')";
                                   $this->db->where($where);    
                                   $query=$this->db->get('client_master');
                                
                                   $count= $query->num_rows();
                                   $res_arr =$query->result_array();
                                   
                                   if($count == 0)
                                   {
                                       $flag= 1;
                                       $arr = array('company_name'=>$data[$i][0],'company_address'=>$data[$i][1],'contact_person'=>$data[$i][2],'contact_number'=>$data[$i][3],'pan_number'=>$data[$i][4],'gstin_number'=>$data[$i][5]);
                                       $query=$this->db->insert('client_master',$arr);
                                       
                                       $id= $this->db->insert_id();
                                   }
                                   else
                                   {   
                                       

                                        $where  = "(`del_status` = 0 ) AND ";
                                        $where .= "(`contact_number` ='".$contact."')";
                                        $this->db->where($where);
                                        $query1=$this->db->get('client_master');
                                        $count1= $query1->num_rows();

                                         if($count1 > 0)
                                         {
                                             $arr = array('company_name'=>$data[$i][0],'company_address'=>$data[$i][1],'contact_person'=>$data[$i][2],'contact_number'=>$data[$i][3],'pan_number'=>$data[$i][4],'gstin_number'=>$data[$i][5]);
                                             $this->db->where('client_id', $res_arr[0]['client_id']);
                                             $this->db->update('client_master', $arr);

                                             $update_list[$i] = $data[$i];

                                         }
                                         else
                                         {
                                           $data[$i][6]  = 'Same Company Name or  GSTIN  or  PAN  exists';
                                           $arr_list[$i] = $data[$i];
                                         }
                                    
                             
                                   }
                
        
                               }
                               else
                               { 
                                 $data[$i][6]  = 'GST Number not valid (15 characters)';
                                 $arr_list[$i] = $data[$i];
                                 
                               }
                            }
                            else
                            { 
                              $data[$i][6]  = 'Pan Number not valid (10 characters)';
                              $arr_list[$i] = $data[$i];
                             
                            }
                        }
                        else
                       { 
                         $data[$i][6]  = 'Contact Number not valid (10 digits)';
                         $arr_list[$i] = $data[$i];
                         
                       }
                     }
                     else
                     {
                       $data[$i][6]  = 'Contact Person name not valid (only characters ,100 max)';
                       $arr_list[$i] = $data[$i];
                       
                     }
                   }
                   else
                   { 
                     $data[$i][6]  = 'Company address not valid (300 max)';
                     $arr_list[$i] = $data[$i];
                     
                   }
                 }
                 else
                 {  
                    $data[$i][6]  = 'Company name not valid (100 max)';
                    $arr_list[$i] = $data[$i];
                   
                 }


                 
            }
         
          $arr_list =array_values($arr_list);   
          $update_list =array_values($update_list);   
          //print_r($update_list);
          
        if($flag ==1)
        {  
          
           $res = array('stat'=>'200','msg'=>'Customer Added Successfully','error_list'=>$arr_list,'update_list'=>$update_list);
        }
        else
        {
           $res = array('stat'=>'400','msg'=>'Please enter valid data in CSV file','error_list'=>$arr_list,'update_list'=>$update_list);
        } 

       return $res;

         
      }
     
    }
?>