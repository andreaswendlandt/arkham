<?php
/* Datei: first_site.inc
 * Zweck: Erstellt das zur Anzeige der Kontinente des
 *        Katalogs erforderliche Array, und zeigt dann die Kontinente und
 *        die jeweils möglichen Länder an.
 */
$site = array( "title" => "Reisekatalog",
               "top"   => "Reisekatalog",
               "bottom" => "Bei Fragen, Anregungen oder Problemen wenden Sie sich an webmaster@urlaub-jetzt.de",
             );
?>
<html>
<head><title><?php echo $site['title'] ?></title></head>
<body>
<?php
/* Text vor dem Formular anzeigen */
        echo "<div style='margin-left: .1in'>
        <h1 align='center'>{$site['top']}</h1><hr>";
/* Formular mit Auswahlliste erzeugen */
echo "<form action='$_SERVER[PHP_SELF]' method='POST'>\n";
echo "<select name='desire'>";
foreach($continent as $key => $subarray)
{
        $key=htmlentities($key);
        echo "<option value='$key'>$key</option>";
}
echo "</select>";
echo "<p><input type='submit' name='Destination'
        value='Kontinent w&auml;hlen'>\n
      </form></div>\n";
?>
<hr><p align='center'><font size="-1">
        <?php echo $site['bottom'] ?></font></p>
</body></html>
