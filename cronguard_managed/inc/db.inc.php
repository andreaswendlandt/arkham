<?php
$conn = @(new mysqli("localhost", "user", "password", "database"));
if ($conn->connect_error) {
  echo "Error while connecting: " . mysqli_connect_error();
  exit();
}
