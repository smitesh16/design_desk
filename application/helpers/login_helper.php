<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('login'))
{
    function login()
    {
        $CI = & get_instance();
       if($CI->session->userdata('admin_id')=="")
        {
              header('Location: '.base_url());
        }
    }
}

