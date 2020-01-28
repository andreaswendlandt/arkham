<?php
include "generatetoken.class.php";

$email = "foo@bar.de";
$gen_token = new GenerateToken($email);
$token = $gen_token->{'generate_token'}();
$bool = $gen_token->{'write_to_database'}($token, $email);
if ($bool){
    echo "entry created";
} else {
    echo "entry not created";
}
