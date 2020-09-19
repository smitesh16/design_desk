<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quotation_model extends CI_Model {

   
    public function add_quotation($data)
    { 
      
        $quotation_date=date('Y-m-d');

        $total_discount = 0;
        $total_tax      = 0;
        $sell_amount    = 0;
        $amount         = 0;
        $new_amt        = 0;
        $final_amount   = 0;
        $outstanding_amt= 0;
        $dis_per        = 0;
        $tax_per        = 0;
        
        //print_r($data);
       
       
        for($i=0;$i<count($data);$i++)
        { 
          $total_discount = $total_discount + $data[$i]['discount'];
          $total_tax      = $total_tax + $data[$i]['tax'];
          $sell_amount    = $sell_amount + $data[$i]['price'];
          $dis_per        = ($data[$i]['price'] * $data[$i]['per_discount'])/100;
          $new_amt        = $data[$i]['price'] - $dis_per;
          $tax_per        = ($new_amt * $data[$i]['per_tax'])/100;
          $amount         = $new_amt + $tax_per;
          $final_amount   = $final_amount + ($amount * $data[$i]['quantity']);
          
        }

        $outstanding_amt = $final_amount;
        $final_amount = round($final_amount,2);
        $total_discount = round($total_discount,2);
        $total_tax = round($total_tax,2);
        $sell_amount = round($sell_amount,2);
  
       
      
       
       
       $this->db->where('del_status',0);
       $this->db->where('sequence_id',7);
       $query=$this->db->get('sequence_master');
       $count= $query->num_rows();
       $res  = $query->result_array();
       
       if($count > 0)
       {
         $num=$res[0]['sequence_number'];
         $pref=$res[0]['prefix'];
         $quotation_num =  $pref.'_'.$num;
         $new_num =  $num + 1;

         $arr=array('sequence_number'=>$new_num);

             $this->db->where('sequence_id',$res[0]['sequence_id']);
             $this->db->update('sequence_master', $arr);

            
               
         $list=array('quotation_number'=>$quotation_num,'client_id'=>$data[0]['client_id'],'quotation_amount'=>$sell_amount,'total_discount'=>$total_discount,'total_tax'=>$total_tax,'final_amount'=>$final_amount,'quotation_date'=>$quotation_date,'quotation_note'=>$data[0]['sale_note']);

                $query=$this->db->insert('quotation_master',$list);
                $id= $this->db->insert_id();
                if($id)
                {  
                  $flag = 0;
                   for($i=0;$i<count($data);$i++)
                   {
                      $list1 = array('quotation_id'=>$id,'product_id'=>$data[$i]['product_id'],'quantity'=>$data[$i]['quantity'],'price'=>$data[$i]['price'],'discount'=>$data[$i]['per_discount'],'tax'=>$data[$i]['per_tax']);

                      $query=$this->db->insert('quotation_details_master',$list1);
                     
                      $insert_id= $this->db->insert_id();
                      if($insert_id)
                      {
                        $flag = 1;
                         
                      }
                      
                   }
                  
                 
                 if($flag == 1)
                 {

                   $res = array('stat'=>'200','msg'=>'Data added successfully');
                 }
                 else
                 {
                   $res = array('stat'=>'400','msg'=>'Product not Added.Some data is missing');
                 }
            }
            else
            {
               $res = array('stat'=>'400','msg'=>'Product not Added.Some data is missing');
            }

        }
        else
       {
           $res = array('stat'=>'400','msg'=>'Some data is missing');
       }

         

       return $res;

    }

    
    public function listing($data)
    { 
      
       
        $this->db->select('*');
      
       if(array_key_exists('quotation_id', $data))
       {
         
         $this->db->where('quotation_master.quotation_id',$data['quotation_id']);
       }
       
       $this->db->join('quotation_details_master', 'quotation_master.quotation_id = quotation_details_master.quotation_id');
       $this->db->join('product_master', 'product_master.product_id = quotation_details_master.product_id');
       $this->db->join('client_master', 'client_master.client_id = quotation_master.client_id');
       $query=$this->db->get('quotation_master');
    
       $count= $query->num_rows();
       $res  = $query->result_array();
       if($count>0){
           $new = "quotation_id,quotation_number,final_amount,quotation_date,quotation_note,company_name,company_address,contact_person,contact_number,pan_number,gstin_number,client_id";
           $repeat = "quotation_details_id,product_id,quantity,price,product_name,part_number,description,discount,tax,current_stock,default_price,igst";
           $byGroup = group_by("quotation_id",$new,$repeat,$res);
           return array("stat"=>200,"msg"=>"Quotation List.","all_list"=>$byGroup);
       } else{
           return array("stat"=>500,"msg"=>"No data found");
       }
       

    }


     public function delete($data)
    { 

        $this->db->from('quotation_master');
        $this->db->where('del_status',0);
        $this->db->where('quotation_id',$data['quotation_id']);
        $query = $this->db->get();
       
        $count_row = $query->num_rows();  
        if($count_row > 0)
        {
           $this->db->where('quotation_id', $data['quotation_id']);
           $this->db->where('del_status',0);
           $this->db->delete('quotation_details_master');

           $this->db->where('quotation_id', $data['quotation_id']);
           $this->db->where('del_status',0);
           $this->db->delete('quotation_master');

              $this->db->from('quotation_master');
              $this->db->where('del_status',0);
              $this->db->where('quotation_id',$data['quotation_id']);
              $query = $this->db->get();
              $count_row1 = $query->num_rows();
              if($count_row1 > 0)
              {
                $res = array('stat'=>'400','msg'=>'Quotation not deleted');
              }
              else
              {
                $res = array('stat'=>'200','msg'=>'Data deleted  successfully');
              }

        }
       else
      {
          $res = array('stat'=>'400','msg'=>'Quotation not found');
      }
      
    
     return $res;

    }

    public function edit_quotation($data)
    {
       $quotation_date=date('Y-m-d');

        $total_discount = 0;
        $total_tax      = 0;
        $sell_amount    = 0;
        $amount         = 0;
        $new_amt        = 0;
        $final_amount   = 0;
        $outstanding_amt= 0;
        $dis_per        = 0;
        $tax_per        = 0;
        
        //print_r($data);
       
       
        for($i=0;$i<count($data);$i++)
        { 
          $total_discount = $total_discount + $data[$i]['discount'];
          $total_tax      = $total_tax + $data[$i]['tax'];
          $sell_amount    = $sell_amount + $data[$i]['price'];
          $dis_per        = ($data[$i]['price'] * $data[$i]['per_discount'])/100;
          $new_amt        = $data[$i]['price'] - $dis_per;
          $tax_per        = ($new_amt * $data[$i]['per_tax'])/100;
          $amount         = $new_amt + $tax_per;
          $final_amount   = $final_amount + ($amount * $data[$i]['quantity']);
          
        }

        $outstanding_amt = $final_amount;
        $final_amount = round($final_amount,2);
        $total_discount = round($total_discount,2);
        $total_tax = round($total_tax,2);
        $sell_amount = round($sell_amount,2);
  
       
         $this->db->from('quotation_master');
         $this->db->where('del_status',0);
         $this->db->where('quotation_id',$data[0]['quotation_id']);
         $query = $this->db->get();
         $count_row = $query->num_rows();
         if($count_row > 0)
         {
              
           $this->db->where('quotation_id', $data[0]['quotation_id']);
           $this->db->where('del_status',0);
           $this->db->delete('quotation_details_master');

           $this->db->where('quotation_id', $data[0]['quotation_id']);
           $this->db->where('del_status',0);
           $this->db->delete('quotation_master');
         }
                 
         $list=array('quotation_number'=>$data[0]['quotation_num'],'client_id'=>$data[0]['client_id'],'quotation_amount'=>$sell_amount,'total_discount'=>$total_discount,'total_tax'=>$total_tax,'final_amount'=>$final_amount,'quotation_date'=>$quotation_date,'quotation_note'=>$data[0]['sale_note']);

                $query=$this->db->insert('quotation_master',$list);
                $id= $this->db->insert_id();
                if($id)
                {  
                  $flag = 0;
                   for($i=0;$i<count($data);$i++)
                   {
                      $list1 = array('quotation_id'=>$id,'product_id'=>$data[$i]['product_id'],'quantity'=>$data[$i]['quantity'],'price'=>$data[$i]['price'],'discount'=>$data[$i]['per_discount'],'tax'=>$data[$i]['per_tax']);

                      $query=$this->db->insert('quotation_details_master',$list1);
                     
                      $insert_id= $this->db->insert_id();
                      if($insert_id)
                      {
                        $flag = 1;
                         
                      }
                      
                   }
                  
                 
                 if($flag == 1)
                 {

                   $res = array('stat'=>'200','msg'=>'Data added successfully');
                 }
                 else
                 {
                   $res = array('stat'=>'400','msg'=>'Product not Added.Some data is missing');
                 }
            }
            else
            {
               $res = array('stat'=>'400','msg'=>'Product not Added.Some data is missing');
            }

       
         

       return $res;
      }
    
     
    }
?>