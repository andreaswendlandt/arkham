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
    <title>Generate Token</title> 
    <meta name="viewport" content="width=device-width; initial-scale=1.0"> 
  </head> 
  <body> 
    <div class="ui inverted segment">
      <div class="ui inverted secondary six item menu">
        <a class="item" href="index.php">Home</a>
        <a class="active item" href="generate_token.php">Generate Token</a>
        <a class="item" href="validate_token.php">Validate Token</a>
        <a class="item" href="download_section.php">Download Section</a>
        <a class="item" href="remove_token_mail.php">Remove Token</a>
        <a class="item" href="forgot_token.php">Forgot Token</a>
      </div>
    </div>
    <div class="ui container">
      <div class="ui clearing segment">
        <h2 class="ui left floated header">Generate a Token</h2>
      </div>
    <h4 class="ui top attached blue inverted header">What will be done here</h4>
    <div class="ui segment">
      Here you can generate a token, enter a valid email address into the form and a token will be generated. Take that token and put it into the file tocken.inc.sh and place that file in the directory /opt/cronguard. What you can do as well is download a template with no value from the download page <a href="https://cronguard.ddns.net/download_section.php">Download Section</a> and put your generated token there - <strong>important</strong> is that you place that file at /opt/cronguard/ because the cron_wrapper.sh expects it there.
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
        include "class/generatetoken.class.php";
        include "inc/mail.inc.php";
        if (!empty($_POST['email'])){
            $email = $_POST['email'];
        } else {
            echo "Please provide a valid email address";
            exit();
        }
        $gen_token = new GenerateToken($email);
        $bool_double = $gen_token->{'check_mail_doubling'}($email);
        if ($bool_double) {
            $bool_val = $gen_token->{'validate_email'}($email);
            if ($bool_val){
                $token = $gen_token->{'generate_token'}();
                $bool_gen = $gen_token->{'write_to_database'}($token, $email);
                    if ($bool_gen){
                        echo "Your Token is: \"$token\"" . "<br />";
                        $subject = "Your new token from cronguard";
                        $message = "Your token is: $token";
                        send_mail($email, $subject, $message);
                        echo "A mail has been sent to $email";
                    } else {
                        echo "Could not create a new database entry, please contact the admin";
                    }
            } else {
                echo "Email: $email is not a valid email address";
            }
        } else {
            echo "Email: $email already exist";
        }
    }
    ?>
    </div>
  </body>
</html>
