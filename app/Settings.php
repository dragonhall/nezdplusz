<?php

namespace Player;

class Settings {

    private $settings;

    private $db;

    const FUSION_PATH = '/srv/www/www.dragonhall.hu/current';


    public function __construct($db) {
        $this->db = $db;
        $this->loadSettings();
    }

    private function loadSettings() {
        $stmt = $this->db->query('SELECT * FROM fusion_settings');
        $this->settings = $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function __get($key) {
        if (array_key_exists($key, $this->settings)) {
            return $this->settings[$key];
        } else {
            throw new \Exception("Setting {$key} does not exist.");
        }
    }

    public function getGlobalLocalizations() {
        $lang = $this->settings['locale'];

        $localizationPath = self::FUSION_PATH . '/locale/' . $lang . '/global.php';
        if (file_exists($localizationPath)) {
            return include $localizationPath;
        } else {
            return [];
        }
    }
}
