<?php
/* Datei: index.php
 * Zweck: Zeigt einen Katalog an. Dieser besteht aus
 *        zwei verschiedenen Seiten: einer Indexseite
 *	  mit Kategorien und einer Produktseite, 
 *        die nach Auswahl einer Kategorie angezeigt wird.
 */
require_once("Holiday.class");
if(isset($_POST['Products']))
{
	if(!isset($_POST['interest']))
	{
		header("location: index.php");
		exit();
	}
	else
	{
		try
		{
			$holidaycatalog = new Catalog("credentials.inc");
			$holidaycatalog->selectCatalog("urlaub");
			$holidaycatalog->displayAllofType($_POST['interest'],2);
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit();
		}
	}
}
else
{
	try
	{
		$holidaycatalog = new Catalog("credentials.inc");
		$holidaycatalog->selectCatalog("urlaub");
		$holidaycatalog->displayCategories();
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		exit();
	}
}
?>


