<?php
	session_start();
	include("tpl/config.php");
	include("tpl/function.php");

	$db = dbConnect();
	
	$logedIn = checkLogIn();
	if (!$logedIn) {
		redirect("logIn.php");
	}

	$UserID = (isset($_GET) && isset($_GET["UserID"]) && is_numeric($_GET["UserID"])) ? $_GET["UserID"] : null;
	
	
	
	if ($UserID) {
		$sql = $db->prepare("DELETE FROM Users WHERE UserID = ?");
		$sql-> execute([$UserID]);
		$sql = $db->prepare("DELETE FROM Transactions WHERE UserID = ?");
		$sql-> execute([$UserID]);
		redirect("uporabniki.php");
	}
	else {
		redirect("uporabniki.php");
	}
	


?>