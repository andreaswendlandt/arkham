<?php
/* Datei: Catalog.php
 * Zweck: Zeigt einen Katalog an. Dieser besteht aus
 *        zwei verschiedenen Seiten: einer Indexseite
 *	  mit Kategorien und einer Produktseite, 
 *        die nach Auswahl einer Kategorie angezeigt wird.
 */
require_once("Catalog.class");
if(isset($_POST['Products']))
{
	if(!isset($_POST['interest']))
	{
		header("location: Catalog.php");
		exit();
	}
	else
	{
		try
		{
			$baucat = new Catalog("Vars.inc");
			$baucat->selectCatalog("baumarkt");
			$baucat->displayAllofType($_POST['interest'],2);
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
		$baucat = new Catalog("Vars.inc");
		$baucat->selectCatalog("baumarkt");
		$baucat->displayCategories();
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		exit();
	}
}
?>


