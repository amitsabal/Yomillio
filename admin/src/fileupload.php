<?php
$data = json_decode(file_get_contents("php://input"), true);
$data = array_merge(is_array($data) ? $data : array(), $_GET);

$encodedFileName = "";
$uploadedFiles = [];

if(!isset($data['submitted_image']))
{
  //Validate whether file is uploaded or not
  if( !isset($_FILES) && !isset($_FILES['file']) )
      return;
  $response = array();
  $response['file'] = $_FILES;
  $response['uploadedFiles'] = [];
  $response['message'] = [];
  $response['error'] = false;
  
  header('Content-Type: application/json');
  
  $allowedExts = array("jpg", "jpeg", "png");
  $temp = explode(".", $_FILES["file"]["name"]);
  $extension = end($temp);
  $phpFileUploadErrors = array(
      0 => 'There is no error, the file uploaded with success',
      1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
      2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
      3 => 'The uploaded file was only partially uploaded',
      4 => 'No file was uploaded',
      6 => 'Missing a temporary folder',
      7 => 'Failed to write file to disk.',
      8 => 'A PHP extension stopped the file upload.',
  );
  
  // Returns a file size limit in bytes based on the PHP upload_max_filesize
  // and post_max_size
  function file_upload_max_size() {
    static $max_size = -1;
  
    if ($max_size < 0) {
      // Start with post_max_size.
      $max_size = parse_size(ini_get('post_max_size'));
  
      // If upload_max_size is less, then reduce. Except if upload_max_size is
      // zero, which indicates no limit.
      $upload_max = parse_size(ini_get('upload_max_filesize'));
      if ($upload_max > 0 && $upload_max < $max_size) {
        $max_size = $upload_max;
      }
    }
    return $max_size;
  }
  
  function parse_size($size) {
    $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
    $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
    if ($unit) {
      // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
      return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
    }
    else {
      return round($size);
    }
  }
   
  
   //Check if there is any error in uploading the file
  
  if ($_FILES["file"]["error"] > 0) {
      
      $response['error'] = true;    
      $response['message'][] =  "Sorry, there was an error uploading your file." . $phpFileUploadErrors[$_FILES['file']['error']];
      
      if($_FILES['file']['error'] == 1)
      {
          $max_upload_size = file_upload_max_size();
          $response['message'][] =  "File size shoud be less than $max_upload_size kB";
      }
      
  }
  if ( $_FILES["file"]["type"] != "image/png" &&
          $_FILES["file"]["type"] != "image/jpg" &&
          $_FILES["file"]["type"] != "image/jpeg" ) {
      
      $response['message'][] =  "Mime type not allowed";
      
  }
  if (!in_array(strtolower($extension), $allowedExts)) {
      
      $response['error'] = true;
      $response['message'][] =  "Extension not allowed";
      $response['extension'] = $extension;
  }
  
  
  if(isset($response['error']) && $response['error'])
  {
      http_response_code(500);
      echo json_encode($response);
      exit;
  }
}
require_once('config.php');

//Now resize all the images to required sizes and save
// load the image manipulation class
require './Zebra_Image.php';



function compress($source, $destination, $name, $quality)
{
    $info = getimagesize($source);
    
    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);
    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);
    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);
    
    imagejpeg($image, $destination . $name, $quality);
    //imagepng($image, $destination ."_png_" . $name, 9);
    
    return $destination;
}

function resize($path, $w, $h, $prefix, $srcFile, $field, $crop=6) {
    global $uploadedFiles, $encodedFileName;
    error_log($path."--".$w. "--".$h."--".$prefix."--".$srcFile."--".$field);
    // create a new instance of the class
    $image = new Zebra_Image();
    
    // indicate a source image (a GIF, PNG or JPEG file)
    $image->source_path = $srcFile;
    
    // indicate a target image
    // note that there's no extra property to set in order to specify the target
    // image's type -simply by writing '.jpg' as extension will instruct the script
    // to create a 'jpg' file
    $image->target_path = $path . $prefix . $encodedFileName;
    
    // some additional properties that can be set
    // read about them in the documentation
    $image->preserve_aspect_ratio = true;
    $image->enlarge_smaller_images = true;
    $image->preserve_time = true;
    
    // resize the image to exactly 100x100 pixels by using the "crop from center" method
    // (read more in the overview section or in the documentation)
    //  and if there is an error, check what the error is about
    if (!$image->resize($w, $h, $crop)) {
    
        error_log(print_r($image,true));
        // if there was an error, let's see what the error is about
        switch ($image->error) {
    
            case 1:
                return 'Source file could not be found!';
                break;
            case 2:
                return 'Source file is not readable!';
                break;
            case 3:
                return 'Could not write target file!';
                break;
            case 4:
                return 'Unsupported source file format!';
                break;
            case 5:
                return 'Unsupported target file format!';
                break;
            case 6:
                return 'GD library version does not support target file format!';
                break;
            case 7:
                return 'GD library is not installed!';
                break;
            case 8:
                return '"chmod" command is disabled via configuration!';
                break;
    
        }
    
    // if no errors
    }
    else
    {
        error_log("Compressing..");
        compress($image->target_path, $path , $prefix . $encodedFileName, 70);
        $uploadedFiles[$field] = str_ireplace($path, "",$image->target_path);
        return 'Success!';
    }
    
}


function article_files_upload()
{
    global $uploadedFiles, $encodedFileName, $data;
    
    $article_id = $_GET['item_id'];
    $article_type_id = $_GET['item_type_id'];
    $bool = @mkdir(APP_BASE_MEDIA_URL."uploads/images/articles/".$article_id, 0777);
    $target_dir = APP_BASE_MEDIA_URL."uploads/images/articles/".$article_id."/";
    $name = ""; $ext = "";
    $target_file;
    if( isset($_FILES) && isset($_FILES['file']) )
    {
        $name = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : "";
    
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $encodedFileName = base64_encode($article_id). ".". $ext;
        $target_file  = $target_dir . "org_". $encodedFileName ;
    
        if (isset($_FILES) && isset($_FILES['file']) && move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
        {
            compress($target_file, $target_file, "", 70);
            $uploadedFiles['original'] = str_ireplace($target_dir, "",$target_file);
        }
    }
    else if(isset($data['submitted_image']))
    {
        $uploadedFiles['original'] = $data['submitted_image'];
        $target_file  = $target_dir . $uploadedFiles['original'] ;
        $ext = pathinfo($target_file, PATHINFO_EXTENSION);
        $encodedFileName = base64_encode($article_id). ".". $ext;
    }
    else {
        $response = array();
        $response['error'] = true;
        $response['uploadedFiles'] = $uploadedFiles;
        $response['message'] =  "Sorry, there was an error uploading your file.";
        http_response_code(500);
        echo json_encode($response);
        exit;
    }
    
    
    // article
    if($article_type_id == 1 || $article_type_id == 3)
    {
        resize($target_dir, 560, 310, "f_", $target_file, "featured_image_large",ZEBRA_IMAGE_BOXED);
        $uploadedFiles['featured_image_small'] = $uploadedFiles['featured_image_large'];
        resize($target_dir, 570, 270, "th_big_", $target_file, "thumbnail_big_image",ZEBRA_IMAGE_BOXED);
        resize($target_dir, 270, 270, "th_", $target_file, "thumbnail_image",ZEBRA_IMAGE_BOXED);
        resize($target_dir, 700, 400, "b_", $target_file, "banner_image",ZEBRA_IMAGE_BOXED);   
    }
    elseif($article_type_id == 2)
    {
        resize($target_dir, 560, 310, "f_", $target_file, "featured_image_large",ZEBRA_IMAGE_CROP_TOPCENTER);
        $uploadedFiles['featured_image_small'] = $uploadedFiles['featured_image_large'];
        resize($target_dir, 570, 270, "th_big_", $target_file, "thumbnail_big_image",ZEBRA_IMAGE_CROP_TOPCENTER);
        resize($target_dir, 270, 270, "th_", $target_file, "thumbnail_image",ZEBRA_IMAGE_CROP_TOPCENTER);
        list($width, $height) = getimagesize($target_file);
        resize($target_dir, $width, $height, "b_", $target_file, "banner_image", ZEBRA_IMAGE_BOXED);
    }
}


function event_files_upload()
{
    global $uploadedFiles, $encodedFileName;
    $article_id = $_GET['item_id'];
  
    $bool = @mkdir(APP_BASE_MEDIA_URL."uploads/images/events/".$article_id, 0777);
    if(!$bool) error_log("Unable to create directory!");
    $target_dir = APP_BASE_MEDIA_URL."uploads/images/events/".$article_id."/";
    $name = ""; $ext = "";
    if( isset($_FILES) && isset($_FILES['file']) )
    {
        $name = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : "";
    
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $encodedFileName = base64_encode($article_id). ".". $ext;
        $target_file  = $target_dir . "org_". $encodedFileName ;
    
        if (isset($_FILES) && isset($_FILES['file']) && move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
        {
            compress($target_file, $target_file, "", 70);
            $uploadedFiles['original'] = str_ireplace($target_dir, "",$target_file);
        }
    }
    else {
        $response = array();
        $response['error'] = true;
        $response['uploadedFiles'] = $uploadedFiles;
        $response['message'] =  "Sorry, there was an error uploading your file.";
        http_response_code(500);
        echo json_encode($response);
        exit;
    }    

    resize($target_dir, 270, 270, "th_", $target_file, "thumbnail_image",ZEBRA_IMAGE_BOXED);
    resize($target_dir, 982, 564, "b_", $target_file, "banner_image",ZEBRA_IMAGE_BOXED);   
}

function participant_files_upload()
{
    global $uploadedFiles, $encodedFileName;
    $participant_id = $_GET['item_id'];
  
    $bool = @mkdir(APP_BASE_MEDIA_URL."uploads/images/participants/".$participant_id, 0777);
    if(!$bool) error_log("Unable to create directory!");
    $target_dir = APP_BASE_MEDIA_URL."uploads/images/participants/".$participant_id."/";
    $name = ""; $ext = "";
    if( isset($_FILES) && isset($_FILES['file']) )
    {
        $name = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : "";
    
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $encodedFileName = base64_encode($participant_id). ".". $ext;
        $target_file  = $target_dir . "org_". $encodedFileName ;
    
        if (isset($_FILES) && isset($_FILES['file']) && move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
        {
            compress($target_file, $target_file, "", 70);
            $uploadedFiles['original'] = str_ireplace($target_dir, "",$target_file);
        }
    }
    else {
        $response = array();
        $response['error'] = true;
        $response['uploadedFiles'] = $uploadedFiles;
        $response['message'] =  "Sorry, there was an error uploading your file.";
        http_response_code(500);
        echo json_encode($response);
        exit;
    }    

    resize($target_dir, 270, 270, "th_", $target_file, "thumbnail_image",ZEBRA_IMAGE_BOXED);
    resize($target_dir, 982, 564, "b_", $target_file, "banner_image",ZEBRA_IMAGE_BOXED);   
}

$item_type = $_GET['item_type'];
$item_type_id = $_GET['item_type_id'];
$item_id = $_GET['item_id'];

switch($item_type) {
    case 'article' :
        
        article_files_upload();
        
        break;
    
    case 'events' :
        
        event_files_upload();
        break;
    
    case 'participants' :
        
        participant_files_upload();
        break;
}



$response = array();
$response['error'] = false;
$response['uploadedFiles'] = $uploadedFiles;
$response['message'] =  "Successfully uploaded all files.";
http_response_code(200);
echo json_encode($response);
exit;

// infographics
// thumbnail image - change the size(239*331), banner should be of original size of image uploaded - 

//video
// thumbnail image - change the size. - 195 X 180
// thumb_big_image - 650 X 368
// banner image - same as article(982, 564)