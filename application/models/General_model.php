<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model {

    public function general_function($objarray,$api_url)
   {
       $api_key = $this->config->item('api_key');
       $auth_username = $this->config->item('auth_username');
       $auth_password = $this->config->item('auth_password');
       $auth_key = "Basic ".base64_encode($auth_username.":".$auth_password);

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $api_url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
       curl_setopt($ch, CURLOPT_HEADER, FALSE);
       curl_setopt($ch, CURLOPT_POST,TRUE);
       curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($objarray));
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   "Authorization: ".$auth_key,
                   "Content-Type: application/json",
                   "api_key: ".$api_key,
      ));
        //echo json_encode($objarray); die;
       $response = curl_exec($ch);
       curl_close($ch);
       // echo json_encode($response); die;
       return $response;
   }
}
?>