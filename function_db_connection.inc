<?php
/* Datei: function_db_connection.inc
 * Zweck: Stellt die Verbindung zur MySQL-Datenbank her
 */
function Connect_to_db($credential_file)
{
	include($credential_file);
	$connection = mysqli_connect($host,$user,$password)
		or die ("Keine Verbindung zum Server.");
	$db = mysqli_select_db($connection,$database)
		or die ("Datenbank nicht verf&uuml;gbar.");
	return $connection;
}
?>
