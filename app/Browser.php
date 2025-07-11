<?php

namespace Player;

class Browser {

    private $db;

    private $smarty;

    private $userService;

    const DOWNLOAD_BASE = 'http://dragonhall.hu:81/';
    const DOWNLOAD_PATH = '/szeroka/dh0/load/';
    const COVER_BASE = 'https://dragonhall.hu/index_elemei/epizod_kepek/';
    const COVER_PATH = '/szeroka/dh0/www/index_elemei/epizod_kepek/';
    const COVER_DEFAULT = '/index_elemei/anime_cimkepek/nincskep.jpg';


    public function __construct($db, $smarty, $userService) {
        $this->db = $db;
        $this->smarty = $smarty;
        $this->userService = $userService;
    }

    public function catBrowser($catid) {

        $catid = intval($catid);

        if ($catid == 0) {
            header('HTTP/1.0 404 Not Found');
            require_once '/szeroka/dh0/www/inc/error/cod/404.php';
            return;
        }

        $currentUser = $this->userService->currentUser();
        $accessible = AccessHelper::checkAccess($catid, $currentUser);

        if (!$accessible) {
            AccessHelper::forbidden();
            return;
        }

        if (!$this->smarty->isCached('browser.tpl', $catid)) {
            $category = $this->getCategoryByID($catid);
            $topCat = $this->findRootCat($catid);
            $breadcrumb = $this->buildBreadcrumb($catid);
            $downloads = $this->getDownloads($catid);

          // Generate ad positions
            $dl_size = count($downloads);


          //$category['cover'] = $this->getCategoryImage($topCat['cat_id']);
          //$category['cover'] = str_replace('index_elemei', 'index_elemei_fb', $category['cover']);
            $catImage = $this->getCategoryImage($topCat['cat_id']);
            $fbCatImage = str_replace('index_elemei', 'index_elemei_fb', $catImage);

            $coverfile = str_replace('https://dragonhall.hu/', '/szeroka/dh0/www/', $fbCatImage);

            if (!file_exists($coverfile)) {
                copy(str_replace('https://dragonhall.hu/', '/szeroka/dh0/www/', $catImage), $coverfile);
            }

            $s = getimagesize($coverfile);

            $category['cover'] = $fbCatImage;
            $category['cover_image_type'] = $s['mime'];
            $category['cover_width'] = $s[0];
            $category['cover_height'] = $s[1];
            $category['cover'] .= '?' . filemtime($coverfile);

            $category['copy'] = $this->getFirstCopyright($catid);
            $category['title'] = $this->calcFancyTitle($category);

          //if($dl_size > 3) {
            $ads = AdvertisementRegistry::getAds();
          //} else {
          //  $ads = [];
          //}

          //$ratio = $category['cover_width'] / $category['cover_height'];
            $firstImage = $downloads[0]['cover_path'];
            $s = getimagesize($firstImage);
            $ratio = $s[0] / $s[1];

            if ($ratio < 1.5) {
              // Treat it as 4:3
                $ad_cover_class = 'cover';
            } else {
                $ad_cover_class = 'cover-16';
            }


            $this->smarty->assign('advert', $ads[0]);
            $this->smarty->assign('adclass', $ad_cover_class);
            $this->smarty->assign('adratio', $ratio);
            $this->smarty->assign('breadcrumb', $breadcrumb);
            $this->smarty->assign('category', $category);
            $this->smarty->assign('topcat', $topCat);
            $this->smarty->assign('downloads', $downloads);
            $this->smarty->assign('vip', AccessHelper::isVIP($currentUser));
            $this->smarty->assign('vip_category', !!in_array($catid, AccessHelper::VIP_CATEGORIES));
        }

        $this->smarty->display('browser.tpl', $catid);
    }



    private function getCategoryByID($catid) {
        $sql = 'SELECT cat_id, top_cat, cat_name AS name, cat_desc AS description FROM fusion_pdp_cats WHERE cat_id = :catid LIMIT 1';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(':catid' => $catid));

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data;
    }

    private function calcFancyTitle($cat) {
        $rootCat = $this->findRootCat($cat['cat_id']);

        if ($rootCat['cat_id'] == $cat['cat_id']) {
            return $cat['name'];
        }

        if (preg_match('/(^|\b)(.+-RIP|\d+p)\b/', $cat['name'])) {
            $parent = $this->getParentCategory($cat);
            if ($parent['cat_id'] == $rootCat['cat_id']) {
                return $rootCat['name'];
            } else {
                return "{$rootCat['name']} - {$parent['name']}";
            }
        } else {
            return "{$rootCat['name']} - {$cat['name']}";
        }
    }


    private function getParentCategory($cat) {
        return $this->getCategoryByID($cat['top_cat']);
    }

    private function findRootCat($catid) {

        $cat = $this->getCategoryByID($catid);
        if ($cat['top_cat'] == 0) {
            return $cat;
        }

        while ($cat && $cat['top_cat'] != 0) {
          /*
           * HACK Ugly hack, we accept a category as a root category if it has an image.
           *      This is neccessary because category cover is calculated based on this.
           *      Breadcrumb generation should have different logic for finding a root category
           *      so it should NOT be affected by this hack.
           *
           *      DO NOT USE THIS METHOD TO FIND A TRUE CATEGORY ROOT!!!!!
           */
            $image = $this->getCategoryImage($cat['cat_id']);
          //print_r(['cat_id' => $cat['cat_id'], 'image' => $image]);
            if ($image && !preg_match('/nincskep\.jpg/', $image)) {
                return $cat;
            }
            $cat = $this->getCategoryByID($cat['top_cat']);
        }

        return $cat;
    }


    private function getCategoryImage($catid) {
        $sql = "SELECT CONCAT('https://dragonhall.hu', category_image) AS category_image FROM category_pages WHERE category_id = ? LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($catid));

        $col = $stmt->fetchColumn();
        if (!isset($col) || empty($col)) {
            $col = 'https://dragonhall.hu' . self::COVER_DEFAULT;
        }

        return $col;
    }

    private function buildBreadcrumb($catid) {

        $cat = $this->getCategoryByID($catid);
        $bread = $cat['name'];

        while ($cat && $cat['top_cat'] != 0) {
            $cat = $this->getCategoryByID($cat['top_cat']);
            $bread = $cat['name'] . ' &raquo; ' . $bread;
        }

        return $bread;
    }


    private function getDownloads($catid) {
        $catid = intval($catid);
        $count = $this->db->query("SELECT COUNT(*) FROM fusion_pdp_downloads WHERE cat_id = {$catid}")->fetchColumn();

        $last_new = time() - $this->getPDPNewDaysLong();
        if ($count > 0) {
            $sql = "SELECT fusion_pdp_downloads.download_id AS id, fusion_pdp_downloads.dl_name AS title,
              CONCAT('" . self::COVER_BASE . "', fusion_pdp_images.pic_url) AS cover,
              CONCAT('" . self::COVER_PATH . "', fusion_pdp_images.pic_url) AS cover_path,
              (dl_mtime > {$last_new}) AS is_new
              FROM fusion_pdp_downloads
              LEFT JOIN fusion_pdp_images ON fusion_pdp_downloads.download_id = fusion_pdp_images.download_id
              LEFT JOIN fusion_pdp_cats ON fusion_pdp_downloads.cat_id = fusion_pdp_cats.cat_id
              WHERE fusion_pdp_cats.cat_id = ? AND fusion_pdp_downloads.dl_status = 'Y' ORDER BY fusion_pdp_downloads.dl_name DESC, fusion_pdp_downloads.dl_ctime DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($catid));

            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $data;
        } else {
            return array();
        }
    }

    private function getPDPNewDaysLong() {
        $new_days_long = $this->db->query('SELECT new_days_long FROM fusion_pdp_settings WHERE id = 1 LIMIT 1')->fetchColumn();
        return $new_days_long * 24 * 3600;
    }

    private function getFirstCopyright($catid) {
        $catid = intval($catid);
        $copy = $this->db->query("SELECT dl_copyright FROM fusion_pdp_downloads WHERE cat_id = {$catid}")->fetchColumn();

        return $copy;
    }
}
