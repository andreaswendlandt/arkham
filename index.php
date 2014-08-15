<?php
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
			$holidaycatalog = new Holiday;
			$holidaycatalog->connectHost("credentials.php");
			$holidaycatalog->selectDatabase("urlaub");
			$holidaycatalog->showContinentData($_POST['desire']);
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
		$holidaycatalog = new Holiday;
		$holidaycatalog->connectHost("credentials.php");
		$holidaycatalog->selectDatabase("urlaub");
		$holidaycatalog->showContinents();
	}
	catch(Exception $exception)
	{
		echo $exception->getMessage();
		exit();
	}
}
?>


