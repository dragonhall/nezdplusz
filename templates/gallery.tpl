<!DOCTYPE html>
<html lang="hu" xml:lang="hu">
<head>
        <title>DH+ VIP Galéria</title>
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


    <style>

        body > table {
            width: 960px;
            margin: 5px auto;
        }

        .header {
            background: url(assets/vip_galeriak.png);
            height: 92px;
            margin: 0 auto 10px auto;
        }

        .grid {
            margin: 10px 15px;
            display: grid;
            grid-template-columns: 310px 310px 310px;
            text-align: center;
        }


        .gridlink {
            display: block;
        }

        .gridlink:hover {
            color: lightblue;
        }

        figure.episode {
            display: block;
            height: 430px;
            margin: 5px 6px;
            border: 1px solid #000;
            border-radius: 5px;
            position: relative;
        }

        /*figure.episode > img {
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            position: absolute;
        }*/

        .cover {
            position: relative;
            display: block;
            vertical-align: middle;
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


        .pagination {
            text-align: center;
            font-size: 1.5em;
        }
        .pagination ul,
        .pagination ul li {
            display: inline-block;
            padding-left: 10px;
        }

        .pagination ul li a,
        .pagination ul li strong {
            color: #2e526e;
        }

        .pagination ul li a:hover,
        .pagination ul li a:active {
            color: #598fb9;
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

    </style>
</head>
<body>
<nav class="floating-sidebar">
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
        <td class="capmain">DragonHall+ VIP képgaléria</td>
    </tr>
    <tr>
        <td class="main" style="padding: 5px;">
            <div style="color: white; background: red; margin: 5px 10px; padding: 5px; font-weight: bold; font-size: 10pt; text-align: center;">Kisérleti verzió</div>
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

            {include file='_paginator.tpl'}
            <div class="grid">
                {foreach from=$album item=image}
                    <a href="https://dragonhall.hu/nezdplusz/gallery.php?iid={$image.photo_id}" target="_blank"
                       class="gridlink">
                        <figure class="episode">
                            <div class="cover">
                                <img src="{$image.photo_thumb2}" alt="{$image.title}" style="width: 100%;"/>
                            </div>
                            <figcaption>{$image.title}</figcaption>
                        </figure>
                    </a>
                {/foreach}
            </div>
            {include file='_paginator.tpl'}
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
            //window.open(this.href, "player_win", "height=625,width=800,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,toolbar=no");
        });
    });
</script>
{include file='_ga.tpl'}

</body>
</html>
