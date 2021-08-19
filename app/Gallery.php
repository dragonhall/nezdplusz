<?php

namespace Player;

class Gallery {
  private $db;
  private $smarty;
  private $userService;

  const ALBUMS_PATH = '/szeroka/dh0/www/images/photoalbum';
  const ALBUMS_BASE = 'https://dragonhall.hu/images/photoalbum';
  const VIP_ALBUM_ID = 692;
  const IMG_PER_PAGE = 21;
  
  public function __construct($db, $smarty, $userService) {
    $this->db = $db;
    $this->smarty = $smarty;
    $this->userService = $userService;
  }


  public function albumBrowser($page) {

    $currentUser = $this->userService->currentUser();
    $accessible = AccessHelper::isVIP($currentUser, true);
    $script = basename($_SERVER['PHP_SELF']);
    $myUrl = $this->baseUrl() . '/' . $script;

    if(!$accessible) {
      AccessHelper::forbidden();
      return;
    }

    if($page === 0) {
      $page = 1;
    }

    if(!$this->smarty->isCached('gallery.tpl', $page)) {
      $album = $this->getAlbum($page);
      $albumSize = $this->getAlbumSize();

      $pagination = array();
      $lastPage = ceil($albumSize / self::IMG_PER_PAGE);
      $prevPage = ($page == 1) ? 1 : $page - 1;
      $nextPage = ($page >= $lastPage) ? $lastPage : $page + 1;

      $pagination[] = "<a href=\"{$myUrl}?page=1\" title=\"Első oldal\">&laquo;</a>";
      $pagination[] = "<a href=\"{$myUrl}?page={$prevPage}\" title=\"Előző oldal\">&lsaquo;</a>";

      for($i = 1; $i <= $lastPage; $i++) {
        if($i === $page) {
          $pagination[] = "<strong>{$i}</strong>";
        } else {
          $pagination[] = "<a href=\"{$myUrl}?page={$i}\" title=\"Ugrás: {$i}. oldal\">{$i}</a>";
        }
      }

      $pagination[] = "<a href=\"{$myUrl}?page={$nextPage}\" title=\"Következő oldal\">&rsaquo;</a>";
      $pagination[] = "<a href=\"{$myUrl}?page={$lastPage}\" title=\"Utolsó oldal\">&raquo;</a>";

      // print_r(array(
      //   'paginator' => $pagination,
      //   'page' => $page,
      // ));

      $this->smarty->assign('baseUrl', $this->baseUrl());
      $this->smarty->assign('pagination', $pagination);
      $this->smarty->assign('album', $album);

    }

    $this->smarty->display('gallery.tpl', $page);
  }

  public function shareImage($iid) {
    $currentUser = $this->userService->currentUser();
    $accessible = AccessHelper::isVIP($currentUser, true);

    if(false && !$accessible) {
      AccessHelper::forbidden();
      return;
    }
    $data = $this->getImageByID($iid);

    $path = self::ALBUMS_PATH . '/album_' . self::VIP_ALBUM_ID . '/' . $data['photo_filename'];

    if(file_exists($path)) {
      $type = mime_content_type($path);
      $size = filesize($path);

      //print_r(array('type' => $type, 'size' => $size, 'path' => $path)); exit;

      header("Content-Type: {$type}");
      header("Content-Length: {$size}");
      header('Content-Transfer-Encoding: binary');

      if($_GET['dl'] === 1) {
        header('Content-Disposition: attachment; filename=' . basename($path) . ';');
      } else {
        header('Content-Disposition: inline');
      }

      header('X-Sendfile: ' . $path);

    }
  }


  private function getImageByID($id) {
    $sql = 'SELECT photo_filename FROM fusion_photos WHERE photo_id = ? AND album_id = ?';

    $stmt = $this->db->prepare($sql);
    $stmt->execute(array($id, self::VIP_ALBUM_ID));

    $data = $stmt->fetch(\PDO::FETCH_ASSOC);

    return $data;
  }

  private function getAlbumSize() {
    $sql = 'SELECT COUNT(*) FROM fusion_photos WHERE album_id = ?';
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute(array(self::VIP_ALBUM_ID));

    $count = $stmt->fetchColumn();

    return (int)$count;
  }

  private function getAlbum($page) {
    $offset = ($page - 1) * self::IMG_PER_PAGE;

    $sql = "SELECT photo_id, CONCAT('" . self::ALBUMS_BASE . "/album_', album_id, '/', photo_thumb2) AS photo_thumb2 FROM fusion_photos WHERE album_id = :album_id ORDER BY photo_order DESC, photo_datestamp DESC LIMIT {$offset}, " . self::IMG_PER_PAGE;

    $stmt = $this->db->prepare($sql);
    $stmt->execute(array(
      ':album_id' => self::VIP_ALBUM_ID,
    ));

    $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
    return $data;
  }

  private function baseUrl() {
    $scheme = $_SERVER['REQUEST_SCHEME'];
    if(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
      $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];
    }
    
    $port = intval($_SERVER['SERVER_PORT']);

    // Workaround a quirk about Nginx reverse proxy, it forwards proto but not portnumber
    if($scheme === 'https' && $port === 80 && (isset($_SERVER['HTTP_X_FORWARDED_PROTO']))) {
      $port = 443;
    }

    if(($scheme === 'http' && $port === 80) || ($scheme === 'https' && $port === 443)) {
      $locationBase = $_SERVER['HTTP_HOST'];
    } else {
      $locationBase = $_SERVER['HTTP_HOST'] . ':' . $port;
    }

    return "{$scheme}://{$locationBase}" . dirname($_SERVER['PHP_SELF']);
  }

}
