<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Contact Us" );
    }

    function index()
    {
        $this->response['pageTitle'] = "Contact Us";
        
        if(isset($_POST) && isset($_POST['name']))
        {
            $this->sendemail();
        }
        else
            $this->render_view('contact');
    }
    
    function sendemail()
    {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $website = $this->input->post('website');
        $text = $this->input->post('message');
        
        $msgtext = file_get_contents(APPPATH . "/views/templates/mail.tpl"); 
        $msgtext = str_replace('%username%', $name, $msgtext); 
        $msgtext = str_replace('%useremail%', $email, $msgtext);
        $msgtext = str_replace('%userwebsite%', $website, $msgtext);
        $msgtext = str_replace('%usertext%', $text, $msgtext);
        
        $to = SMTP_FROM;
        
        $from = $this->input->post('email');
        $body = $this->input->post('text');
        $subject = 'Enquiry';
        $from_name = $this->input->post('name');
        $reply_to = $to;
        
        $val = utils::mail_send($to, $from, $subject, $msgtext, $from_name, $reply_to);
        if(!$val == "true")
        {
            $this->session->set_flashdata('errorMessage', "Message could not be sent!");
            
        }
        else
        {
            $this->session->set_flashdata('successMessage', "Thank you for your enquiry. Your message has been sent successfully. We will address your enquiry shortly.");
        }
        
        redirect(APP_BASE_URL."contact");
        exit;  
        
    }
    
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */