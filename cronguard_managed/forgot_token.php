<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Validate Token</title> 
<meta name="viewport" content="width=device-width; initial-scale=1.0"> 
</head> 
<body> 
<?php
require_once('navigation.php');
echo "<div id=\"nav\"></div>";
?>
<div id="content">
<h2>Forgot Token</h2> 
<form method="post" action="forgottoken.php">
Email <input type="text" name="email" /><br /><br />
<input type="submit" name="Submit" value="Send email" />
</form>
</body>
</html>
