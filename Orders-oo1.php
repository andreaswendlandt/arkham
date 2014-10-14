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
include("functions_main.inc");
session_start();                                         #16
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
elseif(isset($_POST['Cart']))                            #31
{
   $cart = new ShoppingCart();
   if($_POST['Cart'] == "Warenkorb aktualisieren")                   #34
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
   elseif($_POST['Cart'] == "in den Warenkorb")         #46
   {
     foreach($_POST as $field => $value)                 #48
     {
        if(ereg("item",$field) && $value > 0)
        {
           try
           {
             $cat_no = substr($field,4);                 #54
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
   }
   try
   {
      $cart->displayCart("fields_cart-oo.inc","table_page-oo.inc");                       #69
   }
   catch(Exception $e)
   {
       echo $e->getMessage();
       exit();
   }
}
elseif(isset($_POST['Ship']))                            #77
{
   try
   {
     $db = new Database("Vars.inc");
     $db->useDatabase("baumarkt");
     $order = new Order($db->getConnection(),"bestellung"); 
     if(isset($_SESSION['bestell_nr']))                #85
     {
        $order->selectOrder($_SESSION['order_number']);
     }
     else
     {
        $order->createOrder();
     }
     $ord = $order->getOrderNumber();
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
elseif(isset($_POST['Summary']))                     #105
{
   try
   {
     $form = new WebForm("single_form.inc","fields_ship_info-oo.inc",$_POST);
     $blanks = $form->checkForBlanks();
   }
   catch(Exception $e)
   {
      echo $e->getMessage();
   }
   if(is_array($blanks))                             #118
   {
       $GLOBALS['message'] = "Die folgenden Felder sind leer, bitte geben Sie die erforderlichen Daten ein:  ";
       foreach($blanks as $value)
       {
         $GLOBALS['message'] .="$value, ";
       }
       $form->displayform();
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
elseif(isset($_POST['Final']))                         #174
{
   if($_POST['Final'] == "Bestellung aufgeben")               #176
   {
     $db = new Database("Vars.inc");
     $db->useDatabase("baumarkt");
     $order = new Order($db->getConnection(),"bestellung"); 
     $order->selectOrder($_SESSION['bestell_nr']);
     if(processCC())                                   #180
     {
        $order->setSubmitted();                        #182
        $order->sendToShipping();                      #183
        $order->sendEMailtoCustomer();                 #184
        $confirm = new webPage("confirm_page.inc",$data);
        $confirmpage->displayPage();                   #186
     }
     else                                              #188
     {
        $order->cancel();
        $unapp = new webPage("not_accepted_page.inc",$data);
        $unapp->displayPage();
        unset($_SESSION['bestell_nr']);
        unset($_SESSION);
        session_destroy();
     }
   }
   else                                                #198
   {
        $order->cancel();
        $cancel = new webPage("cancel.inc",$data);
        $cancel->displayPage();
        unset($_SESSION['bestell_nr']);
        unset($_SESSION);
        session_destroy();
   }
}
else                                                   #208
{
   $catalog = new Catalog("Vars.inc");
   $catalog->selectCatalog("baumarkt");
   $catalog->displayCategories();
}
?>
