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
<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
Token <input type="text" name="token" /><br /><br />
<input type="submit" name="submit" value="Send Token" />
</form>
<br />
<?php
if(isset($_POST['submit'])){
    include "validatetoken.class.php";
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
