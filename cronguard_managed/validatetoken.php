<?php
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
