<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Remove Token</title> 
<meta name="viewport" content="width=device-width; initial-scale=1.0"> 
</head> 
<body> 
<?php
require_once('navigation.php');
echo "<div id=\"nav\"></div>";
?>
<div id="content">
<h2>Remove your Token and Mailaddress</h2>
<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
Token <input type="text" name="token" /><br /><br />
<input type="submit" name="submit" value="Send Token" />
</form>
<br />
<?php
if(isset($_POST['submit'])){
    include "class/removetokenmail.class.php";
    if (!empty($_POST['token'])){
        $token = $_POST['token'];
    } else {
        echo "No token provided, aborting!";
        exit();
    }
    $rem_token = new RemoveTokenMail($token);
    $token_valid = $rem_token->{'check_token'}();
    if ($token_valid){
        $bool = $rem_token->{'remove_from_database'}($token);
        if ($bool){
            echo "Token: $token removed\n";
        } else {
            echo "Could not remove token: $token\n";
        }
    } else {
        echo "Token: $token does not exist\n";
    }
}
?>
</body>
</html>
