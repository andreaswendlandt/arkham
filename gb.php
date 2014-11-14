<html>
<head>
<title>G&auml;stebuch</title>
</head>
<body>
<h1>Mein G&auml;stebuch</h1>
<?php
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
//Datenbankabfrage korrespondierend zur Seitenauswahl durchführen und rgebnis darstellen
$query = "SELECT * FROM gaestebuch ORDER BY id DESC LIMIT $start, $eintraege_pro_seite";
$result = mysql_query($query);
while($row = mysql_fetch_object($result))
   {
   $content = $row->inhalt;
   $date = date("d.m.Y H:i", $row->datum);
   $entry_number = $row->id;
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
//Jetzt kommt das "Inhaltsverzeichnis",
//sprich dort steht jetzt: Seite: 1 2 3 4 5
//Wieviele Einträge gibt es überhaupt
//Wichtig! Hier muss die gleiche Abfrage sein, wie bei der Ausgabe der Daten
//also der gleiche Text wie in der Variable $abfrage, blo&szlig; das hier das LIMIT fehlt
//Sonst funktioniert die Blätterfunktion nicht richtig,
//und hier kann nur 1 Feld abgefragt werden, also id
$result = mysql_query("SELECT id FROM gaestebuch");
$amount = mysql_num_rows($result);
//Errechnen wieviele Seiten es geben wird
$number_of_pages = $amount / $eintraege_pro_seite;
//Ausgabe der Seitenlinks:
echo "<div align=\"center\">";
echo "<b>Seite:</b> ";
//Ausgabe der Links zu den Seiten
for($a=0; $a < $number_of_pages; $a++)
   {
   $b = $a + 1;
   //Wenn der User sich auf dieser Seite befindet, keinen Link ausgeben
   if($site == $b)
   {
      echo "  <b>$b</b> ";
      }
   //Aus dieser Seite ist der User nicht, also einen Link ausgeben
   else
      {
      echo "  <a href=\"?site=$b\">$b</a> ";
      }
   }
echo "</div>";
?> 
<p><a href="formular.html">Neuen Eintrag verfassen</a>
</body>
</html>
