<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<title>G&auml;stebuch</title>
</head>
<body>
<h1>Mein G&auml;stebuch</h1>
<?php
//Datei mit den Zugangsdaten einbinden
include("credentials.php");
//Abfrage auf welcher Seite man ist
$site = $_GET["site"]; 
//Wenn keine Seite angegeben ist, landet man automatisch auf Seite 1
if(!isset($site))
   {
   $site = 1;
   }
//Verbindung zur Datenbank aufbauen
$conn = mysql_connect("$host", "$user")
   or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
//Datenbank auswählen
mysql_select_db("$database") 
   or die ("Die Datenbank existiert nicht");
//Einträge pro Seite, danach werden nummerische Links erzeugt
$eintraege_pro_seite = 5;
//Berechnen welche Spalte zuerst dargestellt wird und dementsprechend in der Variablen $start speichern
$start = $site * $eintraege_pro_seite - $eintraege_pro_seite;
//Datenbankabfrage korrespondierend zur Seitenauswahl durchführen und Ergebnis darstellen
$query = "SELECT * FROM gaestebuch ORDER BY id DESC LIMIT $start, $eintraege_pro_seite";
$result = mysql_query($query);
while($row = mysql_fetch_object($result))
   {
   $content = $row->inhalt;
   $date = date("d.m.Y H:i", $row->datum);
   $entry_number = $row->id;
//der Name soll als Link mit der Email Adresse dargestellt werden, d.h. es wird beim Betätigen des Links automatisch 
//das präferierte Email Programm gestartet mit der Email Adresse des Verfassers des Eintrages als Adressat
   $name = "<a href=\"mailto:$row->email\">$row->name</a>";
   echo "<table align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"5\" bgcolor=\"#000000\" width=\"50%\">";
   echo "<tr bgcolor=\"#ffffff\">";
   echo "<td>";
   echo "Von <b>$name</b> am $date Eintrag Nummer: $entry_number";
   echo "</td>";
   echo "</tr>";
   echo "<tr bgcolor=\"#ffffff\">";
   echo "<td>";
   echo "$content";
   echo "</td>";
   echo "</tr>";
   echo "</table><br>";
   }
//Zum Schluß noch Berechnen wieviele Seitenlinks benötigt werden und diese dann auch generieren und darstellen
//Wieviele Einträge gibt es
$result = mysql_query("SELECT id FROM gaestebuch");
$amount = mysql_num_rows($result);
//Berechnen wieviele Seiten es geben wird
$number_of_pages = $amount / $eintraege_pro_seite;
//Darstellen der Links
echo "<div align='center'>";
echo "<b>Seite:</b> ";
for($a=0; $a < $number_of_pages; $a++)
   {
   $b = $a + 1;
   //Wenn man sich auf dieser Seite befindet dann nichts ausgeben...
   if($site == $b)
   {
      echo "  <b>$b</b> ";
      }
   //...andernfalls schon
   else
      {
      echo "  <a href='?site=$b'>$b</a> ";
      }
   }
echo "</div>";
?> 
<p><a href="formular.html">Neuen Eintrag verfassen</a>
</body>
</html>
