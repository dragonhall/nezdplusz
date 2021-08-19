<?php

ini_set('display_errors', true);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

define('APP_ROOT', __DIR__);
define('FUSION_ROOT', dirname(APP_ROOT));

define('CACHE_DIR', APP_ROOT . DIRECTORY_SEPARATOR . 'cache');

require_once(APP_ROOT . '/vendor/autoload.php');
require_once(FUSION_ROOT . '/config.php');

if(php_sapi_name() !== 'cli' && '5c2efcaa211ac2bc0f11c4944a8bf2eb' !== $_GET['itok']) {
  die('Token mismatch');
}

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8";

$db = null;
try {
  $db = new PDO($dsn, $db_user, $db_pass);
  $db->exec("SET NAMES utf8");
} catch (PDOException $ex) {
  die("<b>Connection error:</b> {$ex->getMessage()}");
}


$sql = "SELECT * FROM fusion_custom_pages";

$data = $db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

header('Content-Type: text/plain; charset=utf-8');

foreach($data as $row) {
  $content = stripcslashes($row['page_content']);
  $title = $row['page_title'];


  preg_match_all('/<img[^>]*src *= *["\']?([^"\']*)/i', $content,  $img_raw);

  $image = $img_raw[1][0];

  preg_match_all('/<a[^>]*href *= *["\']?.+?catid=([^"\']*)/i', $content,  $cat_raw);

  $category = $cat_raw[1][0];

  if(!empty($category)) {
    print "INSERT INTO category_pages(page_id, category_id, category_image) VALUES({$row['page_id']}, {$category}, '{$image}')" . PHP_EOL;

    print '========================================================================================' . PHP_EOL;
    print PHP_EOL;
    
    $sql = "SELECT COUNT(*) AS count FROM category_pages WHERE category_id = :cat_id AND page_id = :page_id";

    $stmt = $db->prepare($sql);

    $cnt=$stmt->fetch()[0];

    $stmt->execute(array(
      ':page_id' => $row['page_id'],
      ':cat_id' => $category,
    ));

    if($cnt == 0) {
      print $title . PHP_EOL;

      $sql = 'INSERT INTO category_pages(page_id, category_id, category_image) VALUES (:page_id, :cat_id, :image)';

      $stmt = $db->prepare($sql);

      $stmt->execute(array(
        ':page_id' => $row['page_id'],
        ':cat_id' => $category,
        ':image' => $image
      ));
    }
  }
}

// Invalidate Smarty cache
if(file_exists(CACHE_DIR) && is_dir(CACHE_DIR)) {
  $dh = opendir(CACHE_DIR);
  while(($f = readdir($dh)) !== false) {
    if(is_file(CACHE_DIR . DIRECTORY_SEPARATOR . $f)) {
      unlink(CACHE_DIR . DIRECTORY_SEPARATOR . $f);
    }
  }
  closedir($dh);
}

