<?php
require_once ("db.inc.php");

$sql = "SELECT * FROM job_foo";
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
    echo "0 results";
}

$conn->close();
?>
