<?php

use Player\GroupService;
use Player\UserService;
use Player\CategoryService;
use Player\Settings;

ini_set('display_errors', true);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

define('APP_ROOT', __DIR__);
define('FUSION_ROOT', dirname(APP_ROOT));

// require_once(APP_ROOT . '/recaptcha_check.php');

require_once(APP_ROOT . '/vendor/autoload.php');
require_once(FUSION_ROOT . '/config.php');

if (!isset($_GET['did']) || !is_numeric($_GET['did'])) {
    die('<b>No video specified!</b>');
}


$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8";

$db = null;
try {
    $db = new PDO($dsn, $db_user, $db_pass);
    $db->exec("SET NAMES utf8");
} catch (PDOException $ex) {
    die("<b>Connection error:</b> {$ex->getMessage()}");
}

$smarty = new Smarty();
$smarty->template_dir = APP_ROOT . '/templates';
$smarty->cache_dir = APP_ROOT . '/cache';
//$smarty->debugging = true;

$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);


if (!file_exists($smarty->cache_dir)) {
    mkdir($smarty->cache_dir);
}

$userService = new UserService($db);
$settings = new Settings($db);
$groupService = new GroupService($db, $settings);
$categoryService = new CategoryService($db);

$player = new Player\Player($db, $smarty, $userService);
$player->playVideo((int) $_GET['did']);
