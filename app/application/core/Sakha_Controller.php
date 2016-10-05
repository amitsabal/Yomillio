<?php

include_once APPPATH . '/libraries/secureimage/securimage.php';
class Sakha_Controller extends CI_Controller
{
    var $sessionCheck = false;
    var $access = ""; 
    var $isAJAXRequest;
    var $response;

    function __construct()
    {
        parent::__construct();
        
        $this->response = array();
        $post = json_decode (file_get_contents("php://input"), true);

        if(isset($post['isAJAXRequest'])){
            $this->isAJAXRequest = $post['isAJAXRequest'];   
        }
        
        $this->set_title(APP_TITLE);
        
        if( $this->sessionCheck && !$this->is_active_session())
        {
            if(!$this->isAJAXRequest) {
                redirect('/', 'refresh');
                exit;
            }
        }
        
        $this->populate_categories();
        
        $session_namespace = $this->config->item('sess_namespace');
        $this->smarty->assign( 'SESSION_NAMESPACE', $session_namespace );
        
        $this->smarty->assign('successMessage', $this->session->flashdata('successMessage'));
        $this->smarty->assign('errorMessage', $this->session->flashdata('errorMessage'));
    }
    
    function set_title( $title )
    {
        $this->smarty->assign( 'title', $title );
    }
    
    function set_page_name( $pageName )
    {
        $this->smarty->assign( 'name',  $pageName );
    }
    
    public function is_active_session()
    {
        if(isset($_SESSION) && isset($_SESSION['session_user']) && isset($_SESSION['session_user']->id))
            return true;
        return false;
    }
    
    public function is_admin()
    {
    }
    
    public function is_user()
    {
    }
    
    public function send_ajax_response()
    {
        header('Content-Type: application/json');
		//if(count($this->response['error']) > 0)
		
		if( is_array($this->response))
		{
			if(isset($this->response['error']) && $this->response['error']) {
				http_response_code(500);
			}
			else if( is_array($this->response['error']) && count($this->response['error']) > 0) {
				http_response_code(500);
			}
			else {
				http_response_code(200);
			}
		}
		else
			http_response_code(200);
        echo json_encode($this->response);
        exit;
    }
	
	public function send_xml_response()
	{
		header('Content-Type: application/xml');
		
		if(count($this->response['error']) > 0)
			http_response_code(500);
		else
			http_response_code(200);
        echo $this->response->asXML();
        exit;
	}
    
    public function render_view($name)
    {
        $this->smarty->view( $name .'.tpl', array('response' => $this->response) );
        return;
    }
    
    public function populate_categories()
    {
        $categories = $this->restutil->get("portal/categories/ddl", array());
      
		$this->response['categories'] = $categories->categories;
		
    }
	
	public function show_captcha()
	{
		$img = new Securimage();
        
        // You can customize the image by making changes below, some examples are included - remove the "//" to uncomment
        
        //$img->ttf_file        = './Quiff.ttf';
        //$img->captcha_type    = Securimage::SI_CAPTCHA_MATHEMATIC; // show a simple math problem instead of text
        //$img->case_sensitive  = true;                              // true to use case sensitve codes - not recommended
        //$img->image_height    = 90;                                // height in pixels of the image
        //$img->image_width     = $img->image_height * M_E;          // a good formula for image size based on the height
        //$img->perturbation    = .75;                               // 1.0 = high distortion, higher numbers = more distortion
        //$img->image_bg_color  = new Securimage_Color("#0099CC");   // image background color
        //$img->text_color      = new Securimage_Color("#EAEAEA");   // captcha text color
        //$img->num_lines       = 8;                                 // how many lines to draw over the image
        //$img->line_color      = new Securimage_Color("#0000CC");   // color of lines over the image
        //$img->image_type      = SI_IMAGE_JPEG;                     // render as a jpeg image
        //$img->signature_color = new Securimage_Color(rand(0, 64),
        //                                             rand(64, 128),
        //                                             rand(128, 255));  // random signature color
        
        // see securimage.php for more options that can be set
        
        // set namespace if supplied to script via HTTP GET
        if (!empty($_GET['namespace'])) $img->setNamespace($_GET['namespace']);
        
        
        $img->show();  // outputs the image and content headers to the browser
        // alternate use:
        // $img->show('/path/to/background_image.jpg');
	}
	
	public function is_valid_captcha()
	{
		$securimage = new Securimage();
		
        if (isset($_POST) && isset($_POST['captcha_code']) && $securimage->check($_POST['captcha_code']) == false) {
			echo var_dump($securimage->check($_POST['captcha_code']));
            $this->response['error']['captcha_code'] = "The security code entered was incorrect!";
            return false;
        }
		else {
			$post = json_decode(file_get_contents("php://input"),true);
			if (isset($post) && isset($post['captcha_code']) && $securimage->check($post['captcha_code']) == false) {
				//echo var_dump($securimage->check($_POST['captcha_code']));
				$this->response['error']['captcha_code'] = "The security code entered was incorrect!";
				return false;
			}
		}
		return true;
	}
}
