<?php
$link = mysql_connect("localhost","root","egal") or die ("Keine Verbindung m&ouml;glich");
mysql_select_db("gb") or die ("Die Datenbank existiert nicht");

$name = $_POST["name"];
$email = $_POST["email"];
$inhalt = $_POST["inhalt"];
$inhalt = htmlentities($inhalt);
$datum = time();
//Wurden die benötigten Felder ausgefüllt?
if($name == "" OR $inhalt == "" OR $email == "")
    {
   echo "Bitte ALLE Felder ausf&uuml;llen<br> <a href=\"formular.html\">Zur&uuml;ck</a>";
   exit; //Script Ablauf wird unterbrochen, Eintrag wird nicht gespeichert
    }
//$inhalt = htmlentities($inhalt);
//echo "das wird eingetragen: $inhalt";
//exit;

$eintrag = "INSERT INTO gaestebuch (datum, name, email, inhalt) VALUES ('$datum', '$name', '$email', '$inhalt')";
$eintragen = mysql_query($eintrag);

//Wurde der Eintrag erfolgreich gespeichert?
if($eintragen == true)
   {
   echo "Beitrag erfolgreich gespeichert. ";
   }
else
   {
   echo "Fehler beim Speichern";
   }

echo "<br> <a href=\"gb.php\">Zur&uuml;ck</a>";
?> 
