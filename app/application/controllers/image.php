<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(1);
class Image extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    function index($type = "")
    {
        $height = isset($_GET['h']) ? $_GET['h'] : "";
        $width = isset($_GET['w']) ? $_GET['w'] : "";
        $url = MEDIA_FILES_URL . "images/imagenotavailable.jpg";
        if(isset($_GET['file_name']) && strlen(trim($_GET['file_name'])) > 0)  {
            $url = MEDIA_FILES_URL ."uploads/images/";
            if($type == "article")
                $url .= "articles/";
            else if($type == "profile")
                $url .= "profile/";
            else if($type == 'events')
                $url .= "events/";
            else if($type == 'participants')
                $url .= "participants/";
            else
                $url .= "articles/";
            $url .= $_GET['file_name'];
            //echo $url;exit;
            $image_size=getimagesize($url);
            #error_log();
            if(!is_array($image_size))
            {
                $fileType;
                $ext = "." . pathinfo($url, PATHINFO_EXTENSION);
                if($type == "article") {
                    $fileNames = explode("/",$_GET['file_name']);
                    $articleId = base64_encode($fileNames[0]);
                    $fileType = str_ireplace($ext, "",str_ireplace($articleId,"",$fileNames[1]));
                }
                //else $fileType = "th_sm";
                
                
                switch($fileType) {
                    case "f_" :
                    case "featured_":
                        $url = MEDIA_FILES_URL . "images/notfound/560x310.jpg";
                        break;
                    
                    case "th_big_" :
                    case "thumb_big_":
                        $url = MEDIA_FILES_URL . "images/notfound/570x270.jpg";
                        break;
                    
                    case "th_" :
                        $url = MEDIA_FILES_URL . "images/notfound/270x270.jpg";
                        break;
                    
                     case "th_sm" :
                        $url = MEDIA_FILES_URL . "images/notfound/50x50.jpg";
                        break;
                    
                    case "b_" :
                        $url = MEDIA_FILES_URL . "images/notfound/270x270.jpg";
                        break;
                    
                    default :
                        if(strstr("featured_", $fileType) !== FALSE)
                            $url = MEDIA_FILES_URL . "images/notfound/560x310.jpg";
                        else if(strstr("thumb_big_", $fileType) !== FALSE)
                            $url = MEDIA_FILES_URL . "images/notfound/570x270.jpg";
                        else if(strstr("thumb_", $fileType) !== FALSE)
                            $url = MEDIA_FILES_URL . "images/notfound/270x270.jpg";
                        else if(strstr("thumb_small_", $fileType) !== FALSE)
                            $url = MEDIA_FILES_URL . "images/notfound/270x270.jpg";
                        else if(strstr("banner_", $fileType) !== FALSE)
                            $url = MEDIA_FILES_URL . "images/notfound/270x270.jpg";
                        else if($width !== "" && $height !== "") {
                             $url = MEDIA_FILES_URL . "images/notfound/".$width."x".$height.".jpg";                           
                        }
                        else
                            $url = MEDIA_FILES_URL . "images/notfound/270x270.jpg";
                        break;
                }
                #error_log( $url . "----".$fileType );
            }
        }
        
        $ext = "." . pathinfo($url, PATHINFO_EXTENSION);
    
        header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");//Dont cache
        header("Pragma: no-cache");//Dont cache
        header("Expires: " . date('D, d M Y H:i:s'));
        if($ext  == ".png") {
            $re = @imagecreatefrompng($url);
            if(!$re) {
                $re = imagecreatefromjpeg($url);
                
                if(!$re) {
                    $url = HOST_BASE_URL . "media/images/imagenotavailable.jpg";
                    $re = imagecreatefromjpeg($url);
                    header('Content-type: image/jpeg');
                    imagejpeg($re);
                    exit;
                }
                header('Content-type: image/jpeg');
                imagejpeg($re);
                exit;
            }
            header('Content-type: image/png');
            imagepng($re);
            exit;
        }
        else{
            $re = imagecreatefromjpeg($url);
        
            if(!$re) {
                $url = HOST_BASE_URL . "media/images/imagenotavailable.jpg";
                $re = imagecreatefromjpeg($url);
                header('Content-type: image/jpeg');
                imagejpeg($re);
                exit;
            }
            header('Content-type: image/jpeg');
            imagejpeg($re);
            exit;
        }
        exit;
    }
}