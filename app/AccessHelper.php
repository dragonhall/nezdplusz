<?php

namespace Player;

class AccessHelper
{
    const VIP_CATEGORIES = [1512];
  //const VIP_GROUPS = [115,116,117];
    const VIP_GROUPS = [7,15,16];
    const VIP_IMG_GROUPS = [7,15,16,17];
  //const VIP_GROUPS = [7,15,16,17];
    const FORBIDDEN_PAGE = Settings::FUSION_PATH . '/inc/error/cod/403v2.php';

    const iGUEST = 0;
    const iMEMBER = 101;
    const iADMIN = 102;
    const iSUPERADMIN = 103;


    public static function checkAccess($catid, $user, $categoryService = null)
    {
        if (in_array($catid, self::VIP_CATEGORIES)) {
            return static::isVIP($user);
        } else {

            
            if ($categoryService === null) {
                $categoryService = $GLOBALS['categoryService'];
            }
            $category = $categoryService->findBy(['cat_id' => $catid]);

            if($category['cat_access'] == self::iGUEST) {
                return true;
            }
            
            $member = static::isMember($user);
            return $member && $category && $category['cat_access'] == self::iMEMBER;
        }
    }

    public static function isVIP($user, $gallery = false)
    {
        if ($user) {
            $groups = self::getUserGroups($user);

            foreach ($groups as $group) {
                if ($gallery) {
                    if (in_array($group, self::VIP_IMG_GROUPS)) {
                        return true;
                    }
                } else {
                    if (in_array($group, self::VIP_GROUPS)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function isMember($user)
    {
        if ($user) {
            $groups = self::getUserGroups($user);
            return in_array(self::iMEMBER, $groups);
        }
        return false;
    }

    public static function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');

        require_once self::FORBIDDEN_PAGE;
    }


    private static function getUserGroups($user)
    {
        if (isset($user['user_groups'])) {
            return array_map(
                function ($g) {
                    return $g['group_id'];
                },
                $user['user_groups']
            );
        }
        return [];
    }
}
