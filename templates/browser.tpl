<!DOCTYPE html>
<html lang="hu" xml:lang="hu">
    <head>
        <title>{$category.title} &mdash; NÉZD+ Player</title>
        <meta charset="utf8" />
        <meta name="description" content="Egy hely, ahol a régebbi mesék legalább olyan fontosak, mint az újak. Ahol szinkronos és feliratos anime egyenértékû, és jól megférnek egymással. Ahol csakis a minõség a fontos, és nem csak a mennyiség! Mi garanciát vállalunk az igényességre! Tarts velünk és ismertesd meg másokkal is az álmunkat! Hisz csak együtt sikerülhet! DragonHall+ | Már nem csak álom az igényesség!" />
        <meta name='keywords' content='anime, manga, rajzfilm, szinkron, DH, Dragon, Hall, DragonHall, szinkronhangok, magyarhangok, ' />
        <link rel="stylesheet" type="text/css" href="/themes/DragonSTAR/styles.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flowplayer/7.2.7/skin/skin.min.css" />
        <!--link rel="stylesheet" type="text/css" href="/nezdplusz/node_modules/flowplayer/dist/skin/skin.min.css" /-->

        <link rel="shortcut icon" type="image/gif" href="/images/favicon.gif" />

        <!-- FaceBook sh!t -->
        <meta property="og:title" content="{$category.title}" />
        <meta property="og:type"  content="article" />
        <meta property="og:url" content="https://dragonhall.hu/nezdplusz/download.php?catid={$category.cat_id}" />
        <meta property="og:image:url" content="{$category.cover}" />
        <meta property="og:image:secure_url" content="{$category.cover}" />
        <meta property="og:image:type" content="{$category.cover_image_type}" />
        <meta property="og:image:width" content="{$category.cover_width}" />
        <meta property="og:image:height" content="{$category.cover_height}" />
        <meta property="og:description" content="{$category.title} - Csak a DragonHall+ oldalán! Készítette: {$category.copy}" />
        <meta property="article:publisher" content="https://www.facebook.com/dragonhall.hu/" />
        <meta property="article:author" content="{$category.copy}" />


        <!-- Twitter sh!t -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@dragonhallplus" />
        <meta name="twitter:url" content="https://dragonhall.hu/nezdplusz/download.php?catid={$category.cat_id}" />
        <meta name="twitter:title" content="{$category.title}" />
        <meta name="twitter:description" content="{$category.title} - Csak a DragonHall+ oldalán! Készítette: {$category.copy}" />
        <meta name="twitter:image" content="{$category.cover}" />

        <style>
            .flowplayer .fp-captions p {
                font-size: 1.8em;
            }


            body > table {
                width: 960px;
				margin: 5px auto;
            }

            .header {
                background: url(assets/nezd+player.png); 
                height: 92px; 
                margin: 0 auto 10px auto;
            }

            .grid {
                margin: 10px 15px;
                display: grid;
                grid-template-columns: 310px 310px 310px;
                text-align: center;
            }


            .play-small {
                opacity: 0;

                transition: .5s ease;
                transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                position: absolute; 
                top: 50%;
                left: 50%;
                text-align: center;
            }

            .gridlink {
                display: block;
            }
            .gridlink:hover {
                color: lightblue;
            }

            .gridlink:hover .play-small {
                opacity: 1;
            }

            figure.episode {
                display: block;
                margin: 5px 6px;
                border: 1px solid #000;
                border-radius: 5px;
            }

            figure.episode > img {
                border-top-left-radius: 5px;
                border-top-right-radius: 5px;
            }

            .cover {
                position: relative;
                display: block;
            }
            figcaption {
                font-weight: bold;
                padding: 10px; 0;
            }
            ins.adsbygoogle {
                display: inline-block;
            }
            .header > ins.adsbygoogle {
                width: 600px;
                height: 74px;
                margin-left: 356px;
                margin-top: 9px;

            }
        </style>
    </head>
    <body>
        <table cellpadding="0" cellspacing="0" width="99%">
            <tbody>
                <tr>
                    <td class="capmain">{$breadcrumb}</td>
                </tr>
                <tr>
                    <td class="main" style="padding: 5px;">
                        <!--div style="color: white; background: red; margin: 5px 10px; padding: 5px; font-weight: bold; font-size: 10pt; text-align: center;">Kisérleti verzió</div-->
                        <div class="header">
                            <!-- Google Ads -->
                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- Dragonhall2 -->
                            <ins class="adsbygoogle"
                                data-ad-client="ca-pub-0561270397040036"
                                data-ad-slot="8128789862"></ins>
                            <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                        </div>

						<div class="grid">
                            {foreach from=$downloads item=download}
                                <a href="https://dragonhall.hu/nezdplusz/player.php?did={$download.id}" target="_blank" class="gridlink">
                                    <figure class="episode">
                                        <div class="cover">
                                            <img src="{$download.cover}" alt="{$download.title}" style="width: 100%;" />
                                            <img src="assets/play-small.png" class="play-small" />
                                        </div>
                                        <figcaption>{$download.title}</figcaption>
                                    </figure>
                                </a>
                            {/foreach}
						</div>
                    </td>
                </tr>
            </tbody>
        </table>

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <!--script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flowplayer/7.2.7/flowplayer.min.js"></script-->
        <script>
        $(function() {
            $('a.gridlink').on('click', function(e) {
                e.preventDefault();

                alert("Ez a videó a DragonHall+ tulajdonát képezi, engedély nélkül nem oszthatod meg vagy játszhatod le más oldalakon!\nA továbblépéshez kattints az OK gombra!");
                window.open(this.href, "player_win", "height=625,width=800,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,toolbar=no");
            });
        });
        </script>
        {include file='_ga.tpl'}

    </body>
</html>
