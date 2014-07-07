<html>
	<head>
 		<title>Suche</title>
	</head>
	<body>
 		<h1>Was suchen Sie?</h1>
  		<form action="frage6.php" method="post">
      		<p><strong>Suchbegriff eingeben:</strong></p>
      		<p><br/>
        	<input name="searchterm" type="text">
        	<input name="submit" type="submit" value="Suchen">
        	<br/>
        	</p>
  		</form>
<?php
	include("db_connect.inc.php");
	$verbindung = mysql_connect ($host, $user)
		or die ("keine Verbindung m&ouml;glich");
	mysql_select_db("Firma")
		or die ("Die Datenbank existiert nicht.");
	$begriff = mysql_real_escape_string($_POST['searchterm']);
	if ($begriff)
	{
	$abfrage = "SELECT ID, Produktname, Produktart, Produktanzahl, Lagerort FROM lager WHERE ID like '%$begriff%' 
                or Produktname like '%$begriff%'
                or Produktart like '%$begriff%'
                or Lagerort like '%$begriff%'";

	 $ergebnis = mysql_query($abfrage) 
		or die ("MySQL-Fehler: " . mysql_error());
	if ($ergebnis)
		{
	echo '<table width="100%" border="1">';
	echo "<tr>";
        echo "<td>". ID . "</td>";
        echo "<td>". Produktname . "</td>";
        echo "<td>". Produktart  . "</td>";
        echo "<td>". Produktanzahl . "</td>";
        echo "<td>". Lagerort . "</td>";
        echo "</tr>";
        while($row = mysql_fetch_object($ergebnis))
        {
	echo "<tr>";
 	echo "<td>". $row->ID . "</td>"; 
 	echo "<td>". $row->Produktname . "</td>"; 
 	echo "<td>". $row->Produktart . "</td>"; 
 	echo "<td>". $row->Produktanzahl . "</td>"; 
 	echo "<td>". $row->Lagerort . "</td>";
 	echo "</tr>"; 
	}
echo "</table>";
	}
	        else
	{
        echo "Suchbegriff nicht gefunden";
        }
}
echo "<p><a href=\"" . $_SERVER['PHP_SELF'] . "\">Zur&uuml;ck zum Formular</a></p>\n";
?>
	</body>
</html>
