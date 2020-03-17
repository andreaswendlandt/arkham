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
    <title>Remove Token</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
  </head>
  <body> 
    <div class="ui inverted segment">
      <div class="ui inverted secondary six item menu">
        <a class="item" href="index.php">Home</a>
        <a class="item" href="generate_token.php">Generate Token</a>
        <a class="item" href="validate_token.php">Validate Token</a>
        <a class="item" href="download_section.php">Download Section</a>
        <a class="active item" href="remove_token_mail.php">Remove Token</a>
        <a class="item" href="forgot_token.php">Forgot Token</a>
      </div>
    </div>
    <div class="ui container">
      <div class="ui clearing segment">
        <h2 class="ui left floated header">Remove your Token and Email address</h2>
      </div>
    <h4 class="ui top attached blue inverted header">What will be done here</h4>
    <div class="ui segment">
      Here you can remove your token and your email address by typing your token into the form, it will check if the token is a valid one and then remove the corresponding database entry (with the token and the email address). Keep in mind that there will be no further confirmation - if you press the `Submit` button your token/email address will be deleted. If you don't know your token anymore and want your token/email address deleted anyway - go to the <a href="https://cronguard.ddns.net/forgot_token.php">Forgot Token</a> page, let your token send to you and delete it afterwards here.
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
        include "class/removetokenmail.class.php";
        if (!empty($_POST['token'])){
            $token = $_POST['token'];
        } else {
            echo "Please provide a Token";
            exit();
        }
        $rem_token = new RemoveTokenMail($token);
        $token_valid = $rem_token->{'check_token'}();
        if ($token_valid){
            $bool = $rem_token->{'remove_from_database'}($token);
            if ($bool){
                echo "Token: $token removed";
            } else {
                echo "Could not remove token: $token, please contact the admin";
            }
        } else {
            echo "Token: $token does not exist";
        }
    }
    ?>
    </div>
  </body>
</html>
