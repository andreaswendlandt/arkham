<?php
include "generatetoken.class.php";

if (!empty($_POST['email'])){
    $email = $_POST['email'];
} else {
    echo "No email address provided, aborting";
    exit();
}

$gen_token = new GenerateToken($email);
$bool_val = $gen_token->{'validate_email'}($email);
if ($bool_val){
    $token = $gen_token->{'generate_token'}();
    $bool_gen = $gen_token->{'write_to_database'}($token, $email);
        if ($bool_gen){
            echo "email: $email is valid and a new database entry was created\n";
    	    echo "Your Token is: \"$token\"";
        } else {
            echo "Could not create a new database entry, please contact the admin";
        }
} else {
    echo "email: $email is not valid\n";
}
