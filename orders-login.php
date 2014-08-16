 <?php
/* Datei: orders-login.php
 * Zweck: stellt eine Verbindung zur Datenbank her,
 *        prueft den usernamen und das passwort und
 *        gewaehrt dann Zugang zum geschuetzten Bereich
 */
include("Vars.inc");
session_start();
$conn = mysql_connect("$host", "$user", "$password")
	or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
mysql_select_db("$database") 
	or die ("Datenbank konnte nicht ausgewählt werden");
$username = $_POST["username"];
$password = md5($_POST["password"]);
$query = "SELECT username, password FROM login WHERE username LIKE '$username' LIMIT 1";
$result = mysql_query($query);
$row = mysql_fetch_object($result);
if($row->password == $password)
    {
    $_SESSION["username"] = $username;
    echo "Login erfolgreich. <br> <a href=\"Orders-oo.php\">Gesch&uuml;tzter Bereich</a>";
    }
else
    {
    echo "Benutzername und/oder Passwort waren falsch. Bitte versuchen Sie es erneut <a href=\"orders-login.html\">Login</a>";
    }
?> 
