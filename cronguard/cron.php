 <?php
$servername = "localhost";
$username = "cronguard";
$password = "egal";
$dbname = "cronguard";

//echo "$_POST['token']\n";
//echo "$_POST['host']\n";

if (isset($_POST['token']) && isset($_POST['host'])) {
    $token = $_POST['token'];
    $host = $_POST['host'];    
}
else {  
    echo "no data retrieved\n";
}
echo "$token\n";
echo "$host\n";

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
