<?php
	session_start();
	include("tpl/config.php");
	include("tpl/function.php");

	$db = dbConnect();
	
	$logedIn = checkLogIn();
	if (!$logedIn) {
		redirect("logIn.php");
	}

	$TransactionID = (isset($_GET) && isset($_GET["TransactionID"]) && is_numeric($_GET["TransactionID"])) ? urldecode($_GET["TransactionID"]) : null;
	
	$isAdmin = checkAdmin();
	
	if ($TransactionID) {
		$sql = $db->prepare("DELETE FROM Transactions WHERE TransactionID = ?");
		$sql-> execute([$TransactionID]);
		if ($isAdmin) {
			redirect("transakcije.php");
		}
		else {
			redirect("main.php");
		}
		
	}
	else {
		if ($isAdmin) {
			redirect("transakcije.php");
		}
		else {
			redirect("main.php");
		}
	}
	


?>