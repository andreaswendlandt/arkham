<?php
session_start();
if(!isset($_SESSION["username"]))
{
   echo "Bitte erst <a href=\"orders-login.html\">einloggen</a>";
   exit();
}
else
{
	echo "logged in";
}
?>
