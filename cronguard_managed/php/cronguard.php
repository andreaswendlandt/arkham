<?php
require ("inc/db.inc.php");
include "validatetoken.class.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}
else {
    die("Something went wrong with the data transmission\n");
}

if ($action == 'start') {
    if (isset($_POST['ident']) && isset($_POST['token']) && isset($_POST['host']) && isset($_POST['start_time']) && isset($_POST['command'])) {
        $ident = $_POST['ident'];
        $token = $_POST['token'];
        $host = $_POST['host'];
        $start_time = $_POST['start_time'];
        $command = $_POST['command'];
    }
    else {  
        die("no data retrieved\n");
    }
    $token_to_check_before = new ValidateToken($_POST['token']);
    var_dump($token_to_check_before);
    $bool_before = $token_to_check_before->{'check_token'}();
    var_dump($bool_before);
    if ($bool_before){
        $stmt = $conn->prepare("INSERT INTO job_test (ident, token, host, start_time, command, action)
        VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $ident, $token, $host, $start_time, $command, $action);
        if ($stmt->execute() === TRUE){
            echo "New record created successfully";
        }
        else {
            echo "Error with creating a new record";
        }
        $stmt->close();
    } else {
        echo "Your token is not valid, please create a new one!";
    }
}
elseif ($action == "finished") {
    if (isset($_POST['ident']) && isset($_POST['end_time']) && isset($_POST['result'])) {
        $ident = $_POST['ident'];
        $end_time = $_POST['end_time'];
        $result = $_POST['result'];
    }
    else {
        die("no data retrieved\n");
    }
    $token_to_check_after = new ValidateToken($_POST['token']);
    var_dump($token_to_check_after);
    $bool_after = $token_to_check_after->{'check_token'}();
    var_dump($bool_after);
    if ($bool_after){
        $stmt = $conn->prepare("UPDATE job_test SET end_time = ?, action = ?, result = ? WHERE ident = ?");
        $stmt->bind_param("isss", $end_time, $action, $result, $ident);
        if ($stmt->execute() === TRUE){
            echo "Record updated successfully";
        }
        else {
            echo "Error with updating the record";
        }
        $stmt->close();
    }
}
else {
    die("something messed up");
}

$conn->close();
