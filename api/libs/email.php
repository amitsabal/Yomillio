<?php
    use Mailgun\Mailgun;

    class Email
    {
        private $to;
        private $from;
        private $fromName;
        private $cc;
        private $bcc;
        private $subject;
        private $body;
        private $altBody;
        
        /**
         * Default Get Method
         * */
        function __get( $name )
        {
            return $this->$name;
        }
        
        /**
         * Default Set Method
         * */
        function __set( $name, $value )
        {
            $this->$name = $value;
        }
        
        /**
         * Default constructor
         * */
        function __construct( )
        {
            $this->to = array();
            $this->from = "";
            $this->fromName = "";
            $this->cc = array();
            $this->bcc = array();
            $this->subject = "";
            $this->body = "";
            $this->altBody = "";
        }
        
        public function addTo( $email, $name )
        {
            $this->to[$name] = $email;
        }
        
        public function addToMail( $email )
        {
            $this->to[] = $email;
        }
        
        public function addCC( $email )
        {
            $this->cc[] = $email;
        }
        
        public function addBcc( $email )
        {
            $this->bcc[] = $email;
        }

        private function sendViaMailgun( $includeBasicTemplate = true )
        {
            # First, instantiate the SDK with your API credentials and define your domain. 
            $mg = new Mailgun(MAILGUN_API_KEY);
            $domain = MAILGUN_API_URL;
            
            $response = [];
            
            foreach($this->to as $recipientEmail) {
                $mail = array(
                                'from'    => MAILGUN_SMTP_FROM, 
                                'to'      => $recipientEmail,
                                'o:tag'   => $this->subject,
                                'subject' => $this->subject,
                                'html'    => $this->setMessageContent($includeBasicTemplate)
                            );
                
                # Now, compose and send your message.
                $result = $mg->sendMessage($domain, $mail);
                
                $httpResponseCode = $result->http_response_code;
                $httpResponseBody = $result->http_response_body;
                
                $response[] = (array('code' => $httpResponseCode, 'response' => $httpResponseBody));
            }
            
            return $response;
        }
        
        private function sendViaPHPMailer( )
        {
            $mail = new PHPMailer();
            
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
            //$mail->SMTPDebug = 2;
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = SMTP_USERNAME;                 // SMTP username
            $mail->Password = SMTP_PASSWORD;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
            //$mail->Port = 465;
            
            $mail->From = SMTP_FROM;
            $mail->FromName = SMTP_FROM_NAME;
            
            $mail->addBCC('radhika.hosahalli@sakhatech.com', 'Radhika');
            
            foreach( $this->to as $k => $v )
            {
               if( is_int($k)) $mail->addAddress($v);
               else $mail->addAddress($v, $k);     // Add a recipient
            }
            
            $mail->addReplyTo($this->from, $this->fromName);
            
            foreach( $this->cc as $k => $v )
               $mail->addCC($v);
            
            foreach( $this->bcc as $k => $v )
               $mail->addBCC($v);
            
            $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML
            
            $mail->Subject = $this->subject;
            $mail->Body    = $this->setMessageContent(true);
            $mail->AltBody = $this->altBody;
            $mail->ConfirmReadingTo = true;
            Logger::debug($mail);
            if(!$mail->send()) {
                Logger::debug($mail->ErrorInfo);
                Logger::debug("Unable to send a mail");
                return false;
            } else {
                Logger::debug("Success");
                return true;
            }
        }

        private function setMessageContent($includeBasicTemplate)
        {
            if ($includeBasicTemplate == true)
            {
                $content = file_get_contents( "templates/email/layout.html" );
                $content = str_ireplace("@@CONTENT@@",$this->body,$content);
            }
            else
            {
                $content = $this->body;            
            }
            
            //$content = str_ireplace("@@APPLICATION_NAME@@",APPLICATION_NAME,$content);
            //$content = str_ireplace("@@SMTP_FROM_NAME@@",SMTP_FROM_NAME,$content);
            //$content = str_ireplace("@@CONTACT_EMAIL@@",CONTACT_EMAIL,$content);
            //$content = str_ireplace("@@APP_BASE_URL@@",APP_BASE_URL,$content);
            $content = str_ireplace("\n","<br />",$content);

            return $content;
        }
        
        public function send($includeBasicTemplate = true) {
            if(ACTIVE_MAILER == PHP_MAILER) {
                return $this->sendViaPHPMailer($includeBasicTemplate);
            } else if(ACTIVE_MAILER == MAILGUN) {
                return $this->sendViaMailgun($includeBasicTemplate);
            }
            else if(ACTIVE_MAILER == PHP_SENDMAIL) {
                return $this->sendViaSendMail($includeBasicTemplate);
            }
            else if(ACTIVE_MAILER == PHP_MAIL) {
                return $this->sendViaPHPMail($includeBasicTemplate);
            }
        }
        
        private function sendViaSendMail( )
        {
            $mail = new PHPMailer();
            
            $mail->isSendmail();                                      // Set mailer to use SMTP
            
            $mail->From = SMTP_FROM;
            $mail->FromName = SMTP_FROM_NAME;
            
            //$mail->addBCC('radhika.hosahalli@sakhatech.com', 'Radhika');
            
            foreach( $this->to as $k => $v )
            {
               if( is_int($k)) $mail->addAddress($v);
               else $mail->addAddress($v, $k);     // Add a recipient
            }
            
            $mail->addReplyTo($this->from, $this->fromName);
            
            foreach( $this->cc as $k => $v )
               $mail->addCC($v);
            
            foreach( $this->bcc as $k => $v )
               $mail->addBCC($v);
            
            $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML
            
            $mail->Subject = $this->subject;
            $mail->Body    = $this->setMessageContent(true);
            $mail->AltBody = $this->altBody;
            
            if(!$mail->send()) {
                //Logger::debug($mail->ErrorInfo);
                //Logger::debug("Unable to send a mail");
                return false;
            } else {
                //Logger::debug("Success");
                return true;
            }
        }
        
        private function sendViaPHPMail( )
        {
            $mail = new PHPMailer();
            
            $mail->From = SMTP_FROM;
            $mail->FromName = SMTP_FROM_NAME;
            
            //$mail->addBCC('radhika.hosahalli@sakhatech.com', 'Radhika');
            
            foreach( $this->to as $k => $v )
            {
               if( is_int($k)) $mail->addAddress($v);
               else $mail->addAddress($v, $k);     // Add a recipient
            }
            
            $mail->addReplyTo($this->from, $this->fromName);
            
            foreach( $this->cc as $k => $v )
               $mail->addCC($v);
            
            foreach( $this->bcc as $k => $v )
               $mail->addBCC($v);
            
            $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML
            
            $mail->Subject = $this->subject;
            $mail->Body    = $this->setMessageContent(true);
            $mail->AltBody = $this->altBody;
            
            if(!$mail->send()) {
                //Logger::debug($mail->ErrorInfo);
                //Logger::debug("Unable to send a mail");
                return false;
            } else {
                //Logger::debug("Success");
                return true;
            }
        }
    }
