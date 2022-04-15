<?php
//config.php
//Include Google Client Library for PHP autoload file
require_once '../vendor/autoload.php';

//set up configs -- client id, secret, redirect uri, etc.
$google_client = new Google_Client();
$google_client->setAuthConfig('../client_secret.json');

//scopes that user will authorize
$google_client->addScope('email');
$google_client->addScope('profile');

//start session on web page
if(session_id() == '')
    session_start();
?>
