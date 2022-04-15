<?php
//index.php
//Include Configuration File
include('config.php');

$login_button = '';

//this $_GET["code"] is received after a user has login into their Google Account (from redirct to PHP script)
if(isset($_GET["code"]))
{
    //either 1) state not in URL but code is, 2) no state set up in session, 3) state token doesn't match
    if(!isset($_GET['state']) || !isset($_SESSION['state']) || $_GET['state'] != $_SESSION['state']){
        header("Location: http://127.0.0.1/blocked.html"); 
        exit();
    }
    //attempt to exchange code for a valid authentication token.
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    //this condition checks if an error occured while geting authentication token
    if(!isset($token['error']))
    {
        $google_client->setAccessToken($token['access_token']); //set the access token used for requests
        $_SESSION['access_token'] = $token['access_token']; //store "access_token" value in $_SESSION variable for future use.

        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get(); //get user profile data from google

        //below you can get profile data and store it in $_SESSION variable
        if(!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }
        if(!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }
        if(!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }
        if(!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }
        if(!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}

if(isset($_GET['state']) && $_GET['state'] != $_SESSION['state']){
    header("Location: http://127.0.0.1/blocked.html"); 
    exit();
}

//if a user isn't logged in then it will display Google Login link
if(!isset($_SESSION['access_token'])) {
    //create a URL to obtain user authorization
    $state = bin2hex(random_bytes(128/8));
    $_SESSION['state'] = $state;
    $google_client->setState($state);
    $auth_url = $google_client->createAuthUrl();
    $login_button = '<a href="'.filter_var($auth_url, FILTER_SANITIZE_URL).'"><img src="sign-in-with-google.jpg" /></a>';
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>PHP Login using Google Account</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <br />
            <h2 align="center">PHP Login using Google Account</h2>
            <br />
            <div class="panel panel-default">
            <?php
            if($login_button == '')
            {
                echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
                echo '<img src="'.$_SESSION["user_image"].'" class="img-responsive img-circle img-thumbnail" />';
                echo '<h3><b>Name :</b> '.$_SESSION['user_first_name'].' '.$_SESSION['user_last_name'].'</h3>';
                echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
                echo '<h3><a href="logout.php">Logout</h3></div>';
            }
            else
            {
                echo '<div align="center">'.$login_button . '</div>';
            }
            ?>
            </div>
        </div>
    </body>
</html>
