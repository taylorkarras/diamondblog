<?php
pluginClass::initialize();
use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();
$GLOBALS['router'] = new RouteCollector();

//$router->any('/example', function(){
//    return 'This route responds to any method (POST, GET, DELETE etc...) at the URI /example';
//});

// or '/page/{id:i}' (see shortcuts)

//$router->post('/page/{id:\d+}', function($id){

    // $id contains the url paramter

//    return 'This route responds to the post method at the URI /page/{param} where param is at least one number';
//});

$router->any('/console', function(){
$retrive = new DB_retrival;
if ($retrive->isLoggedIn()){
} else {
define ('POSTPEND', 'Login');
}
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::login');;
});

$router->post('/console/login', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::login');;
});

$router->any('/console/posts', function(){
define ('POSTPEND', 'Posts');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::posts');;
});

$router->any('/console/posts/new', function(){
define ('POSTPEND', 'Create New Post');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::postedit');;
});

$router->any('/console/posts/edit', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::postedit');;
});

$router->post('/console/posts/console/post', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::posttoblog');;
});

$router->get('/console/posts/delete', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::delete');;
});

$router->get('/console/posts/deleteconfirm', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::delete');;
});

$router->get('/console/pages/deleteconfirm', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::delete');;
});

$router->get('/console/posts/comments', function(){
define ('POSTPEND', 'Comments');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::comments');;
});

$router->get('/console/reports', function(){
define ('POSTPEND', 'Reports');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::reports');;
});

$router->get('/console/reports/approval', function(){
define ('POSTPEND', 'Comment Approval');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::reports');;
});

$router->get('/console/posts/comments/delete', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::delete');;
});

$router->get('/console/posts/comments/edit', function(){
define ('POSTPEND', 'Edit Comment');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::commentedit');;
});

$router->get('/console/comments/approve', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::editcomment');;
});

$router->post('console/posts/comments/console/editcomment', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::editcomment');;
});

$router->get('console/users', function(){
define ('POSTPEND', 'Users');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::users');;
});

$router->get('console/users/new', function(){
	define ('POSTPEND', 'New User');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::edituser');;
});

$router->get('console/users/edit', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::edituser');;
});

$router->post('/console/users/console/edituser', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::useredit');;
});

$router->post('/console/users/console/createuser', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::useredit');;
});

$router->get('console/ban', function(){
define ('POSTPEND', 'Ban');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::ban');;
});

$router->post('console/ban/console/banadd', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::banadd');;
});

$router->post('console/console/banadd', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::banadd');;
});

$router->get('console/ban/unban', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::unban');;
});

$router->get('console/ban/unbanconfirm', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::banadd');;
});

$router->get('console/users/delete', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::delete');;
});

$router->get('console/pages/delete', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::delete');;
});

$router->get('console/posts/drafts/delete', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::delete');;
});

$router->get('/console/users/deleteconfirm', function(){
	define ('POSTPEND', 'Delete User?');
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::delete');;
});

$router->get('/console/posts/drafts/deleteconfirm', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::delete');;
});

$router->get('/console/settings', function(){
	define ('POSTPEND', 'Settings');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::settings');;
});

$router->get('/console/settings/importexport', function(){
	define ('POSTPEND', 'Import/Export');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::settings');;
});

$router->get('/console/settings/site', function(){
	define ('POSTPEND', 'Site Settings');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::settings');;
});

$router->get('/console/settings/theme', function(){
define ('POSTPEND', 'Theme Settings');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::settings');;
});

$router->get('/console/settings/storage', function(){
	define ('POSTPEND', 'Storage Settings');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::settings');;
});



$router->post('/console/settings/console/sitesettings', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::settingsubmit');;
});

$router->get('/console/settings/themes/activatetheme', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::settingsubmit');;
});

$router->get('/console/settings/categoriesandpages', function(){
$templates = new League\Plates\Engine();
define ('POSTPEND', 'Categories');
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::settings');;
});

$router->get('/console/settings/categoriesandpages/tags', function(){
	define ('POSTPEND', 'Tags');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::settings');;
});

$router->get('/console/settings/categoriesandpages/mail', function(){
		define ('POSTPEND', 'Mail');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::settings');;
});

$router->get('/console/settings/categoriesandpages/2', function(){
			define ('POSTPEND', 'Pages');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::pages');;
});

$router->post('console/settings/console/storagesettings', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::settingsubmit');;
});

$router->post('console/settings/console/mailsettings', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::mailsettingssubmit');;
});

$router->post('console/settings/console/categoryedit1', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::settingsubmit');;
});

$router->post('console/settings/console/categoryedit2', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::categoryadd');;
});

$router->post('console/pages/console/page', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::pagetoblog');;
});

$router->get('console/pages/new', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::pageedit');;
});

$router->get('console/pages/edit', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::pageedit');;
});

$router->get('console/settings/categoriesandpages/2/pageswitch', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::pageswitch');;
});

$router->post('console/posts/console/search', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolesearch', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/search');
    return $templates->render('consolesearch::search');;
});

$router->post('console/console/search', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolesearch', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/search');
    return $templates->render('consolesearch::search');;
});

$router->post('console/users/console/search', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolesearch', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/search');
    return $templates->render('consolesearch::search');;
});

$router->post('console/ban/console/search', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolesearch', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/search');
    return $templates->render('consolesearch::search');;
});

$router->get('console/posts/search', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolesearch', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/search');
    return $templates->render('consolesearch::postsearchresults');;
});

$router->get('console/users/search', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolesearch', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/search');
    return $templates->render('consolesearch::usersearchresults');;
});

$router->get('console/ban/search', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolesearch', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/search');
    return $templates->render('consolesearch::bansearchresults');;
});

$router->get('console/logout', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::logout');;
});

$router->get('console/settings/plugins', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::plugins');;
});

$router->get('console/settings/pluginsettings', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::plugins');;
});

$router->get('console/settings/templates', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::templates');;
});

$router->get('console/settings/plugins/{id}/activate', function(){

$url = explode('/', $_SERVER['REQUEST_URI']);
$templates = new League\Plates\Engine();
$templates->addFolder('plugin', ''.$_SERVER['DOCUMENT_ROOT'].'/plugins/'.$url[4]);
   return $templates->render('plugin::activate');;
});

$router->get('console/plugins/{id}/settings', function(){

$url = explode('/', $_SERVER['REQUEST_URI']);
$templates = new League\Plates\Engine();
$templates->addFolder('plugin', ''.$_SERVER['DOCUMENT_ROOT'].'/plugins/'.$url[3]);
   return $templates->render('plugin::settings');;
});

$router->post('console/plugins/{id}/console/pluginsettings', function(){

$url = explode('/', $_SERVER['REQUEST_URI']);
$templates = new League\Plates\Engine();
$templates->addFolder('plugin', ''.$_SERVER['DOCUMENT_ROOT'].'/plugins/'.$url[3]);
   return $templates->render('plugin::settings_submit');
});

$router->post('console/plugins/{id}/console/pluginsettings1', function(){

$url = explode('/', $_SERVER['REQUEST_URI']);
$templates = new League\Plates\Engine();
$templates->addFolder('plugin', ''.$_SERVER['DOCUMENT_ROOT'].'/plugins/'.$url[3]);
   return $templates->render('plugin::settings_submit1');
});

$router->post('console/plugins/{id}/console/pluginsettings2', function(){

$url = explode('/', $_SERVER['REQUEST_URI']);
$templates = new League\Plates\Engine();
$templates->addFolder('plugin', ''.$_SERVER['DOCUMENT_ROOT'].'/plugins/'.$url[3]);
   return $templates->render('plugin::settings_submit2');
});

$router->post('console/plugins/{id}/console/pluginsettings3', function(){

$url = explode('/', $_SERVER['REQUEST_URI']);
$templates = new League\Plates\Engine();
$templates->addFolder('plugin', ''.$_SERVER['DOCUMENT_ROOT'].'/plugins/'.$url[3]);
   return $templates->render('plugin::settings_submit3');
});

$router->post('console/plugins/{id}/console/pluginsettings4', function(){

$url = explode('/', $_SERVER['REQUEST_URI']);
$templates = new League\Plates\Engine();
$templates->addFolder('plugin', ''.$_SERVER['DOCUMENT_ROOT'].'/plugins/'.$url[3]);
   return $templates->render('plugin::settings_submit4');
});

$router->get('console/settings/plugins/{id}/install', function(){
$url = explode('/', $_SERVER['REQUEST_URI']);
$templates = new League\Plates\Engine();
$templates->addFolder('plugin', ''.$_SERVER['DOCUMENT_ROOT'].'/plugins/'.$url[4]);
   return $templates->render('plugin::install');;
});

$router->post('console/settings/categoriesandpages/console/tagdelete', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::categoryadd');;
});

$router->get('console/posts/comments/unreport', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::unreport');;
});
$router->post('console/settings/categoriesandpages/console/maildelete', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::mailsettingssubmit');;
});

$router->post('console/settings/categoriesandpages/console/mailadd', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::mailadd');;
});

$router->post('console/settings/console/template', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::templatesubmit');;
});

$router->post('console/posts/console/draft', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::draft');;
});

$router->post('console/settings/console/iconupload', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::iconupload');;
});

$router->post('console/settings/console/logoupload', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::logoupload');;
});

$router->get('console/posts/livetagsearch', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::tagsearch');;
});

$router->any('/console/posts/drafts', function(){
define ('POSTPEND', 'Drafts');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::drafts');;
});

$router->any('/console/settings/theme/css', function(){
define ('POSTPEND', 'Edit Theme CSS');
$templates = new League\Plates\Engine();
$templates->addFolder('consolepages', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    return $templates->render('consolepages::themecss');;
});

$router->post('/console/settings/theme/console/themecss', function(){
define ('POSTPEND', 'Edit Theme CSS');
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::themecsssubmit');;
});

$router->get('/console/posts/pin', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::pin');;
});

$router->get('/console/posts/unpin', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::pin');;
});

$router->get('/console/posts/comments/close', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::commentsstatus');;
});

$router->get('/console/posts/comments/open', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::commentsstatus');;
});

$router->any('/console/export', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::export');;
});

$router->post('/console/import', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('consoleincludes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/includes');
    return $templates->render('consoleincludes::import');;
});

pluginClass::hook( "console_link_routes" );

// Lazy load autoloaded route handling classes using strings for classnames
// Calls the Controllers\User::displayUser($id) method with {id} parameter as an argument
//$router->any('/users/{id}', function(){;

// Optional Parameters
// simply add a '?' after the route name to make the parameter optional
// NB. be sure to add a default value for the function argument
//$router->get('/user/{id}?', function($id = null) {
//    return 'second';
//});

# NB. You can cache the return value from $router->getData() so you don't have to create the routes each request - massive speed gains
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Print out the value returned from the dispatched function
function phrouteresponse(){
global $response;
echo $response;
}?>
