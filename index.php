<?php
/* Datei: index.php
 * Zweck: Zeigt einen Katalog an, dieser besteht aus
 *        zwei verschiedenen Seiten: einer Indexseite
 *	  mit möglichen Kontinenten zum auswählen und der zweiten Seite 
 *        die nach Auswahl eines Kontinents mögliche Reiseziele anzeigt.
 */
require_once("Holiday.class");
if(isset($_POST['Destination']))
{
	if(!isset($_POST['desire']))
	{
		header("location: index.php");
		exit();
	}
	else
	{
		try
		{
			$holidaycatalog = new Holiday("credentials.inc");
			$holidaycatalog->selectDatabase("urlaub");
			$holidaycatalog->displayAllofType($_POST['desire']);
		}
		catch(Exception $exception)
		{
			echo $exception->getMessage();
			exit();
		}
	}
}
else
{
	try
	{
		$holidaycatalog = new Holiday("credentials.inc");
		$holidaycatalog->selectDatabase("urlaub");
		$holidaycatalog->displayCategories();
	}
	catch(Exception $exception)
	{
		echo $exception->getMessage();
		exit();
	}
}
?>


