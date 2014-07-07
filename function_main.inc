<?php
/* Funktion: Connect_to_db
* Zweck:	Stellt die Verbindung zur MySQL-Datenbank her.
*		Der Funktion wird der Name einer Datei mit den
*		Datenbankvariablen übergeben.
*/
function Connect_to_db($filename)
{
	include($filename);
	$connection = mysqli_connect($host,$user,$password)
		or die ("Keine Verbindung zum Server.");
	$db = mysqli_select_db($connection,$database)
		or die ("Datenbank nicht verf&uuml;gbar.");
	return $connection;
}
?>
