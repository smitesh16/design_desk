<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Language Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/helpers/language_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('custom_pagination'))
{
	/**
	 * Lang
	 *
	 * Fetches a language variable and optionally outputs a form label
	 *
	 * @param	string	$line		The language line
	 * @param	string	$for		The "for" value (id of the form element)
	 * @param	array	$attributes	Any additional HTML attributes
	 * @return	string
	 */
	function custom_pagination($table_attr,$join_attr,$page_number,$encrypt_searchTxt,$specificarray=array(),$api_url_param="Get",$orderby=array(),$where_in_array=array(),$has_sub_arr=array(),$selectTxt="")
	{
        $CI =& get_instance();
        $api_url = $CI->config->item('api_url');
        $get_api_url = $api_url."General/".$api_url_param;
        $limit = $CI->config->item('pagination_limit');
        
//        $offset = (($page_number-1)*$limit);
        $offset = ($page_number);
        
//        $objarray = array($table_attr=>$specificarray,"limit"=>$limit,"offset"=>$offset);
        $objarray = array($table_attr=>$specificarray);
        
        if($selectTxt != '')
        {
            $objarray['select'] = $selectTxt;
        }
        if($join_attr != '')
        {
            $objarray['join'] = $join_attr;
        }
         if(count($orderby)>0)
        {
            $objarray['order_by'] = $orderby;
        }
         if(count($where_in_array)>0)
        {
            $objarray['where_in'] = $where_in_array;
        }  
        if(count($has_sub_arr)>0)
        {
            $objarray['sub_array'] = $has_sub_arr;
        }
        
        if($encrypt_searchTxt !='')
        {
            if(strpos($encrypt_searchTxt,'__sr__') !== false)
            {
                $encrypt_searchTxt = str_replace("__sr__","",$encrypt_searchTxt);
                if($encrypt_searchTxt !='')
                {
                    $searchTxtArr = explode(':',base64_decode($encrypt_searchTxt));
                    $start_date = $searchTxtArr[0];
                    $end_date = $searchTxtArr[1];
                    $btw_txt = $table_attr."_created_at";
                    if($api_url_param == "Attendance_report")
                    {
                        $end_date = date("Y-m-d",strtotime("+1 Day",strtotime($end_date)));
                        $btw_txt = "login_date";
                    }

                    $objarray[$table_attr][$btw_txt." BETWEEN '".$start_date."' AND '".$end_date."'"] = null;
                }
            }
            else
            {
                $searchTxtArr = explode(':',base64_decode($encrypt_searchTxt));
                $column_name = $searchTxtArr[0];
                $searchTxt = $searchTxtArr[1];
                
                
                $objarray['limit'] = $limit;
                $objarray['offset'] = $offset;
                $objarray[$table_attr][$column_name." LIKE '%".$searchTxt."%'"] = null;
            }
        }
        else
        {
            $objarray['limit'] = $limit;
            $objarray['offset'] = $offset;
        }
        
        $objarray1 = $objarray;
        unset($objarray1['limit']);
        unset($objarray1['offset']);
//        $objarray1['select'] = 'count(*) as all_count';
        
//        return json_encode($objarray);
        
        $response = json_decode($CI->General_model->general_function($objarray,$get_api_url),true);
        $response1 = json_decode($CI->General_model->general_function($objarray1,$get_api_url),true);
        $response['all_count'] = $response1['list_count'];
            
        return json_encode($response);
	}
}


if ( ! function_exists('holiday_list'))
{
	/**
	 * Lang
	 *
	 * Fetches a language variable and optionally outputs a form label
	 *
	 * @param	string	$line		The language line
	 * @param	string	$for		The "for" value (id of the form element)
	 * @param	array	$attributes	Any additional HTML attributes
	 * @return	string
	 */
	function holiday_list()
	{
        $year = date('Y');
        $CI =& get_instance();
        $api_url = $CI->config->item('api_url');
        $get_api_url = $api_url."General/Get_holiday_list";
        $objarray = array("holiday"=>array("year"=>$year));
        $response = json_decode($CI->General_model->general_function($objarray,$get_api_url),true);
        return json_encode($response['all_list']);
	}
}


if ( ! function_exists('pickup_list'))
{
	/**
	 * Lang
	 *
	 * Fetches a language variable and optionally outputs a form label
	 *
	 * @param	string	$line		The language line
	 * @param	string	$for		The "for" value (id of the form element)
	 * @param	array	$attributes	Any additional HTML attributes
	 * @return	string
	 */
	function pickup_list()
	{
        $CI =& get_instance();
        $api_url = $CI->config->item('api_url');
        $get_api_url = $api_url."General/Get";
        $objarray = array("pickup_request"=>array());
        $content['pickup_list'] = json_decode($CI->General_model->general_function($objarray,$get_api_url),true);
        
        if($content['pickup_list']['stat']==200)
        {
            for($i=0;$i<$content['pickup_list']['list_count'];$i++)
            {
                if($content['pickup_list']['all_list'][$i]['pickup_confirm_date']!=null)
                {
                     $pickuparr[]=array("title"=>$content['pickup_list']['all_list'][$i]['pickup_company_name']."\nRequest Date:".$content['pickup_list']['all_list'][$i]['pickup_date_request']."\nPhone:".$content['pickup_list']['all_list'][$i]['pickup_contact_number'],"start"=>$content['pickup_list']['all_list'][$i]['pickup_confirm_date'],"url"=>"Pickup");
                 }  
            }
        }
        else {
            $pickuparr[]=array();
        }
        
        return json_encode($pickuparr);
	}
}
