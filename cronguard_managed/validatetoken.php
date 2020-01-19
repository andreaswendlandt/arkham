<?php
include "validatetoken.class.php";

if (isset ($_POST['token'])){
    $token_to_check = new ValidateToken($_POST['token']);
} else {
    echo "No token provided, aborting";
    exit();
}

$bool = $token_to_check->{'check_token'}();
if ($bool){
    echo "valid";
} else {
    echo "invalid";
}
