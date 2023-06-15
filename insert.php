<?php
	ob_start();
	session_start();
	include("tpl/config.php");
	include("tpl/function.php");
	
	$db = dbConnect();
	
	$logedIn = checkLogIn();
	if (!$logedIn) {
		redirect("logIn.php");
	}
	
?>
<!DOCTYPE html>
<html>

	<head>
	
		<title>BudgetPlanner</title>
		
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="custom_css/mycss.css">
		<meta charset="utf-8">
		<link rel="icon" type="image/x-icon" href="img/monay.png">
	</head>
	
	<body>
		<?php
			checkLogOut();
			
			if (isset($_POST) && isset($_POST["insert_dodaj"])) {
				$Date1 = checkInputValue("date1");
				$PlusOrMinus = checkInputValue("plusorminus");
				$Amount = checkInputValue("number1");
				$Info = checkInputValue("info1");
				
				if ($Date1 != null && $PlusOrMinus != null && $Amount != null && $Info != null) {
					$PlusOrMinus = convertPlusOrMinus($PlusOrMinus);
					$UserID = dbGetUserId($db, $_SESSION["Email"]);
					
					$numOfRows = dbCountTransactionsRows($db);
					$numOfRows = $numOfRows + 1;
					$idExists = dbCheckIdExists($db, $numOfRows);
					while ($idExists > 0) {
						$numOfRows = $numOfRows + 1;
						$idExists = dbCheckIdExists($db, $numOfRows);
					}
					
					dbAddTransaction($db, $numOfRows, $UserID, $Date1, $PlusOrMinus, $Amount, $Info);
					redirect("main.php");
					
				}
				else {
					echo '	<div class="alert alert-danger" role="alert">
								Vsa zahtevana polja niso bila izpolnjena!
							</div>';
				}
				
			}
			else if (isset($_POST) && isset($_POST["insert_nazaj"]))  {
				redirect("main.php");	
			}
		
		?>
		
		<header class="frame">
			<div class="container">
				<div class="row">
					<div class="col">
						<?php include("tpl/headerMainPage.php"); ?>
					</div>
				</div>
			</div>
			
		</header>
		
		<section class="frame">
			
			<div class="container">
				<div class="row">
					<div class="col">
						<form class="my_form" method="post">
							<div class="mb-4">
								<label for="date1" class="form-label my_label">Datum transakcije:</label>
								<input type="date" class="form-control" id="date1" name="date1" value="<?php echo isset($_POST["date1"]) ? $_POST["date1"] : ""?>">
							</div>
							<div class="mb-4">
								<label class="form-label my_label">Izberite ustrezno:</label></br>
								<input type="radio" id="dohodek" name="plusorminus" value="dohodek" <?php echo (isset($_POST["plusorminus"]) && $_POST["plusorminus"] == "dohodek") ? 'checked': '' ?>>
								<label for="dohodek" class="my_radio_label">Dohodek</label>
								<input type="radio" id="odhodek" name="plusorminus" value="odhodek" <?php echo (isset($_POST["plusorminus"]) && $_POST["plusorminus"] == "odhodek") ? 'checked': '' ?>>
								<label for="odhodek">Odhodek</label><br>
							</div>
							<div class="mb-4">
								<label for="number1" class="form-label my_label">Vsota transakcije:</label>
								<input type="number" class="form-control" id="number1" name="number1" step="0.01" min="0" value="<?php echo isset($_POST["number1"]) ? $_POST["number1"] : ""?>">
							</div>
							<div class="mb-4">
								<label for="info1" class="form-label my_label">Informacije transakcije:</label>
								<textarea class="form-control" rows="5" cols="80" id="info1" name="info1"><?php echo isset($_POST["info1"]) ? $_POST["info1"] : ""?></textarea>
							</div>
							<div class="mb-4">
								<button type="submit" class="btn btn-success btn-dodaj" name="insert_dodaj">Dodaj</button>
								<button type="submit" class="btn btn-warning btn-dodaj" name="insert_nazaj">Nazaj</button>
							</div>
							
						</form>
					</div>
				</div>
			</div>
			
		</section>
		
		<footer class="frame text-center">
			<div class="container">
				<div class="row">
					<div class="col">
						<?php include("tpl/footerMainPage.php");  ?>
					</div>
				</div>
			</div>
		</footer>
	
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
		
	</body>

</html>