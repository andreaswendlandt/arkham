<?php
/* Datei: first_site.inc
 * Zweck: Erstellt das zur Anzeige der Kontinente des
 *        Katalogs erforderliche Array, und zeigt dann die Kontinente an
 */
$site = array( "title"     => "Reisekatalog",
               "top"       => "Reisekatalog",
               "bottom"    => "Bei Fragen, Anregungen oder Problemen wenden Sie sich an webmaster@urlaub-jetzt.de",
               "impressum" => "<a href='impressum.html'>Impressum</a>",
             );
?>
<html>
<head>
<title><?php echo $site['title'] ?></title>
</head>
<body style="background-color:#CCFFFF" text="#191970">
<?php
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
?>
<hr>
<p align='right'><font size="-1">
<?php echo $site['bottom'] ?>
</font>
</p>
<p align='left'>
<font size="-1">
<?php echo $site['impressum'] ?>
</font>
</p>
</body>
</html>
