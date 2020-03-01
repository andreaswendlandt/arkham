<!DOCTYPE html> 
<html lang="en"> 
  <head> 
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
    <div class="ui six item menu">
      <a class="item" href="index.php">Home</a>
      <a class="item" href="generate_token.php">Generate Token</a>
      <a class="active item" href="validate_token.php">Validate Token</a>
      <a class="item" href="download_section.php">Download Section</a>
      <a class="item" href="remove_token_mail.php">Remove Token</a>
      <a class="item" href="forgot_token.php">Forgot Token</a>
    </div>
    <div class="ui container">
      <div class="ui clearing segment">
        <h2 class="ui left floated header">Validate a Token</h2>
      </div>
    <h4 class="ui top attached inverted header">What will be done here</h4>
    <div class="ui segment">
      Here you can validate a token, type your token into the form below and it will check if your token is a valid one and finally return          the result, in case your token is valid you can write with that token as kind of an authentication to the database - in the way of            running the cron_wrapper.sh script with the include file 'token.inc.sh'(where the token is in). If your token is not valid you have two       choices, either you go to the href="https://cronguard.ddns.net/forgot_token.php">Forgot Token</a> site, type in your mailaddress and           your token will be send to you, or you just create a new one at the 'generate token' page.
    </div>
    <form class="ui form" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
      <div class="fields">
        <div class="eight wide field">
          <label>Token</label>
          <input type="text" name="token" placeholder="Token">
        </div>
      </div>
      <button class="ui button" type="submit" name="submit">Submit</button>
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
