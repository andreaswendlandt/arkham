<?php
/* Datei: catalog_index_page.inc
 * Zweck: Zeigt die Kategorien des Katalogs an.
 */
?>
<html>
<head><title><?php echo $page['title'] ?></title></head>
<body>
<?php
/* Text vor dem Formular anzeigen */
	echo "<div style='margin-left: .1in'>
	<h1 align='center'> {$page['top']}</h1><hr>";

/* Formular mit Auswahlliste erzeugen */
echo "<form action='$_SERVER[PHP_SELF]' method='POST'>\n";
foreach($bau_categories as $key => $subarray)	#16
{
	echo "<h3>$key</h3>";
	echo "<ul>";
	foreach($subarray as $type)
	{
		echo "<input type='radio' name='interest'
			value='$type'><b>$type</b><br>\n";
	}
	echo "</ul>";
}
echo "<p><input type='submit' name='Products'
	value='Kategorie w&auml;hlen'>\n
      </form></div>\n";
?>
<hr><p align='center'><font size="-1">
	<?php echo$page['bottom'] ?></font></p>
</body></html>
