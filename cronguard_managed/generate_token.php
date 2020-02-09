<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Cronguard</title> 
<meta name="viewport" content="width=device-width; initial-scale=1.0"> 
</head> 
<body> 
<?php
require_once('navigation.php');
echo "<div id=\"nav\"></div>";
?>
<div id="content">
<h2>Generate a Token</h2> 
<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
Email address <input type="text" name="email" /><br /><br />
<input type="submit" name="submit" value="Send email address" />
</form>
<br />
<?php
if(isset($_POST['submit'])){
    include "generatetoken.class.php";
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
                    echo "Email: $email is valid and a new database entry was created\n";
                    echo "Your Token is: \"$token\"";
                } else {
                    echo "Could not create a new database entry, please contact the admin";
                }
        } else {
            echo "Email: $email is not a valid email address\n";
        }
    } else {
        echo "Email: $email already exist!";
    }
}
?>
</body>
</html>
