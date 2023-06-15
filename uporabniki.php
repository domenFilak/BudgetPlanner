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
		<meta charset="utf-8">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="custom_css/mycss.css">
		<link rel="icon" type="image/x-icon" href="img/monay.png">
	</head>
	
	<body>
		<?php
			checkLogOut();
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
							<?php
								echo dbOutputUsers($db);
							?>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<a class="btn btn-success btn-dodaj" href="insertUser.php">Dodaj uporabnika</a>
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