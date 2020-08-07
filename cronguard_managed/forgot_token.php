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
    <title>Forgot Token</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
  </head>
  <body> 
    <div class="ui inverted segment">
      <div class="ui inverted secondary six item menu">
        <a class="item" href="index.php">Home</a>
        <a class="item" href="generate_token.php">Generate Token</a>
        <a class="item" href="validate_token.php">Validate Token</a>
        <a class="item" href="download_section.php">Download Section</a>
        <a class="item" href="remove_token_mail.php">Remove Token</a>
        <a class="active item" href="forgot_token.php">Forgot Token</a>
      </div>
    </div>
    <div class="ui container">
      <div class="ui clearing segment">
        <h2 class="ui left floated header">Forgot Token</h2>
      </div>
    <h4 class="ui top attached blue inverted header">What will be done here</h4>
    <div class="ui segment">
      Here you can have the application send you your token if you have forgotten or lost it. Just enter your email address and the token will sent to you - provided that your email address is associated to a token.
    </div>
    <form class="ui form" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
      <div class="fields">
        <div class="eight wide field">
          <label>Email</label>
          <input type="text" name="email" placeholder="Email">
        </div>
      </div>
      <button class="ui labeled icon blue button" type="submit" name="submit"><i class="paper plane icon"></i>Submit</button>
    </form
    <br />
    <br />
    <?php
    if(isset($_POST['submit'])){
        include "class/forgottoken.class.php";
        include "inc/mail.inc.php";
        if (!empty($_POST['email'])){
            $email = $_POST['email'];
        } else {
            echo "Please provide a valid email address";
            exit();
        }
        $email_to_check = new ForgotToken($email);
        $bool = $email_to_check->{'check_email'}();
        if ($bool){
            $token = $email_to_check->{'return_token'}();
            echo "The token for the email address $email is \"$token\"" . "<br />";
            $subject = "Your token from cronguard";
            $message = "Your token is: $token";
            send_mail($email, $subject, $message);
            echo "A mail has been sent to $email";
        } else {
            echo "Email: $email does not exist on this system";
        }
    }
    ?>
   </div>
  </body>
</html>
