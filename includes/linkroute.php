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

$router->any('/', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::content');;
});

$router->any('/{id}', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::post');;
});

$router->any('/{id}/amp', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::amp');;
});

$router->any('/{id}/amp/comments', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('amp', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog/amp');
    return $templates->render('amp::amppostcomments');;
});

$router->get('/feed', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::feed');;
});

$router->post('/postcomment', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::comment');;
});

$router->get('/votecomment', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::votecomment');;
});

$router->post('/mail', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::contact');;
});

$router->any('/{id}/contact', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::usercontact');;
});

$router->post('/{id}/mail', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::contact');;
});

$router->get('/category', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::category');;
});

$router->get('/author', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::author');;
});

$router->get('/tag', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::tag');;
});

$router->post('/search', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('search', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/search');
    return $templates->render('search::search');;
});

$router->get('/search', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('search', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/search');
    return $templates->render('search::searchresults');;
});

$router->get('/sitemap', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('includes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/');
    return $templates->render('includes::sitemapindex');;
});

$router->get('/sitemap/{id}', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('includes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/');
    return $templates->render('includes::sitemap');;
});

$router->get('/reportcomment', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::reportcomment');;
});

$router->post('/reportcomment2', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('blog', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog');
    return $templates->render('blog::reportcomment2');;
});

$router->get('/manifest.json', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('includes', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/');
    return $templates->render('includes::manifest');;
});

$router->any('/scripts/ckeditor/skins/{id}/skin.js', function(){
$link = explode('/', $_SERVER['REQUEST_URI']);
echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/scripts/ckeditor/skins/'.$link[4].'/skin.js');
exit;
});

pluginClass::hook( "link_routes" );

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
