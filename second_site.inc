<?php
/* Datei: second_site.inc
 * Zweck: Zeigt die gefunden Hotels und Länder des gewählten
 *        Kontinents an
 */
$site = array( "title"     => "Der Reisekatalog",
               "top"       => "Der Reisekatalog",
               "bottom"    => "Bei Fragen, Anregungen oder Problemen wenden Sie sich an webmaster@urlaub-jetzt.de",
	       "impressum" => "<a href='impressum.html'>Impressum</a>",
             );
$caption = array("hotel"      => "Hotel",
                 "stadt"      => "Stadt",
                 "angebot_nr" => "Angebotsnr.",
                 "preis"      => "Preis",
		 "land"	      => "Land",
                 );
?>
<html>
<head>
<title>Der Reisekatalog</title></head>
<body>
<?php
echo "<div style='margin-left: .1in; margin-right: .1in'>";
echo "<h1 align='center'>Der Reisekatalog</h1><hr>";
echo "<p><font size='+2'><b>{$_POST['desire']}</b></font></p>";
echo "<table border = '0' cellpadding = '3' width = '100%'>";
echo "<tr>";
foreach($caption as $heading)
{
        echo "<th>$heading</th>";
}
echo "</tr>";
for ($n=$n_start;$n<=$n_end;$n++)
{
        echo "<tr>";
        echo "<td align='center'>{$all[$n]->hotel}</td>\n";
        echo "<td align='center'>{$all[$n]->stadt}</td>\n";
        echo "<td align='center'>{$all[$n]->angebot_nr}</td>\n";
        echo "<td align='center'>{$all[$n]->preis} Euro</td>\n";
        echo "<td align='center'>{$all[$n]->land}</td>\n";
        echo "</tr>";
}
echo "<form action='$_SERVER[PHP_SELF]' method='POST'>";
echo "<input type='hidden' name='n_end' value='$n_end'>";
echo "<input type='hidden' name='desire' value='$_POST[desire]'>";
echo "<tr>";
echo "<td colspan='2'>";
echo "<input type='submit' value='Anderen Kontinent w&auml;hlen'></td>";
echo "<td colspan='3' align='right'>";
echo "</td></form></tr></table></div>";
echo "<hr>";
echo "<p style='text-align: right; font-size: -1'>{$site['bottom']}";
echo "<p style='text-align: left; font-size: -1'>{$site['impressum']}";
?>
</body>
</html>
