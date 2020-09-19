<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('EncryptID'))
{
    function EncryptID($id)
    {
          $id=(double)$id*555355.24;
          return base64_encode($id);
    }
}
if (!function_exists('DecryptID'))
{
    function DecryptID($url_id)
    {
         $url_id=base64_decode($url_id);
         $id=(double)$url_id/555355.24;
         return $id;
    }
}