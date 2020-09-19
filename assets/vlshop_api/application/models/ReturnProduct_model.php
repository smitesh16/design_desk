<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReturnProduct_model extends CI_Model {
    
    
    public function sell_wise_product($data){

          $sql = "SELECT *, CASE WHEN EXISTS(SELECT rm.return_quantity FROM return_master rm WHERE rm.sell_id=sdm.sell_id AND rm.product_id=sdm.product_id)>0 THEN (SELECT SUM(rm.return_quantity) FROM return_master rm WHERE rm.sell_id=sdm.sell_id AND rm.product_id=sdm.product_id ) ELSE 0 END return_quantity, (SELECT pm.product_name FROM product_master pm WHERE pm.product_id=sdm.product_id) AS product_name,(SELECT pm.part_number FROM product_master pm WHERE pm.product_id=sdm.product_id) AS part_number FROM sell_details_master sdm WHERE sdm.sell_id=".$data['sell_id'];
          $query = $this->db->query($sql);
          $res = $query->result_array();

          if(count($res)>0){
            return array("stat"=>200,"msg"=>"All List","all_list"=>$res);
           } else{
          return array("stat"=>500,"msg"=>"No Data Found");
        }
       /*$sql1   = "SELECT * FROM sell_master WHERE `sell_id`=".$data['sell_id']." AND `outstanding_amount`= '0.00'";
       $query1 = $this->db->query($sql1);
       $res1   = $query1->result_array();
      
       if(count($res1) > 0)
       {  
          return array("stat"=>500,"msg"=>"No Products to return");
       }*/
        
    }
    
  /*  public function return_submit($data){
        //echo "<pre>";print_r($data);die;
        $date = date('Y-m-d');
        $qty      = "";
        $r_insert = "";
        $p_update = "";
        $p_where = "";
        $dsio_insert_query = '';
        $dsio_update_query = '';
        $dsio_update_query1 = '';
        $dsio_update_w_query = '';

         $sql1   = "SELECT * FROM sell_master WHERE `sell_id`=".$data['sell_id']." AND `outstanding_amount`= '0.00'";
         $query1 = $this->db->query($sql1);
         $res1   = $query1->result_array();
        
         if(count($res1) > 0)
         {  
            return array("stat"=>500,"msg"=>"Products cannot be returned");
         }
         else
         {

            $dsio_sql = "SELECT GROUP_CONCAT(`product_id`) AS product_id FROM `daily_stock_inout_master` WHERE `date`='".$date."'";
            $dsio_query = $this->db->query($dsio_sql);
            $dsio_res = $dsio_query->result_array();
            if(count($dsio_res)>0){
                $product_id_arr = explode(",",$dsio_res[0]['product_id']);
            } else{
                $product_id_arr = array();
            }

            //Find the return number
            $sq_sql = "SELECT * FROM `sequence_master` WHERE `sequence_id`=8";
            $sq_query = $this->db->query($sq_sql);
            $sq_res = $sq_query->result_array();
            $return_no = $sq_res[0]['sequence_number'];
            $return_prefix = $sq_res[0]['prefix'];
            
            foreach($data['return_details'] as $return_details){
                $s_sql = "SELECT * FROM `sell_details_master` WHERE sell_id=".$data['sell_id']." AND product_id=".$return_details['product_id'];
                $s_query = $this->db->query($s_sql);
                $s_res = $s_query->result_array();

                if(count($s_res)>0){
                    
                    $r_sql = "SELECT SUM(`return_quantity`) AS return_quantity FROM `return_master` WHERE `sell_id`=".$data['sell_id']." AND `product_id`=".$return_details['product_id'];
                    $r_query = $this->db->query($r_sql);
                    $r_res = $r_query->result_array();
                    //Check if product return then sum of now and before quantity is not greater than sell quantity
                    $all_return_quantity = $r_res[0]['return_quantity'] + $return_details['return_quantity'];
                    if($all_return_quantity <= $s_res[0]['quantity']){


                       $r_insert .= "(".$data['sell_id'].",".$return_details['product_id'].",".$return_details['return_quantity'].",".$return_no.",'".$date."'),";
                        $p_update .= " WHEN ".$return_details['product_id']." THEN current_stock+".$return_details['return_quantity']." ";
                        $p_where .= $return_details['product_id'].",";
                        
                       if(in_array($return_details['product_id'],$product_id_arr)){
                          $dsio_update_query .= " WHEN product_id=".$return_details['product_id']." THEN total_return+".$return_details['return_quantity']." ";
                          $dsio_update_query1 .= " WHEN product_id=".$return_details['product_id']." THEN final_stock+".$return_details['return_quantity']." ";
                          $dsio_update_w_query .= $return_details['product_id'].",";
                      }else{
                           $sql = "SELECT * FROM `product_master` WHERE product_id=".$return_details['product_id'];
                           $query = $this->db->query($sql);
                           $res = $query->result_array();
                           $final_stock = $res[0]['current_stock']+$return_details['return_quantity'];
                           
                          $dsio_insert_query .= "(".$return_details['product_id'].",".$return_details['return_quantity'].", ".$final_stock.", '".$date."'),";
                      }
                    }
                } 
            }
            
              //Multiple return insert
              if($r_insert != ''){
                  $r_insert = rtrim($r_insert,",");
                  $r_in_sql = "INSERT INTO `return_master`(`sell_id`, `product_id`, `return_quantity`, `return_no`, `date`) VALUES ".$r_insert;
                  $this->db->query($r_in_sql);
                  
                  $sq_update_sql = "UPDATE `sequence_master` SET `sequence_number`=sequence_number+1 WHERE `sequence_id`=8";
                  $this->db->query($sq_update_sql);
              }

              //Multiple product update current stock
              if($p_update != ''){
                  $p_where = rtrim($p_where,",");
                  $sell_sql = "UPDATE `product_master` SET `current_stock`= CASE `product_id` ".$p_update." END WHERE `product_id` IN (".$p_where.")";
                  $this->db->query($sell_sql);
              }
            
              //Daily stock update 
              if($dsio_update_query != ''){
                  $dsio_update_w_query = rtrim($dsio_update_w_query,",");
                  $u_dsio_sql = "UPDATE daily_stock_inout_master SET total_return = (case ".$dsio_update_query." end), final_stock = (case ".$dsio_update_query1." end) WHERE date='".$date."' AND product_id in (".$dsio_update_w_query.")";
                  $this->db->query($u_dsio_sql);
              }

              //Daily stock insert
              if($dsio_insert_query != ''){
                  $dsio_insert_query = rtrim($dsio_insert_query,",");
                  $dsio_i_sql = "INSERT INTO `daily_stock_inout_master`(product_id, `total_return`, `final_stock`, `date`) VALUES ".$dsio_insert_query;
                  $this->db->query($dsio_i_sql);
              }
            
            return array("stat"=>200,"msg"=>"Return successfully");   

       }
    }*/


  public function return_submit($data)
  {
        //echo "<pre>";print_r($data);die;
        $date = date('Y-m-d');
        $total_return_amt = 0;
        $r_insert = "";
        $p_update = "";
        $p_where = "";
        $dsio_insert_query = '';
        $dsio_update_query = '';
        $dsio_update_query1 = '';
        $dsio_update_w_query = '';


            $dsio_sql = "SELECT GROUP_CONCAT(`product_id`) AS product_id FROM `daily_stock_inout_master` WHERE `date`='".$date."'";
            $dsio_query = $this->db->query($dsio_sql);
            $dsio_res = $dsio_query->result_array();
            if(count($dsio_res)>0){
                $product_id_arr = explode(",",$dsio_res[0]['product_id']);
            } else{
                $product_id_arr = array();
            }

            //Find the return number
            $sq_sql = "SELECT * FROM `sequence_master` WHERE `sequence_id`=8";
            $sq_query = $this->db->query($sq_sql);
            $sq_res = $sq_query->result_array();
            $return_no = $sq_res[0]['sequence_number'];
            $return_prefix = $sq_res[0]['prefix'];
            
            foreach($data['return_details'] as $return_details){
                $s_sql = "SELECT * FROM `sell_details_master` WHERE sell_id=".$data['sell_id']." AND product_id=".$return_details['product_id'];
                $s_query = $this->db->query($s_sql);
                $s_res = $s_query->result_array();

                if(count($s_res)>0){
                    
                    $r_sql = "SELECT SUM(`return_quantity`) AS return_quantity FROM `return_master` WHERE `sell_id`=".$data['sell_id']." AND `product_id`=".$return_details['product_id'];
                    $r_query = $this->db->query($r_sql);
                    $r_res = $r_query->result_array();
                    //Check if product return then sum of now and before quantity is not greater than sell quantity
                    $all_return_quantity = $r_res[0]['return_quantity'] + $return_details['return_quantity'];
                    if($all_return_quantity <= $s_res[0]['quantity']){


                      $return_qty   = $return_details['return_quantity'];
               
                      $dis           = floatval(($s_res[0]['price'] * $s_res[0]['discount'])/100);
                      $rem           = $s_res[0]['price'] - $dis;
                      $tax              = floatval(($rem * $s_res[0]['tax'])/100);
                      $return_amount    =   ($rem + $tax) * $return_qty;
                     
                      $total_return_amt    = floatval($total_return_amt) + floatval($return_amount);
         
                      
                     


                       $r_insert .= "(".$data['sell_id'].",".$return_details['product_id'].",".$return_details['return_quantity'].",".$return_no.",'".$date."'),";
                        $p_update .= " WHEN ".$return_details['product_id']." THEN current_stock+".$return_details['return_quantity']." ";
                        $p_where .= $return_details['product_id'].",";
                        
                       if(in_array($return_details['product_id'],$product_id_arr)){
                          $dsio_update_query .= " WHEN product_id=".$return_details['product_id']." THEN total_return+".$return_details['return_quantity']." ";
                          $dsio_update_query1 .= " WHEN product_id=".$return_details['product_id']." THEN final_stock+".$return_details['return_quantity']." ";
                          $dsio_update_w_query .= $return_details['product_id'].",";
                      }else{
                           $sql = "SELECT * FROM `product_master` WHERE product_id=".$return_details['product_id'];
                           $query = $this->db->query($sql);
                           $res = $query->result_array();
                           $final_stock = $res[0]['current_stock']+$return_details['return_quantity'];
                           
                          $dsio_insert_query .= "(".$return_details['product_id'].",".$return_details['return_quantity'].", ".$final_stock.", '".$date."'),";
                      }
                    }
                } 
            }
            
              //Multiple return insert
              if($r_insert != ''){
                   
                   $total_return_amt =round($total_return_amt,2);
                  
                   $sql1   = "SELECT * FROM sell_master WHERE `sell_id`=".$data['sell_id'];
                   $query1 = $this->db->query($sql1);
                   $res1   = $query1->result_array();
                  
                   if(count($res1) > 0)
                   {  
                      if($total_return_amt >  $res1[0]['outstanding_amount'])
                      {
                         $update_sql = "UPDATE `sell_master` SET `outstanding_amount`= 0 WHERE `sell_id`=".$data['sell_id'];

                         $this->db->query($update_sql);
                      }
                      else if($total_return_amt <=  $res1[0]['outstanding_amount'])
                      {
                         $result = floatval($res1[0]['outstanding_amount']- $total_return_amt);
                         $update_sql = "UPDATE `sell_master` SET `outstanding_amount`= ".$result." WHERE `sell_id`=".$data['sell_id'];
                         $this->db->query($update_sql);

                      }
                   }
                  /* echo $total_return_amt;
                   die();*/
                  $r_insert = rtrim($r_insert,",");
                  $r_in_sql = "INSERT INTO `return_master`(`sell_id`, `product_id`, `return_quantity`, `return_no`, `date`) VALUES ".$r_insert;
                  $this->db->query($r_in_sql);
                  
                  $sq_update_sql = "UPDATE `sequence_master` SET `sequence_number`=sequence_number+1 WHERE `sequence_id`=8";
                  $this->db->query($sq_update_sql);
              }

              //Multiple product update current stock
              if($p_update != ''){
                  $p_where = rtrim($p_where,",");
                  $sell_sql = "UPDATE `product_master` SET `current_stock`= CASE `product_id` ".$p_update." END WHERE `product_id` IN (".$p_where.")";
                  $this->db->query($sell_sql);
              }
            
              //Daily stock update 
              if($dsio_update_query != ''){
                  $dsio_update_w_query = rtrim($dsio_update_w_query,",");
                  $u_dsio_sql = "UPDATE daily_stock_inout_master SET total_return = (case ".$dsio_update_query." end), final_stock = (case ".$dsio_update_query1." end) WHERE date='".$date."' AND product_id in (".$dsio_update_w_query.")";
                  $this->db->query($u_dsio_sql);
              }

              //Daily stock insert
              if($dsio_insert_query != ''){
                  $dsio_insert_query = rtrim($dsio_insert_query,",");
                  $dsio_i_sql = "INSERT INTO `daily_stock_inout_master`(product_id, `total_return`, `final_stock`, `date`) VALUES ".$dsio_insert_query;
                  $this->db->query($dsio_i_sql);
              }
            
            return array("stat"=>200,"msg"=>"Return successfully");   

       
    }

 


    public function all_list($data)
    { 
       $arr = array();
       if(array_key_exists('return_no', $data))
       {
         $where = " WHERE rm.return_no=".$data['return_no'];
       }
       else if(array_key_exists('date', $data))
       {
         $where = " WHERE rm.`date` BETWEEN '".$data['date']['from']."' AND '".$data['date']['to']."'";
         if($data['date']['client'] !=0 && $data['date']['client'] != '')
         {
          
            $where .= " AND cm.`client_id` = ".$data['date']['client'];
         }
       }
       else{
           $where = "";
       }
          
       $sql = "SELECT * FROM `return_master` rm JOIN `sell_master` sm ON `sm`.`sell_id` = `rm`.`sell_id` JOIN sell_details_master sdm ON sdm.sell_id=rm.`sell_id` AND sdm.product_id=rm.`product_id` JOIN `product_master` pm ON `pm`.`product_id` = `rm`.`product_id` JOIN `client_master` cm ON `cm`.`client_id` = `sm`.`client_id` ".$where;

       $query = $this->db->query($sql);
       $res = $query->result_array();
      /* print_r($res);
       die();
          */
        if(count($res)>0){
          
          $sql1   = "SELECT SUM(`amount_paid`) AS pay_amount FROM payment_master WHERE `sell_id`=".$res[0]['sell_id'];
          $query1 = $this->db->query($sql1);
          $res1   = $query1->result_array();

          if(count($res1) > 0)
          {
            $pay_amount = $res1[0]['pay_amount'];
          }
          else
          {
            $pay_amount = 0.00;
          }

           foreach($res as $r){
                $qty           = $r['quantity'];
                $return_qty    = $r['return_quantity'];
                $dis           = floatval(($r['price'] * $r['discount'])/100);
                $rem           = $r['price'] - $dis;
                $tax           = floatval(($rem * $r['tax'])/100);
                $return_amount        =   ($rem + $tax) * $return_qty;
                $dis              = round($dis, 2);
                $tax              = round($tax, 2);
                $return_amount    = round($return_amount, 2);
               
               if(array_key_exists($r['return_no'],$arr)){
                   $arr[$r['return_no']]['product_details'][] = array("product_id"=>$r['product_id'],"product_name"=>$r['product_name'],"part_number"=>$r['part_number'],"quantity"=>$r['quantity'],"price"=>$r['price'],"discount"=>$r['discount'],"tax"=>$r['tax'],"return_quantity"=>$r['return_quantity'],"return_amount"=>$return_amount);
               } else{
                   $arr[$r['return_no']] = array("return_no"=>$r['return_no'],"date"=>$r['date']);
                   $arr[$r['return_no']]['payment_amount'][] =array("amount"=>$pay_amount);
                   
                   $arr[$r['return_no']]['customer_details'][] = array("client_id"=>$r['client_id'],"company_name"=>$r['company_name'],"company_address"=>$r['company_address'],"contact_person"=>$r['contact_person'],"contact_number"=>$r['contact_number'],"pan_number"=>$r['pan_number'],"gstin_number"=>$r['gstin_number']);
                   
                   $arr[$r['return_no']]['sale_details'][] = array("sell_id"=>$r['sell_id'],"invoice_number"=>$r['invoice_number'],"sell_amount"=>$r['sell_amount'],"total_discount"=>$r['total_discount'],"total_tax"=>$r['total_tax'],"final_amount"=>$r['final_amount'],"outstanding_amount"=>$r['outstanding_amount'],"sell_date"=>$r['sell_date'],"sale_note"=>$r['sale_note']);
                   
                   $arr[$r['return_no']]['product_details'][] = array("product_id"=>$r['product_id'],"product_name"=>$r['product_name'],"part_number"=>$r['part_number'],"quantity"=>$r['quantity'],"price"=>$r['price'],"discount"=>$r['discount'],"tax"=>$r['tax'],"return_quantity"=>$r['return_quantity'],"return_amount"=>$return_amount);
               }
           }
           return array("stat"=>200,"msg"=>"List successfully get.","all_list"=>$arr);
       } else{
           return array("stat"=>500,"msg"=>"No data found");
       }
      
    }
   
}
?>