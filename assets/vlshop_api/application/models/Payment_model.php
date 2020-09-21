<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment_model extends CI_Model {
    
  public function place_payment($data)
  {
//      echo "<pre>";print_r($data);die;
      $date = date('Y-m-d');
      $pay_insert = '';
      $sell_update = '';
      $sell_where = '';
      
      //Find the voucher number
      $sq_sql = "SELECT * FROM `sequence_master` WHERE `sequence_id`=6";
      $sq_query = $this->db->query($sq_sql);
      $sq_res = $sq_query->result_array();
      $voucher_no = $sq_res[0]['sequence_number'];
      $voucher_prefix = $sq_res[0]['prefix'];
      
      foreach($data['invoice'] as $invoice){
          $sell_sql = "SELECT * FROM `sell_master` WHERE `sell_id`=".$invoice['sell_id'];
          $sell_query = $this->db->query($sell_sql);
          $sell_res = $sell_query->result_array();
          
          if($sell_res[0]['outstanding_amount'] >= $invoice['amount_paid']){
              if($sell_res[0]['outstanding_amount'] == $invoice['amount_paid']){
                  $payment_type = 0;    //Full payment
              } else{
                  $payment_type = 1;    //Partial payment
              }
              $sell_outstanding_amount = $sell_res[0]['outstanding_amount']-$invoice['amount_paid'];
              
            //Generate insert row for multiple payment
            $pay_insert .= "(".$invoice['sell_id'].",".$invoice['amount_paid'].",'".$date."',".$payment_type.",'".$invoice['remarks']."','".$voucher_prefix."-".$voucher_no."'),"; 
            //Generate update row and condition for multiple sell
            $sell_update .= " WHEN ".$invoice['sell_id']." THEN ".$sell_outstanding_amount." ";
            $sell_where .= $invoice['sell_id'].",";
            
            $voucher_no = $voucher_no +1;
          }
      }
      
      //Multiple payment insert
      if($pay_insert != ''){
          $pay_insert = rtrim($pay_insert,",");
          $pay_sql = "INSERT INTO `payment_master`(`sell_id`, `amount_paid`, `date`, `payment_type`, `remarks`, `voucher_number`) VALUES ".$pay_insert;
          $this->db->query($pay_sql);
      }
      
      //Multiple outstanding update
      if($sell_update != ''){
          $sell_where = rtrim($sell_where,",");
          $sell_sql = "UPDATE `sell_master` SET `outstanding_amount`= CASE `sell_id` ".$sell_update." END WHERE `sell_id` IN (".$sell_where.")";
          $this->db->query($sell_sql);
      }
      
      //Sequence number update of voucher row
      $sequence_sql = "UPDATE `sequence_master` SET `sequence_number`=".$voucher_no." WHERE `sequence_id`=6";
      $this->db->query($sequence_sql);
          
      return array("stat"=>200,"msg"=>"Payment successfully.");
  }
    
    public function all_list($data){
        $arr = array();
       if(array_key_exists("payment_id",$data)){
           $w = "WHERE pym.payment_id=".$data['payment_id'];
       } else{
           $w = "";
       }
       $sql = "SELECT *,(SELECT SUM(`amount_paid`) FROM `payment_master` WHERE payment_master.`sell_id` = pym.`sell_id`) as total_paid FROM `payment_master` pym LEFT JOIN sell_master sm ON sm.sell_id=pym.`sell_id` LEFT JOIN sell_details_master sdm ON sdm.sell_id=pym.sell_id LEFT JOIN product_master pm ON pm.product_id=sdm.product_id LEFT JOIN client_master cm ON cm.client_id=sm.client_id ".$w;
       $query = $this->db->query($sql);
       $res = $query->result_array();

       if(count($res)>0){
           foreach($res as $r){
               if(array_key_exists($r['payment_id'],$arr)){
                   $arr[$r['payment_id']]['product_details'][] = array("product_id"=>$r['product_id'],"product_name"=>$r['product_name'],"part_number"=>$r['part_number'],"quantity"=>$r['quantity'],"price"=>$r['price'],"discount"=>$r['discount'],"tax"=>$r['tax']);
               } else{
                   $arr[$r['payment_id']] = array("payment_id"=>$r['payment_id'],"amount_paid"=>$r['amount_paid'],"date"=>$r['date'],"payment_type"=>$r['payment_type'],"remarks"=>$r['remarks'],"voucher_number"=>$r['voucher_number'],"invoice_number"=>$r['invoice_number'],"total_paid"=>$r['total_paid']);
                   
                   $arr[$r['payment_id']]['customer_details'][] = array("client_id"=>$r['client_id'],"company_name"=>$r['company_name'],"company_address"=>$r['company_address'],"contact_person"=>$r['contact_person'],"contact_number"=>$r['contact_number'],"pan_number"=>$r['pan_number'],"gstin_number"=>$r['gstin_number']);
                   
                   $arr[$r['payment_id']]['sale_details'][] = array("sell_id"=>$r['sell_id'],"sell_amount"=>$r['sell_amount'],"total_discount"=>$r['total_discount'],"total_tax"=>$r['total_tax'],"final_amount"=>$r['final_amount'],"outstanding_amount"=>$r['outstanding_amount'],"sell_date"=>$r['sell_date'],"sale_note"=>$r['sale_note']);
                   
                   $arr[$r['payment_id']]['product_details'][] = array("product_id"=>$r['product_id'],"product_name"=>$r['product_name'],"part_number"=>$r['part_number'],"quantity"=>$r['quantity'],"price"=>$r['price'],"discount"=>$r['discount'],"tax"=>$r['tax']);
               }
           }
//           echo "<pre>";print_r($arr);die;
           return array("stat"=>200,"msg"=>"List successfully get.","all_list"=>$arr);
       } else{
           return array("stat"=>500,"msg"=>"No data found");
       }
   }
   
}
?>