<?php
include "removetokenmail.class.php";

$token = "2cde7d";
$rem_token = new RemoveTokenMail($token);

$token_valid = $rem_token->{'check_token'}();

if ($token_valid){
    $bool = $rem_token->{'remove_from_database'}($token);
    if ($bool){
        echo "token:$token removed\n";
    } else {
        echo "could not remove token:$token\n";
    }
} else {
    echo "$token does not exist\n";
}
