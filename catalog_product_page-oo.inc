<?php
/* Datei: catalog_product_page-oo.inc
 * Zweck: Zeigt die Produkte der gewaehlten Kategorie
 *        an.
 */
?>
<html>
<head><title>Der Baumarkt-Katalog</title></head>
<body>
<?php
echo "<div style='margin-left: .1in; margin-right: .1in'>
      <h1 align='center'>Der Baumarkt</h1><hr>
      <p><font size='+2'><b>{$_POST['interest']}</b></font></p>";
echo "<p align='right'>($n_products Produkt(e) gefunden)</p><hr>";
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
	echo "<td align='center'>{$all[$i]->katalog_nr}</td>\n";
	echo "<td align='center'>{$all[$i]->name}</td>\n";
	echo "<td align='center'>{$all[$i]->fabrikat}</td>\n";
	echo "<td align='center'>{$all[$i]->best_nr}</td>\n";
	echo "<td align='center'>Euro {$all[$i]->preis}</td>\n";
	echo "<td align='center'>{$all[$i]->pr_beschr}</td>\n";
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
echo "<hr><p style='text-align: center; font-size: 75%'>{$page['bottom']}";
?>
</body></html>

