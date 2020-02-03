<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Remove Token</title> 
<meta name="viewport" content="width=device-width; initial-scale=1.0"> 
</head> 
<body> 
<?php
require_once('navigation.php');
echo "<div id=\"nav\"></div>";
?>
<div id="content">
<h2>Remove your Token and Mailaddress</h2>
<form method="post" action="removetokenmail.php">
Token <input type="text" name="token" /><br /><br />
<input type="submit" name="Submit" value="Send Token" />
</form>
</body>
</html>
