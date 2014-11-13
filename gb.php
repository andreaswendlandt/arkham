<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Gaestebuch</title>
</head>
<body>
<h1>Mein G&auml;stebuch</h1>

<?php
$seite = $_GET["seite"];  //Abfrage auf welcher Seite man ist

//Wenn man keine Seite angegeben hat, ist man automatisch auf Seite 1
if(!isset($seite))
   {
   $seite = 1;
   }

//Verbindung zu Datenbank aufbauen

$link = mysql_connect("localhost","root","egal") or die ("Keine Verbindung moeglich");
mysql_select_db("gb") or die ("Die Datenbank existiert nicht");


//Einträge pro Seite: Hier 15 pro Seite
$eintraege_pro_seite = 5;

//Ausrechen welche Spalte man zuerst ausgeben muss:

$start = $seite * $eintraege_pro_seite - $eintraege_pro_seite;


//Tabelle Abfragen
//Tabelle heißt hier einfach: Tabelle
$abfrage = "SELECT * FROM gaestebuch ORDER BY id DESC LIMIT $start, $eintraege_pro_seite";
//$abfrage = "SELECT * FROM gaestebuch WHERE aktiv = '1' ORDER BY id DESC LIMIT $start, $eintraege_pro_seite";
$ergebnis = mysql_query($abfrage);
while($row = mysql_fetch_object($ergebnis))
    {
    $inhalt = $row->inhalt;
    //$inhalt = htmlentities($inhalt);
    //$inhalt = nl2br($inhalt);
    $datum = date("d.m.Y H:i", $row->datum);
    $eintrag_nummer = $row->id;
    //Der Besucher hat keine E-Mail Adresse angegeben:
    if($row->email == "")
       {
       $name = "<b>$row->name</b>";
       }
    else
       {
       //Der User hat eine Email Adresse angegeben:
       $name = "<a href=\"mailto:$row->email\">$row->name</a>";
       }

   echo "<table align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"5\" bgcolor=\"#000000\" width=\"50%\">";
   echo "<tr bgcolor=\"#ffffff\">";
   echo "<td>";
   echo "Von <b>$name</b> am $datum Eintrag Nummer: $eintrag_nummer";
   echo "</td>";
   echo "</tr>";
   echo "<tr bgcolor=\"#ffffff\">";
   echo "<td>";
   echo "$inhalt";
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
$menge = mysql_num_rows($result);

//Errechnen wieviele Seiten es geben wird
$wieviel_seiten = $menge / $eintraege_pro_seite;

//Ausgabe der Seitenlinks:
echo "<div align=\"center\">";
echo "<b>Seite:</b> ";


//Ausgabe der Links zu den Seiten
for($a=0; $a < $wieviel_seiten; $a++)
   {
   $b = $a + 1;

   //Wenn der User sich auf dieser Seite befindet, keinen Link ausgeben
   if($seite == $b)
      {
      echo "  <b>$b</b> ";
      }

   //Aus dieser Seite ist der User nicht, also einen Link ausgeben
   else
      {
      echo "  <a href=\"?seite=$b\">$b</a> ";
      }


   }
echo "</div>";
?> 
<p><a href="formular.html">Neuen Eintrag verfassen</a>
</body>
</html>
