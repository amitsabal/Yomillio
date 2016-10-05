<?php
use Illuminate\Database\Capsule\Manager as DB;
class WebpageController extends Controller
{
	/**
	 * Creates new article
	 */
	public function create(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('title', 'url', 'created_by', 'status'));

		// Save article in DB
	    $webpage = new Webpage();
	    $webpage->title 		= $app->request->post('title');
		$webpage->url 		= $app->request->post('url');
		$webpage->content 		= ($app->request->post('content') != '') ? $app->request->post('content') : '';
	    $webpage->created_by 	= $app->request->post('created_by');
        $webpage->status 	= $app->request->post('status');
		
		/*
		$content = $webpage->content;
		$content = str_ireplace('{$RSS_CSS}', '<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/?f=rss">', $content);
		$content = str_ireplace('{$MEDIA_FILES_URL}', PORTAL_URL ."media/", $content);
		$content = str_ireplace('{$APP_BASE_URL}', PORTAL_URL, $content);
		$webpage->content = $content;
		*/
	    //Check duplicate article
	    $this->check_duplicate($webpage);

	    //Save article details
	    $webpageId = $webpage->save();
		
		//create a controller
		$fh = fopen(APP_BASE_PATH."application/controllers/".$webpage->url.".php", 'w');
		$contents = "<?php
						if ( ! defined('BASEPATH')) exit('No direct script access allowed');
						
						class ".ucfirst($webpage->url)." extends Sakha_Controller {
						
							function __construct()
							{
								parent::__construct();
								
								\$this->set_page_name( '".$webpage->title."' );
							}
							
							function index()
							{
								\$this->response['webpage'] = \$this->restutil->get('portal/webpages/get', array('url' => '".$webpage->url."'));
									
								if(isset(\$this->response['webpage']->webpage->status) && \$this->response['webpage']->webpage->status == 1){
												\$this->render_view('webpage');
								}
						        else{
												\$this->render_view('pagenotfound');
								}
							}
						}";
						
		$write = fwrite($fh, $contents);
	    //Send response
	    $response = new Response();
	    $response->id = $webpage->id;
		$response->write = $write;
	    $response->send(HTTP_CREATED);
	    exit;
	}

	/**
	 * Function to find duplicate record in DB
	 */
	public function check_duplicate($args)
	{
		//Check duplicate
		$webpages;
		if(!isset($args->id) || intval($args->id) <= 0)
			$webpages = Webpage::where('title','=', $args->title)->get();
		else
			$webpages = Webpage::where('title','=', $args->title)->where('id', '<>', $args->id)->get();
        
		foreach ($webpages as $webpage)
		{
		    if((isset($webpage->id) && intval($webpage->id) > 0))
			{
				Response::error(MSG_PAGE_EXISTS);
			}
		}
		
		if(!isset($args->id) || intval($args->id) <= 0)
			$webpages = Webpage::where('url','=', $args->url)->get();
		else
			$webpages = Webpage::where('url','=', $args->url)->where('id', '<>', $args->id)->get();
        
		foreach ($webpages as $webpage)
		{
		    if((isset($webpage->id) && intval($webpage->id) > 0))
			{
				Response::error(MSG_URL_EXISTS);
			}
		}
		return true;
	}

	/**
	 * Updates article info
	 */
	public function update(\Slim\Slim $app)
	{
		//Validate Parameters
		Validate::required_params(array('id', 'updated_by'));

		$webpage = Webpage::find($app->request->put('id'));

		if((!isset($webpage->id) || intval($webpage->id) <= 0))
		{
			Response::not_found(MSG_PAGE_NOT_FOUND);
		}
		
		$webpage->title 		= $app->request->put('title');
		$webpage->url 		= $app->request->put('url');
		$webpage->content 		= $app->request->put('content');
		$webpage->updated_by 	= $app->request->put('updated_by');
		$webpage->status 		= $app->request->put('status');
		/*/
		$content = $webpage->content;
		$content = str_ireplace('{$RSS_CSS}', '<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/?f=rss">', $content);
		$content = str_ireplace('{$MEDIA_FILES_URL}', PORTAL_URL ."media/", $content);
		$content = str_ireplace('{$APP_BASE_URL}', PORTAL_URL, $content);
		$webpage->content = $content;
		*/
		//Check duplicate webpage
	    $this->check_duplicate($webpage);

	 	//Save article details
	    $webpage->save();

	    //Send response
	    $response = new Response();
	    $response->webpage = $webpage;
		
	    $response->send(HTTP_OK);
	    exit;   
	}

	/**
	 * Deletes a article
	 */
	public function delete(\Slim\Slim $app, $id = "")
	{
		
	}

	public function get(\Slim\Slim $app, $id = "")
	{
		//Validate Parameters
		Validate::validate_empty($id,'id');

		$webpage = Webpage::find($id);

		if((!isset($webpage->id) || intval($webpage->id) <= 0))
		{
			Response::not_found(MSG_PAGE_NOT_FOUND);
		}
		
		//$content = $webpage->content;
		//$content = str_ireplace('{$RSS_CSS}', '<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/?f=rss">', $content);
		//$content = str_ireplace('{$MEDIA_FILES_URL}', PORTAL_URL ."media/", $content);
		//$content = str_ireplace('{$APP_BASE_URL}', PORTAL_URL, $content);
		//$webpage->content = $content;
		
		$response = new Response();
		$response->webpage = $webpage;
		//error_log(print_r($response, true));
		$response->send(HTTP_OK);
		exit;
	}

	/**
	 * Gets all articles
	 */
	public function getall(\Slim\Slim $app)
	{
        $webpages = Webpage::withTrashed()->get()->toArray();
	    
	    $response = new Response();
	    $response->webpages = $webpages;	    
	    $response->send(HTTP_OK);
	}
	
	public function getpagedetails(\Slim\Slim $app)
	{
		Validate::required_params(array('url'));
		
		$webpages = Webpage::where('url', '=', $app->request->get('url'))->where('status','=',STATUS_ACTIVE)->get();

		$response = new Response();
		$response->webpage = null;;
		foreach($webpages as $webpage)
		{
			if(isset($webpage->id))
			{
				$content = $webpage->content;
				
				//Category Feeds :{$ALL_CATEGORY_FEED}
				$categoryCntrl = new CategoryController();
				$categories = $categoryCntrl->ddl($app, false);
				
				$categoryHTML = '<ul class="rss-feed">';
				foreach($categories->categories as $category)
				{
					$categoryHTML .= '<li>
										<span>
											<img align="left" src="{$MEDIA_FILES_URL}images/rss_icon.png" style="padding-right:5px;" />
										</span>
										<a href="{$APP_BASE_URL}rss/category/'.strtolower($category['title']).'.rss" target="_blank">'.$category['title'].'</a>
									</li>';
				}
				$categoryHTML .= '</ul>';
				
				//Tag Feeds : {$ALL_TAG_FEED}
				$tagCntrl = new TagController();
				$tags = $tagCntrl->ddl($app, false);
				
				$tagHTML = '<ul class="rss-feed">';
				foreach($tags->tags as $tag)
				{
					$tagHTML .= '<li>
										<span>
											<img align="left" src="{$MEDIA_FILES_URL}images/rss_icon.png" style="padding-right:5px;" />
										</span>
										<a href="{$APP_BASE_URL}rss/tag/'.strtolower($tag['name']).'.rss" target="_blank">'.$tag['name'].'</a>
									</li>';
				}
				$tagHTML .= '</ul>';
				
				$content = str_ireplace('{$ALL_CATEGORY_FEED}', $categoryHTML, $content);
				$content = str_ireplace('{$ALL_TAG_FEED}', $tagHTML, $content);
				$content = str_ireplace('{$RSS_CSS}', '<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/?f=rss">', $content);
				$content = str_ireplace('{$MEDIA_FILES_URL}', PORTAL_URL ."media/", $content);
				$content = str_ireplace('{$APP_BASE_URL}', PORTAL_URL, $content);
				
				$webpage->content = $content;
				
				$response->webpage = $webpage;
				$response->send(HTTP_OK);
			}
		}
		
		$response->message = MSG_URL_NOT_FOUND;
		$response->send(HTTP_NOT_FOUND);
	}
}