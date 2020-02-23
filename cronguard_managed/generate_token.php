<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Generate Token</title> 
<meta name="viewport" content="width=device-width; initial-scale=1.0"> 
</head> 
<body> 
<?php
require_once('navigation.php');
echo "<div id=\"nav\"></div>";
?>
<div id="content">
<h2>Generate a Token</h2>
Here you can generate a token, type a valid email address into the form below and a token will be generated.<br />
Take that token and put it into a file named tocken.inc.sh and place that file in the directory /opt/cronguard.<br />
What you can do as well is  download a template with no value from the download section and put your<br />
generated token there - <strong>important</strong> is that you move that file to /opt/cronguard because<br />
the cron_wrapper.sh expects it there.<br />
<br />
<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
Email address <input type="text" name="email" /><br /><br />
<input type="submit" name="submit" value="Send email address" />
</form>
<br />
<?php
if(isset($_POST['submit'])){
    include "class/generatetoken.class.php";
    include "inc/mail.inc.php";
    if (!empty($_POST['email'])){
        $email = $_POST['email'];
    } else {
        echo "No email address provided, aborting";
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
                    echo "Email: $email is valid and a new database entry was created" . "<br />";
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
        echo "Email: $email already exist!";
    }
}
?>
</body>
</html>
