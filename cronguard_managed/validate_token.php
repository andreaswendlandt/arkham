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
    <h4 class="ui top attached blue inverted header">What will be done here</h4>
    <div class="ui segment">
      Here you can validate a token(just in case you are not sure if your token is a valid one which means it does exist in the database), type in your token into the form below and it will check that and return the result, in case your token is valid you can use it like described(put the token into the token.inc.sh, move that file to /opt/cronguard/ and run your cronjobs with the cron_wrapper.sh). If your token is not valid you have two possibilities, either you go to the <a href="https://cronguard.ddns.net/forgot_token.php">Forgot Token</a> page, type in your email address and your token will be send to you, or you just create a new one at the <a href="https://cronguard.ddns.net/generate_token.php">Generate Token</a> page.
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
