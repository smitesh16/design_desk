<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_model extends CI_Model {

  public function index($data)
  {
      $Arr = array();
      $total_sql = "SELECT (SELECT COUNT(pum.`product_id`) FROM `product_master` pum) AS total_purchase,(SELECT COUNT(sm.enquiry_id) FROM enquiry_master sm) AS total_sell, (SELECT COUNT(pym.analytics_id) FROM analytics_master pym) AS total_payment";
      $total_query = $this->db->query($total_sql);
      $Arr['total'] = $total_query->result_array();
      
      // $current_stock_product_sql = "SELECT * FROM `product_master` WHERE current_stock<5  ORDER BY `current_stock` ASC LIMIT 0,5";
      // $current_stock_product_query = $this->db->query($current_stock_product_sql);
      // $Arr['top_product'] = $current_stock_product_query->result_array();
      
      if(count($Arr)==0){
        return array("stat"=>500,"msg"=>"No data found");  
      } else{
        return array("stat"=>200,"msg"=>"List data successfully","all_list"=>$Arr);
      }
  }


   

     
}
?>