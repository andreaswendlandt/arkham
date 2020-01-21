<?php
$conn = @(new mysqli("localhost", "cronguard", "egal", "cronguard"));
if ($conn->connect_error) {
  echo "Error while connecting: " . mysqli_connect_error();
  exit();
}
?>
