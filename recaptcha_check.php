<?php

$jumpback = $_SERVER['HTTP_REFERER'];

// If no referer (?), we drop to the main page.
if (!isset($jumpback) || empty($jumpback)) {
    $jumpback = '/news.php';
}

// If the challenge response (the recaptcha date) is not set, JS will handle the redirect to keep referer
if (isset($_GET['rcts'])) {
  // Is this a valid datetime?
    $challenge = base64_decode(urldecode($_GET['rcts']));
    $challenge_check = date_parse($challenge);
    if ($challenge_check['error_count'] > 0) {
        header('Location: ' . $jumpback);
        exit;
    }

  // Calculate the age of the challenge to prevent reusing old rcts tokens (older than 10 mins)
  // reCaptcha tokens are valid for 10 mins in theory, so we hardcode this limit too
    if (time() - strtotime($challenge) > 600) {
        header('Location: ' . $jumpback);
        exit;
    }
}
