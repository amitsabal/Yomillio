<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "User Profile" );
    }
    
    public function profile($profilename = "")
    {
        if(isset($_SESSION['session_user']))
        {
            $session_user = isset($_SESSION['session_user']) ? $_SESSION['session_user'] : "";
            
            $this->response["profile"] = $this->restutil->get("portal/users/get/".$session_user->id,array('id'=>$session_user->id, 'token'=>$_SESSION['session_token']));

            $this->render_view('user/profile');
            return;
        }
        redirect(APP_BASE_URL);
        //else if($profilename != "")
        //{
        //    $this->response["profile"] = $this->restutil->get("portal/users/get/".$session_user->id,array('id'=>$session_user->id, 'token'=>$_SESSION['session_token']));
        //    
        //    $this->render_view('user/profile');
        //}
        //if($edit == "")
            
        //else
        //    $this->render_view('user/edit_profile');
    }
    
    public function get($id)
    {
        $this->response = $this->restutil->get("portal/users/get/".$id,array('id'=>$id, 'token'=>$_SESSION['usertoken']));
        $this->send_ajax_response();
    }
    
    public function updatesession()
    {
        $this->response = $this->restutil->put("portal/users/updatesession", array('token'=>$_SESSION['usertoken']));
        $this->send_ajax_response();
    }
    
    public function forgotpassword()
    {
        $json = file_get_contents("php://input");
        $jsonArray = json_decode($json, true);
        $this->response = $this->restutil->put("portal/users/forgotpassword", $jsonArray);
        $data=array("success" => 1);
        $this->send_ajax_response();
    }
    
    public function resetpassword()
    {
        $urlarray = explode("/", $_SERVER['REQUEST_URI']);
        $encryption_key = $urlarray[sizeof($urlarray)-1];
        $this->response = $this->restutil->get("portal/resetpasswordhistories/get", array('encryption_key' => $encryption_key));
        $this->render_view('user/resetpassword');
    }
    
    public function updatepassword(){
        $json = file_get_contents("php://input");
        $jsonArray = json_decode($json, true);
        $this->response = $this->restutil->put("portal/users/updatepassword", $jsonArray);
        $data = array(
            "success" => 0
        );
        if(isset($this->response->success) && $this->response->success == 1){
            $data['success'] = 1;
            $data['message'] = "success";
        }
        else{
            $data['message'] = "Password reset failed , Please enter registered email id.";
        }
        
        //print_r(json_encode($data)); exit;
    }
    
    public function updateprofile()
    {
        $post = $this->input->post();
        $post['id'] = isset($_SESSION['session_user_id']) ? $_SESSION['session_user_id'] : "";
        //print_r($_POST);print_r($_FILES); exit;
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
        $allowedExts = array("jpg", "jpeg", "png");
        $temp = explode(".", $_FILES["profile_pic"]["name"]);
        $extension = end($temp);
        
        
        //Upload profile pic
        if(isset($_FILES) &&  isset($_FILES['profile_pic']['name']) &&
                strlen(trim($_FILES['profile_pic']['name'])) > 0 )
        {
            if($_FILES['profile_pic']['error'] > 0)
            {
                $this->session->set_flashdata('errorMassage', $phpFileUploadErrors[$_FILES['profile_pic']['error']]);
                redirect(APP_BASE_URL ."user/profile");
                exit;
            }
            
            if ( $_FILES["profile_pic"]["type"] != "image/png" &&
                $_FILES["profile_pic"]["type"] != "image/jpg" &&
                $_FILES["profile_pic"]["type"] != "image/jpeg" ) {
                
                $this->session->set_flashdata('errorMassage', "Mime type not allowed");
                redirect(APP_BASE_URL ."user/profile");
                exit;
                
            }
            if (!in_array(strtolower($extension), $allowedExts)) {
               
                $this->session->set_flashdata('errorMassage', $extension . " - Extension not allowed");
                redirect(APP_BASE_URL ."user/profile");
                exit;
            }
            
            $path = $_FILES['profile_pic']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            
            //Check directory exists
            if (!file_exists(PROFILE_PIC_FILE_UPLOAD_PATH) && !is_dir(PROFILE_PIC_FILE_UPLOAD_PATH)) {
                mkdir(PROFILE_PIC_FILE_UPLOAD_PATH,0777,TRUE);
            }
            
            $targetFileName = md5( $post['id'] ) . "." . $ext;
            
            if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], PROFILE_PIC_FILE_UPLOAD_PATH. $targetFileName ))
            {
                Utils::resize_image($targetFileName, PROFILE_PIC_FILE_UPLOAD_PATH, 162, 162,PROFILE_PIC_FILE_UPLOAD_PATH. $targetFileName );
                $post['profile_pic'] = $targetFileName;
            }
        }
        
        $response = $this->restutil->put("portal/users/update", $post);
        //print_r($response);exit;
        if(!$response->error)
        {
            $session_user = $_SESSION['session_user'];
            foreach($response->user as $k => $u)
            {
                $session_user->$k = $u;
            }
            $_SESSION['session_user'] = $session_user;
        }
        else
        {
            $this->session->set_flashdata('errorMessage', $response->message);
            redirect(APP_BASE_URL);
            exit;
            
        }
        
        $this->session->set_flashdata('successMessage', "Successfully updated your profile details");
        redirect(APP_BASE_URL ."user/profile");
    }
    
    function changepassword(){
        $post = $this->input->post();       
        //$post['id'] = isset($_SESSION['session_user_id']) ? $_SESSION['session_user_id'] : "";
        
        if(isset($_SESSION['session_user_id'])){
            
            $post['id'] = $_SESSION['session_user_id']; 
            $this->response = $this->restutil->put("portal/users/changepassword", $post);
            //Logger::debug($this->response);
            
            if(!isset($this->response->error) || !$this->response->error){
                $data['success'] = 1;
                $data['message'] = "success";
                $this->session->set_flashdata('successMessage', "Password successfully changed ");
                redirect(APP_BASE_URL ."user/profile#/account-settings");
            }
            else{
                $this->session->set_flashdata('errorMessage', $this->response->message);            
                redirect(APP_BASE_URL ."user/profile#/account-settings");
            }
        }
    }
}