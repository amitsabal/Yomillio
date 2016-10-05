<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends Sakha_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->set_page_name( "Home" );
    }

    function index()
    {
        $this->response['featured'] = $this->restutil->get("portal/articles/getall",array("published"=>1, "featured"=>1,"limit"=>3,"latest"=>1))->articles;
        
        $articles = $this->restutil->get("portal/articles/getall",array("published"=>1, "limit"=>9,"latest"=>1,"type_id"=>1));
        
        $this->response['latest'] = $articles->articles;
        $this->response['popular'] = $this->restutil->get("portal/articles/getall",array("published"=>1, "limit"=>9,"popular"=>1,"type_id"=>1))->articles;
		
        //$this->response['allArticlesCount'] = $articles->count;
        //$this->response['allArticlesCountPagination'] = Utils::buildPagination(1,9,$articles->count);
        
        $this->response['latestVideos'] = $this->restutil->get("portal/articles/getall",array("published"=>1, "limit"=>4,"latest"=>1,"type_id"=>3))->articles;
        $this->response['popularVideos'] = $this->restutil->get("portal/articles/getall",array("published"=>1, "limit"=>4,"popular"=>1,"type_id"=>3))->articles;
        
        //$this->response['latestInfographics'] = $this->restutil->get("portal/articles/getall",array("published"=>1, "limit"=>4,"latest"=>1,"type_id"=>2))->articles;
        //$this->response['popularInfographics'] = $this->restutil->get("portal/articles/getall",array("published"=>1, "limit"=>4,"popular"=>1,"type_id"=>2))->articles;
        
        $this->render_view('index');
	}
    
    
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */