<?php

use Player\AccessHelper;
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

if(!isset($_COOKIE['fusion_user']) || !is_numeric($_COOKIE['fusion_user'])) {
    AccessHelper::forbidden();
    exit;
}

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8";

$db = null;
try {
    $db = new PDO($dsn, $db_user, $db_pass);
    $db->exec("SET NAMES utf8");
} catch (PDOException $ex) {
    die("<b>Connection error:</b> {$ex->getMessage()}");
}


$userService = new UserService($db);

header('Content-Type: application/json');
$user = $userService->currentUser();
if (!$user) {
    echo json_encode(['error' => 'User not found']);
    exit;
}

$debug['user'] = $user;
$debug['member'] = Player\AccessHelper::isMember($user);

if(isset($_GET['catid']) && is_numeric($_GET['catid'])) {
    $catid = (int) $_GET['catid'];
    $categoryService = new CategoryService($db);
    $category = $categoryService->findBy(['cat_id' => $catid]);
    
    if ($category) {
        $debug['category'] = $category;
        $access = Player\AccessHelper::checkAccess($catid, $user, $categoryService);
        $debug['access'] = $access;
    } else {
        echo json_encode(['error' => 'Category not found']);
        exit;
    }
}

echo json_encode($debug, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);