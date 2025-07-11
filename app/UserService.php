<?php

namespace Player;

class UserService {

    private $db;

    // SELECT user_name, user_email, user_groups, user_status, user_password FROM fusion_users;
    public $user_name;

    public $user_email;

    public $user_status;

    private $user_groups;

    public $groups;

    public function __construct($db) {
        $this->db = $db;
    }


    public function currentUser() {
        if (isset($_COOKIE) && array_key_exists('fusion_user', $_COOKIE)) {
            return $this->findBy(['user_id' => intval($_COOKIE['fusion_user'])]);
        } else {
            return [];
        }
    }

    public function findBy($query) {
        $where = array();
        $binding = array();
        foreach ($query as $col => $val) {
            $where[] = "{$col} = :{$col}";
            $binding[":{$col}"] = $val;
        }

        $sql = 'SELECT * FROM fusion_users WHERE ' . implode(' AND ', $where) . ' LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($binding);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && isset($user['user_groups'])) {
            $groups = array_map('intval', explode('.', $user['user_groups']));
            $groupSQL = implode(',', $groups);

            $sql = "SELECT group_id, group_name FROM fusion_user_groups WHERE group_id IN ({$groupSQL})";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $sgroups = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (isset($sgroups) && !empty($sgroups)) {
                $user['user_groups'] = $sgroups;
            }
        }

        // if ($user && isset($user['user_level'])) {
        //     $user['user_groups'][] = GroupService::BUILTIN_GROUPS[$user['user_level']];
        // }
        return $user;
    }
}
