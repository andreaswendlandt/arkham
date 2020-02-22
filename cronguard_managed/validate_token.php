<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Validate Token</title> 
<meta name="viewport" content="width=device-width; initial-scale=1.0"> 
</head> 
<body> 
<?php
require_once('navigation.php');
echo "<div id=\"nav\"></div>";
?>
<div id="content">
<h2>Validate a Token</h2> 
Here you can validate a token, type your token into the form below and it will check if your token is a valid one<br />
and finally return the result, in case your token is valid you can write with that token as kind of an authentication<br />
to the database - in the way of running the cron_wrapper.sh script with the include file<br />
'token.inc.sh'(where the token is in). If your token is not valid you have two choices, either you go to the<br />
<a href="http://cronguard.ddns.net/forgot_token.php">Forgot Token</a> site, type in your mail and your token will be send to you via mail<br />
or you just create a new one at the 'generate token' page.<br />
<br />
<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
Token <input type="text" name="token" /><br /><br />
<input type="submit" name="submit" value="Send Token" />
</form>
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
</body>
</html>
