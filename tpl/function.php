<?php

function dbConnect(){
	
	$db = null;
	global $config;
	
	$dbUserName = $config["dbUserName"];
	$dbPassword = $config["dbPassword"];
	$dbHostName = $config["dbHostName"];
	$dbName = $config["dbName"];
	
	$db = new PDO("mysql:host=$dbHostName;dbname=$dbName", $dbUserName, $dbPassword);
	
	$sql = $db->prepare("SET NAMES utf8"); //convert db to utf-8 charset
	$sql-> execute();
	
	return $db;
	
}

function dbCheckValueExists($db, $valueName, $value) {
	$output = false;
	
	$sql = $db->query("SELECT {$valueName} FROM Users WHERE {$valueName} = '{$value}'");
	$count = $sql->rowCount();
	
	if($count != 0) {
		
		$output = true;
	}
	
	return $output;
	
}

function dbCountTransactionsRows($db) {
	$output = 0;
	
	$sql = $db->query("SELECT TransactionID FROM Transactions");
	$output = $sql->rowCount();
	
	return $output;
}

function dbCountUsersRows($db) {
	$output = 0;
	
	$sql = $db->query("SELECT UserID FROM Users");
	$output = $sql->rowCount();
	
	return $output;
}

function dbCheckPasswordsMatch($db, $value1, $value2) { //value1 == email , value2 == password
	$output = false;
	
	$sql= $db->prepare("SELECT UserPassword FROM Users WHERE UserEmail=?");
	$sql->execute([$value1]);
	$password = $sql->fetchColumn();
	
	if ($password == $value2) {
		$output = true;
	}
	
	return $output;
}

function dbGetUsername($db, $email) {
	$output = false;
	
	$sql= $db->prepare("SELECT UserName FROM Users WHERE UserEmail=?");
	$sql->execute([$email]);
	$output = $sql->fetchColumn();
	
	return $output;
	
}

function dbGetUserId($db, $email) {
	$output = false;
	
	$sql= $db->prepare("SELECT UserID FROM Users WHERE UserEmail=?");
	$sql->execute([$email]);
	$output = $sql->fetchColumn();
	
	return $output;
}

function dbOutputData($db, $userId) {
	

	
	$sql = $db->prepare("SELECT TransactionID, TransactionDate, TransactionPlusORMinus, TransactionAmount, TransactionInfo FROM Transactions WHERE UserID = ? ORDER BY TransactionDate DESC");
	$sql-> execute([$userId]);
	$dbTransactions = $sql-> fetchAll(PDO::FETCH_ASSOC);
	
	$output = null;
	if (isset($dbTransactions) && count($dbTransactions) > 0) {
		$output .= '<div class="tbodyDiv">';
		$output .= '<table class="table table-bordered text-center" id="my_table">';
		$output .= '<thead class="sticky-top">';
		$output .= '<tr>';
		$output .= '<th>#</th>';
		$output .= '<th>Datum transakcije</th>';
		$output .= '<th>Dohodek/odhodek</th>';
		$output .= '<th>Vsota transakcije</th>';
		$output .= '<th>Informacije transakcije</th>';
		$output .= '<th>Opcije</th>';
		$output .= '</tr>';
		$output .= '</thead>';
		
		$output .= '<tbody>';
		$counterTransactions = 1;
		$counterMoney = 0;
		foreach ($dbTransactions as $key=>$row) {
			$TransactionID = $row["TransactionID"];
			$TransactionDate = $row["TransactionDate"];
			$TransactionPlusORMinus = ($row["TransactionPlusORMinus"] == 1) ? "Dohodek" : "Odhodek";
			$TransactionAmount = $row["TransactionAmount"];
			$TransactionInfo = $row["TransactionInfo"]; 
			
			$outputBtn = '
				<a class="btn btn-danger btn-seznam" href="delete.php?TransactionID=' . urlencode($TransactionID) . '">Briši</a>
				<a class="btn btn-warning btn-seznam" href="update.php?TransactionID=' . urlencode($TransactionID) . '">Uredi</a>
			';
			
			if ($TransactionPlusORMinus == "Dohodek") {
				$counterMoney = $counterMoney + $TransactionAmount;
			}
			else if ($TransactionPlusORMinus == "Odhodek") {
				$counterMoney = $counterMoney - $TransactionAmount;
			}
			
			
			$output .= '<tr>';
			$output .= '<td>' . $counterTransactions .  '</td>';
			$output .= '<td>' . $TransactionDate . '</td>';
			if ($TransactionPlusORMinus == "Dohodek") {
				$output .= '<td><p class="my_p_dohodek">' . $TransactionPlusORMinus . '</p></td>';
			}
			else {
				$output .= '<td><p class="my_p_odohodek">' . $TransactionPlusORMinus . '</p></td>';
			}
			$output .= '<td class="amount">' . $TransactionAmount . '</td>';
			$output .= '<td>' . $TransactionInfo . '</td>';
			$output .= '<td>' . $outputBtn . '</td>';
			$output .= '</tr>';
			
			$counterTransactions++;
		}
		$output .= '</tbody>';
		
		$output .='</table>';
		$output .= '</div>';
		$output .= '<p class="p_show_amount"><strong>Trenutni proračun: </strong>' . $counterMoney . ' €</p>';
		
	}
	else {
		$output .= '<p class="my_p_2"><strong>Trenutno še nimate nobenih transakcij, prosimo da jih dodate.</strong></p>';
		$output .= '<p class="p_show_amount"><strong>Trenutni proračun: </strong>0 €</p>';
	}
	return $output;
}

function dbOutputUsers($db) {
	$sql = $db->prepare("SELECT * FROM Users ORDER BY UserEmail");
	$sql-> execute();
	$dbUsers = $sql-> fetchAll(PDO::FETCH_ASSOC);
	
	$output = null;
	if (isset($dbUsers) && count($dbUsers) > 0) {
		$output .= '<div class="tbodyDiv">';
		$output .= '<table class="table table-bordered text-center">';
		$output .= '<thead class="sticky-top">';
		$output .= '<tr>';
		$output .= '<th>#</th>';
		$output .= '<th>ID uporabnika</th>';
		$output .= '<th>E-mail uporabnika</th>';
		$output .= '<th>Uporabniško ime</th>';
		$output .= '<th>Uporabniško geslo</th>';
		$output .= '<th>Opcije</th>';
		$output .= '</tr>';
		$output .= '</thead>';
		
		$output .= '<tbody>';
		$counterUsers = 0;
		$counter = 1;
		foreach ($dbUsers as $key=>$row) {
			
			$UserID = $row["UserID"];
			$UserEmail = $row["UserEmail"];
			$UserName = $row["UserName"];
			$UserPassword = $row["UserPassword"];
				
			$outputBtn = '
				<a class="btn btn-danger btn-seznam" href="deleteUser.php?UserID=' . $UserID . '">Briši</a>
				<a class="btn btn-warning btn-seznam" href="updateUser.php?UserID=' . $UserID . '">Uredi</a>
			';

			$output .= '<tr>';
			$output .= '<td>' . $counter .  '</td>';
			$output .= '<td>' . $UserID .  '</td>';
			$output .= '<td>' . $UserEmail . '</td>';
			$output .= '<td>' . $UserName . '</td>';
			$output .= '<td>' . $UserPassword . '</td>';
			$output .= '<td>' . $outputBtn . '</td>';
			$output .= '</tr>';
				
			$counterUsers++;
			$counter++;
		}

		$output .= '</tbody>';
		
		$output .='</table>';
		$output .= '</div>';
		$output .= '<p class="p_show_amount"><strong>Trenutno število uporabnikov: </strong>' . $counterUsers . '</p>';
		
	}
	else {
		$output .= '<p class="my_p_2"><strong>Trenutno še nimate nobenih uporabnikov.</strong></p>';
		$output .= '<p class="p_show_amount"><strong>Število uporabnikov: </strong>0</p>';
	}
	return $output;
	
}

function dbOutputTransactions($db) {
	$sql = $db->prepare("SELECT * FROM Transactions ORDER BY UserID");
	$sql-> execute();
	$dbTransactionsAll = $sql-> fetchAll(PDO::FETCH_ASSOC);
	
	$output = null;
	if (isset($dbTransactionsAll) && count($dbTransactionsAll) > 0) {
		$output .= '<div class="tbodyDiv">';
		$output .= '<table class="table table-bordered text-center" id="my_table">';
		$output .= '<thead class="sticky-top">';
		$output .= '<tr>';
		$output .= '<th>#</th>';
		$output .= '<th>ID transakcije</th>';
		$output .= '<th>ID uporabnika</th>';
		$output .= '<th>Datum transakcije</th>';
		$output .= '<th>Dohodek/odhodek</th>';
		$output .= '<th>Vsota transakcije</th>';
		$output .= '<th>Informacije transakcije</th>';
		$output .= '<th>Opcije</th>';
		$output .= '</tr>';
		$output .= '</thead>';
		
		$output .= '<tbody>';
		$counter = 1;
		foreach ($dbTransactionsAll as $key=>$row) {
			
			$TransactionID = $row["TransactionID"];
			$UserID = $row["UserID"];
			$TransactionDate = $row["TransactionDate"];
			$TransactionPlusORMinus = ($row["TransactionPlusORMinus"] == 1) ? "Dohodek" : "Odhodek";
			$TransactionAmount = $row["TransactionAmount"];
			$TransactionInfo = $row["TransactionInfo"];
				
			$outputBtn = '
				<a class="btn btn-danger btn-seznam" href="delete.php?TransactionID=' . $TransactionID . '">Briši</a>
				<a class="btn btn-warning btn-seznam" href="updateTransaction.php?TransactionID=' . $TransactionID . '">Uredi</a>
			';
			
			$output .= '<tr>';
			$output .= '<td>' . $counter .  '</td>';
			$output .= '<td>' . $TransactionID . '</td>';
			$output .= '<td class="userID">' . $UserID . '</td>';
			$output .= '<td>' . $TransactionDate . '</td>';
			if ($TransactionPlusORMinus == "Dohodek") {
				$output .= '<td><p class="my_p_dohodek">' . $TransactionPlusORMinus . '</p></td>';
			}
			else {
				$output .= '<td><p class="my_p_odohodek">' . $TransactionPlusORMinus . '</p></td>';
			}
			$output .= '<td>' . $TransactionAmount . '</td>';
			$output .= '<td>' . $TransactionInfo . '</td>';
			$output .= '<td>' . $outputBtn . '</td>';
			$output .= '</tr>';
			
			$counter++;
		}
		$output .= '</tbody>';
		
		$output .='</table>';
		$output .= '</div>';
		
		
	}
	else {
		$output .= '<p class="my_p_2"><strong>Trenutno še ni nobenih transakcij.</strong></p>';
		
	}
	return $output;
}

function dbGetRow($db, $TransactionID) {
	if($TransactionID) {
		$sql = $db->prepare("SELECT TransactionDate, TransactionPlusORMinus, TransactionAmount, TransactionInfo FROM Transactions WHERE TransactionID = :TransactionID");
		$sql->execute(['TransactionID' => $TransactionID]);
		$dbTransactions = $sql->fetchAll(PDO::FETCH_ASSOC);
		$dbTransactions = (isset($dbTransactions) && isset($dbTransactions[0])) ? $dbTransactions[0] : null;
		
		if ($dbTransactions) {
			return $dbTransactions;
		} else {
			redirect('main.php');
		}
	}

}

function dbGetRowAdmin($db, $TransactionID) {
	if($TransactionID) {
		$sql = $db->prepare("SELECT UserID, TransactionDate, TransactionPlusORMinus, TransactionAmount, TransactionInfo FROM Transactions WHERE TransactionID = :TransactionID");
		$sql->execute(['TransactionID' => $TransactionID]);
		$dbTransactions = $sql->fetchAll(PDO::FETCH_ASSOC);
		$dbTransactions = (isset($dbTransactions) && isset($dbTransactions[0])) ? $dbTransactions[0] : null;
		
		if ($dbTransactions) {
			return $dbTransactions;
		} else {
			redirect('main.php');
		}
	}

}

function dbGetRowUser($db, $UserID) {
	if($UserID) {
		$sql = $db->prepare("SELECT UserName, UserPassword FROM Users WHERE UserID = :UserID");
		$sql->execute(['UserID' => $UserID]);
		$dbUsers = $sql->fetchAll(PDO::FETCH_ASSOC);
		$dbUsers = (isset($dbUsers) && isset($dbUsers[0])) ? $dbUsers[0] : null;
		
		if ($dbUsers) {
			return $dbUsers;
		} else {
			redirect('uporabniki.php');
		}
	}
}



function dbDeleteTransaction($db, $TransactionID) {
	
	if ($TransactionID) {
		$sql = $db->prepare("DELETE FROM Transactions WHERE TransactionID = ?");
		$sql-> execute([$TransactionID]);
		redirect("main.php");
	}
	else {
		redirect("main.php");
	}
}

function dbAddTransaction($db, $TransactionID, $UserID, $Date1, $PlusOrMinus, $Amount, $Info){ 
	
	if ($UserID) {
		$sql = $db->prepare("INSERT INTO Transactions (TransactionID, UserID, TransactionDate, TransactionPlusORMinus, TransactionAmount, TransactionInfo) VALUES (?, ?, ?, ?, ?, ?)");
		$sql-> execute([$TransactionID, $UserID, $Date1, $PlusOrMinus, $Amount, $Info]);
		
	}

	
}

function dbUpdateTransaction($db, $TransactionID, $TransactionDate, $TransactionPlusORMinus, $TransactionAmount, $TransactionInfo) {
	
	$sql = $db->prepare("UPDATE Transactions SET TransactionDate = :TransactionDate, TransactionPlusORMinus = :TransactionPlusORMinus, TransactionAmount = :TransactionAmount, TransactionInfo = :TransactionInfo WHERE TransactionID = :TransactionID");
	$sql->execute([
		'TransactionID' => $TransactionID,
		'TransactionDate' => $TransactionDate,
		'TransactionPlusORMinus' => $TransactionPlusORMinus,
		'TransactionAmount' => $TransactionAmount,
		'TransactionInfo' => $TransactionInfo
				
	]);
		
}

function dbUpdateTransactionAdmin($db, $TransactionID, $UserID, $TransactionDate, $TransactionPlusORMinus, $TransactionAmount, $TransactionInfo) {
	
	$sql = $db->prepare("UPDATE Transactions SET UserID = :UserID, TransactionDate = :TransactionDate, TransactionPlusORMinus = :TransactionPlusORMinus, TransactionAmount = :TransactionAmount, TransactionInfo = :TransactionInfo WHERE TransactionID = :TransactionID");
	$sql->execute([
		'UserID' => $UserID,
		'TransactionID' => $TransactionID,
		'TransactionDate' => $TransactionDate,
		'TransactionPlusORMinus' => $TransactionPlusORMinus,
		'TransactionAmount' => $TransactionAmount,
		'TransactionInfo' => $TransactionInfo
				
	]);
		
}

function dbAddUser($db, $UserID, $UserEmail, $UserName, $UserPassword) {
	
	if ($UserID) {
		$sql = $db->prepare("INSERT INTO Users (UserID, UserEmail, UserName, UserPassword) VALUES (?, ?, ?, ?)");
		$sql-> execute([$UserID, $UserEmail, $UserName, $UserPassword]);
		redirect("uporabniki.php");
	}
	else {
		redirect("uporabniki.php");
	}
}

function dbUpdateUser($db, $UserID, $UserName, $UserPassword) {
	$sql = $db->prepare("UPDATE Users SET UserName = :UserName, UserPassword = :UserPassword WHERE UserID = :UserID");
	$sql->execute([
		'UserID' => $UserID,
		'UserName' => $UserName,
		'UserPassword' => $UserPassword				
	]);
}

function dbCheckIdExists($db, $TransactionID) {
	$output = 0;
	
	$sql = $db->prepare("SELECT UserID FROM Transactions WHERE TransactionID=?");
	$sql->execute([$TransactionID]);
	$output = $sql->rowCount();
	
	return $output;
}

function dbCheckUserIdExists($db, $UserID) {
	$output = 0;
	
	$sql = $db->prepare("SELECT UserEmail FROM Users WHERE UserID=?");
	$sql->execute([$UserID]);
	$output = $sql->rowCount();
	
	return $output;
}


function checkInputValue($value) {
	$output = null;
	
	$output = (isset($_POST) && isset($_POST[$value])) ? trim($_POST[$value]) : null;
	
	return $output;
}

function checkMail($mail) {
	$output = null;
	
	if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $output = true;
    }
    else {
        $output = false;
    }
	
	return $output;
}

function checkUsernameStrength($username) {
	$output = false;
	
	if (strlen($username) >= 5) {
		$output = true;
	}
	
	return $output;
}

function checkPasswordStrength($password) {
	$output = true;
	
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
		$output = false;
	}
	
	return $output;
}

function convertPlusOrMinus($value){
	$output = null;
	if (strcmp($value, "dohodek") == 0) {
		$output = true;
	}
	else  {
		$output = false;
	}
	return $output;
}

function getFieldValue($row, $name) {
	$output = null;
	
	$output = (isset($row) && (isset($name)) && isset($row[$name])) ? $row[$name] : null;
	
	return $output;
}

function checkIsAdmin($email, $password) {
	$output = null;
	
	$output = ($email == "admin@budgetplanner.com" && $password == "root1234") ? true : false;
	
	return $output;
}

function checkAdmin(){
	$output = null;
	
	if (isset($_SESSION) && isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true) {
		$output = true;
	}
	else {
		$output = false;
	}
	
	return $output;
}

function redirect($page) {
	
	if ($page) {
		header("Location: {$page}");
		die();
	}
	
}

function checkLogIn(){
	$output = null;
	
	if (isset($_SESSION) && isset($_SESSION["LogIn"]) && $_SESSION["LogIn"] == true) {
		$output = true;
	}
	else {
		$output = false;
	}
	
	return $output;
}

function checkLogOut() {
	if (isset($_POST) && isset($_POST["read"])) {
		echo '	<div class="alert alert-warning" role="alert" id="popup">
							
					Se zares želite odjaviti?
									
									
															
					<form method="post">
						<button type="submit" class="btn btn-primary btn-daNe" name="btn-da">Da</button>
						<button type="submit" class="btn btn-primary btn-daNe" name="btn-ne">Ne</button>
					</form>
									
							
				</div>';

	}
	if (isset($_POST) && isset($_POST["btn-da"])) {
		logout();	
	}
	else if (isset($_POST) && isset($_POST["btn-ne"]))  {
		//stay on page	
	}
}

function logout() {
	if(isset($_SESSION)) {
		session_unset();
		
		session_destroy();

		redirect("index.php");
	}
}








?>