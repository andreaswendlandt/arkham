<html>
	<head>
		<title>Lagerbestand</title>
	</head>
	<body>
	<?php
		include("db_connect.inc.php");
		$conn = @ mysql_connect ( $host, $user, $password );

		mysql_select_db ( 'Firma', $conn );

		$sql = 'SELECT Produktname, Produktart, Lagerort, Produktanzahl From lager';

	$result = mysql_query ( $sql );
	
	echo "<h2 align='center'>Produkt&uumlbersicht</h2>";

	while ( $row = mysql_fetch_row ( $result ) )
	{
  	echo "<p>Produktname lautet $row[0], aus der Kategorie  $row[1], dieser Artikel befindet sich in $row[2], es sind noch $row[3] St&uuml;ck verf&uuml;gbar <br>";
	}
	?>
	</body>
</html>
