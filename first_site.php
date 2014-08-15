<?php
$site = array( "title"     => "Reisekatalog",
               "top"       => "Reisekatalog",
               "bottom"    => "Bei Fragen, Anregungen oder Problemen wenden Sie sich an webmaster@urlaub-jetzt.de",
               "impressum" => "<a href='impressum.html'>Impressum</a>",
             );
echo "<html>";
echo "<head>";
echo "<title>";
echo $site['title'];
echo "</title>";
echo "</head>";
echo "<body style='background-color:#CCFFFF' text='#191970'>";
echo "<h1 align='center'>{$site['top']}</h1><hr>";
echo "<form action='$_SERVER[PHP_SELF]' method='POST'>\n";
echo "<div style='text-align: center'>";
echo "<select name='desire'>";
foreach($continent as $key => $subarray)
{
        $key=htmlentities($key);
        echo "<option value='$key'>$key</option>";
}
echo "</select>";
echo "<p><input type='submit' name='Destination'";
echo "value='Kontinent w&auml;hlen'>\n";
echo "</div>";
echo "</form>";
echo "<hr>";
echo "<p align='right'><font size='-1'>";
echo $site['bottom'];
echo "</font>";
echo "</p>";
echo "<p align='left'>";
echo "<font size='-1'>";
echo $site['impressum'];
echo "</font>";
echo "</p>";
echo "</body>";
echo "</html>";
?>
