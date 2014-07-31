<?php
/* Datei: second_site.inc
 * Zweck: Definiert Variablen und Arrays für die zweite Seite
 *        und zeigt die gefundenen Hotels an.
 */
$site = array( "title" => "Der Reisekatalog",
               "top"   => "Der Reisekatalog",
               "bottom" => "Bei Fragen, Anregungen oder Problemen wenden Sie sich an webmaster@urlaub-jetzt.de",
             );
$table_heads = array("hotel"      => "Hotel",
                     "stadt"   => "Stadt",
                     "angebot_nr"    => "Angebotsnr.",
                     "preis"      => "Preis",
                    );
?>
<html>
<head><title>Der Reisekatalog</title></head>
<body>
<?php
echo "<div style='margin-left: .1in; margin-right: .1in'>
      <h1 align='center'>Der Reisekatalog</h1><hr>
      <p><font size='+2'><b>{$_POST['interest']}</b></font></p>";
//echo "<p align='right'>($n_products Produkt(e) gefunden)</p><hr>";
echo "<table border = '0' cellpadding = '3' width = '100%'>";
echo "<tr>";
foreach($table_heads as $heading)
{
        echo "<th>$heading</th>";
}
echo "</tr>";
for ($i=$n_start;$i<=$n_end;$i++)
{
        echo "<tr>";
        echo "<td align='center'>{$all[$i]->hotel}</td>\n";
        echo "<td align='center'>{$all[$i]->stadt}</td>\n";
        echo "<td align='center'>{$all[$i]->angebot_nr}</td>\n";
        echo "<td align='center'>{$all[$i]->preis} Euro</td>\n";
        echo "</tr>";
}
echo "<form action='$_SERVER[PHP_SELF]' method='POST'>";
echo "<input type='hidden' name='n_end' value='$n_end'>";
echo "<input type='hidden' name='interest' value='$_POST[interest]'>";
echo "<tr>
      <td colspan='2'>
      <input type='submit' value='Andere Kategorie w&auml;len'></td>
      <td colspan='3' align='right'>";
      if($n_end > $n_per_page)
      {
        echo "<input type='submit' name='Products' value='Vorherige'>";
      }
      if($n_end < $n_products)
      { 
        echo "<input type='submit' name='Products' value='N&auml;chste $n_per_page'>";
      }
echo " </td></form></tr></table></div>";
echo "<hr><p style='text-align: center; font-size: 75%'>{$site['bottom']}";
?>
</body></html>
