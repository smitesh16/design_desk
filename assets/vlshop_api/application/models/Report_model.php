<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report_model extends CI_Model {
   
    public function stock_in_out_filter($data){
        if($data['product_id'] != '' && $data['product_id'] != 0){
            $w = "AND dsim.`product_id`=".$data['product_id'];
        } else{
            $w = "";
        }
        $sql = "SELECT *, (SELECT pm.part_number FROM product_master pm WHERE pm.product_id=dsim.`product_id`) AS part_number, CASE WHEN EXISTS(SELECT * FROM daily_stock_inout_master dm WHERE dm.product_id=dsim.`product_id` AND dm.date < dsim.`date` ORDER BY dm.daily_stock_inout_id DESC LIMIT 1)>0 THEN (SELECT dm.final_stock FROM daily_stock_inout_master dm WHERE dm.product_id=dsim.`product_id` AND dm.date < dsim.`date` ORDER BY dm.daily_stock_inout_id DESC LIMIT 1) ELSE 0 END previous_quantity FROM `daily_stock_inout_master` dsim WHERE dsim.`date` BETWEEN '".$data['from']."' AND '".$data['to']."' ".$w;
        $query = $this->db->query($sql);
        $res = $query->result_array();
        
        if(count($res)>0){
            return array("stat"=>200,"msg"=>"All list","all_list"=>$res);
        } else{
            return array("stat"=>500,"msg"=>"No data found");
        }
    }

    public function cash_filter($data)
    {  
       $arr =array();
       
       $sql="SELECT * FROM `payment_master` pm JOIN `sell_master` sm ON sm.`sell_id` = pm.`sell_id` JOIN `client_master` cm ON cm.`client_id` = sm.`client_id` WHERE pm.`date` BETWEEN '".$data['date']['from']."' AND '".$data['date']['to']."' ORDER BY pm.`payment_id` ASC";

       $query = $this->db->query($sql);
       $res = $query->result_array();
      
       if(count($res) > 0)
       {

          $arr['payment_details'] = $res;
        
       }
       else
       {
          $arr['payment_details'] = 0;
       }

       $sql1="SELECT * FROM `return_master` rm JOIN `sell_master` sm ON sm.`sell_id` = rm.`sell_id` JOIN `sell_details_master` sdm ON sdm.`sell_id`=rm.`sell_id` WHERE rm.`date` BETWEEN '".$data['date']['from']."' AND '".$data['date']['to']."'";

       $query1 = $this->db->query($sql1);
       $res1 = $query1->result_array();


       if(count($res1) > 0)
       {  
          $total = 0;
          for($i=0;$i<count($res1);$i++)
          {
                $qty           = $res1[$i]['quantity'];
                $return_qty    = $res1[$i]['return_quantity'];
                $dis           = floatval(($res1[$i]['price'] * $res1[$i]['discount'])/100);
                $rem           = $res1[$i]['price'] - $dis;
                $tax              = floatval(($rem * $res1[$i]['tax'])/100);
                $return_amount    =   ($rem + $tax) * $return_qty;
                $dis              = round($dis, 2);
                $tax              = round($tax, 2);
                $return_amount    = round($return_amount, 2);
         
                $total = $total + $return_amount;
                
          }
          $arr['return_total'] = $total;
           }
           else
           {
             $arr['return_total'] = 0;
           }

          if($arr['return_total'] == 0 && $arr['payment_details'] == 0)
          {
            
            return array("stat"=>500,"msg"=>"No data found");
          }
          else
          {
             return array("stat"=>200,"msg"=>"All list","all_list"=>$arr);
          }
    }
    
    public function profit_loss_filter($data)
    {
        $w = "";
        if($data['product_id'] != 0 && $data['product_id'] != ''){
            $w .= " AND sdm.product_id=".$data['product_id'];
        }
        if($data['client_id'] != 0 && $data['client_id'] != ''){
            $w .= " AND sm.client_id=".$data['client_id'];
        }
        
        $sql = "SELECT *, (SELECT cm.company_name FROM client_master cm WHERE cm.client_id=sm.client_id) AS company_name, ROUND((sdm.`quantity`*((sdm.`price`-(sdm.`price`*sdm.`discount`)/100)+(((sdm.`price`-(sdm.`price`*sdm.`discount`)/100)*sdm.tax)/100))),2) AS sell_amout, ROUND((sdm.`quantity`*(pm.default_price+((pm.default_price*pm.igst)/100))),2) AS product_amount FROM `sell_details_master` sdm LEFT JOIN product_master pm ON sdm.`product_id`=pm.product_id LEFT JOIN sell_master sm ON sm.sell_id=sdm.`sell_id` WHERE sm.sell_date BETWEEN '".$data['from']."' AND '".$data['to']."' ".$w;
        $query = $this->db->query($sql);
        $res = $query->result_array();
        
        if(count($res)>0){
            return array("stat"=>200,"msg"=>"All list","all_list"=>$res);
        } else{
            return array("stat"=>500,"msg"=>"No data found");
        }
    }

    public function customer_filter($data)
    {  
      $id = $data['date']['client'];
      $where = '';
      if(($data['date']['from'] != 0 && $data['date']['from'] != '') && ($data['date']['to'] == 0 || $data['date']['to'] == ''))
      {
         $where .=" AND sm.`sell_date` >= '".$data['date']['from']."'";
      }
      else if(($data['date']['to'] != 0 && $data['date']['to'] != '') && ($data['date']['from'] == 0 || $data['date']['from'] == ''))
      {
         $where .=" AND sm.`sell_date` <= '".$data['date']['to']."'";
      }
      else if(($data['date']['to'] != 0 && $data['date']['to'] != '') && ($data['date']['from'] != 0 && $data['date']['from'] != ''))
      {
        $where .=" AND sm.`sell_date` BETWEEN '".$data['date']['from']."' AND '".$data['date']['to']."'";
      }

       
       $sql="SELECT *,CASE WHEN EXISTS(SELECT * FROM payment_master pym WHERE pym.sell_id=sm.sell_id)>0 THEN (SELECT SUM(pym.amount_paid) FROM payment_master pym WHERE pym.sell_id=sm.sell_id)ELSE 0 END payment_amount,CASE WHEN EXISTS(SELECT * FROM return_master rm WHERE rm.sell_id=sm.`sell_id`)>0
          THEN (SELECT SUM(ROUND((rm.`return_quantity`*((sdm.`price`-(sdm.`price`*sdm.`discount`)/100)+(((sdm.`price`-(sdm.`price`*sdm.`discount`)/100)*sdm.tax)/100))),2)) FROM return_master rm LEFT JOIN sell_details_master sdm ON sdm.sell_id=rm.`sell_id` AND sdm.product_id=rm.product_id WHERE rm.sell_id=sm.`sell_id`)ELSE 0  END return_amount FROM `sell_master` sm LEFT JOIN client_master cm ON sm.`client_id` =  cm.`client_id` WHERE sm.`client_id`=".$id.$where;  

        $query = $this->db->query($sql);
        $res   = $query->result_array();

        if(count($res)>0){
            return array("stat"=>200,"msg"=>"All list","all_list"=>$res);
        } else{
            return array("stat"=>500,"msg"=>"No data found");
        }
    }


    
    
    
}
?>