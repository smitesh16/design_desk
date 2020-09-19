<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('module'))
{
    function module()
    {
       $arr = array();
       $CI = & get_instance();
       $api_url = $CI->config->item('api_url');
       $base_url = $CI->config->item('base_url');
       $CI->load->model('General_model');
        
        $get_api_url = $api_url."General/Get";
        $objarray = array('module'=>array(),"order_by"=>array("priority_status"=>"asc"));
        //echo json_encode($objarray);
        $result = json_decode($CI->General_model->general_function($objarray,$get_api_url),true);
        if(count($result)>0){
            foreach($result['all_list'] as $r){
                if($r['sidebar_status'] != 0){
                    if(array_key_exists($r['sidebar_status'],$arr)){
                        $arr[$r['sidebar_status']]['submenu'][] = array("module_id"=>$r['module_id'],"module_name"=>$r['module_name'],"controller_name"=>$r['controller_name'],"function_name"=>$r['function_name'],"modal"=>$r['modal'],"priority_status"=>$r['priority_status'],"sidebar_status"=>$r['sidebar_status'],"fav_icon"=>$r['fav_icon']);
                    }   
                } else{
                    $arr[$r['module_id']] = array("module_id"=>$r['module_id'],"module_name"=>$r['module_name'],"controller_name"=>$r['controller_name'],"function_name"=>$r['function_name'],"modal"=>$r['modal'],"priority_status"=>$r['priority_status'],"sidebar_status"=>$r['sidebar_status'],"fav_icon"=>$r['fav_icon']);
                }
            }
        }
        //echo "<pre>";print_r($arr);die;
       return $arr;
    }
}

