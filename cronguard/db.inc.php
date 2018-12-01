<?php
$conn = @(new mysqli("localhost", "cronguard", "secret", "cronguard"));
if ($conn->connect_error) {
  echo "Error while connecting: " . mysqli_connect_error() . "<hr />";
  exit();
}
?>
