<?php

namespace Player;

class AdvertisementRegistry {

  ////////// EZ ITT A REKLAM HELYE VVVV //////////////////////////////////
    private static $ads = [
    ['assets/ads/NEZD_dhtv_3-2.png', 'https://tv.dragonhall.hu/' ],
    ['assets/ads/NEZD_sarkanyok_3-2.png', 'https://donate.dragonhall.hu/' ],
    ['assets/ads/NEZD_tamogatas_3-2.png', 'https://donate.dragonhall.hu/' ],
    ];
  ////////// REKLAMOK VEGE ^^^^ /////////////////////////////////////////

    public static function getAds() {
        $ads = [];
        $root = dirname(__DIR__);
        foreach (static::$ads as $ad) {
            if (file_exists($root . '/' . $ad[0])) {
                $ads[] = $ad;
            }
        }

        shuffle($ads);
        return $ads;
    }
}
