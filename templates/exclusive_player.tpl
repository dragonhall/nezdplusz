<!DOCTYPE html>
<html lang="hu" xml:lang="hu">
    <head>
        <title>Exkluzív elővetítés &mdash; NÉZD+ Player</title>
        <meta charset="utf8" />
        <meta name="description" content="Egy hely, ahol a régebbi mesék legalább olyan fontosak, mint az újak. Ahol szinkronos és feliratos anime egyenértékû, és jól megférnek egymással. Ahol csakis a minõség a fontos, és nem csak a mennyiség! Mi garanciát vállalunk az igényességre! Tarts velünk és ismertesd meg másokkal is az álmunkat! Hisz csak együtt sikerülhet! DragonHall+ | Már nem csak álom az igényesség!" />
        <meta name='keywords' content='anime, manga, rajzfilm, szinkron, DH, Dragon, Hall, DragonHall, szinkronhangok, magyarhangok, ' />
        <link rel="stylesheet" type="text/css" href="/themes/DragonSTAR/styles.css" media="screen" />
        <!--link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flowplayer/7.2.7/skin/skin.min.css" /-->
        <link rel="stylesheet" type="text/css" href="/nezdplusz/node_modules/flowplayer/dist/skin/skin.css" />

        <link rel="shortcut icon" type="image/gif" href="/images/favicon.gif" />
        
        <style>
            .flowplayer .fp-captions p {
                font-size: 1.8em;
            }
        </style>
    </head>
    <body>
        <table cellpadding="0" cellspacing="0" width="99%">
            <tbody>
                <tr>
                    <td class="capmain">&nbsp;&nbsp;Kizárólag VIP tagoknak szóló exkluzív elővetítés</td>
                </tr>
                <tr>
                    <td class="main" style="padding: 5px;">
                        <div style="background: url(assets/vip_elovetites.png) no-repeat; max-width: 1200px; height: 92px; margin-bottom: 10px;">&nbsp;</div>
                        <div class="flowplayer fp-outlined" id="player" style="padding: 5px 0; text-align: center;">
                            <img src="https://dragonhall.hu/nezdplusz/assets/monoscope.png" width="100%" id="player_bg" />
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <!--script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flowplayer/7.2.7/flowplayer.min.js"></script-->
        <!--script type="text/javascript" src="/nezdplusz/node_modules/flowplayer/dist/flowplayer.min.js"></script-->
        <script type="text/javascript" src="/nezdplusz/assets/flowplayer.hlsjs.min.js"></script>
        <script type="text/javascript">
            window.pollUrl = function(url) {
                //console.log("Polling URL: " + url);
                jQuery.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data, status, jqXHR) {

                        $('#player_bg').hide();

                        var container = document.getElementById('player');

                        var clip = {};

                        clip.sources = [{
                            type: 'application/x-mpegURL',
                            src: url
                        }]

                        console.log(clip);
                        flowplayer(container, {
                            debug: false,
                            share: false,
                            embed: false,
                            facebook: false,
                            // TODO replace me
                            poster: "https://dragonhall.hu/nezdplusz/assets/monoscope.png",
                            clip: clip
                            }).on('ready', function() {
                                console.log(container);
                                var fsb = container.querySelector('.fp-fullscreen');
                                container.querySelector('.fp-controls').appendChild(fsb); 
                            });
                    },
                    error: function(jqXHR, textStatus, error) {
                        //console.log({
                        //    error: error, 
                        //    status: textStatus
                        //});
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
