<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//api

function validateApi($headers)
{
//    $headers = getallheaders();
//    echo json_encode($headers);die;

    if(!isset($headers['Authorization']))
    {
//            header('HTTP/1.1 400 Bad Request.', true, 400);
        echo json_encode(array("status"=>400,"type"=>"error","message"=>"Bad request. Please provide auth key"));die;
    }
    
    $ci = & get_instance();

    $authorization = $headers['Authorization'];
    $authorization = base64_decode(str_replace('Basic ','',$authorization));

    $auth_array = explode(":",$authorization);
    $auth_username = $auth_array[0];
    $auth_password = $auth_array[1];

    $config_auth_username = $ci->config->item('auth_username');
    $config_auth_password = $ci->config->item('auth_password');

    if($auth_username != $config_auth_username)
    {
//            header('HTTP/1.1 400 Bad Request.', true, 400);
        echo json_encode(array("status"=>400,"message"=>"Bad request. Auth username missmatch"));die;
    }
    if($auth_password != $config_auth_password)
    {
//            header('HTTP/1.1 400 Bad Request.', true, 400);
        echo json_encode(array("status"=>400,"message"=>"Bad request. Auth password missmatch"));die;
    }
}

















//ui

if ( ! function_exists('CustomEncrypt'))
{
	function CustomEncrypt($string) 
    {
        $result = '';
        $CI = get_instance();
        $key=$CI->config->item('encryptKey');
        for($i=0, $k= strlen($string); $i<$k; $i++)
        {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }
}

if ( ! function_exists('CustomDecrypt'))
{
	function CustomDecrypt($string)
    {
        $result = '';
        $CI = get_instance();
        $key=$CI->config->item('encryptKey');
        $string = base64_decode($string);
        for($i=0,$k=strlen($string); $i< $k ; $i++)
        {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)-ord($keychar));
            $result.=$char;
        }
        return $result;
    }
}

if ( ! function_exists('NumberEncrypt'))
{
	function NumberEncrypt($integer)
    {
        $result = 0;
        $result = (($integer*879465132)+78994651);
        return $result;
    }
}

if ( ! function_exists('NumberDecrypt'))
{
	function NumberDecrypt($integer)
    {
        $result = 0;
        $result = (($integer-78994651)/879465132);
        return $result;
    }
}

if ( ! function_exists('pr'))
{
	function pr($arr)
    {
        echo "<pre>";print_r($arr);die;
    }
}

if ( ! function_exists('je'))
{
	function je($arr)
    {
        echo json_encode($arr);die;
    }
}

if ( ! function_exists('jd'))
{
	function jd($arr,$stat=true)
    {
        echo json_decode($arr,$stat);die;
    }
}

function randomString($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++)
    {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


function sendMail($subject,$to,$viewName,$mailData=array())
{    
    $obj =& get_instance();
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers.= 'From: geetha.raj@microcotton.com';
    // $headers .= 'Cc: geetha.raj@microcotton.com' . "\r\n";
    
    $data['data'] = $mailData;    
    $message= $obj->load->view('mailTemplate/'.$viewName,$data,true);

    $api_url = "http://mail.infimonk.com/mailtest.php";
    $postfield="body=".$message."&to=".$to."&subject=".$subject."&headers=".$headers;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST,TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$postfield);
    $mailResponse = curl_exec($ch);
    curl_close($ch);
    $mailResponse = json_decode($mailResponse,true);
    return $mailResponse;
}


function sendOtp($mobileNumber,$message)
{
	$message = rawurlencode($message);
	// $msgResponse = CurlFunction(array(),"https://api.msg91.com/api/sendhttp.php?authkey=".Config('msg91AuthKey')."&message=".$message."&sender=".Config('msg91SenderKey')."&route=4&mobile=".$mobileNumber."&country=91");
	$msgResponse = CurlFunction(array(),"https://api.msg91.com/api/sendhttp.php?authkey=".Config('msg91AuthKey')."&mobiles=".$mobileNumber."&country=91&message=".$message."&sender=".Config('msg91SenderKey')."&route=4");

	return $msgResponse;
}

function CurlFunction($requestBody,$api_url)
{
    $header = array();
    if(is_array($requestBody))
    {
        $header  = array("Content-Type: application/json");
        $requestBody = json_encode($requestBody);
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST,TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$requestBody);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}



function CustomBaseEncode($t,$idx=8)
{
    for($i=0;$i<$idx;$i++)
    {
        $t = base64_encode($t);
    }
    
    return $t;
}

function CustomBaseDecode($t,$idx=8)
{    
    for($i=0;$i<$idx;$i++)
    {
        $t = base64_decode($t);
    }
    
    return $t;
}

function BigTextCrop($text,$n=100)
{
    $uniqueId = time();
    $dotText = "";
    if(strlen($text)>$n)
    {
        $dotText = '<span class="textspan">...</span><span class="textspan d-none">'.substr($text,$n,strlen($text)).'</span> <a href="javascript:void(0);" onclick="TextHideShow(this)" style="color:#5e15ef;">Show all</a>';
    }
    
    $xxx = '<span class="maintextspan">'.substr($text,0,$n).$dotText.'</span>';
    
    return $xxx;
}

//function SetCookie($name,$value,$time="")
//{
//    if($time == "")
//    {
//        $time = time() + (86400 * 365);
//    }
//    setcookie($name, $value, $time, "/");
//}

function GetCookie($name)
{
    $value = "";
    if(isset($_COOKIE[$name]))
    {
        $value = $_COOKIE[$name];
    }
    return $value;
}



function IsLoggedIn()
{
//    IsConnected();
    if(UserId() == "")
     {
         redirect(base_url("Login"));die;
     }
}

function NotLoggedIn()
{
//    IsConnected();
    if(UserId() != "")
     {
         redirect(base_url(Config('loginRedirectController')));die;
     }
}

function SessionUserData()
{
    return Userdata(Config('sessionPrefix')."sessionData");
}

function UserId()
{    
    $sessionData = Userdata(Config('sessionPrefix')."sessionData");
//    je($sessionData);
    $userId = "";
    if($sessionData && isset($sessionData['userId']))
    {
        $userId = $sessionData['userId'];
    }
    return $userId;
}

function UserName()
{    
    $sessionData = Userdata(Config('sessionPrefix')."sessionData");
//    je($sessionData);
    $userName = "";
    if($sessionData && isset($sessionData['userName']))
    {
        $userName = $sessionData['userName'];
    }
    return $userName;
}

function UserEmail()
{    
    $sessionData = Userdata(Config('sessionPrefix')."sessionData");
//    je($sessionData);
    $userEmail = "";
    if($sessionData && isset($sessionData['userEmail']))
    {
        $userEmail = $sessionData['userEmail'];
    }
    return $userEmail;
}

function UserRoleId()
{    
    $sessionData = Userdata(Config('sessionPrefix')."sessionData");
//    je($sessionData);
    $userRoleId = "";
    if($sessionData && isset($sessionData['userRoleId']))
    {
        $userRoleId = $sessionData['userRoleId'];
    }
    return $userRoleId;
}

function Config($item)
{
    $obj =& get_instance();
    return $obj->config->item($item);
}

function Userdata($item)
{
    $u = "";
    $obj =& get_instance();
    if($obj->session->userdata($item))
    {
        $u = $obj->session->userdata($item);
    }
    return $u;
}


function FilePreview($filePath,$dimension=50)
{
    $xxx = strtolower($filePath);
    $pos = strrpos($xxx, '.');
    $extension = $pos === false ? $xxx : substr($xxx, $pos + 1);
    
//    echo $extension;die;
    if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "svg" || $extension == "gif")
    {
        $txt =  '<img src="'.$filePath.'" width="'.$dimension.'" height="'.$dimension.'" title="Click to view">';
    }
    else
    {
        $txt = 'Click to view';
    }
    
    $atxt = '<a href="'.$filePath.'" target="_blank">'.$txt.'</a>';
    
    return $atxt;
}


function CommonView($pathAttr,$data=array())
{
    return View('Layout/Common/'.$pathAttr,$data,true);
}

function View($path,$data=array(),$stat=true)
{
    $obj =& get_instance();
    return $obj->load->view($path,$data,$stat);
}

function Uri($item)
{
    $obj =& get_instance();
    $ar = explode(',',$item);
    $content = '';
    foreach($ar as $k)
    {
        $content .= $obj->uri->segment($k).'/';
    }
    
    $content = rtrim($content,'/');
    
    return $content;
}

function CurrentUrl()
{
    $params   = $_SERVER['QUERY_STRING'];
    $c = str_replace('index.php/','',current_url());
    if(strlen($params)>0)
    {
        $c = $c . '?' . $params;
    }
    return $c;
}

function InputPost($a='')
{
    $obj =& get_instance();
    if($a == '')
    {
        return $obj->input->post();
    }
    else
    {
        return $obj->input->post($a);
    }
}

function HrefBlankCheck($item)
{
    $xx = 'javascript:void(0);';
    if(strlen($item)>0)
    {
        $xx = $item;
    }
    return $xx;
}

function defaultImg()
{
    return base_url('assets/file/picture.png');
}

function defaultUserImg()
{
    return base_url('assets/file/user.png');
}

function FileSrc($item,$small=true,$configParam='filePath_url')
{
    if($small===true)
    {
        $attr = 'small';
    }
    else
    {
        $attr = 'original';
    }
    
    $xx = defaultImg();
    if(strlen($item)>0)
    {
        if(strpos($item,'http://') !== false || strpos($item,'https://') !== false)
        {
            $xx = $item;
        }
        else
        {
            $xx = Config($configParam).$attr.'/'.$item;
        }
    }
    return $xx;
}

function IdEncrypt($id)
{
    $id = (int) $id;
    $encryptedId = rawurlencode(CustomEncrypt(base64_encode(NumberEncrypt($id))));
    return $encryptedId;
}

function IdDecrypt($encryptedId,$stat=true)
{
    $id = NumberDecrypt(base64_decode(CustomDecrypt(rawurldecode($encryptedId))));
    if(is_int($id))
    {
        $id = (int) $id;
    }
    else
    {
        $id = 0;
    }
    
    if($id == 0 && $stat === true)
    {
        redirect(base_url('Error404'));die;
    }
    
    return $id;
}

function Cnt($d)
{
    $x=0;
    if($d && isset($d) && count($d)>0)
    {
        $x=count($d);
    }
    return $x;
}



function BackupDataToDatabase($backup_array)
{
    $OBJECT =& get_instance();
    $OBJECT->db->insert('all_delete_backup',$backup_array);
//        echo $OBJECT->db->last_query();die;        
    $backup_id = 0;
    if($OBJECT->db->error()['code'] ==0)
    {
        $backup_id = $OBJECT->db->insert_id();
    }

    return $backup_id;
}


function moduleAccessData($specificType="")
{
    $ci =&get_instance();
    $userRoleId = UserRoleId();
    if($userRoleId == "")
    {
        redirect(base_url('logout'));die;
    }    
    $controllerName = Uri(1);
    $moduleAccessData = curlPost('specificUserAccess',array('userRoleId'=>$userRoleId,"controllerName"=>$controllerName));
    if($moduleAccessData['status'] != 200)
    {
        redirect(base_url('Error404'));die;
    }
    if($moduleAccessData['data'][0]['userAccessId'] == 0)
    {
        redirect(base_url('Error404'));die;
    } 
    if($specificType == "add" || $specificType == "edit")
    {
        if($moduleAccessData['data'][0][$specificType.'Status'] == 2)
        {
            redirect(base_url('Error404'));die;
        }
    }
    
    return $moduleAccessData['data'][0];
}

function getApi($hdr="",$allData=array(),$joindata="",$stat=true)
{
    $ci = & get_instance();
    $response = $ci->Api_model->GetData($allData,$hdr,$joindata);
    if($stat === false)
    {
        $response = json_encode($response);
    }   
    return $response;
}

function curlPost($functionName,$allData=array(),$hdr="",$joindata="",$stat=true)
{
    $ci = & get_instance();
    $fn = ucfirst($functionName).'Data';
    $response = $ci->Api_model->$fn($allData,$hdr,$joindata);
    if($stat === false)
    {
        $response = json_encode($response);
    }   
    return $response;
}


function GetImageResolution($fileKey,$small=true)
{
    if($small===true)
    {
        $attr = 'Small';
    }
    else
    {
        $attr = 'Big';
    }
    
    $xx = Config('image'.$attr.'Resolution');
    
    $r = array("width"=>false,"height"=>false);
    
    if($xx)
    {
        $keys = array_keys($xx);
        for($i=0;$i<count($keys);$i++)
        {
            if(strpos(strtolower($fileKey),$keys[$i]) !== false)
            {
                $r = $xx[$keys[$i]];
    //            break;
            }
        }
    }    
    
    return $r;
}

function ThmbnailImageUpload($config,$fileKey,$mainImageData)
{
    $obj =& get_instance();
    $mainWidth = $mainImageData['image_width'];
    $mainHeight = $mainImageData['image_height'];
    
    $r = GetImageResolution($fileKey);
    
    $w = $r['width'];
    $h = $r['height'];
    
    if($w === false || $h === false)
    {
        $w = (int) ($mainWidth/2);
        $h = (int) ($mainHeight/2);
    }
    
    $thumbnailFilePath = "";
    $file_upload_path=$obj->config->item('file_url');
    $upload_path = $file_upload_path.'/small/';
    
    $config['upload_path'] = $upload_path;
    
    $obj->load->library('upload',$config);
    $obj->upload->initialize($config);
    if($obj->upload->do_upload($fileKey))
    {
        $uploadData = $obj->upload->data();
        $pictureName =  $uploadData['file_name'];
        $thumbnailFilePath = $uploadData['full_path'];
        
        ImageCropper($w,$h,$thumbnailFilePath,$config);
    }
    
    return $thumbnailFilePath;
}


function ImageCropper($w,$h,$full_path,$config)
{
    $obj =& get_instance();
    
    $config['image_library'] = 'gd2';
    $config['source_image']  =  $full_path;
    $config['maintain_ratio'] = false;
    $config['quality'] = '100%';
    $config['width'] = $w;
    $config['height'] = $h;

    $obj->image_lib->clear();
    $obj->image_lib->initialize($config);
    $obj->image_lib->resize();
//    $obj->image_lib->crop();
    
    return 1;
}


function ImageUpload($FILES,$configPath=true,$thumbStat=true)
{
    if($configPath === true)
    {
        $configPath = 'file_url';
    }
    
//    if($configPath === false)
//    {
//        $configPath = 'profile_docs_param';
//    }
    
    $obj =& get_instance();
    $file_upload_path=$obj->config->item($configPath);
//    echo $configPath;die;
    $keys=array_keys($FILES);
    $objarray=array();
    $error=array();
    $pictureName = "";
    $upload_path = $file_upload_path.'/original/';
    
//    echo $upload_path;die;
//    pr($FILES);
    
    for($i=0;$i<count($keys);$i++)
    {
        if($FILES[$keys[$i]]['name'] != '')
        {
            if(!is_array($FILES[$keys[$i]]['name'])) //single image
            {
                $filesNameXX= str_replace(' ','-',$FILES[$keys[$i]]['name']);
                $filesNameXX = preg_replace('/[^A-Za-z0-9\-]/', '', $filesNameXX);
                
                $picturefile_name = time()."_".ucwords($keys[$i])."_".$filesNameXX;
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = '*';
                $config['file_name'] = $picturefile_name;
                $obj->load->library('upload',$config);
                $obj->upload->initialize($config);
    //            echo $keys[$i];die;
                if($obj->upload->do_upload($keys[$i]))
                {
                    $uploadData = $obj->upload->data();
                    $pictureName =  $uploadData['file_name'];
                    if(strpos($uploadData['file_type'],'image')!==false)
                    {
                        $mainFilePath = $uploadData['full_path'];
                        $r = GetImageResolution($keys[$i],false);
                        $w = $r['width'];
                        $h = $r['height'];
                        if($w != false && $h !== false)
                        {
                            ImageCropper($w,$h,$mainFilePath,$config);
                        }
                        
                        if($thumbStat === true)
                        {
                            $thumbnailFilePath = ThmbnailImageUpload($config,$keys[$i],$uploadData);
                        }                        
                    }
                }
                
                $objarray[$keys[$i]]=$pictureName;
            }
            else //multiple image
            {
    //            echo "in";die;
                if(empty($FILES[$keys[$i]]['name'][0]))
                {
                    continue;
                }
                $objarray[$keys[$i]] = "";
                $galleryImgCount = count($FILES[$keys[$i]]['name']);
                $pictureName = "";

                for ($j = 0; $j < $galleryImgCount; $j++)
                {
                    $_FILES[$keys[$i].'_img']['name'] = $FILES[$keys[$i]]['name'][$j];
                    $_FILES[$keys[$i].'_img']['type'] = $FILES[$keys[$i]]['type'][$j];
                    $_FILES[$keys[$i].'_img']['tmp_name'] = $FILES[$keys[$i]]['tmp_name'][$j];
                    $_FILES[$keys[$i].'_img']['error'] = $FILES[$keys[$i]]['error'][$j];
                    $_FILES[$keys[$i].'_img']['size'] = $FILES[$keys[$i]]['size'][$j];
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = '*';
                    $config['file_name'] = time()."_".$FILES[$keys[$i]]['name'][$j];
                    //$mediaPath = $base_url.'assets/media/';
                    $obj->load->library('upload',$config);
                    $obj->upload->initialize($config);
                    if($obj->upload->do_upload($keys[$i].'_img'))
                    {
                        $uploadData = $obj->upload->data();
                        $pictureName .= $uploadData['file_name'].",";
                    }
                }
                $objarray[$keys[$i]] = rtrim($pictureName,',');
            }
        }
        
    }
    
    return $objarray;
}


function getDateToday($timestamp)
{
    $datestamp1 = strtotime($timestamp); 
    $datestamp2 = strtotime(date('Y-m-d H:i:s'));
    
    $date1 = date('d-m-y',$datestamp1);
    $date2 = date('d-m-y');
    
    if($date1 == $date2)
    {
        return 'Today '.date('h:i a',$datestamp1);
    }
    else
    {
        return date('d-m-y h:i a',$datestamp1);
    }
}

function getTimeDiff($timestamp)
{
    $date1 = strtotime($timestamp); 
    $date2 = strtotime(date('Y-m-d H:i:s'));
    $diff = abs($date2 - $date1);


//        $diff = abs($strtotime);

    $years = floor($diff / (365*60*60*24));

    $months = floor(($diff - $years * 365*60*60*24) 
                                / (30*60*60*24));

    $days = floor(($diff - $years * 365*60*60*24 - 
                $months*30*60*60*24)/ (60*60*24));

    $hours = floor(($diff - $years * 365*60*60*24 
        - $months*30*60*60*24 - $days*60*60*24) 
                                    / (60*60));

    $minutes = floor(($diff - $years * 365*60*60*24 
            - $months*30*60*60*24 - $days*60*60*24 
                            - $hours*60*60)/ 60);

    $seconds = floor(($diff - $years * 365*60*60*24 
            - $months*30*60*60*24 - $days*60*60*24 
                    - $hours*60*60 - $minutes*60));

//        printf("%d years, %d months, %d days, %d hours, "
//            . "%d minutes, %d seconds", $years, $months, 
//                    $days, $hours, $minutes, $seconds);

//        return "$hours hours, $minutes minutes, $seconds seconds";

    if($years > 0)
    {
        $txt = "s";
        if($years==1)
        {
            $txt = "";
        }
        $returnTxt = "$years year$txt ago";
    }
    else
    {
        if($months>0)
        {
            $txt = "s";
            if($months==1)
            {
                $txt = "";
            }
            $returnTxt = "$months month$txt ago";
        }
        else
        {
            if($days>0)
            {
                $txt = "s";
                if($days==1)
                {
                    $txt = "";
                }
                $returnTxt = "$days day$txt ago";
            }
            else
            {
                if($hours>0)
                {
                    $txt = "s";
                    if($hours==1)
                    {
                        $txt = "";
                    }
                    $returnTxt = "$hours hour$txt ago";
                }
                else
                {
                    if($minutes>0)
                    {
                        $txt = "s";
                        if($minutes==1)
                        {
                            $txt = "";
                        }
                        $returnTxt = "$minutes minute$txt ago";
                    }
                    else
                    {
                        $returnTxt = "Just now";
                    }
                }
            }
        }
    }

//        echo $days;die;

    return $returnTxt;
}



















function chatData($userType,$webinarDatesUniqueCode,$participantId=0)
{
    if($userType == 'user')
    {
        $data['participantQuestionData'] = curlPost('get',array('webinar_dates.webinarDatesUniqueCode'=>$webinarDatesUniqueCode,"webinar_questions.questionStatusId <"=>3,"order_by"=>array("webinarQuestionId"=>"asc")),'webinar_questions','webinar_dates,question_status,participant');
    }
    else
    {
        $data['participantQuestionData'] = curlPost('get',array('webinar_dates.webinarDatesUniqueCode'=>$webinarDatesUniqueCode,"webinar_questions.participantId"=>$participantId,"webinar_questions.questionStatusId <"=>3),'webinar_questions','webinar_dates,question_status,participant');
    }
    
    $data['approvedQuestionData'] = curlPost('get',array('webinar_dates.webinarDatesUniqueCode'=>$webinarDatesUniqueCode,"webinar_questions.questionStatusId"=>2),'webinar_questions','webinar_dates,question_status,participant');
    
    return $data;
}

function gethost($userId,$webinarId)
{
    if($userId > 0){
        $data = curlPost('get',array('webinar_users.userId'=>$userId,"webinar_users.webinarId"=>$webinarId,"webinar_users.hostStatus"=>1),'webinar_users');
        if($data['status'] !=200){
            $data = curlPost('get',array('webinar_users.onlineStatus'=>1,"webinar_users.webinarId"=>$webinarId,"webinar_users.hostStatus"=>1),'webinar_users');
        }
    }else{
         $data = curlPost('get',array('webinar_users.onlineStatus'=>1,"webinar_users.webinarId"=>$webinarId,"webinar_users.hostStatus"=>1),'webinar_users');
    }
    
    return $data;
}

function genPost($allData=array(),$fn="Get",$stat=true)
{
    $ci = & get_instance();
    $api_url = $ci->config->item('api_url');
    $api_url = $api_url."General/".$fn;
    // echo $api_url; die;
    $response = $ci->General_model->general_function($allData,$api_url);
    if($stat === false)
    {
        $response = json_encode($response,true);
    }else{
        $response = json_decode($response,true);
    }   
    // pr($response); die;
    return $response;
}

function getnextprod($prodId,$displayNo)
{
   $objarray = array('product_id'=>$prodId,"displayNo"=>$displayNo);
    $data = genPost($objarray,"NextRow");
    $v = "";
    if($data['stat'] == 200){
        $v = $data['all_list'][0];
    }
    return $v;
}
function getprevprod($prodId,$displayNo)
{
    $objarray = array('product_id'=>$prodId,"displayNo"=>$displayNo);
    $data = genPost($objarray,"PrevRow");
    $v = "";
    if($data['stat'] == 200){
        $v = $data['all_list'][0];
    }
    return $v;
}

function Cartcount()
{
    $user_id = Userdata('user_id');
    $objarray = array("cart"=>array("client_id"=>$user_id));
    $data = genPost($objarray);
    return count($data['all_list']);
}

function Cartdata()
{
    $user_id = Userdata('user_id');
    $objarray = array("cart"=>array("client_id"=>$user_id),"join"=>"product");
    $data = genPost($objarray);
    return $data;
}

function Productdata($productId)
{
    $user_id = Userdata('user_id');
    $objarray = array("product"=>array("product_id"=>$productId));
    $data = genPost($objarray);
    return $data;
}