<?php

use \Player\UserService;

ini_set('display_errors', true);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

define('APP_ROOT', __DIR__);
define('FUSION_ROOT', dirname(APP_ROOT));

// require_once(APP_ROOT . '/recaptcha_check.php');

require_once(APP_ROOT . '/vendor/autoload.php');
require_once(FUSION_ROOT . '/config.php');

if(!isset($_GET['catid']) || !is_numeric($_GET['catid'])) {
  die('<b>No category specified!</b>');
}


$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8";

$db = null;
try {
  $db = new PDO($dsn, $db_user, $db_pass);
  $db->exec("SET NAMES utf8");
} catch (PDOException $ex) {
  die("<b>Connection error:</b> {$ex->getMessage()}");
}

$smarty = new Smarty;
$smarty->template_dir = APP_ROOT . '/templates';
$smarty->cache_dir = APP_ROOT . '/cache';
//$smarty->debugging = true;

$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
$smarty->setCacheLifetime(15 * 60);


if(!file_exists($smarty->cache_dir)) {
  mkdir($smarty->cache_dir);
}

$userService = new UserService($db);

$player = new Player\Browser($db, $smarty, $userService);
$player->catBrowser($_GET['catid']);
