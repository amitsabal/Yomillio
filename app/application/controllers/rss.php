<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rss extends Sakha_Controller {

	function __construct()
	{
		parent::__construct();
			
		$this->set_page_name( 'RSS Feed' );
	}
	
	function index()
	{
		$this->response['webpage'] = $this->restutil->get('portal/webpages/get', array('url' => 'rss'));
			
		if(isset($this->response['webpage']->webpage->status) && $this->response['webpage']->webpage->status == 1)
		{
			$this->render_view('webpage');
		}
		else{
			$this->render_view('pagenotfound');
		}
	}
	
	/** Renders RSS feed **/
	function render_feed()
	{
		//print_r(func_get_args());
		$args = func_get_args();
		
		$request = array();
		foreach($args as $key => $arg)
		{
			$arg = str_ireplace(".rss", "", $arg);
			switch($arg)
			{
				case "articles" :
					$request['type_id'] = 1;
					break;
				
				case "infographics" :
					$request['type_id'] = "2,3";
					break;
				
				case "latest" :
					$request['latest'] = 1;
				
				case "popular" :
					$request['popular'] = 1;
					
				case "featured" :
					$request['featured'] = 1;
					
				case "tag" :
					$request['tag_name'] = isset($args[$key+1]) ? str_ireplace(".rss", "", $args[$key+1]) : "";
					break;
				
				case "category" :
					$request['category_title'] = isset($args[$key+1]) ? str_ireplace(".rss", "", $args[$key+1]) : "";
					break;
			}
		}
		$articles = $this->restutil->get("portal/articles.rss",$request);
		
		$this->response = $articles;
		$this->send_xml_response();
		exit;
	}
}