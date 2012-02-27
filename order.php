<?php
require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);

/**
 * Contains the list of items to order. All orders are contained within the "item" key, and each subentry
 * contains the item and it's size as well as the order amount.
 */
$orderItems = array();

foreach ($_REQUEST["item"] as $key => $value) {
	if ($value !== "") {
		$orderItems[] = array("name" => str_pad($key, 30), "amount" => str_pad($value,4));
	}
}

$variables = array();
$variables["name"] = $_REQUEST["name"];
$variables["email"] = $_REQUEST["email"];
$variables["comments"] = $_REQUEST["comments"];
$variables["items"] = $orderItems;

$twig->display('ordercomplete.html', $variables);

$mailtext = $twig->render('mailtemplate.txt', $variables);

mail("felicitus@felicitus.org", "RZL-Merchandise-Shop Bestellung", $mailtext);