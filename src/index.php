<?php

/**
 * Example Application
 *
 * @package Example-application
 */

require_once('includes/functions.php');
require_once('smarty/libs/Smarty.class.php');
require_once('config.php');

$originalUrl = isset($_GET['4WPU9PbwMi']) ? $_GET['4WPU9PbwMi'] : 'home';
if(empty(trim($originalUrl))) {
    $originalUrl = "home";
}
$splitted = explode('/', $originalUrl);
$fileName = 'controllers/' . $splitted[0] . '.php';
if(!file_exists($fileName)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true);
    die('page not found');
}
require_once($fileName);
$className = ucfirst($splitted[0]) . 'Controller';
if(!class_exists($className)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true);
    die('class ' . $className . ' does not exist');
}
if(!is_subclass_of($className, 'BaseController')) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true);
    die('class ' . $className . ' does not extend BaseController');
}
$controller = new $className();
$controller->setTemplateDir('views');
$controller->setCompileDir('views_c');
//$controller->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
//$controller->setCacheLifetime(-1);
$controller->addPluginsDir('plugins');
$controller->configLoad('config.conf');

session_name('FLUCKY_SESSION');
session_set_cookie_params(604800);
if(!session_start()) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true);
    die('konnte die session nicht starten!');
}

if(isset($_SESSION['logged_in'])) {
    if($_SESSION['logged_in']) {
        define('USER_ID', $_SESSION['user_id']);
        define('USER_NAME', $_SESSION['user_name']);
        define('USER_EMAIL', $_SESSION['user_email']);
    }
} else {
    $_SESSION['logged_in'] = false;
}

define('LOGGED_IN', $_SESSION['logged_in']);

$template = 1;
$template = $controller->process($splitted);
if($template === 1) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true);
    die('return im $controller->process() vergessen!');
}

$cacheId = $controller->getCacheId();
if(!empty($cacheId)) {
    $cacheId .= "|";
}
$cacheId .= LOGGED_IN ? "user" : "guest";

$controller->setCacheId($cacheId);

if(!$controller->isCached($template)) {
    $controller->assign('pageName', $splitted[0]);
    $controller->setCacheableVars();
}

$controller->assign('loggedIn', LOGGED_IN);
if(LOGGED_IN) {
    $controller->assign('userId', USER_ID);
    $controller->assign('userName', USER_NAME);
    $controller->assign('userEmail', USER_EMAIL);
}

$controller->display($template);
