<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_model extends CI_Model {
    
  public function place_order($data)
  {
      $date = date('Y-m-d');
      $insert_query = '';
      $p_update_query = '';
      $p_update_w_query = '';
      $dsio_insert_query = '';
      $dsio_update_query = '';
      $dsio_update_query1 = '';
      $dsio_update_w_query = '';
      $total_amount = 0;
      $o_sql = "SELECT * FROM `purchase_master` WHERE `del_status`=0 AND `purchase_number`='".$data['purchase_number']."'";
      $o_query = $this->db->query($o_sql);
      $o_res = $o_query->result_array();
      
      if(count($o_res)==0){
          foreach($data['product'] as $product){
              $total_amount = $total_amount + ($product['quantity'] * $product['price']);
          }
          
          $o_i_sql = "INSERT INTO `purchase_master`(`purchase_number`, `total_amount`, `purchase_note`, `date`) VALUES ('".$data['purchase_number']."',".$total_amount.",'".$data['purchase_note']."','".$date."')";
          $this->db->query($o_i_sql);
          $insert_id = $this->db->insert_id();
          
          if($insert_id>0){
              $dsio_sql = "SELECT GROUP_CONCAT(`product_id`) AS product_id FROM `daily_stock_inout_master` WHERE `date`='".$date."'";
              $dsio_query = $this->db->query($dsio_sql);
              $dsio_res = $dsio_query->result_array();
              if(count($dsio_res)>0){
                  $product_id_arr = explode(",",$dsio_res[0]['product_id']);
              } else{
                  $product_id_arr = array();
              }
              foreach($data['product'] as $product){
                  $insert_query .= "(".$insert_id.",".$product['product_id'].",".$product['quantity'].",".$product['price']."),";
                  $p_update_query .= "WHEN product_id=".$product['product_id']." THEN current_stock+".$product['quantity']." ";
                  $p_update_w_query .= $product['product_id'].",";
              }

              $insert_query = rtrim($insert_query,",");
              $od_i_sql = "INSERT INTO `purchase_details_master`( `purchase_id`, `product_id`, `quantity`, `price`) VALUES ".$insert_query;
              $this->db->query($od_i_sql);
              
              $p_update_w_query = rtrim($p_update_w_query,",");
              $u_p_sql = "UPDATE product_master SET current_stock = (case ".$p_update_query." end) WHERE product_id in (".$p_update_w_query.")";
              $this->db->query($u_p_sql);
              
              foreach($data['product'] as $product){
                  if(in_array($product['product_id'],$product_id_arr)){
                      $dsio_update_query .= " WHEN product_id=".$product['product_id']." THEN total_purchase+".$product['quantity']." ";
                      $dsio_update_query1 .= " WHEN product_id=".$product['product_id']." THEN final_stock+".$product['quantity']." ";
                      $dsio_update_w_query .= $product['product_id'].",";
                  }else{
                      $p_sql = "SELECT * FROM `product_master` WHERE product_id=".$product['product_id'];
                      $query = $this->db->query($p_sql);
                      $p_res = $query->result_array();
                      $dsio_insert_query .= "(".$product['product_id'].",".$product['quantity'].", ".$p_res[0]['current_stock'].", '".$date."'),";
                  }
              }
              
              if($dsio_update_query != ''){
                  $dsio_update_w_query = rtrim($dsio_update_w_query,",");
                  $u_dsio_sql = "UPDATE daily_stock_inout_master SET total_purchase = (case ".$dsio_update_query." end), final_stock = (case ".$dsio_update_query1." end) WHERE date='".$date."' AND product_id in (".$dsio_update_w_query.")";
                  $this->db->query($u_dsio_sql);
              }
              
              if($dsio_insert_query != ''){
                  $dsio_insert_query = rtrim($dsio_insert_query,",");
                  $dsio_i_sql = "INSERT INTO `daily_stock_inout_master`(product_id, `total_purchase`, `final_stock`, `date`) VALUES ".$dsio_insert_query;
                  $this->db->query($dsio_i_sql);
              }
              
              return array("stat"=>200,"msg"=>"Added successfully.");
          } else{
              return array("stat"=>400,"msg"=>"Bad request. Some field missing.");
          }
      } else{
          return array("stat"=>201,"msg"=>"Insert failed. Purchase number already exist");
      }
  }
    
   public function all_list($data){
       if(array_key_exists("purchase_id",$data)){
           $w = "AND pm.`purchase_id`=".$data['purchase_id'];
       } else if(array_key_exists("date",$data)){
           $w = " AND `date` BETWEEN '".$data['date']['from']."' AND '".$data['date']['to']."'";
       } else{
           $w = "";
       }
       $sql = "SELECT *, (SELECT p.part_number FROM product_master p WHERE p.product_id=pdm.product_id) AS part_number FROM purchase_master pm JOIN purchase_details_master pdm WHERE pdm.purchase_id=pm.`purchase_id` ".$w;
       $query = $this->db->query($sql);
       $res = $query->result_array();

       if(count($res)>0){
           $new = "purchase_id,purchase_number,total_amount,date,purchase_note";
           $repeat = "purchase_details_id,product_id,quantity,price,part_number";
           $byGroup = group_by("purchase_id",$new,$repeat,$res);
           return array("stat"=>200,"msg"=>"List successfully get.","all_list"=>$byGroup);
       } else{
           return array("stat"=>500,"msg"=>"No data found");
       }
   }
    
    public function Batch($data){
//        echo "<pre>";print_r($data);die;
        $date = date('Y-m-d');
        $notInsertArr = array();
        foreach($data as $key=>$d){
            $purchase_number = $d[0];
            $product_name = $d[1];
            $quantity = $d[2];
            $price = $d[3];
            
            if($purchase_number!='' && $product_name!='' && $quantity!='' && $price!=''){
                if(is_numeric($quantity)==true || is_numeric($quantity)==1 && is_numeric($price)==true || is_numeric($price)==1){
                    if(0<$quantity && 0<=$price){
                        if (filter_var($quantity, FILTER_VALIDATE_INT)){
                            $quantity_digit = strlen($quantity);
                            $price_digit = strlen($price);
                            if(0<$quantity_digit && $quantity_digit<=10 && 0<$price_digit && $price_digit<=10){
                                $pro_sql = "SELECT `product_id`, `current_stock` FROM `product_master` WHERE `part_number`='".$product_name."' AND `del_status`=0";
                                $pro_query = $this->db->query($pro_sql);
                                $pro_res = $pro_query->result_array();

                                if(count($pro_res)>0){
                                    $pur_sql = "SELECT `purchase_id` FROM `purchase_master` WHERE `purchase_number`='".$purchase_number."' AND `del_status`=0";
                                    $pur_query = $this->db->query($pur_sql);
                                    $pur_res = $pur_query->result_array();
                                    if(count($pur_res)>0){
                                        $pur_sql1 = "SELECT * FROM `purchase_details_master` WHERE `purchase_id`=".$pur_res[0]['purchase_id']." AND `product_id`=".$pro_res[0]['product_id']." AND `del_status`=0";
                                        $pur_query1 = $this->db->query($pur_sql1);
                                        $pur_res1 = $pur_query1->result_array();
                                        $purchase_id = $pur_res[0]['purchase_id'];
                                        if(count($pur_res1)>0){
                                            $notInsertArr[] = array("purchase_number"=>$purchase_number,"product_name"=>$product_name,"quantity"=>$quantity,"price"=>$price,"remarks"=>"Product already exist in this purchase number");
                                            continue;
                                        } else{
                                            $pur_d_ins = "INSERT INTO `purchase_details_master`(`purchase_id`, `product_id`, `quantity`, `price`) VALUES (".$pur_res[0]['purchase_id'].",".$pro_res[0]['product_id'].",".$quantity.",".round($price,2).")";
                                            $pur_d_query = $this->db->query($pur_d_ins);
                                        }
                                    } else{
                                        $pur_ins = "INSERT INTO `purchase_master`(`purchase_number`, `total_amount`, `date`) VALUES ('".$purchase_number."',0,'".$date."')";
                                        $pur_query = $this->db->query($pur_ins);
                                        $purchase_id = $this->db->insert_id();

                                        $pur_d_ins = "INSERT INTO `purchase_details_master`(`purchase_id`, `product_id`, `quantity`, `price`) VALUES (".$purchase_id.",".$pro_res[0]['product_id'].",".$quantity.",".round($price,2).")";
                                        $pur_d_query = $this->db->query($pur_d_ins);
                                    }
                                    $amount = $quantity * round($price,2);
                                    $pur_up = "UPDATE `purchase_master` SET `total_amount`=total_amount+".$amount." WHERE `purchase_id`=".$purchase_id;
                                    $pur_up_query = $this->db->query($pur_up);

                                    $pro_up = "UPDATE `product_master` SET `current_stock`=current_stock+".$quantity." WHERE `product_id`=".$pro_res[0]['product_id'];
                                    $pro_up_query = $this->db->query($pro_up);

                                    $ds_sql = "SELECT * FROM `daily_stock_inout_master` WHERE `product_id`=".$pro_res[0]['product_id']." AND `date`='".$date."' AND `del_status`=0";
                                    $ds_query = $this->db->query($ds_sql);
                                    $ds_res = $ds_query->result_array();

                                    if(count($ds_res)>0){
                                        $ds_up = "UPDATE `daily_stock_inout_master` SET `total_purchase`=total_purchase+".$quantity.",`final_stock`=final_stock+".$quantity." WHERE `daily_stock_inout_id`=".$ds_res[0]['daily_stock_inout_id'];
                                        $ds_up_query = $this->db->query($ds_up);
                                    } else{
                                        $final_stock = $pro_res[0]['current_stock']+$quantity;
                                        $ds_ins = "INSERT INTO `daily_stock_inout_master`(`total_purchase`, `final_stock`, `product_id`, `date`) VALUES (".$quantity.",".$final_stock.",".$pro_res[0]['product_id'].",'".$date."')";
                                        $ds_ins_query = $this->db->query($ds_ins);
                                    }
                                } else{
                                    $notInsertArr[] = array("purchase_number"=>$purchase_number,"product_name"=>$product_name,"quantity"=>$quantity,"price"=>$price,"remarks"=>"Product part number not found");
                                }
                            } else{
                                $notInsertArr[] = array("purchase_number"=>$purchase_number,"product_name"=>$product_name,"quantity"=>$quantity,"price"=>$price,"remarks"=>"Price and quantity length within 10 number");   
                            }
                        } else{
                            $notInsertArr[] = array("purchase_number"=>$purchase_number,"product_name"=>$product_name,"quantity"=>$quantity,"price"=>$price,"remarks"=>"Quantity must be positive integer number");
                        }
                    } else{
                        $notInsertArr[] = array("purchase_number"=>$purchase_number,"product_name"=>$product_name,"quantity"=>$quantity,"price"=>$price,"remarks"=>"Quantity and price should be positive number");
                    }
                } else{
                $notInsertArr[] = array("purchase_number"=>$purchase_number,"product_name"=>$product_name,"quantity"=>$quantity,"price"=>$price,"remarks"=>"Quantity and price must be contain integer");
                }
            } else{
                $notInsertArr[] = array("purchase_number"=>$purchase_number,"product_name"=>$product_name,"quantity"=>$quantity,"price"=>$price,"remarks"=>"All field must have some data");
            } 
        }
        
        if(count($notInsertArr)==0){
            return array("stat"=>200,"msg"=>"Added successfully.");
        } else{
            return array("stat"=>201,"msg"=>"Added successfully.","data"=>$notInsertArr);
        }
    }
    
}
?>