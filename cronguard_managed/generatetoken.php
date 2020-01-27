<?php
include "generatetoken.class.php";

$email = "foo@bar.de";
$token = substr(md5(mt_rand()), 0, 6);
$generate_token = new GenerateToken($email);

$bool = $generate_token->{'write_to_database'}($token, $email);
if ($bool){
    echo "entry created";
} else {
    echo "entry not created";
}
