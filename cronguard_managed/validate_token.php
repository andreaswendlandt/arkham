<!DOCTYPE html> 
<html lang="en"> 
  <head> 
    <link rel="apple-touch-icon" sizes="57x57" href="fav/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="fav/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="fav/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="fav/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="fav/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="fav/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="fav/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="fav/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="fav/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="fav/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="fav/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="fav/favicon-16x16.png">
    <link rel="manifest" href="fav/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="fav/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
    <script
      src="https://code.jquery.com/jquery-3.1.1.min.js"
      integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
      crossorigin="anonymous"></script>
    <script src="semantic/dist/semantic.min.js"></script>
    <title>Validate Token</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
  </head> 
  <body> 
    <div class="ui inverted segment">
      <div class="ui inverted secondary six item menu">
        <a class="item" href="index.php">Home</a>
        <a class="item" href="generate_token.php">Generate Token</a>
        <a class="active item" href="validate_token.php">Validate Token</a>
        <a class="item" href="download_section.php">Download Section</a>
        <a class="item" href="remove_token_mail.php">Remove Token</a>
        <a class="item" href="forgot_token.php">Forgot Token</a>
      </div>
    </div>
    <div class="ui container">
      <div class="ui clearing segment">
        <h2 class="ui left floated header">Validate a Token</h2>
      </div>
    <h4 class="ui top attached blue inverted header">What will be done here</h4>
    <div class="ui segment">
      Here you can validate a token(just in case you are not sure if your token is valid what means it exists in the database), enter your token into the form below and it will return the result, in case your token is valid you can use it as described(put the token into the file token.inc.sh, place that file in /opt/cronguard/ and run your cronjobs with the cron_wrapper.sh). If your token is not valid you have two options, either you go to the <a href="https://cronguard.ddns.net/forgot_token.php">Forgot Token</a> page, enter your email address and your token will be sent to you, or you create a new one at the <a href="https://cronguard.ddns.net/generate_token.php">Generate Token</a> page.
    </div>
    <form class="ui form" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
      <div class="fields">
        <div class="eight wide field">
          <label>Token</label>
          <input type="text" name="token" placeholder="Token">
        </div>
      </div>
      <button class="ui labeled icon blue button" type="submit" name="submit"><i class="paper plane icon"></i>Submit</button>
    </form
    <br />
    <br />
    <?php
    if(isset($_POST['submit'])){
        include "class/validatetoken.class.php";
        if (!empty($_POST['token'])){
            $token = $_POST['token'];
        } else {
            echo "No token provided, aborting";
            exit();
        }
        $token_to_check = new ValidateToken($token);
        $bool = $token_to_check->{'check_token'}();
        if ($bool){
            echo "Token: $token is valid";
        } else {
            echo "Token: $token is not valid";
        }
    }
    ?>
    </div>
  </body>
</html>
