<?php
/* Datei: orders-register.php
 * Zweck: stellt eine Verbindung zur Datenbank her, prueft ob alle Werte
 *        vorhanden sind sowie ob es den vorgeschlagenen username schon gibt und 
 *        legt den neuen Benutzer dann an
 */
include("Vars.inc");
$conn = mysql_connect("$host", "$user", "$password")
	or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
mysql_select_db("$database")
	or die ("Datenbank konnte nicht ausgewählt werden");
$username = $_POST["username"];
$passwort = $_POST["passwort"];
$passwort2 = $_POST["passwort2"];
if($passwort != $passwort2 OR $username == "" OR $passwort == "")
    {
    echo "Eingabefehler. Bitte alle Felder korrekt ausf&uuml;llen. <a href=\"orders-register.html\">Zur&uuml;ck</a>";
    exit();
    }
$passwort = md5($passwort);
$result = mysql_query("SELECT id FROM login WHERE username LIKE '$username'");
$amount = mysql_num_rows($result);

if($amount == 0)
    {
    $insert = "INSERT INTO login (username, password) VALUES ('$username', '$passwort')";
    $register = mysql_query($insert);

    if($register == true)
        {
        echo "Benutzername <b>$username</b> wurde erstellt. <a href=\"orders-login.html\">Login</a>";
        }
    else
        {
        echo "Fehler beim Speichern des Benutzernames. <a href=\"orders-register.html\">Zur&uuml;ck</a>";
        }


    }

else
    {
    echo "Benutzername schon vorhanden. W&auml;hlen Sie einen anderen. <a href=\"orders-register.html\">Zur&uumlck</a>";
    }
?> 
