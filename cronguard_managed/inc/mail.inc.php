<?php
function send_mail($email, $subject, $message){
    $to = "$email";
    $sub = "message from cronguard";
    $msg = "$message";
    $headers = "From: cronguard";
    mail($to, $sub, $msg, $headers);
}
