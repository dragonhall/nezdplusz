<?php

namespace Player;

class AccessHelper {
    const VIP_CATEGORIES = [1512];
    //const VIP_GROUPS = [115,116,117];
    const VIP_GROUPS = [7, 15, 16];
    const VIP_IMG_GROUPS = [7, 15, 16, 17];
    //const VIP_GROUPS = [7,15,16,17];
    const FORBIDDEN_PAGE = Settings::FUSION_PATH . '/inc/error/cod/403v2.php';

    const iGUEST = 0;
    const iMEMBER = 101;
    const iADMIN = 102;
    const iSUPERADMIN = 103;


    public static function checkAccess($catid, $user, $categoryService = null) {
        if (in_array($catid, self::VIP_CATEGORIES)) {
            return static::isVIP($user);
        } else {
            if ($categoryService === null) {
                $categoryService = $GLOBALS['categoryService'];
            }
            
            $category = $categoryService->findBy(['cat_id' => $catid]);

            // If the category is set to guest access, allow access to anonymous users too
            if ($category['cat_access'] == self::iGUEST) {
                return true;
            }

            $member = static::isMember($user);
            $cat_access = $category && isset($category['cat_access']) ? $category['cat_access'] : self::iGUEST;

            // Check if the category access level is asssigned to an user level
            if ($member) {
                if (
                    in_array($cat_access, [self::iMEMBER, self::iADMIN, self::iSUPERADMIN]) &&
                    $user['user_level'] == $cat_access
                ) {
                    return true;
                }
                // Check if the category access level is set to a group ID and the user is in that group
                if (isset($user['user_groups']) && is_array($user['user_groups'])) {
                    foreach ($user['user_groups'] as $group) {
                        if ($group['group_id'] == $cat_access) {
                            return true;
                        }
                    }
                }
            }

            return false;
        }
    }

    public static function isVIP($user, $gallery = false) {
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

    public static function isMember($user) {
        if ($user) {
            return $user['user_level'] == self::iMEMBER || $user['user_level'] == self::iADMIN || $user['user_level'] == self::iSUPERADMIN;
        }
        return false;
    }

    public static function forbidden() {
        header('HTTP/1.0 403 Forbidden');

        require_once self::FORBIDDEN_PAGE;
    }


    private static function getUserGroups($user) {
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
