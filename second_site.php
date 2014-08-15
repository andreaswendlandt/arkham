<?php
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
echo "<html>";
echo "<head>";
echo "<title>Der Reisekatalog</title>";
echo "</head>";
echo "<body style='background-color:#CCFFFF' text='#191970'>";
echo "<h1 align='center'>Der Reisekatalog</h1><hr>";
echo "<p><font size='+2'><b>{$_POST['desire']}</b></font></p>";
echo "<table border = '1' cellpadding = '4' width = '100%'>";
echo "<tr>";
foreach($caption as $heading)
{
        echo "<th>$heading</th>";
}
echo "</tr>";
while ($n_start <= $n_end)
{
        echo "<tr>";
        echo "<td align='center'>{$all[$n_start]->hotel}</td>\n";
        echo "<td align='center'>{$all[$n_start]->stadt}</td>\n";
        echo "<td align='center'>{$all[$n_start]->angebot_nr}</td>\n";
        echo "<td align='center'>{$all[$n_start]->preis} Euro</td>\n";
        echo "<td align='center'>{$all[$n_start]->land}</td>\n";
        echo "</tr>";
	$n_start++;
}
echo "</table>";
echo "<br>";
echo "<form action='$_SERVER[PHP_SELF]' method='POST'>";
echo "<input type='hidden' name='n_end' value='$n_end'>";
echo "<input type='hidden' name='desire' value='$_POST[desire]'>";
echo "<input type='submit' value='Anderen Kontinent w&auml;hlen'></td>";
echo "</form>";
echo "<p style='text-align: right; font-size: -1'>{$site['bottom']}";
echo "<p style='text-align: left; font-size: -1'>{$site['impressum']}";
echo "</body>";
echo "</html>";
?>
