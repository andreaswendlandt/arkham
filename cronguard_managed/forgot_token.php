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
    <title>Forgot Token</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
  </head>
  <body> 
    <div class="ui six item menu">
      <a class="item" href="index.php">Home</a>
      <a class=" item" href="generate_token.php">Generate Token</a>
      <a class="item" href="validate_token.php">Validate Token</a>
      <a class="item" href="download_section.php">Download Section</a>
      <a class="item" href="remove_token_mail.php">Remove Token</a>
      <a class="active item" href="forgot_token.php">Forgot Token</a>
    </div>
    <div class="ui container">
      <div class="ui clearing segment">
        <h2 class="ui left floated header">Forgot Token</h2>
      </div>
    <h4 class="ui top attached inverted header">What will be done here</h4>
    <div class="ui segment">
      Here you can let the application send your token to you in case you forgot or lost it. Just type in your mailaddress and the token will       send to you - provided that your mailaddress is associated to a token.
    </div>
    <form class="ui form" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
      <div class="fields">
        <div class="eight wide field">
          <label>Email</label>
          <input type="text" name="email" placeholder="Email">
        </div>
      </div>
      <button class="ui button" type="submit" name="submit">Submit</button>
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
            echo "The token for the emailaddress $email is \"$token\"" . "<br />";
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
