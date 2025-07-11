<?php

namespace Player;

class GroupService {

    private $db;

    private $settings;

    public function __construct($db, $settings = null) {
        if ($settings === null) {
            $settings = $GLOBALS['settings'];
        }
        $this->settings = $settings;
        $this->db = $db;
    }

    public function getGroupByID($groupId) {

        $localizations = $this->settings->getGlobalLocalizations();

        $builtinGroups = [
            AccessHelper::iGUEST => [
                'group_id' => AccessHelper::iGUEST,
                'group_name' => isset($localizations['user0']) ? $localizations['user0'] : 'Guest',
                'group_description' => 'Guest users with no access rights.'
            ],
            AccessHelper::iMEMBER => [
                'group_id' => AccessHelper::iMEMBER,
                'group_name' => isset($localizations['user1']) ? $localizations['user1'] : 'Member',
                'group_description' => 'Registered members with standard access rights.'
            ],
            AccessHelper::iADMIN => [
                'group_id' => AccessHelper::iADMIN,
                'group_name' => isset($localizations['user2']) ? $localizations['user2'] : 'Admin',
                'group_description' => 'Administrators with elevated access rights.'
            ],
            AccessHelper::iSUPERADMIN => [
                'group_id' => AccessHelper::iSUPERADMIN,
                'group_name' => isset($localizations['user3']) ? $localizations['user3'] : 'Super Admin',
                'group_description' => 'Super administrators with full access rights.'
            ]
        ];

        if (array_key_exists($groupId, $builtinGroups)) {
            return $builtinGroups[$groupId];
        }

        $stmt = $this->db->prepare('SELECT * FROM fusion_user_groups WHERE group_id = :group_id LIMIT 1');
        $stmt->execute([':group_id' => $groupId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllGroups() {
        $stmt = $this->db->query('SELECT * FROM fusion_user_groups');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
