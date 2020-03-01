<?php
require_once ("inc/db.inc.php");
include "validatetoken.class.php";

function usage(){
    echo "Call this api as follows:";
    echo "<br>";
    echo "https://cronguard.ddns.net/cronguard_api.php?method=api&token=`your_token`";
}

function api($token) {
    global $conn;
    $sql = "SELECT * FROM job_test WHERE token = \"$token\"";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $cronjobs = array();
        while($row = $result->fetch_assoc()) {
            $cronjobs[] = $row;
        } 
    header('Content-Type: application/json');
    echo json_encode($cronjobs, JSON_PRETTY_PRINT);
    }
    else {
        echo "0 Results";
    }
    exit();
}

if (isset ($_GET['method'])) {
    $method = $_GET['method'];
    if (isset ($_GET['token'])) {
        $token = $_GET['token'];
	$token_to_check = new ValidateToken($token);
	$bool = $token_to_check->{'check_token'}();
	if (!$bool) {
	    echo "Error, your token is not valid";
	    echo "<br>";
	    exit();
	}
    }
    else {
        echo "ERROR, you need to provide a token!";
	echo "<br>";
	usage();
	exit();
    }
    if ("$method" == "api") {
        api($token);
    }
    else {
        echo "Invalid Argument ($method), use api<br>";
	usage();
	exit();
    }
}

if (empty($_POST)) {
    echo "You need to provide a method and a valid token";
    echo "<br>";
    usage();
    exit();
}
