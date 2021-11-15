<?php

namespace Player;

class ExclusivePlayer {
  private $db;
  private $smarty;
  private $userService;

  
  public function __construct($db, $smarty, $userService) {
    $this->db = $db;
    $this->smarty = $smarty;
    $this->userService = $userService;
  }

  public function playStream() {

    $currentUser = $this->userService->currentUser();

    //print_r($currentUser); exit;

    if(!AccessHelper::isVIP($currentUser, false)) {
      AccessHelper::forbidden();
      return;
    }
    
    //$template = $embed == 1 ? 'embed.tpl' : 'player.tpl';
    $template = 'exclusive_player.tpl';

    if(!$this->smarty->isCached($template)) {

      $this->smarty->assign('error', $this->db->errorInfo());
    }
    $this->smarty->display($template);

  }
}
