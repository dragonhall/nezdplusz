<?php

namespace Player;

class Player {

    private $db;

    private $smarty;

    private $userService;

    // const DOWNLOAD_BASE = 'http://dragonhall.hu:81/';
    const DOWNLOAD_BASE = 'https://download.dragonhall.hu/';
    const SECURE_BASE = 'https://download.dragonhall.hu/';
    const DOWNLOAD_PATH = '/szeroka/dh0/load/';
    const COVER_BASE = 'https://dragonhall.hu/index_elemei/epizod_kepek/';
    const COVER_PATH = '/szeroka/dh0/www/index_elemei/epizod_kepek/';

    public function __construct($db, $smarty, $userService, $groupService, $categoryService, $settings) {
        $this->db = $db;
        $this->smarty = $smarty;
        $this->userService = $userService;
    }

    public function playVideo($did) {

        $embed = isset($_GET['embed']) && $_GET['embed'] === '1' ? 1 : 0;

        if (
            preg_match('/facebook\.com/', $_SERVER['HTTP_USER_AGENT'])
            || preg_match('/facebook\.com/', $_SERVER['HTTP_REFERER'])
        ) {
            // Facebook hit
            $embed = 1;
        }

        $category = $this->getCategory($did);
        // VIP categories cannot embedded
        if (in_array($category, AccessHelper::VIP_CATEGORIES)) {
            if ($embed) {
                AccessHelper::forbidden();
                return;
            }

            $currentUser = $this->userService->currentUser();

            if (!AccessHelper::checkAccess($category, $currentUser)) {
                AccessHelper::forbidden();
                return;
            }
        }

        //$template = $embed == 1 ? 'embed.tpl' : 'player.tpl';
        $template = 'player.tpl';

        if (!$this->smarty->isCached($template, $did)) {
            $data = $this->getVideoByID($did);

            $data['type'] = 'video/' . pathinfo($data['url'], \PATHINFO_EXTENSION);
            $data['url'] = html_entity_decode($data['url']);

            $image = getimagesize(self::COVER_PATH . $data['cover']);

            $data['width'] = $image[0];
            $data['height'] = $image[1];


            if ($data['subtitle']) {
                $vtt = preg_replace('/\.(7z|srt)$/', '.vtt', $data['subtitle']);

                if (file_exists('/szeroka/dh0/load/' . $vtt)) {
                    $data['subtitle'] = 'https://dragonhall.hu' . $vtt;
                } else {
                    unset($data['subtitle']);
                }
            }


            $this->smarty->assign('did', $did);
            $this->smarty->assign('error', $this->db->errorInfo());
            //      $this->smarty->assign('category', $category);
            if (in_array($category, AccessHelper::VIP_CATEGORIES)) {
                $this->smarty->assign('headerimg', 'vip_videotar.png');
            } else {
                $this->smarty->assign('headerimg', 'nezd+player.png');
            }

            if (
                !file_exists(self::COVER_PATH . 'play/' . $data['cover'])
                && file_exists(self::COVER_PATH . "play/__Online_player_{$data['width']}x{$data['height']}.png")
            ) {
                $image = imagecreatefromjpeg(self::COVER_PATH . $data['cover']);
                $imagewidth = imagesx($image);
                $imageheight = imagesy($image);

                $watermark = imagecreatefrompng(self::COVER_PATH . "play/__Online_player_{$data['width']}x{$data['height']}.png");
                $watermarkwidth = imagesx($watermark);
                $watermarkheight = imagesy($watermark);

                imagecopyresampled($image, $watermark, 0, 0, 0, 0, $imagewidth, $imageheight, $watermarkwidth, $watermarkheight);
                imagejpeg($image, self::COVER_PATH . 'play/' . $data['cover'], 100);
                imagedestroy($image);
                imagedestroy($watermark);
            }

            if (file_exists(self::COVER_PATH . 'play/' . $data['cover'])) {
                $data['fb_cover'] = self::COVER_BASE . 'play/' . $data['cover'];
            } else {
                $data['fb_cover'] = self::COVER_BASE . $data['cover'];
            }

            if (preg_match('/(t\.co|twitter\.com)/', $_SERVER['HTTP_REFERER'])) {
                $data['autoplay'] = 1;
            } else {
                $data['autoplay'] = 0;
            }

            $data['cover'] = self::COVER_BASE . $data['cover'];

            $this->smarty->assign('video', $data);
        }

        $this->smarty->display($template, $did);
    }

    public function shareVideo($did) {
        $data = $this->getVideoByID($did);

        $url = html_entity_decode($data['url']);
        $path = str_replace(self::DOWNLOAD_BASE, self::DOWNLOAD_PATH, $url);
        $secure_url = str_replace(self::DOWNLOAD_BASE, self::SECURE_BASE, $url);

        $type = 'video/' . pathinfo($path, \PATHINFO_EXTENSION);
        $size = filesize($path);


        $this->upCounter($did);

        //header("Content-Type: {$type}");
        //header("Content-Length: {$size}");
        //header('Content-Transfer-Encoding: binary');

        //header('Content-Disposition: attachment; filename=' . basename($path) . ';');

        //$vfp = fopen($path, 'rb');
        //$out = fopen('php://output', 'wb');

        //if($_SERVER['REQUEST_METHOD'] === 'GET') {
        //  while(!feof($vfp)) {
        //    fwrite($out, fread($vfp, min(8192, $size)));
        //  }

        //  fclose($vfp);
        //  flush($out);
        //  fclose($out);

        //  #if(preg_match('/http:\/\/(www\.)?(facebook|twitter)\.com/i', $_SERVER['HTTP_REFERER'])) {

        //  #}

        //}
        header('Location: ' . $secure_url, true, 302);
    }


    private function getVideoByID($id) {
        $sql = "SELECT fusion_pdp_downloads.download_id AS id, fusion_pdp_downloads.dl_name AS title,
            fusion_pdp_downloads.dl_homepage AS subtitle,
            fusion_pdp_files.file_url AS url,
            fusion_pdp_images.pic_url AS cover
            FROM fusion_pdp_downloads 
            JOIN fusion_pdp_files ON fusion_pdp_downloads.download_id = fusion_pdp_files.download_id
            LEFT JOIN fusion_pdp_images ON fusion_pdp_downloads.download_id = fusion_pdp_images.download_id
            WHERE fusion_pdp_downloads.download_id = ?";

        //          CONCAT('http://dragonhall.hu:81', fusion_pdp_downloads.dl_homepage) AS subtitle,


        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));

        //print_r($this->db); exit;
        //print_r($stmt); exit;

        //$stmt->debugDumpParams(); exit;

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data;
    }

    private function getCategory($id) {
        $sql = "SELECT cat_id FROM fusion_pdp_downloads WHERE download_id = ? LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));

        $catid = $stmt->fetchColumn(0);

        return $catid;
    }

    private function upCounter($id) {
        $this->db->exec("UPDATE fusion_pdp_downloads SET dl_count = dl_count + 1 WHERE download_id = {$id} LIMIT 1");
    }
}
