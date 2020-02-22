<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Forgot Token</title> 
<meta name="viewport" content="width=device-width; initial-scale=1.0"> 
</head> 
<body> 
<?php
require_once('navigation.php');
echo "<div id=\"nav\"></div>";
?>
<div id="content">
<h2>Forgot Token</h2> 
Here you can let the application send your token to you in case you forgot or lost it.<br />
Just type in your mailaddress and the token will send to you - provided that your mailaddress is<br />
associated to a token.<br />
<br />
<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
Email <input type="text" name="email" /><br /><br />
<input type="submit" name="submit" value="Send email" />
</form>
<br />
<?php
if(isset($_POST['submit'])){
    include "class/forgottoken.class.php";
    if (!empty($_POST['email'])){
        $email = $_POST['email'];
    } else {
        echo "No emailaddress provided, aborting";
        exit();
    }
    $email_to_check = new ForgotToken($email);
    $bool = $email_to_check->{'check_email'}();
    if ($bool){
        $token = $email_to_check->{'return_token'}();
        echo "The token for the emailaddress $email is \"$token\"";
    } else {
        echo "Email: $email does not exist";
    }
}
?>
</body>
</html>
