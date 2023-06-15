<?php

	ob_start();
	session_start();
	include("tpl/config.php");
	include("tpl/function.php");
	
	$logedIn = checkLogIn();
	$isAdmin = checkAdmin();
	if ($logedIn) {
		if ($isAdmin == true) {
			redirect("adminMain.php");
		}
		else {
			redirect("main.php");
		}
		
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
		
		<header class="frame">
			<div class="container">
				<div class="row">
					<div class="col">
						<?php include("tpl/header.php"); ?>
					</div>
				</div>
			</div>
			
		</header>
		
		<section class="frame">
			
				<div class="container">
					<div class="row">
						<div class="col">
							<h3 class="my_h3">Spremljajte svoj osebni proračun</h3>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<p class="my_p">Na tej spletni strani lahko spremljate svoj osebni proračun.</p>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<img src="img/monay2.png" class="img-fluid">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<h3 class="my_h3">Dodajte, odstranite in uredite svoje dohodke</h3>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<p class="my_p">Po samem logiranju v stran lahko dodate dohodek, ga odstranite ali uredite.<br>Stran pa vam bo nato sama izračunala, kakšno je vaše finančno stanje.</p>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<h3 class="my_h3">Pričnite z uporabo</h3>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<p class="my_p">Pred uporabo je potreben vpis na oknu LogIn. V kolikor pa ste tukaj prvič,<br>vas prosimo, da najprej opravite še registracijo na oknu Register.</p>
						</div>
					</div>
				</div>
			
		</section>
		
		<footer class="frame text-center">
			<div class="container">
				<div class="row">
					<div class="col">
						<?php include("tpl/footer.php");  ?>
					</div>
				</div>
			</div>
		</footer>
	
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

		
	</body>

</html>