<?php

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$captcha_secret = '6Ldwj7YqAAAAAKrNf2jEA3s9VaQrqvckCxcoyAbE';
$captcha_api = 'https://www.google.com/recaptcha/api/siteverify';

require __DIR__ . '/vendor/autoload.php';

function get_remote_ip()
{
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (array_key_exists('REMOTE_ADDR', $_SERVER)) {
        return $_SERVER['REMOTE_ADDR'];
    } elseif (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    return '';
}

function validate_recaptcha($data)
{
    try {
        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $options = [
        'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
        ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

      //print "API Response:" . PHP_EOL;
      //print_r($result);

        return json_decode($result);
    } catch (Exception $e) {
        return null;
    }
}

function rebuild_url($u)
{
    return $u['scheme'] . '://' . $u['host'] . $u['path'] . '?' . $u['query'];
}

if (isset($_POST['g-recaptcha-response'])) {
    $api_request = [
    'secret' => $captcha_secret,
    'response' => $_POST['g-recaptcha-response'],
    'remoteip' => get_remote_ip(),
    ];

  // print "API Request:" . PHP_EOL;
  // print_r($api_request);

    $api_result = validate_recaptcha($api_request);

    if ($api_result->success && isset($_POST['jumpid'])) {
        $url = parse_url(base64_decode($_POST['jumpid'])); // we just hide the next url from the search engines, not from users
        $url['query'] .= '&rcts=' . urlencode(base64_encode($api_result->challenge_ts)); // The next hop may or may not validate this timestamp
        header('Location: ' . rebuild_url($url));
    } else {
      //print ($api_result->success ? "Captcha OK" : "Captcha not OK");
        print_r($api_result);
        print "Captcha success (ezt nem kéne látnod, irj nekünk az info@dragonhall.hu -ra, és jelöld meg, melyik filmet próbáltad megnézni/letölteni. Köszi!)";
    }
    exit;
}
?>
<html>
<head>
<title>Google Recaptcha teszt oldal</title>
</head>
<body>
  <form method="POST" id="copyright-form" action="<?php print $_SERVER['PHP_SELF']; ?>">
    <h1>Figyelmeztetés</h1>
    <p>A következő tartalom a DragonHall+ tulajdonát képezi, engedély nélkül nem oszthatod meg vagy játszhatod le más oldalakon!</p>
    <p>A továbblépéshez kattints az OK gombra</p>
    <input type="hidden" id="jumpid" name="jumpid" value="<?php print base64_encode($_SERVER['HTTP_REFERER']); ?>" /><!-- hopp-hopp: <?php print $_SERVER['HTTP_REFERER'] ?> -->
    <button class="g-recaptcha" 
        data-sitekey="6Ldwj7YqAAAAAE60NaD8xWA1UZnvqSJ8MwDKwRSI" 
        data-callback='onSubmit' 
        data-action='submit'>OK</button>
  </form>
  <div style="width: 1px; height: 1px; left: -999999px"> <audio src='https://dragonhall.hu/index_elemei/hangeffektek/figyucsak_letoltes.mp3' id='figyucsak' preload='auto'></audio></div>
  <script src="https://www.google.com/recaptcha/api.js"></script>
  <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", (event) => {
      document.getElementById("figyucsak").play();
    });

    function onSubmit(token) {
      document.getElementById("copyright-form").submit();
    }
  </script>
</body>
