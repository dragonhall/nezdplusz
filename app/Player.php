<?php

namespace Player;

class Player {
  private $db;
  private $smarty;
  
  public function __construct($db, $smarty) {
    $this->db = $db;
    $this->smarty = $smarty;
  }

  public function playVideo($did) {
    $sql = "SELECT fusion_pdp_downloads.dl_name AS title,
            fusion_pdp_downloads.dl_homepage AS subtitle,
            fusion_pdp_files.file_url AS url
            FROM fusion_pdp_downloads JOIN fusion_pdp_files ON fusion_pdp_downloads.download_id = fusion_pdp_files.download_id 
            WHERE fusion_pdp_downloads.download_id = ?";

//          CONCAT('http://dragonhall.hu:81', fusion_pdp_downloads.dl_homepage) AS subtitle, 


    $stmt = $this->db->prepare($sql);
    $stmt->execute(array($did));

    //print_r($this->db); exit;
    //print_r($stmt); exit;

    //$stmt->debugDumpParams(); exit;

    $data = $stmt->fetch(\PDO::FETCH_ASSOC);

    $data['type'] = 'video/' . pathinfo($data['url'], \PATHINFO_EXTENSION);
    $data['url'] = html_entity_decode($data['url']);

    if($data['subtitle']) {
      $vtt = preg_replace('/\.(7z|srt)$/', '.vtt', $data['subtitle']);

      if(file_exists('/szeroka/dh0/load/' . $vtt)) {
        $data['subtitle'] = 'http://dragonhall.hu' . $vtt ;
      } else {
        unset($data['subtitle']);
      }
    }
      

    $this->db->exec("UPDATE fusion_pdp_downloads SET dl_count = dl_count + 1 WHERE download_id = {$did} LIMIT 1"); 

    $this->smarty->assign('video', $data);
    $this->smarty->assign('did', $did);
    $this->smarty->assign('error', $this->db->errorInfo());
    $this->smarty->display('player.tpl');
  }
}
