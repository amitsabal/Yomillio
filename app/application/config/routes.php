<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "index";
$route['404_override'] = '';

$route['article/create'] = 'article/create';
$route['article/(:any)'] = 'article/index/$1';
$route['articles/(:any)/(:num)'] = 'articles/index/$1/$2';
$route['articles/(:any)/(:any)'] = 'articles/index/$1/$2';
$route['search']         = 'articles/search';
$route['search/(:any)']         = 'articles/search/$1';
$route['search/(:any)/(:any)']         = 'articles/search/$1/$2';

$route['infographic/(:any)'] = 'infographic/index/$1';
$route['infographics/'] = 'infographics/index';
$route['infographics/(:any)/(:any)'] = 'infographics/index/$1/$2';

$route['video/(:any)'] = 'article/index/$1';
$route['videos/(:any)/(:num)'] = 'videos/index/$1/$2';
$route['videos/(:any)/(:any)'] = 'videos/index/$1/$2';


$route['forum/(:any)'] = 'forum/index/$1';
$route['forums/(:any)/(:any)'] = 'forums/index/$1/$2';

$route['event/(:any)'] = 'event/index/$1';

$route['image']         = 'image/index';
$route['image/(:any)']         = 'image/index/$1';

$route['insight/(:any)'] = 'insight/index/$1';
$route['insights/(:any)/(:num)'] = 'insights/index/$1/$2';
$route['insights/(:any)/(:any)'] = 'insights/index/$1/$2';

$route['rss/articles/(:any)'] = 'rss/render_feed/articles/$1';
$route['rss/insights/(:any)'] = 'rss/render_feed/insights/$1';
$route['rss/category/(:any)'] = 'rss/render_feed/category/$1';
$route['rss/tag/(:any)'] = 'rss/render_feed/tag/$1';

//$route['user/(:any)'] = 'user/profile/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */