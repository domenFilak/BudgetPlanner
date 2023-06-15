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
	
	$UserID = (isset($_GET) && isset($_GET['UserID']) && is_numeric($_GET['UserID'])) ? $_GET['UserID'] : null;
	
	$row = dbGetRowUser($db, $UserID);
	
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
			
			if (isset($_POST) && isset($_POST["insert_posodobi"])) {
			
				$UserName = checkInputValue("username1");
				$UserPassword = checkInputValue("userpassword1");
				
				if ($UserName != null && $UserPassword != null) {
			
					dbUpdateUser($db, $UserID, $UserName, $UserPassword);
					redirect("uporabniki.php");
				}
				else {
					echo '	<div class="alert alert-danger" role="alert">
								Vsa zahtevana polja niso bila izpolnjena!
							</div>';
				}
				
			}
			else if (isset($_POST) && isset($_POST["insert_nazaj"]))  {
				redirect("uporabniki.php");	
			}
		
		?>
		
		<header class="frame">
			<div class="container">
				<div class="row">
					<div class="col">
						<?php include("tpl/headerAdminMainPage.php"); ?>
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
								<label for="username1" class="form-label my_label">Uporabniško ime:</label>
								<input type="text" class="form-control" id="username1" name="username1" value="<?php echo (isset($_POST["username1"])) ? $_POST["username1"] : getFieldValue($row, "UserName"); ?>">
							</div>
							<div class="mb-4">
								<label for="userpassword1" class="form-label my_label">Uporabniško geslo:</label>
								<input type="text" class="form-control" id="userpassword1" name="userpassword1" value="<?php echo (isset($_POST["userpassword1"])) ? $_POST["userpassword1"] : getFieldValue($row, "UserPassword"); ?>">
							</div>
							<div class="mb-4">
								<button type="submit" class="btn btn-success btn-dodaj" name="insert_posodobi">Posodobi</button>
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