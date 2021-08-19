<!DOCTYPE html>
<html lang="hu" xml:lang="hu">
<head>
    <title>{$category.title} &mdash; NÉZD+ Player</title>
    <meta charset="utf8"/>
    <meta name="description"
          content="Egy hely, ahol a régebbi mesék legalább olyan fontosak, mint az újak. Ahol szinkronos és feliratos anime egyenértékû, és jól megférnek egymással. Ahol csakis a minõség a fontos, és nem csak a mennyiség! Mi garanciát vállalunk az igényességre! Tarts velünk és ismertesd meg másokkal is az álmunkat! Hisz csak együtt sikerülhet! DragonHall+ | Már nem csak álom az igényesség!"/>
    <meta name='keywords'
          content='anime, manga, rajzfilm, szinkron, DH, Dragon, Hall, DragonHall, szinkronhangok, magyarhangok, '/>
    <link rel="stylesheet" type="text/css" href="/themes/DragonSTAR/styles.css" media="screen"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/flowplayer/7.2.7/skin/skin.min.css"/>
    <!--link rel="stylesheet" type="text/css" href="/nezdplusz/node_modules/flowplayer/dist/skin/skin.min.css" /-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
          integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <link rel="shortcut icon" type="image/gif" href="/images/favicon.gif"/>

    <!-- FaceBook sh!t -->
    <meta property="og:title" content="{$category.title}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="https://dragonhall.hu/nezdplusz/download.php?catid={$category.cat_id}"/>
    <meta property="og:image:url" content="{$category.cover}"/>
    <meta property="og:image:secure_url" content="{$category.cover}"/>
    <meta property="og:image:type" content="{$category.cover_image_type}"/>
    <meta property="og:image:width" content="{$category.cover_width}"/>
    <meta property="og:image:height" content="{$category.cover_height}"/>
    <meta property="og:description"
          content="{$category.title} - Csak a DragonHall+ oldalán! Készítette: {$category.copy}"/>
    <meta property="article:publisher" content="https://www.facebook.com/dragonhall.hu/"/>
    <meta property="article:author" content="{$category.copy}"/>


    <!-- Twitter sh!t -->
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="@dragonhallplus"/>
    <meta name="twitter:url" content="https://dragonhall.hu/nezdplusz/download.php?catid={$category.cat_id}"/>
    <meta name="twitter:title" content="{$category.title}"/>
    <meta name="twitter:description"
          content="{$category.title} - Csak a DragonHall+ oldalán! Készítette: {$category.copy}"/>
    <meta name="twitter:image" content="{$category.cover}"/>

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
            position: relative;
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
            padding: 10px;
            0;
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

        .d-block {
            display: block;
        }

        .floating-sidebar {
            position: fixed;
            top: 50%;
            left: 0;
        }

        .icon-menu {
            font-size: 2em;
            width: 24px;
        }

        .floating-sidebar > .d-block {
            background-image: url('/themes/DragonSTAR/images/menupic.png');
            padding: 4px;
        }

        .rotated-left-90 {
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            transform: rotate(-90deg);
            -webkit-transform-origin: left top 0;
            -moz-transform-origin: left top 0;
            -ms-transform-origin: left top 0;
            -o-transform-origin: left top 0;
            transform-origin: left top 0;
        }

        .new-ribbon {
            width: 25px;
            height: 25px;
            position: absolute;
            bottom: -10px;
            right: -10px;
            overflow: hidden;
        }
        .new-ribbon::before,
        .new-ribbon::after {
            border: 5px solid #2980b9; /* width of curl */
            border-bottom-color: transparent;
            border-right-color: transparent;
            position: absolute;
            display: block;
            content: '';
            /** z-index: -1; */
        }
        .new-ribbon::before {
            bottom: 0;
            left: 0;
        }

        .new-ribbon::after {
            top: -5px;
            right: 0;
            z-index: 0;
        }
        .new-ribbon > span {
          width: 35px;
          height: 8px;
          background-color: #3498db;
          box-shadow: 0 5px 10px rgba(0,0,0,.1);
          color: #fff;
          font-weight: bold;
          font-size: 6pt;
          padding-top: 2px;
          line-height: 1;
          font-family: sans-serif;

          text-shadow: 0 1px 1px rgba(0,0,0,.2);
          text-transform: uppercase;
          text-align: center;

          transform: rotate(-45deg);

          position: absolute;
          left: -5px;
          bottom: 6px;
        }
    </style>
</head>
<body>
<nav class="floating-sidebar">
    {if !$vip}
    <a href="http://dragonhall.hu/infusions/pro_download_panel/download.php?catid={($category.top_cat == 0) ? $category.cat_id : $category.top_cat}"
       target="_blank" class="d-block rotated-left-90"
       style="font-size: 1.5em; font-weight: bold; padding: 6px; background: #2E5570; color: white">Még több ilyet!</a>
    {/if}
    <span class="d-block icon-menu" style="padding-top: 6px;">
                <a class="dh-icon" href="http://dragonhall.hu" target="_blank" title="DragonHall+ főoldal">
                    <img src="/themes/DragonSTAR/images/arrow_off.png" style="width: 24px; height: 24px;"/>
                </a>
            </span>
    <a class="d-block icon-menu" href="https://www.facebook.com/dragonhall.hu/" target="_blank" title="DragonHall+ a Facebookon">
        <i class="fab fa-facebook" style="color: white;"></i>
    </a>
    <a class="d-block icon-menu" href="https://twitter.com/dragonhallplus" title="DragonHall+ a Twitteren" target="_blank">
        <i class="fab fa-twitter" style="color: white;"></i>
    </a>
    <a class="d-block icon-menu" href="https://www.youtube.com/user/DragonHallPlusz" target="_blank" title="DragonHall+ a YouTube-on">
        <i class="fab fa-youtube" style="color: white;"></i>
    </a>
</nav>

<table cellpadding="0" cellspacing="0" width="99%">
    <tbody>
    <tr>
        <td class="capmain">{$breadcrumb}</td>
    </tr>
    <tr>
        <td class="main" style="padding: 5px;">
            <!--div style="color: white; background: red; margin: 5px 10px; padding: 5px; font-weight: bold; font-size: 10pt; text-align: center;">Kisérleti verzió</div-->
            <div class="header"
            {if $vip_category}
                style="background-image: url(assets/vip_videotar.png);"
            {/if}
            >
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
                    <a href="https://dragonhall.hu/nezdplusz/player.php?did={$download.id}" target="_blank"
                       class="gridlink">
                        <figure class="episode">
                            <div class="cover">
                                <img src="{$download.cover}" alt="{$download.title}" style="width: 100%;"/>
                                <img src="assets/play-small.png" class="play-small"/>
                            </div>
                            <figcaption>{$download.title}</figcaption>
                            {if $download.is_new}
                                <div class="new-ribbon"><span class="text">új</span></div>
                            {/if}
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
    $(function () {
        $('a.gridlink').on('click', function (e) {
            e.preventDefault();

            alert("Ez a videó a DragonHall+ tulajdonát képezi, engedély nélkül nem oszthatod meg vagy játszhatod le más oldalakon!\nA továbblépéshez kattints az OK gombra!");
            window.open(this.href, "player_win", "height=625,width=800,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,toolbar=no");
        });
    });
</script>
{include file='_ga.tpl'}

</body>
</html>
