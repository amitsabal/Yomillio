<?php
    require_once('config.php');
    
    $url = HOST_BASE_URL . "media/images/imagenotavailable.jpg";
    if(isset($_GET['file_name']) && strlen(trim($_GET['file_name'])) > 0)  {
        $url = HOST_BASE_URL . "media/uploads/images/articles/";
        
        $type = isset($_GET['type']) ? $_GET['type'] : "articles";
        if($type == 'users')
            $url = HOST_BASE_URL . "media/uploads/images/profile/";    
        
        $url .= $_GET['file_name'];
        
        $image_size=getimagesize($url);

        if(!is_array($image_size))
        {
            $url = HOST_BASE_URL . "media/images/imagenotavailable.jpg";
        }
    }
    $ext = "";
$ext = "." . pathinfo($url, PATHINFO_EXTENSION);
//echo $ext ."--".$url;exit;
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
