<?php
/* Programm: Orders-oo.php
 * Zweck:    Fuehrt alle Funktionen der Online-Shopping-
 *           Anwendung aus. Der Name der submit-
 *           Schaltflaeche wird geprueft, um zu ermitteln
 *           welcher Programmteil ausgefuehrt werden soll.
 */
require_once("Item.class");
require_once("Catalog.class");
require_once("ShoppingCart.class");
require_once("WebForm.class");
require_once("WebPage.class");
require_once("Order.class");
require_once("Database.class");
include("function.inc");
session_start();
if(!isset($_SESSION["username"]))
{
   echo "Bitte erst <a href=\"orders-login.html\">einloggen</a>";
   exit;
}
else
{
	if(isset($_POST['Products']) && isset($_POST['interest']))
	{
		try
		{
			$catalog = new Catalog("Vars.inc");
			$catalog->selectCatalog("baumarkt");
			$catalog->displayAllofType($_POST['interest'],2);
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit();
		}
	}
	elseif(isset($_POST['Cart']))
	{
		$cart = new ShoppingCart();
		if($_POST['Cart'] == "Warenkorb aktualisieren")
		{
			try
			{
				$cart->updateCart($_POST);
			}
			catch(Exception $e)
	        	{
        	        	echo $e->getMessage();
                		exit();
        		}
		}
	}
	elseif($_POST['Cart'] == "In den Warenkorb")
	{
		foreach($_POST as $field => $value)
		{
			if(ereg("item",$field) && $value > 0)
			{
				try
				{
					$cat_no = substr($field,4);
					$item = new Item($cat_no,$value);
					$cart->addItem($item);
				}
				catch(Exception $e)
				{
					echo $e->getMessage();
					exit();
				}
			}
		}
		try
		{
			$cart->displayCart("fields_cart-oo.inc","table_page-oo.inc");
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit();
		}
	}
	elseif(isset($_POST['Ship']))
	{
		try
		{
			$db = new Database("Vars.inc");
			$db->useDatabase("baumarkt");
			$order = new Order($db->getConnection(),"bestellung");
			if(isset($_SESSION['bestell_nr']))
			{
				$order->selectOrder($_SESSION['bestell_nr']);
			}
			else
			{
				$order->createOrder();
			}
			$order = $order->getOrderNumber();
			$info = $order->getOrderInfo();
			$form = new WebForm("single_form.inc","fields_ship_info.inc",$info);
			$form->displayForm();
		}
        	catch(Exception $e)
        	{
                	echo $e->getMessage();
                	exit();
        	}
	}
	elseif(isset($_POST['Summary']))
	{
		try
		{
			$form = new WebForm("single_form.inc","fields_ship_info.inc",$_POST);
			$blanks = $form->checkForBlanks();
		}
        	catch(Exception $e)
        	{
                	echo $e->getMessage();
        	}
		if(is_array($blanks))
		{
			$GLOBALS['message'] = "Die folgenden Felder sind leer, bitte geben Sie die erforderlichen Daten ein: ";
			foreach($blanks as $value)
			{
				$GLOBALS['message'] .="$value, ";
			}
			$form->displayForm();
			exit();
		}
		$form->trimData();
		$form->stripTagsFromData();
		try
		{
			$errors = $form->verifyData();
		}
        	catch(Exception $e)
        	{
                	echo $e->getMessage();
		}
		if(is_array($errors))
		{
			$GLOBALS['message'] = "";
			foreach($errors as $value)
			{
				$GLOBALS['message'] .="$value<br> ";
			}
			$form->displayForm();
			exit();
		}
		try
		{
			$db = new Database("Vars.inc");
			$db->useDatabase("baumarkt");
			$order = new Order($db->getConnection(),"bestellung");
			$order->selectOrder($_SESSION['bestell_nr']);
			$order->updateOrderInfo($_POST);
			$cart = new ShoppingCart();
			$order->addCart($cart);	
			$order->displayOrderSummary("fields_summary-oo.inc","summary_page.inc");
		}
        	catch(Exception $e)
        	{
                	echo $e->getMessage();
        	} 
	}
	elseif(isset($_POST['Final']))
	{
		if($_POST['Final'] == "Bestellung aufgeben")
		{
			$db = new Database("Vars.inc");
			$db->useDatabase("baumarkt");
			$order = new Order($db->getConnection(),"bestellung");
			$order->selectOrder($_SESSION['bestell_nr']);
			if(processCC())
			{
				$order->setSubmitted();
				$order->sendToShipping();
				$order->sendEMailtoCustomer();
				$confirm = new WebPage("confirm_page.inc",$data);
				$confirmpage->displayPage();
			}
			else
			{
				$order->cancel();
				$unapp = new WebPage("not_accepted_page.inc",$data);
				$unapp->displayPage();
				unset($_SESSION['bestell_nr']);
				unset($_SESSION);
				session_destroy();
			}
		}
		else
		{
			$order->cancel();
	        	$unapp = new WebPage("cancel.inc",$data);
                	$unapp->displayPage();
                	unset($_SESSION['bestell_nr']);
                	unset($_SESSION);
                	session_destroy();
		}
	}
	else
	{
		try
		{
		$catalog = new Catalog("Vars.inc");
		$catalog->selectCatalog("baumarkt");
		$catalog->displayCategories();
		}
                	catch(Exception $e)
                	{
                        	echo $e->getMessage();
                        	exit();
                	}
	}
}
?>

