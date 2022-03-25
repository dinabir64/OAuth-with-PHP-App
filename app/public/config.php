<?php
//config.php
//Include Google Client Library for PHP autoload file
require_once '../vendor/autoload.php';

$google_client = new Google_Client();

$google_client->setClientId('996169484802-2ppi40quk41umumotlbfdda66qkp2uqk.apps.googleusercontent.com');
$google_client->setClientSecret('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');
$google_client->setRedirectUri('http://127.0.0.1/index.php');

//scopes that this will allow
$google_client->addScope('email');
$google_client->addScope('profile');

//start session on web page
session_start();
?>