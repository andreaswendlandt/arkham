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
    <title>Generate Token</title> 
    <meta name="viewport" content="width=device-width; initial-scale=1.0"> 
  </head> 
  <body> 
    <div class="ui six item menu">
      <a class="item" href="index.php">Home</a>
      <a class="active item" href="generate_token.php">Generate Token</a>
      <a class="item" href="validate_token.php">Validate Token</a>
      <a class="item" href="download_section.php">Download Section</a>
      <a class="item" href="remove_token_mail.php">Remove Token</a>
      <a class="item" href="forgot_token.php">Forgot Token</a>
    </div>
    <div class="ui container">
      <div class="ui clearing segment">
        <h2 class="ui left floated header">Generate a Token</h2>
      </div>
    <h4 class="ui top attached inverted header">What will be done here</h4>
    <div class="ui segment">
      Here you can generate a token, type a valid email address into the form below and a token will be generated. Take that token and put it into a file named tocken.inc.sh and place that file in the directory /opt/cronguard. What you can do as well is download a template with no value from the download site and put your generated token there - <strong>important</strong> is that you move that file to /opt/cronguard/ because the cron_wrapper.sh expects it there.
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
