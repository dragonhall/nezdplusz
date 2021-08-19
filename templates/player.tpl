<!DOCTYPE html>
<html lang="hu" xml:lang="hu">
    <head>
        <title>{$video.title} &mdash; NÉZD+ Player</title>
        <meta charset="utf8" />
        <meta name="description" content="Egy hely, ahol a régebbi mesék legalább olyan fontosak, mint az újak. Ahol szinkronos és feliratos anime egyenértékû, és jól megférnek egymással. Ahol csakis a minõség a fontos, és nem csak a mennyiség! Mi garanciát vállalunk az igényességre! Tarts velünk és ismertesd meg másokkal is az álmunkat! Hisz csak együtt sikerülhet! DragonHall+ | Már nem csak álom az igényesség!" />
        <meta name='keywords' content='anime, manga, rajzfilm, szinkron, DH, Dragon, Hall, DragonHall, szinkronhangok, magyarhangok, ' />
        <link rel="stylesheet" type="text/css" href="/themes/DragonSTAR/styles.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flowplayer/7.2.7/skin/skin.min.css" />
        <!--link rel="stylesheet" type="text/css" href="/nezdplusz/node_modules/flowplayer/dist/skin/skin.min.css" /-->

        <link rel="shortcut icon" type="image/gif" href="/images/favicon.gif" />
        
        <!-- FaceBook sh!t -->
        <meta property="og:title" content="{$video.title}" />
        <meta property="og:type"  content="video.other" />
        <meta property="og:url" content="https://dragonhall.hu/nezdplusz/player.php?did={$video.id}" />
        <meta property="og:image" content="{$video.fb_cover}" />
        <meta property="og:image:width" content="{$video.width}" />
        <meta property="og:image:height" content="{$video.height}" />
        <meta property="og:image:alt" content="{$video.title}" />
        <meta property="og:video:url" content="https://dragonhall.hu/nezdplusz/share.php?did={$video.id}" />
        <meta property="og:video:secure_url" content="https://dragonhall.hu/nezdplusz/share.php?did={$video.id}" />
        <meta property="og:video:type" content="{$video.type}" />
        <meta property="og:description" content="{$video.title} - Csak a DragonHall+ oldalán!" />
        <meta property="og:video:width" content="{$video.width}" />
        <meta property="og:video:height" content="{$video.height}" />


        <!-- Twitter sh!t -->
        <meta name="twitter:card" content="player" />
        <meta name="twitter:site" content="@dragonhallplus" />
        <meta name="twitter:url" content="https://dragonhall.hu/nezdplusz/player.php?did={$video.id}" />
        <meta name="twitter:title" content="{$video.title}" />
        <meta name="twitter:description" content="{$video.title} - Csak a DragonHall+ oldalán!" />
        <meta name="twitter:image" content="{$video.cover}" />
        <meta name="twitter:player" content="https://dragonhall.hu/nezdplusz/player.php?did={$video.id}&embed=1" />
        <meta name="twitter:player:width" content="{$video.width}">
        <meta name="twitter:player:height" content="{$video.height}">

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
                    <td class="capmain">&nbsp;&nbsp;Epizód/Film címe:&nbsp;{$video.title}</td>
                </tr>
                <tr>
                    <td class="main" style="padding: 5px;">
                        <!--div style="color: white; background: red; margin: 5px 10px; padding: 5px; font-weight: bold; font-size: 10pt; text-align: center;">Kisérleti verzió</div-->
                        <div style="background: url(assets/nezd+player.png); max-width: 900px; height: 92px; margin-bottom: 10px;">&nbsp;</div>
                        <div class="flowplayer fp-outlined" id="player" style="padding: 5px 0; text-align: center;">
                                <!--
                            <video preload="auto" data-debug="true">
                                <source src="https://dragonhall.hu/nezdplusz/share.php?did={$video.id}" type="{$video.type}" />
                                {if $video.subtitle}
                                <track label="Magyar" kind="subtitles" srclang="hu" src="{$video.subtitle}" default="default" />
                                {/if}
                            </video>
                                -->
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <!--script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flowplayer/7.2.7/flowplayer.min.js"></script-->
        <script type="text/javascript" src="/nezdplusz/node_modules/flowplayer/dist/flowplayer.min.js"></script>
        <script type="text/javascript">
            //flowplayer.conf = { 
            //    logo: false 
            //}
            jQuery(function() {
                // flowplayer(function(api, root) {
                //     var fsb = root.querySelector('.fp-fullscreen');

                //     api.on('ready', function() { 
                //         root.querySelector('.fp-controls').appendChild(fsb); 
                //     });
                // });
                var container = document.getElementById('player');

                var clip = {};

                clip.sources = [{
                                    type: "{$video.type}",
                                    src: "https://dragonhall.hu/nezdplusz/share.php?did={$video.id}"
                                }];
                {if $video.subtitle}
                clip.subtitles = [{
                                    "default": true,
                                    kind: "subtitle",
                                    label: "Magyar",
                                    srclang: "hu",
                                    src: "{$video.subtitle}"
                                }]
                {/if}

                //clip.poster = "{$video.cover}";
                console.log(clip);
                flowplayer(container, {
                    debug: false,
                    share: true,
                    embed: false,
                    facebook: true,
                    poster: "{$video.cover}",
                    clip: clip
                    }).on('ready', function() {
                    console.log(container);
                    var fsb = container.querySelector('.fp-fullscreen');
                    container.querySelector('.fp-controls').appendChild(fsb); 
                });
            });
        </script>
        {include file='_ga.tpl'}

    </body>
</html>
