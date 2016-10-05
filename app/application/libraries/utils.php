<?php
require_once(__DIR__ . "/vendor/autoload.php");

 use Mailgun\Mailgun;
class Utils {
    public static function buildPagination($curPage, $pageSize, $total) {
        $pagination = ["curPage" => $curPage, "lastPage" => ceil($total/$pageSize), "total" => $total];
        
        $pages = [];
        $pageStart = ($curPage == $pagination["lastPage"]) ? ($curPage - 4) : ($curPage - 2);
        if ($pageStart <= 0) {
            $pageStart = 1;
        }
        for($i = $pageStart; $i <= 5 && $i<= $pagination["lastPage"]; $i++)
        {
            $pages[] = $i;
        }
        $pagination["pages"] = $pages;
        $pagination["next"] = ($curPage < $pagination["lastPage"]) ? ($curPage + 1) : $pagination["lastPage"];
        $pagination["prev"] = ($curPage > 1) ? ($curPage - 1) : 1;
        
        return $pagination;
    }
    
    public static function send_mail($to, $from, $subject, $body, $from_name, $reply_to)
    {   
        $mail = new PHPMailer;
        $mail->IsSMTP();                                      // Set mailer to use SMTP
        $mail->Host = SMTP_HOST;                              // Specify main and backup server
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = SMTP_USERNAME;                      // SMTP username
        $mail->Password = SMTP_PASSWORD;                      // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
      
        $mail->From = $from;
        $mail->FromName = $from_name;
        $mail->AddAddress($to);                                // Add a recipient
        //$mail->AddAddress('rahul.anand@sakhatech.com', 'anand');
        $mail->AddReplyTo($reply_to);
        
        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->IsHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = $subject;
        $mail->Body    = $body;
        
        $mail->MsgHTML($body);
        $mail->IsHTML(true); 
        $mail->CharSet="utf-8";
        if(!$mail->Send())
        {
          return false;
        }
       return true;
        
    }
    
    public static function sortByDate(&$array, $sort = SORT_DESC)
    {
        usort($array, function($a, $b) {
            if($sort = SORT_DESC)
                return strtotime($b->created_at) - strtotime($a->created_at);
            else
                return strtotime($a->created_at) - strtotime($b->created_at);
        });
        
        return $array;
    }
    
    public static function resize_image($name, $path, $w, $h, $srcFile, $prefix = "" )
    {
        // create a new instance of the class
        $image = new Zebra_Image();
        
        // indicate a source image (a GIF, PNG or JPEG file)
        $image->source_path = $srcFile;
        
        // indicate a target image
        // note that there's no extra property to set in order to specify the target
        // image's type -simply by writing '.jpg' as extension will instruct the script
        // to create a 'jpg' file
        $image->target_path = $path . $prefix . $name;
        
        // some additional properties that can be set
        // read about them in the documentation
        $image->preserve_aspect_ratio = true;
        $image->enlarge_smaller_images = true;
        $image->preserve_time = true;
        
        if (!$image->resize($w, $h, ZEBRA_IMAGE_CROP_CENTER)) {
    
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
        } else return 'Success!';
    }
    
    public static function sendViaSendMail( $to, $from, $subject, $body, $from_name, $reply_to )
    {
        $body = strip_tags($body);
        $body = str_ireplace("table {border: 1px solid #00b4f0}
        td, tr {border: 0}","",$body);
        return mail($to, $subject, $body);
    }
    
    public static function sendViaMailgun( $to, $from, $subject, $body, $from_name, $reply_to )
    {
        # First, instantiate the SDK with your API credentials and define your domain. 
        $mg = new Mailgun(MAILGUN_API_KEY);
        $domain = MAILGUN_API_URL;
        
        $response = [];
        
        //foreach($this->to as $recipientEmail) {
            $mail = array(
                            'from'    => MAILGUN_SMTP_FROM, 
                            'to'      => $to,
                            'o:tag'   => $subject,
                            'subject' => $subject,
                            'html'    => $body
                        );
            
            # Now, compose and send your message.
            $result = $mg->sendMessage($domain, $mail);
            
            $httpResponseCode = $result->http_response_code;
            $httpResponseBody = $result->http_response_body;
            
            $response[] = (array('code' => $httpResponseCode, 'response' => $httpResponseBody));
       // }
        
        return $response;
    }
    
    public function mail_send($to, $from, $subject, $body, $from_name, $reply_to) {
        if(ACTIVE_MAILER == PHP_MAILER) {
            return self::send_mail($to, $from, $subject, $body, $from_name, $reply_to);
        } else if(ACTIVE_MAILER == MAILGUN) {
            return self::sendViaMailgun($to, $from, $subject, $body, $from_name, $reply_to);
        }
        else if(ACTIVE_MAILER == PHP_SENDMAIL) {
            return self::sendViaSendMail($to, $from, $subject, $body, $from_name, $reply_to);
        }
    }
}