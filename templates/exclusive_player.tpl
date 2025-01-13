<!DOCTYPE html>
<html lang="hu" xml:lang="hu">
    <head>
        <title>Exkluzív elővetítés &mdash; NÉZD+ Player</title>
        <meta charset="utf8" />
        <meta name="description" content="Egy hely, ahol a régebbi mesék legalább olyan fontosak, mint az újak. Ahol szinkronos és feliratos anime egyenértékû, és jól megférnek egymással. Ahol csakis a minõség a fontos, és nem csak a mennyiség! Mi garanciát vállalunk az igényességre! Tarts velünk és ismertesd meg másokkal is az álmunkat! Hisz csak együtt sikerülhet! DragonHall+ | Már nem csak álom az igényesség!" />
        <meta name='keywords' content='anime, manga, rajzfilm, szinkron, DH, Dragon, Hall, DragonHall, szinkronhangok, magyarhangok, ' />
        <link rel="stylesheet" type="text/css" href="/themes/DragonSTAR/styles.css" media="screen" />
        <link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/gif" href="/images/favicon.gif" />

        <style>
            .flowplayer .fp-captions p {
                font-size: 1.8em;
            }
            #player {
                width: 100%;
                min-height: 404px;
            }
        </style>
    </head>
    <body>
        <script type="text/javascript" src="assets/figyucsak.js"></script>
        <table cellpadding="0" cellspacing="0" width="99%">
            <tbody>
                <tr>
                    <td class="capmain">&nbsp;&nbsp;Kizárólag VIP tagoknak szóló exkluzív elővetítés</td>
                </tr>
                <tr>
                    <td class="main" style="padding: 5px;">
                        <div style="background: url(assets/vip_elovetites.png) no-repeat; max-width: 1200px; height: 92px; margin-bottom: 10px;">&nbsp;</div>
                        <div id="monoscope" style="padding: 5px 0; text-align: center;">
                            <img src="https://dragonhall.hu/nezdplusz/assets/monoscope.png" width="100%" id="player_bg" />
                        </div>
                        <video id="tv_player"
                               class="videojs video-js vjs-default-skin vjs-big-play-centered"
                               poster="https://dragonhall.hu/nezdplusz/assets/monoscope.png"
                               controls="controls" preload="none"
                               style="display: none;">
                            <source type="application/x-mpegURL"></source>
                        </video>
                    </td>
                </tr>
            </tbody>
        </table>

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

        <script src="//vjs.zencdn.net/7.15.4/video.js"></script>
        <script type="text/javascript">
            window.pollUrl = function(url) {
                //console.log("Polling URL: " + url);
                jQuery.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data, status, jqXHR) {

                        var container = document.getElementById('player');

                        var clip = {};

                        console.log(clip);

                        $('#monoscope').hide();
                        $('#tv_player').show();

                        var tv_params = {
                            liveui: true,
                            fluid: true,
                            controls: true,
                            autoplay: true,
                            controlBar: {
                                progressControl: false,
                                playToggle: false
                            }
                        }

                        $('#tv_player').find('source').attr('src', url);

                        var tvPlayer = videojs('tv_player', tv_params);

                        tvPlayer.ready(function() {
                            var promise = tvPlayer.play();
                        });
                    },
                    error: function(jqXHR, textStatus, error) {
                        console.log({
                            error: error,
                            status: textStatus
                        });

                        window.setTimeout(window.pollUrl, 1000, url);
                    },
                });
            }

            jQuery(function() {
                window.pollUrl('https://tv.dragonhall.hu/live/dragonhall_exclusive.m3u8');
            });
        </script>
        {include file='_ga.tpl'}
    </body>
</html>
