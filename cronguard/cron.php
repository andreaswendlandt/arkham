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

if (isset($_POST['token']) && isset($_POST['host']) && isset($_POST['start_time']) && isset($_POST['command'])) {
    $token = $_POST['token'];
    $host = $_POST['host'];
    $start_time = $_POST['start_time'];
    $command = $_POST['command'];
}
else {  
    die("no data retrieved\n");
}
//echo "$token\n";
//echo "$host\n";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO jobs (token, host)
VALUES ('$token', '$host')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 
