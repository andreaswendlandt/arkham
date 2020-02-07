<?php
include "forgottoken.class.php";

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
