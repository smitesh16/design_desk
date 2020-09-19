<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sell_model extends CI_Model {

   
    public function add_sell($data)
    { 
      
        $sell_date=date('Y-m-d');

        $total_discount = 0;
        $total_tax      = 0;
        $sell_amount    = 0;
        $amount         = 0;
        $final_amount   = 0;
        $outstanding_amt= 0;
        $new_array      = $data;
       
      
 
        for($i=0;$i<count($data);$i++)
        {  
         
           $this->db->where('del_status',0);
           $this->db->where('current_stock >',0);
           $this->db->where('product_id',$data[$i]['product_id']);
           $this->db->where('current_stock >=',$data[$i]['quantity']);
           $query=$this->db->get('product_master');

           $count= $query->num_rows();
           if($count == 0)
           {
              unset($new_array[$i]);
           }


        }


    

     $data = $new_array;
     $data = array_values($data);
    /* print_r($data);
     die();
*/
    if(!empty($data)) {

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
       $this->db->where('sequence_id',1);
       $query=$this->db->get('sequence_master');
       $count= $query->num_rows();
       $res  = $query->result_array();
       
       if($count > 0)
       {
         $num=$res[0]['sequence_number'];
         $pref=$res[0]['prefix'];
         $invoice_num =  $pref.'_'.$num;
         $new_num =  $num + 1;

         $arr=array('sequence_number'=>$new_num);

             $this->db->where('sequence_id',$res[0]['sequence_id']);
             $this->db->update('sequence_master', $arr);

            
               
         $list=array('invoice_number'=>$invoice_num,'client_id'=>$data[0]['client_id'],'sell_amount'=>$sell_amount,'total_discount'=>$total_discount,'total_tax'=>$total_tax,'final_amount'=>$final_amount,'outstanding_amount'=>$final_amount,'chalan_number'=>'','chalan_date'=>'','sell_date'=>$sell_date,'sale_note'=>$data[0]['sale_note']);

                $query=$this->db->insert('sell_master',$list);
                $id= $this->db->insert_id();
                if($id)
                {
                   for($i=0;$i<count($data);$i++)
                   {
                      $list1 = array('sell_id'=>$id,'product_id'=>$data[$i]['product_id'],'quantity'=>$data[$i]['quantity'],'price'=>$data[$i]['price'],'discount'=>$data[$i]['per_discount'],'tax'=>$data[$i]['per_tax']);

                      $query=$this->db->insert('sell_details_master',$list1);
                     
                      $insert_id= $this->db->insert_id();
                      if($insert_id)
                      {
                         $rem  = $data[$i]['stock'] - $data[$i]['quantity'];
                         $arr1 = array('current_stock'=>$rem);

                         $this->db->where('product_id',$data[$i]['product_id']);
                         $this->db->update('product_master', $arr1);

                         $this->db->where('del_status',0);
                         $this->db->where('product_id',$data[$i]['product_id']);
                         $this->db->where('date',$sell_date);
                         $query=$this->db->get('daily_stock_inout_master');
                         //echo $this->db->last_query();
                         $count1= $query->num_rows();
                         $res1  = $query->result_array();
                         if($count1 == 0)
                         {  

                            

                             $list2 = array('total_sell'=>$data[$i]['quantity'],'final_stock'=>$rem,'product_id'=>$data[$i]['product_id'],'date'=>$sell_date);
                             $query=$this->db->insert('daily_stock_inout_master',$list2);
                              
                         }
                         else
                         {  
                             $total = $res1[0]['total_sell'] + $data[$i]['quantity'];
                             $final = $res1[0]['final_stock'] - $data[$i]['quantity'];
                             $list3 = array('total_sell'=>$total,'final_stock'=>$final);
                             $this->db->where('daily_stock_inout_id',$res1[0]['daily_stock_inout_id']);
                             $this->db->update('daily_stock_inout_master', $list3);

                         }


                        
                      }
                      
                   }
                  

                   $res = array('stat'=>'200','msg'=>'Data added successfully');
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
   }

   else
       {
           $res = array('stat'=>'500','msg'=>'Product Stock is not there');
       }
         

       return $res;

 }

    
    public function listing($data)
    { 
      
       
        $this->db->select('*');
      
       if(array_key_exists('sell_id', $data))
       {
         
         $this->db->where('sell_master.sell_id',$data['sell_id']);
       }
       else if(array_key_exists('date', $data))
       {
          $this->db->where('sell_master.sell_date >=',$data['date']['from']);
          $this->db->where('sell_master.sell_date <=',$data['date']['to']);

           if($data['date']['client'] && ($data['date']['client'] != '') &&  ($data['date']['client'] != 0) &&  ($data['date']['client'] != "0"))
           {        
             $this->db->where('sell_master.client_id',$data['date']['client']);
           }
       }
       $this->db->join('sell_details_master', 'sell_master.sell_id = sell_details_master.sell_id');
       $this->db->join('product_master', 'product_master.product_id = sell_details_master.product_id');
       $this->db->join('client_master', 'client_master.client_id = sell_master.client_id');
       $query=$this->db->get('sell_master');
    
     
       $count= $query->num_rows();
       $res  = $query->result_array();
       if($count>0){
           $new = "sell_id,invoice_number,final_amount,outstanding_amount,sell_date,chalan_number,chalan_date,chalan_status,company_name,company_address,contact_person,contact_number,pan_number,gstin_number";
           $repeat = "sell_details_id,product_id,quantity,price,product_name,part_number,description,discount,tax";
           $byGroup = group_by("sell_id",$new,$repeat,$res);
           return array("stat"=>200,"msg"=>"Sell List.","all_list"=>$byGroup);
       } else{
           return array("stat"=>500,"msg"=>"No data found");
       }
       

    }

    public function chalan($data)
    {
       $id=$data['sell_id'];
       $date = date('Y-m-d');

       $this->db->where('del_status',0);
       $this->db->where('sequence_id',5);
       $query=$this->db->get('sequence_master');
       $count= $query->num_rows();
       $res  = $query->result_array();
       
       if($count > 0)
       {
         $num        = $res[0]['sequence_number'];
         $pref       = $res[0]['prefix'];
         $chalan_num = $pref.'_'.$num;
         $new_num    = $num + 1;

             $arr=array('sequence_number'=>$new_num);
             $this->db->where('sequence_id',$res[0]['sequence_id']);
             $this->db->update('sequence_master', $arr);
             $count1 = $this->db->affected_rows();
             if($count1 > 0)
             {
                  $arr1 = array('chalan_number'=>$chalan_num,'chalan_date'=>$date,'chalan_status'=>1);
                  $this->db->where('sell_id',$id);
                  $this->db->update('sell_master',$arr1);
                  $count2 = $this->db->affected_rows();
                  if($count2 > 0)
                  {
                      return array("stat"=>200,"msg"=>"Data updated successfully");
                  }
                  else
                  {
                     return array("stat"=>400,"msg"=>"Data not updated");
                  }
             }
             else
             {
                 return array("stat"=>400,"msg"=>"Data not updated");
             }
             

       }
       else
       {
          return array("stat"=>400,"msg"=>"No data found");
       }

    }

    
     
    }
?>