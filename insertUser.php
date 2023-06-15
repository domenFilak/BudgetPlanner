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
			
			$username1 = checkInputValue("username1");
			$email1 = checkInputValue("email1");
			$password1 = checkInputValue("password1");

			if (isset($_POST) && isset($_POST["dodaj"]) && count($_POST) > 0) {
			
				if (($username1 != null) && ($email1 != null) && ($password1 != null)) {
					if (checkUsernameStrength($username1)) {
						if (checkMail($email1)) {
							if ($username1 != $email1 && $username1 != $password1) {
								if ($password1 != $username1 && $password1 != $email1) {
									if (checkPasswordStrength($password1)) {
											$userExists = dbCheckValueExists($db, "UserEmail" ,$email1);
											if ($userExists) {
												echo '	<div class="alert alert-danger" role="alert">
															Uporabnik z danim e-mail naslovom že obstaja!
														</div>';
											}
											else {
												$numOfRows = dbCountUsersRows($db);
												$numOfRows = $numOfRows + 1;
												$idExists = dbCheckUserIdExists($db, $numOfRows);
												while ($idExists > 0) {
													$numOfRows = $numOfRows + 1;
													$idExists = dbCheckUserIdExists($db, $numOfRows);
												}
												dbAddUser($db, $numOfRows, $email1, $username1, $password1);
												$_POST = array();
												redirect("uporabniki.php");
												
												
											}
									}
									else {
										echo '	<div class="alert alert-danger" role="alert">
														Geslo mora vsebovati vsaj eno veliko črko, eno malo črko, številko, poseben znak ter biti vsaj dolžine 8!
												</div>';
									}
								}
								else {
									echo '	<div class="alert alert-danger" role="alert">
												Geslo ne sme biti enako kot uporabniško ime/e-mail!
											</div>';
								}
							}
							else {
								echo '	<div class="alert alert-danger" role="alert">
											Uporabniško ime ne sme biti enako kot e-mail/geslo!
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
									Uporabniško ime mora biti dolžine vsaj 5!
								</div>';
					}
				}
				else {

					echo '	<div class="alert alert-danger" role="alert">
								Vsa zahtevana polja niso bila izpolnjena!
							</div>';

				}
			
			}
			else if (isset($_POST) && isset($_POST["insert_nazaj"])) {
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
						<form id="configform" class="my_form" method="post">
							<div class="mb-4">
								<label for="username1" class="form-label">Uporabniško ime</label>
								<input type="text" class="form-control" id="username1" name="username1" value="<?php echo isset($_POST["username1"]) ? $_POST["username1"] : ""?>" aria-describedby="usernameHelp">
								<div id="usernameHelp" class="form-text">Uporabniško ime naj bo dolžine vsaj 5 črk</div>
							</div>
							<div class="mb-4">
								<label for="email1" class="form-label">Email naslov</label>
								<input type="email" class="form-control" id="email1" name="email1" value="<?php echo isset($_POST["email1"]) ? $_POST["email1"] : ""?>" aria-describedby="emailHelp">
								<div id="emailHelp" class="form-text">Primer pravilno formuliranega e-mail naslova: emailtest@gmail.com</div>
							</div>
							<div class="mb-4">
								<label for="password1" class="form-label">Geslo</label>
								<input type="password" class="form-control" id="password1" name="password1" value="<?php echo isset($_POST["password1"]) ? $_POST["password1"] : ""?>" aria-describedby="passwordHelp">
								<div id="passwordHelp" class="form-text">Geslo naj bo vsaj dolžine 8 črk, naj vsebuje vsaj eno veliko črko, vsaj eno malo črko, vsaj eno številko in vsaj en poseben simbol</div>
							</div>
							<button type="submit" class="btn btn-primary btn-dodaj" name="dodaj">Dodaj</button>
							<button type="submit" class="btn btn-warning btn-dodaj" name="insert_nazaj">Nazaj</button>
						</form>
					</div>
				</div>
			</div>
		</section>
		
		<footer class="frame  text-center">
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