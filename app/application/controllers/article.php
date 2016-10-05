<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ALL|E_STRICT);

class Article extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "View Article" );
    }
    
    function index($perma_link="")
    {
        $this->response['pageTitle'] = "View Article";
        
        if(stripos(urldecode($perma_link),'{{comment',0) !== FALSE) exit;
        
        {
            $article = $this->restutil->get("portal/articles/get/".$perma_link,array());
            
            $this->response['article'] = new stdClass();
            if(!$article->error)
            {
                $this->response['article'] = $article->article;
                
                $this->set_page_name( "View Article : " . $article->article->title );
            }
            $this->render_view('articles/view');
            
        }
    }
    
    //Create new article by user
    function create()
    {
        $this->response['error'] = array();
        
        $this->set_page_name( "Submit Your Article" );
            
        $this->response['pageTitle'] = "Submit Your Article";
        
        //Validate Post values
        if(!isset($_POST) || sizeof($_POST) <= 0)
        {
            
            
            if(!$this->is_active_session())
            {
                $this->smarty->assign('errorMessage', "Please login/signup to continue!");
            }
            
            $this->render_view('articles/create');
            return;
        }
        
        $this->is_valid_captcha();
		//echo var_dump($captcha);
        
        if(!isset($_POST['title']) || strlen(trim($_POST['title'])) <= 0)
        {
            $this->response['error']['title'] = "Title cannot be empty!";
            //return false;
        }
        
        if(!isset($_POST['content']) || strlen(trim($_POST['content'])) <= 0)
        {
            $this->response['error']['content'] = "Content cannot be empty!";
            //return false;
        }
        
        if(!isset($_POST['category']) || strlen(trim($_POST['category'])) <= 0)
        {
            $this->response['error']['category'] = "Category cannot be empty!";
            //return false;
        }
        
        if(!isset($_POST['tags']) || count($_POST['tags']) <= 0)
        {
            $this->response['error']['tags'] = "Tags cannot be empty!";
            //return false;
        }
        if(!isset($_FILES) && sizeof($_FILES) <= 0)
        {
            $this->response['error']['article_image'] = "Article image is required!";
            //return;
        }
        
        if(isset($this->response['error']) && count($this->response['error']) > 0)
        {
            $this->render_view('articles/create');
            return;
        }
        
        $session_user = $_SESSION['session_user'];
        
        $post = $_POST;
        $post['author_type'] = 2;
        $post['author_id'] = $session_user->id;
        $post['created_by'] = $session_user->id;
        $post['status'] = 3; //Pending for approval
        $post['type_id'] = 1;
        $post['category_id'] = $post['category'];
        $post['is_featured'] = 2;
        $post['summary'] = $post['title'];
        
        $response = $this->restutil->post("portal/articles/create",$post);
        
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
        
        
        if(isset($response->id) && $response->id > 0)
        {
            //Upload Article pic
            if(isset($_FILES) &&  isset($_FILES['article_image']['name']) &&
                    strlen(trim($_FILES['article_image']['name'])) > 0 )
            {
                if($_FILES['article_image']['error'] > 0)
                {
                    $this->session->set_flashdata('errorMassage', $phpFileUploadErrors[$_FILES['article_image']['error']]);
                }
                
                $path = $_FILES['article_image']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                
                //Check directory exists
                if (!file_exists(ARTICLE_PIC_FILE_UPLOAD_PATH . "/" . $response->id) && !is_dir(ARTICLE_PIC_FILE_UPLOAD_PATH. "/" . $response->id)) {
                    mkdir(ARTICLE_PIC_FILE_UPLOAD_PATH. "/" . $response->id,0777,TRUE);
                }
                
                $targetFileName = "org_". base64_encode( $response->id ) . "." . $ext;
                
                if(move_uploaded_file($_FILES['article_image']['tmp_name'], ARTICLE_PIC_FILE_UPLOAD_PATH . "/" . $response->id . "/" . $targetFileName ))
                {
                    //Utils::resize_image($targetFileName, ARTICLE_PIC_FILE_UPLOAD_PATH, 162, 162,ARTICLE_PIC_FILE_UPLOAD_PATH. $targetFileName );
                    $post['submitted_image'] = $targetFileName;
                    $post['id'] = $response->id;
                    $post['updated_by'] = $session_user->id;
                    $response = $this->restutil->put("portal/articles/update",$post);
                }
            }
            $this->session->set_flashdata('successMessage', "Your article will be reviewed and published!");
        }
        else
        {
            $this->session->set_flashdata('errorMessage',$response->message);
        }
        
        redirect(APP_BASE_URL."articles");
        exit;
    }
}