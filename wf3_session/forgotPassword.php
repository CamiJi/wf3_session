<?php
	session_start();

	require(__DIR__.'/config/db.php');

	// 1. Vérifier que le form a bien été soumis
	if(isset($_POST['action'])) {
		//2. Affecter une variable à l'email récupéré, (faire trim et htmlentities)
		$email = trim(htmlentities($_POST['email']));

		//3. Initialisation d'un tableau d'erreurs $errors
		$errors = [];

		//4. Check du champs email
		if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false){
			$errors['email'] = "wrong email";
		}
		elseif (strlen($email) > 60) {
			$errors['email'] = "Email trop long";
		}
		// Si il n'y a pas d'erreurs
		if (empty($errors)) {
			// 5. Récupération de l'utilisateur dans la bdd
			$query = $pdo->prepare('SELECT * FROM users WHERE email = :email');
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			$query->execute();
			// Je récupère le résultat sql
			$resultUser = $query->fetch();

			if ($resultUser) {
				// 6. Génération d'un token, on génère une chaine aléatoire qui servira de clé de sécurité.
				$token = md5(uniqid(mt_rand(), true));

				$expireToken = date("Y-m-d H:i:s", strtotime('+ 1 day'));

				// Updater le user dans la bdd grâce à ces nouvelles informations.
				$query = $pdo->prepare('UPDATE users
									 	SET token = :token, expire_token = :expire_token, updated_at = NOW()
									 	WHERE id =:id');
				$query->bindValue(':token', $token, PDO::PARAM_STR);
				$query->bindValue(':expire_token', $expireToken, PDO::PARAM_STR);				
				$query->bindValue(':id', $resultUser['id'], PDO::PARAM_INT);
				$query->execute();

				// équivalent à : http://localhost/php/38/wf3_session/resetPassword.php?token=8c05f6d9f8bd95785a452697f7bbc34c&email=aubertcam@gmail.com
				// si on travaille sur robert.com on pourra soit changer l'adresse pour la mettre en dur: http://www.robert.com/resetPassword.php?token=8c05f6d9f8bd95785a452697f7bbc34c&email=aubertcam@gmail.com
				// soit garder la formule ci-dessous qui est dynamique et qui se générera automatique toute seule ;)
				$resetLink='http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/resetPassword.php?token='.$token.'$email='.$email;



				$messageResetPassword = "Hello".$email.", To reset your password click the following link : ".$resetLink."Thank You";
				$messageResetPasswordWrap = wordwrap($messageResetPassword, 70, "\r\n");
				$subject = "Click this link to reset your password";

				mail($email, $subject, $messageResetPasswordWrap);

				// echo $resetLink;

			}
			else{
				$errors['user'] = "User not found";
			}

		}
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>WF3 Session</title>
		<!-- Bootstrap CSS -->
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h1>Forgot password</h1>

					<?php if(!empty($errors)): ?>
						<div class="alert alert-danger">
							<?php foreach ($errors as $keyError => $error): ?>
								<p><?php echo $error ?></p>
							<?php endforeach ; ?>	
						</div>
					<?php endif ; ?>

					<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class="form-group">
			              <label for="email">Email</label>
			              <input type="text" class="form-control" id="email" name="email" placeholder="Email">
						</div>

						<button type="submit" name="action" class="btn btn-default">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>