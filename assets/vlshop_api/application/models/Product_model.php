<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_model extends CI_Model {

  public function Batch($data)
  {
      $notInsertArr = array();
      foreach($data as $d){
          if($d[0]!='' && $d[1]!='' && $d[2]!='' && $d[3]!='' && $d[4]!='' && $d[5]!=''){
              $part_digits = strlen($d[1]);
              $hsn_digits = strlen($d[3]);
              $desc_digits = strlen($d[2]);

              if(0<$part_digits && 0<$hsn_digits && 0<$desc_digits){
                  if($part_digits<=100 && $hsn_digits<=100 && $desc_digits<=300){
                      if(is_numeric($d[4])==true || is_numeric($d[4])==1 && is_numeric($d[5])==true || is_numeric($d[5])==1){
                          $df_digits = strlen($d[5]);
                          if(0<$d[4] && $d[4]<= 100 && 0<=$d[5] && $df_digits<=10){
                              //Part Number find for uniqness
                              $p_sql = "SELECT * FROM `product_master` WHERE `part_number`='".$d[1]."'";
                              $p_query = $this->db->query($p_sql);
                              $p_res = $p_query->result_array();
                              if(count($p_res)>0){
                                  /*$p_sql1 = "SELECT * FROM `product_master` WHERE `part_number`='".$d[1]."' AND NOT `product_id`=".$p_res[0]['product_id'];
                                  $p_query1 = $this->db->query($p_sql1);
                                  $p_res1 = $p_query1->result_array();
                                  if(count($p_res1)==0){*/
                                    //Update product for same part number
                                    $u_p_sql = "UPDATE `product_master` SET `part_number`='".$d[1]."',`description`='".$d[2]."',`hsn_code`='".$d[3]."',`igst`=".$d[4].",`default_price`=".$d[5]." WHERE `product_id`=".$p_res[0]['product_id'];
                                    $u_p_query = $this->db->query($u_p_sql);
                                  /*} else{
                                      $notInsertArr[] = array("Product Name"=>$d[0],"Part Number"=>$d[1],"Description"=>$d[2],"HSN Code"=>$d[3],"IGST"=>$d[4],"Default Price"=>$d[5],"remarks"=>"Part number already exist");
                                  }*/
                              } else{
                                  /*$p_sql1 = "SELECT * FROM `product_master` WHERE `part_number`='".$d[1]."'";
                                  $p_query1 = $this->db->query($p_sql1);
                                  $p_res1 = $p_query1->result_array();
                                  if(count($p_res1)==0){*/
                                      //Insert Product for uniq part number
                                      $i_p_sql = "INSERT INTO `product_master`(`product_name`, `part_number`, `description`, `hsn_code`, `igst`, `default_price`) VALUES ('".$d[0]."','".$d[1]."','".$d[2]."','".$d[3]."',".$d[4].",".$d[5].")";
                                      $i_p_query = $this->db->query($i_p_sql);
                                  /*} else{
                                      $notInsertArr[] = array("Product Name"=>$d[0],"Part Number"=>$d[1],"Description"=>$d[2],"HSN Code"=>$d[3],"IGST"=>$d[4],"Default Price"=>$d[5],"remarks"=>"Part number already exist");
                                  }*/
                              }
                          } else{
                              $notInsertArr[] = array("Product Name"=>$d[0],"Part Number"=>$d[1],"Description"=>$d[2],"HSN Code"=>$d[3],"IGST"=>$d[4],"Default Price"=>$d[5],"remarks"=>"IGST and price should not be less than 0 and Default Price length should not be greater than 10");
                          }
                      } else{
                          $notInsertArr[] = array("Product Name"=>$d[0],"Part Number"=>$d[1],"Description"=>$d[2],"HSN Code"=>$d[3],"IGST"=>$d[4],"Default Price"=>$d[5],"remarks"=>"IGST and Default Price should be integer value");
                      }
                  } else{
                      $notInsertArr[] = array("Product Name"=>$d[0],"Part Number"=>$d[1],"Description"=>$d[2],"HSN Code"=>$d[3],"IGST"=>$d[4],"Default Price"=>$d[5],"remarks"=>"Part, HSN length should not be greater than 100 and Description should not be 300");
                  }
              } else{
                $notInsertArr[] = array("Product Name"=>$d[0],"Part Number"=>$d[1],"Description"=>$d[2],"HSN Code"=>$d[3],"IGST"=>$d[4],"Default Price"=>$d[5],"remarks"=>"Part, HSN, Description length should not be less than 0");

              }
          } else{
              $notInsertArr[] = array("Product Name"=>$d[0],"Part Number"=>$d[1],"Description"=>$d[2],"HSN Code"=>$d[3],"IGST"=>$d[4],"Default Price"=>$d[5],"remarks"=>"All field must have some data");
          }
      }
      
      if(count($notInsertArr)>0){
        return array("stat"=>500,"msg"=>"Added successfully","data"=>$notInsertArr);  
      } else{
        return array("stat"=>200,"msg"=>"Added successfully");
      }
  }


   

     
}
?>