<?php
	ob_start();
	session_start();
	include("tpl/config.php");
	include("tpl/function.php");
	
	
	$db = dbConnect();
	
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
	
		<?php
		
			$email1 = checkInputValue("email1");
			$password1 = checkInputValue("password1");
			
			if (isset($_POST) && count($_POST) > 0) {
				if (($email1 != null) && ($password1 != null)) {
					if (checkMail($email1)) {
						$userExists = dbCheckValueExists($db, "UserEmail", $email1);
						if ($userExists) {
							$passwordsMatch = dbCheckPasswordsMatch($db, $email1, $password1);
							if ($passwordsMatch) {
								$_SESSION["LogIn"] = true;
								$username = dbGetUsername($db, $email1);
								$_SESSION["Username"] = $username;
								$_SESSION["Email"] = $email1;
								
								if (checkIsAdmin($email1, $password1)) {
									$_SESSION["isAdmin"] = true;
									redirect("adminMain.php");
								}
								else {
									redirect("main.php");
								}
												
							}
							else {
								echo '	<div class="alert alert-danger" role="alert">
											Za dani e-mail naslov geslo ni pravilno!
										</div>';
							}
						}
						else {
							echo '	<div class="alert alert-warning" role="alert">
										Uporabnik z danim e-mail naslovom še ne obstaja! Prosimo, da opravite registracijo.
									</div>';
							
						}
					}
					else {
						echo '	<div class="alert alert-danger" role="alert">
										E-mail naslov ni bil pravilno formuliran!
								</div>';
					}
				}
				else {
						echo '	<div class="alert alert-danger" role="alert">
									Vsa zahtevana polja niso bila izpolnjena!
								</div>';
				}
			
			}
		
		
		?>
		
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
						<form class="my_form" method="post">
							<div class="mb-4">
								<label for="email1" class="form-label">Email naslov</label>
								<input type="email" class="form-control" id="email1" name="email1" value="<?php echo isset($_POST["email1"]) ? $_POST["email1"] : ""?>" aria-describedby="emailHelp">
								<div id="emailHelp" class="form-text">Primer pravilno formuliranega e-mail naslova: emailtest@gmail.com</div>
							</div>
							<div class="mb-4">
								<label for="password1" class="form-label">Geslo</label>
								<input type="password" class="form-control" id="password1" name="password1" value="<?php echo isset($_POST["password1"]) ? $_POST["password1"] : ""?>">
							</div>
							<button type="submit" class="btn btn-primary btn-dodaj">LogIn</button>
						</form>
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