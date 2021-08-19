<?php

namespace Player;

class AccessHelper {

  const VIP_CATEGORIES = [1512];
  //const VIP_GROUPS = [115,116,117];
  const VIP_GROUPS = [7,15];
  const VIP_IMG_GROUPS = [7,15,16,17];
  //const VIP_GROUPS = [7,15,16,17];
  const FORBIDDEN_PAGE = '/szeroka/dh0/www/inc/error/cod/403v2.php';


  public static function checkAccess($catid, $user) {
    if(in_array($catid, self::VIP_CATEGORIES)) {
      return static::isVIP($user);
    } else {
      return true;
    }
  }

  public static function isVIP($user, $gallery = false) {
    if($user && isset($user['user_groups'])) {
      $groups = array_map(function($g) { return $g['group_id']; }, $user['user_groups']);

      foreach($groups as $group) {
        if($gallery) {
          if(in_array($group, self::VIP_IMG_GROUPS)) {
            return true;
          }
        } else {
          if(in_array($group, self::VIP_GROUPS)) {
            return true;
          }
        }
      }
    }
    return false;
  }

  public static function forbidden() {
    header('HTTP/1.0 403 Forbidden');

    require_once self::FORBIDDEN_PAGE;
  }

}
