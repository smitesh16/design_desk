<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class General_model extends CI_Model {

    public function create_token_data($all_data)
    {
        $List = "'" . implode( "','",($all_data) ) . "'";
        $query="insert into client_verification values('',$List)";
         $this->db->query($query);
         
        //  return array("stat"=>200,"msg"=>"Added successfully.","data"=>$list);
    }

    public function create_reverification_data($all_data)
    {
        // var_dump($all_data);
        $Clientid =  $all_data['userid'];
        $Expiry =  $all_data['expired'];
        $Verified =  $all_data['verified'];
        $Code =  $all_data['code'];

        $query="insert into client_verification values('','$Clientid','$Code','$Verified','$Expiry')";
        
        $this->db->query($query);
         
         return array("stat"=>200,"msg"=>"Added successfully.","data"=>$query);
    }

    public function email_verify_data($all_data)
    {
        // var_dump($all_data);

         $Code = $all_data['code'];
         $expquery = $this->db->query("SELECT cv.*,cm.* 
         FROM `client_verification` cv
         inner join client_master cm on cm.client_id=cv.client_id
         where cm.del_status=0 and code = '$Code'");

         foreach ($expquery->result() as $row)
         { 
                 $expdate =  $row->expiry;
                 $email =  $row->user_email;
                 $userid =  $row->client_id;
                 $username =  $row->user_name;
         }
         $Expiry = $expdate;
         $Currentdate = date('Y-m-d h:i:s');
         $expconverted = strtotime($Expiry);  //expiry conversion
         $curconverted = strtotime($Currentdate);   //current conversion
         $avgtime = abs($curconverted - $expconverted)/(60*60);
            //  var_dump($Code,$Expiry);
        //  $List1 = implode($Code) ;
        //  var_dump($List1);
            if($avgtime <= 1)
                { 
                    $query = $this->db->query("SELECT * FROM client_verification WHERE code = '$Code' and verified=1");
                    // echo $query->num_rows();
                    
                    if($query->num_rows()==0)
                        {
                        //   $Code = $all_data;
                            //   $List1 = implode($Code) ;
                            $Code = $all_data['code'];
                            $Expiry = $all_data['expiry'];
                            $verified = 1;
                            $active_status = 1;
                            
                            $query1 = "UPDATE client_verification 
                            set verified = $verified
                            WHERE code = '$Code' ";
                            //   var_dump($query1);
                
                            $query2 = "UPDATE client_master cm
                                        INNER JOIN client_verification cv
                                        ON cm.client_id= cv.client_id
                                        SET cm.active_status = $active_status
                                        WHERE cv.code='$Code' ";
                        // var_dump($query2);
                            $this->db->query($query1);
                            $this->db->query($query2);
                                return array("stat"=>200,"msg"=>"Verified successfully. Please Login", "expiry"=>$Expiry, "email"=>$email, "clientid"=>$userid, "name"=>$username);
                            } 
                        else
                            {
                                return array("stat"=>300,"msg"=>"Already Verified. Please Login", "expiry"=>$Expiry, "email"=>$email, "clientid"=>$userid, "name"=>$username);
                            } 
                }
                else
                { 
                    return array("stat"=>400,"msg"=>"Link Expired!!", "expiry"=>$Expiry, "email"=>$email, "clientid"=>$userid, "name"=>$username);
                }
                
    }

    public function add_data($all_data)
    {
        $table_prefix = $this->config->item('table_prefix');
        $table_suffix = $this->config->item('table_suffix');

        $key_array = array_keys($all_data);
        $table_attribute = $key_array[0];
        $sub_array = array();
        if(isset($all_data[$key_array[0]]['sub_array']))
        {
            $sub_array = $all_data[$key_array[0]]['sub_array'];
            unset($all_data[$key_array[0]]['sub_array']);
        }
        
        if(isset($all_data['check']) && $all_data['check']!='')
        {
            $check_table_attribute_arr = explode(',',$all_data['check']);
            for($i=0;$i<count($check_table_attribute_arr);$i++)
            {
                $variable = $check_table_attribute_arr[$i];
                $this->db->where($variable, $all_data[$key_array[0]][$variable]);
            }
            $this->db->where('del_status ', 0);
    	    $query = $this->db->get($table_prefix.$table_attribute.$table_suffix);
    	    $count_row = $query->num_rows();
            if($count_row>0)
            {
                return array("stat"=>405,"msg"=>"Insert failed. This same value exist","insert_id"=>0);die;
            }
        }
        
        $this->db->insert($table_prefix.$table_attribute.$table_suffix,$all_data[$key_array[0]]);
        if( $this->db->error()['code'] !=0)
        {
            $errMess = $this->db->error()['message'];
            header('HTTP/1.1 400 Bad Request.', true, 400);
            return array("stat"=>400,"msg"=>"Bad request. ".$errMess);
        }
        $insert_id = $this->db->insert_id();
        
        if(count($sub_array)>0 && $this->db->error()['code'] == 0)
        {
            $sub_table_attribute = $table_attribute."_details";
            
            for($i=0;$i<count($sub_array);$i++)
            {
                $sub_array[$i][$table_attribute.'_id'] = $insert_id;
            }
           
           
            $this->db->insert_batch($table_prefix.$sub_table_attribute.$table_suffix,$sub_array);
        }
       
        return array("stat"=>200,"msg"=>"Added successfully","insert_id"=>$insert_id);
	}

    
    public function update_data($all_data)
    {
        $table_prefix = $this->config->item('table_prefix');
        $table_suffix = $this->config->item('table_suffix');
        
        $key_array = array_keys($all_data);
        $table_attribute = $key_array[0];
        
//        if(!isset($all_data[$key_array[0]][$table_attribute.'_id']) && $all_data[$key_array[0]][$table_attribute.'_id']=='')
//        {
//            return array("stat"=>405,"msg"=>"Please give ".$table_attribute."_id");die;
//        }
        
        if(count($all_data[$key_array[0]])==0)
        {
            return array("stat"=>406,"msg"=>"Please give data for update");die;
        }
        
        if(isset($all_data['where']) && $all_data['where']!='')
        {
            $where = $all_data['where'];
        }
        else
        {
            $where = array();
        }
        
        if(isset($all_data['check']) && $all_data['check']!='')
        {
            $check_table_attribute_arr = explode(',',$all_data['check']);
            for($i=0;$i<count($check_table_attribute_arr);$i++)
            {
//                $variable = $table_attribute."_".strtolower($check_table_attribute_arr[$i]);
                $variable = $check_table_attribute_arr[$i];
                $this->db->where($variable, $all_data[$key_array[0]][$variable]);
            }
            if(count($where)>0)
            {
                $where_key_array = array_keys($where);
                for($j=0;$j<count($where);$j++)
                {
                    $this->db->where($where_key_array[$j].'!=' ,$where[$where_key_array[$j]]);
                }
            }
            
            $this->db->where('del_status ', 0);
    	    $query = $this->db->get($table_prefix.$table_attribute.$table_suffix);
//            echo $this->db->last_query(); die;
    	    $count_row = $query->num_rows();
            if($count_row>0)
            {
                return array("stat"=>407,"msg"=>"Update Failed. This same value exist","update_id"=>0);die;
            }
        }
        
//        $this->db->update($table_prefix.$table_attribute.$table_suffix, $all_data[$key_array[0]], array($table_attribute.'_id' => $all_data[$key_array[0]][$table_attribute.'_id']));
        
        $this->db->update($table_prefix.$table_attribute.$table_suffix, $all_data[$key_array[0]], $where);
        if( $this->db->error()['code'] !=0)
        {
            $errMess = $this->db->error()['message'];
            header('HTTP/1.1 400 Bad Request.', true, 400);
            return array("stat"=>400,"msg"=>"Bad request. ".$errMess);
        }
        return array("stat"=>200,"msg"=>"Updated Successfully");
	}
      
    
	public function get_data($all_data)
	{
        $table_prefix = $this->config->item('table_prefix');
        $table_suffix = $this->config->item('table_suffix');
        
        $key_array = array_keys($all_data);
        $table_attribute = $key_array[0];
        
        $this->db->where($all_data[$key_array[0]]);
        $this->db->where($table_prefix.$table_attribute.$table_suffix.'.del_status', 0);
        
        
        if(isset($all_data['select']) && $all_data['select']!='')
        {
            $this->db->select($all_data['select']);
        }
        
        if(isset($all_data['where_in']) && $all_data['where_in']!='')
        {
            $where_in_key_array = array_keys($all_data['where_in']);
            for($i=0;$i<count($where_in_key_array);$i++)
            {
                $this->db->where_in($where_in_key_array[$i],$all_data['where_in'][$where_in_key_array[$i]]);
            }
        }
        
        if(isset($all_data['join']) && $all_data['join']!='')
        {
            $join_table_attribute_arr = explode(',',$all_data['join']);
            for($i=0;$i<count($join_table_attribute_arr);$i++)
            {
                $new_join_table_attribute = explode(":",$join_table_attribute_arr[$i]);
                $join_table_attribute = $new_join_table_attribute[0];

                $this->db->join($table_prefix.$join_table_attribute.$table_suffix, $table_prefix.$join_table_attribute.$table_suffix.'.'.$join_table_attribute.'_id='.$table_prefix.$table_attribute.$table_suffix.'.'.$join_table_attribute.'_id', 'left');

                if(count($new_join_table_attribute)>1)
                {
                    $sub_join_str = $new_join_table_attribute[1];
                    $sub_join_arr = explode('|',$sub_join_str);
                    if(count($sub_join_arr)>0)
                    {
                        for($j=0;$j<count($sub_join_arr);$j++)
                        {
                            $sub_join_table_attribute = $sub_join_arr[$j];

                            $this->db->join($table_prefix.$sub_join_table_attribute.$table_suffix, $table_prefix.$sub_join_table_attribute.$table_suffix.'.'.$sub_join_table_attribute.'_id='.$table_prefix.$join_table_attribute.$table_suffix.'.'.$sub_join_table_attribute.'_id', 'left');
                        }
                    }
                }
            }
        }
        
        if(isset($all_data['customjoin']) && $all_data['customjoin']!='')
        {
            $join_table_attribute_arr = explode(',',$all_data['customjoin']);
            for($i=0;$i<count($join_table_attribute_arr);$i++)
            {
                $new_join_table_attribute = explode(":",$join_table_attribute_arr[$i]);
                $join_table_name = $new_join_table_attribute[0];
                $join_table_attribute = $new_join_table_attribute[1];

                $this->db->join($table_prefix.$join_table_name.$table_suffix, $table_prefix.$join_table_name.$table_suffix.'.'.$join_table_name.'_'.$join_table_attribute.'='.$table_prefix.$table_attribute.$table_suffix.'.'.$join_table_attribute, 'left');
            }
        }
        
        if(isset($all_data['order_by']) && $all_data['order_by']!='')
        {
            $key_array_new = array_keys($all_data['order_by']);
            if(count($key_array_new)>0)
            {
                for($a=0;$a<count($key_array_new);$a++)
                {
                    if(strtolower($all_data['order_by'][$key_array_new[$a]]) == 'asc' || strtolower($all_data['order_by'][$key_array_new[$a]]) == 'desc')
                    {
                        $this->db->order_by($key_array_new[$a],strtolower($all_data['order_by'][$key_array_new[$a]]));
                    }
                }
            }
        }
        
        if(isset($all_data['limit']) && $all_data['limit']!='')
        {
            $limit = $all_data['limit'];
            $this->db->limit($limit);
        }
        if(isset($all_data['offset']) && $all_data['offset']!='')
        {
            $offset = $all_data['offset'];
            $this->db->offset($offset);
        }
        if(isset($all_data['group_by']) && $all_data['group_by']!='')
        {
            $group_by = $all_data['group_by'];
            $this->db->group_by($group_by);
        }
        
		$query = $this->db->get($table_prefix.$table_attribute.$table_suffix);
//        echo json_encode($this->db->error());die;
        if( $this->db->error()['code'] !=0)
        {
            $errMess = $this->db->error()['message'];
            header('HTTP/1.1 400 Bad Request.', true, 400);
            return array("stat"=>400,"msg"=>"Bad request. ".$errMess);
        }
		$count_row = $query->num_rows();
        
//		 echo $this->db->last_query(); die;
		if($count_row>0)
        {
            $query_result_array = $query->result_array();
            
            if(isset($all_data['sub_array']) && isset($all_data['sub_array']['has_sub_array']) && $all_data['sub_array']['has_sub_array'] === true)
            {
                for($a=0;$a<$count_row;$a++)
                {
                    if(isset($all_data['sub_array']['join']) && $all_data['sub_array']['join']!='')
                    {
                        $join_table_attribute_arr = explode(',',$all_data['sub_array']['join']);
                        for($i=0;$i<count($join_table_attribute_arr);$i++)
                        {
                            $new_join_table_attribute = explode(":",$join_table_attribute_arr[$i]);
                            $join_table_attribute = $new_join_table_attribute[0];

                            $this->db->join($table_prefix.$join_table_attribute.$table_suffix, $table_prefix.$join_table_attribute.$table_suffix.'.'.$join_table_attribute.'_id='.$table_prefix.$table_attribute.'_details'.$table_suffix.'.'.$join_table_attribute.'_id', 'left');

                            if(count($new_join_table_attribute)>1)
                            {
                                $sub_join_str = $new_join_table_attribute[1];
                                $sub_join_arr = explode('|',$sub_join_str);
                                if(count($sub_join_arr)>0)
                                {
                                    for($j=0;$j<count($sub_join_arr);$j++)
                                    {
                                        $sub_join_table_attribute = $sub_join_arr[$j];

                                        $this->db->join($table_prefix.$sub_join_table_attribute.$table_suffix, $table_prefix.$sub_join_table_attribute.$table_suffix.'.'.$sub_join_table_attribute.'_id='.$table_prefix.$join_table_attribute.$table_suffix.'.'.$sub_join_table_attribute.'_id', 'left');
                                    }
                                }
                            }
                        }
                    }
                    
                    $this->db->where($table_prefix.$table_attribute.'_details'.$table_suffix.'.'.$table_prefix.$table_attribute.'_id', $query_result_array[$a][$table_prefix.$table_attribute.'_id']);
                    $this->db->where($table_prefix.$table_attribute.'_details'.$table_suffix.'.del_status', 0);
                    $sub_query = $this->db->get($table_prefix.$table_attribute.'_details'.$table_suffix);
                    
                    $query_result_array[$a]['sub_array'] = $sub_query->result_array();
                }                
//                echo json_encode($sub_query->result_array());die;
            }
            
			$res = array("stat"=>200,"msg"=>"All list","list_count"=>$count_row,"all_list"=>$query_result_array);
		}
        else{
			$res = array("stat"=>500,"msg"=>"No data found","list_count"=>$count_row,"all_list"=>array());
		}
		return $res;

	}
    
	
    
   
    
    public function delete_data($all_data)
    {
        $table_prefix = $this->config->item('table_prefix');
        $table_suffix = $this->config->item('table_suffix');
        
        $key_array = array_keys($all_data);
        $table_attribute = $key_array[0];
        
//        echo json_encode($all_data[$key_array[0]]);die;
        
//        if(!isset($all_data[$key_array[0]][$table_attribute.'_id']) || $all_data[$key_array[0]][$table_attribute.'_id']=='')
//        {
//            return array("stat"=>408,"msg"=>"Please give ".$table_attribute."_id");die;
//        }
        
        $this->db->where('del_status ', 0);
        $this->db->where($all_data[$key_array[0]]);
    	$query = $this->db->get($table_prefix.$table_attribute.$table_suffix);
        if( $this->db->error()['code'] !=0)
        {
            $errMess = $this->db->error()['message'];
            header('HTTP/1.1 400 Bad Request.', true, 400);
            return array("stat"=>400,"msg"=>"Bad request. ".$errMess);
        }
    	$count_row = $query->num_rows();
        if($count_row>0)
        {
            $this->db->set('del_status','1');
            $this->db->where($all_data[$key_array[0]]);
            $this->db->update($table_prefix.$table_attribute.$table_suffix);
            
            return array("stat"=>200,"msg"=>"Delete Successfully");
        }
        else
        {
            return array("stat"=>409,"msg"=>"Delete failed. This id not exists");
        }
        
    }
    
    public function remove_data($all_data)
    {
        $table_prefix = $this->config->item('table_prefix');
        $table_suffix = $this->config->item('table_suffix');
        
        $key_array = array_keys($all_data);
        $table_attribute = $key_array[0];
        
        if(!isset($all_data[$key_array[0]]))
        {
            return array("stat"=>410,"msg"=>"Please give proper data");die;
        }
        
		$this->db->where($all_data[$key_array[0]]);
    	$query = $this->db->get($table_prefix.$table_attribute.$table_suffix);
    	$count_row = $query->num_rows();
        
        if($count_row>0)
        {
            if(count($all_data[$key_array[0]])>0)
            {
                $this->db->where($all_data[$key_array[0]]);
                $this->db->delete($table_prefix.$table_attribute.$table_suffix);
            }
            else
            {
                $this->db->truncate($table_prefix.$table_attribute.$table_suffix);
            }
            if( $this->db->error()['code'] !=0)
            {
                $errMess = $this->db->error()['message'];
                header('HTTP/1.1 400 Bad Request.', true, 400);
                return array("stat"=>400,"msg"=>"Delete cann't be possible. Because that ".$table_attribute." used in another section.","query"=>$errMess);
            }
            
            return array("stat"=>200,"msg"=>"Remove Successfully");
        }
        else
        {
            return array("stat"=>411,"msg"=>"Remove failed. Please try again");
        }
    }
    
    public function backup_data()
    {
        $dir = "system/backup/";
        $a = scandir($dir);
        if(isset($a[2]))
        {
            unlink('system/backup/'.$a[2]);
        }
        
        $this->load->dbutil();
        $db_name = $this->db->database;

        $prefs = array(     
            'format'      => 'zip',             
            'filename'    => $db_name.'.sql'
            );
        $backup = $this->dbutil->backup($prefs); 

        $db_name = $db_name.'.zip';
        $save = 'system/backup/'.$db_name;

        $this->load->helper('file');
        write_file($save, $backup);
        
        return array("stat"=>200,"msg"=>"Backup Successfully");
    }

    public function GetEnquiry_data()
    {
         $sq_sql = "SELECT * FROM `enquiry_master` em LEFT JOIN `enquiry_details_master` edm ON edm.enquiry_id = em.enquiry_id LEFT JOIN `client_master` cm ON cm.client_id = em.client_id LEFT JOIN `product_master` pm ON pm.product_id = edm.product_id WHERE em.del_status =0";
         $sq_query = $this->db->query($sq_sql);
         $sq_res = $sq_query->result_array();
         $sq_count = $sq_query->num_rows();
         if($sq_count>0){
            $finalArr = array();
            $enquiry_idArr = array();
            foreach ($sq_res as $value) {
                $id = $value['enquiry_id'];
                $detailsArr = array();
                   foreach ($sq_res as $value2) {
                    if($value['enquiry_id'] == $value2['enquiry_id']){
                        $detailsArr[] = array("product_id"=>$value2['product_id'],"product_name"=>$value2['product_name'],"part_number"=>$value2['part_number'],"description"=>$value2['description'],"product_image"=>$value2['product_image'],"product_quantity"=>$value2['product_quantity'],"comment"=>$value2['comment']);
                    }
                // $enquiry_idArr
                }
                if (!in_array($id, $enquiry_idArr)){
                    array_push($enquiry_idArr,$id);
                    $finalArr[] = array("enquiry_id"=>$id,"client_id"=>$value['client_id'],"user_name"=>$value['user_name'],"user_address"=>$value['user_address'],"user_email"=>$value['user_email'],"contact_number"=>$value['contact_number'],"enquiry_date"=>$value['enquiry_date'],"moq"=>$value['moq'],"territory"=>$value['territory'],"del_status"=>$value['del_status'],"Details"=>$detailsArr); 

                }
            }
            return array("stat"=>200,"msg"=>"Enquiry List", "data"=>$finalArr);   
         }else{
            return array("stat"=>400,"msg"=>"No enquiry found");   
         }
         
    }
    
    public function NextRow_data($allData)
    {
        $sql = "select *,(select count(product_id) from product_master where product_id > ".$allData['product_id']." AND category_id = ".$allData['displayNo'].") as cp from product_master where product_id > ".$allData['product_id']." AND category_id = ".$allData['displayNo']."  ORDER BY product_id LIMIT 1";
        $sq_query = $this->db->query($sql);
         $sq_res = $sq_query->result_array();
         $sq_count = $sq_query->num_rows();
         if($sq_count>0){
            return array("stat"=>200,"msg"=>"Enquiry List", "all_list"=>$sq_res);   
         }else{
            return array("stat"=>400,"msg"=>"No enquiry found");   
         }
    }
    public function PrevRow_data($allData)
    {
        $sql = "select *,(select count(product_id) from product_master where product_id < ".$allData['product_id']." AND category_id = ".$allData['displayNo'].") as cp from product_master where product_id < ".$allData['product_id']." AND category_id = ".$allData['displayNo']." ORDER BY product_id DESC LIMIT 1";
        $sq_query = $this->db->query($sql);
         $sq_res = $sq_query->result_array();
         $sq_count = $sq_query->num_rows();
         if($sq_count>0){
            return array("stat"=>200,"msg"=>"Enquiry List", "all_list"=>$sq_res);   
         }else{
            return array("stat"=>400,"msg"=>"No enquiry found");   
         }
    }

    public function AbandonCart_data()
    {
        $nowDate = date('Y-m-d H:i:s');
        $sql = "SELECT cm.`cart_id`, cm.`client_id`,c.`user_name`,c.`user_email`, cm.`product_id`,p.`product_name`, p.`part_number`, p.`product_image`,p.`fabric`, cm.`del_status`, cm.`created_at` FROM `cart_master` cm LEFT JOIN client_master c ON c.client_id = cm.client_id LEFT JOIN product_master p on p.product_id = cm.product_id WHERE TIMESTAMPDIFF(MINUTE,cm.`created_at`,'".$nowDate."')>=180 and TIMESTAMPDIFF(MINUTE,cm.`created_at`,'".$nowDate."')<=240 ORDER BY cm.client_id asc";
        $sq_query = $this->db->query($sql);
         $sq_res = $sq_query->result_array();
         $sq_count = $sq_query->num_rows();
         if($sq_count>0){
            $finalArr = array();
            $cart_idArr = array();
            foreach ($sq_res as $value) {
                $id = $value['client_id'];
                $detailsArr = array();
                   foreach ($sq_res as $value2) {
                    if($value['client_id'] == $value2['client_id']){
                        $detailsArr[] = array("cart_id"=>$value2['cart_id'],"product_id"=>$value2['product_id'],"product_name"=>$value2['product_name'],"part_number"=>$value2['part_number'],"product_image"=>$value2['product_image'],"fabric"=>$value2['fabric']);
                    }
                // $cart_idArr
                }
                if (!in_array($id, $cart_idArr)){
                    array_push($cart_idArr,$id);
                    $finalArr[] = array("client_id"=>$value['client_id'],"user_name"=>$value['user_name'],"user_email"=>$value['user_email'],"Details"=>$detailsArr); 

                }
            }
            return array("stat"=>200,"msg"=>"Abandon Cart List", "data"=>$finalArr);   
         }else{
            return array("stat"=>400,"msg"=>"No enquiry found","query"=>$sql);   
         }
    }
}

?>


