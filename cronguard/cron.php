 <?php
$servername = "localhost";
$username = "cronguard";
$password = "egal";
$dbname = "cronguard";


if (isset($_POST['action'])) {
    $action = $_POST['action'];
}
else {
    die("Something went wrong with the data transmission\n");
}
echo "$action\n";

if ($action == 'start') {
    if (isset($_POST['token']) && isset($_POST['host']) && isset($_POST['start_time']) && isset($_POST['command'])) {
        $token = $_POST['token'];
        $host = $_POST['host'];
        $start_time = $_POST['start_time'];
        $command = $_POST['command'];
    }
    else {  
        die("no data retrieved\n");
    }
    $sql = "INSERT INTO jobs_new (token, host, start_time, command, action)
    VALUES ('$token', '$host', '$start_time', '$command', '$action')";
//echo "$token\n";
//echo "$host\n";
}
elseif ($action == "finished") {
    if (isset($_POST['token']) && isset($_POST['end_time']) && isset($_POST['result'])) {
        $token = $_POST['token'];
        $end_time = $_POST['end_time'];
        $result = $_POST['result'];
    }
    else {
        die("no data retrieved\n");
    }
    $sql = "UPDATE jobs_new SET end_time='$end_time', action='$action', result='$result' WHERE token='$token'";
}
else {
    die("something messed up");
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

#$sql = "INSERT INTO jobs_new (token, host, start_time, command, action)
#VALUES ('$token', '$host', '$start_time', '$command', '$action')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 
