<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function group_by($key, $newValue, $repeatValue, $data) {
        $result = array();
        $Arr = array();
        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                if(array_key_exists($val[$key], $result)){
                    
                    $repeat = explode(",",$repeatValue);
                    foreach($repeat as $r){
                        $Arr[$r] = $val[$r];
                    }
                    $result[$val[$key]]['details'][] = $Arr;
                }else{
                    
                    $new = explode(",",$newValue);
                    foreach($new as $n){
                        $result[$val[$key]][$n] = $val[$n];
                    }
                    
                    $repeat = explode(",",$repeatValue);
                    foreach($repeat as $r){
                        $Arr[$r] = $val[$r];
                    }
                    $result[$val[$key]]['details'][] = $Arr;
                    
                }
            }
        }
        return $result;
    }

?>