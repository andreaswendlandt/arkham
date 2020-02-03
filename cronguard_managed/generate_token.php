<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Cronguard</title> 
<meta name="viewport" content="width=device-width; initial-scale=1.0"> 
</head> 
<body> 
<?php
require_once('navigation.php');
echo "<div id=\"nav\"></div>";
?>
<div id="content">
<h2>Generate a Token</h2> 
<form method="post" action="generatetoken.php">
Email address <input type="text" name="email" /><br /><br />
<input type="submit" name="Submit" value="Send email address" />
</form>
</body>
</html>
