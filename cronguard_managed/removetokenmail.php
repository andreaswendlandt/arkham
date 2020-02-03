<?php
include "removetokenmail.class.php";

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
