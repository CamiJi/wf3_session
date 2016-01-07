<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Wf3 Session</title>
		<meta charset='utf-8'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	</head>

	<body>
		<div class="container">
			<div class="row">

				<?php if(isset($_SESSION['message'])): ?>
					<div class="alert alert-info">
						<p><?php echo $_SESSION['message']; ?></p>
						<?php unset($_SESSION['message']); ?>
					</div>
				<?php endif; ?>

				<div class="col-md-6">
					<h1>Register</h1>

					<!-- Affiche les erreurs stockés en session avec la clé registerErrors -->
					<?php if(isset($_SESSION['registerErrors'])): ?>
						<div class="alert alert-danger">
							<?php foreach($_SESSION['registerErrors'] as $keyError => $error): ?>
								<p><?php echo $error; ?></p>
							<?php endforeach; ?>
						</div>
						<!-- Supprime les erreurs après les avoir affiché 1 fois -->
						<?php unset($_SESSION['registerErrors']); ?>
					<?php endif; ?>

					<!-- Copié de bootstrap : http://getbootstrap.com/css/#forms -->
					<form method="POST" action="registerHandler.php">
						<div class="form-group">
			              <label for="email">Email</label>
			              <input type="text" class="form-control" id="email" name="email" placeholder="Email">
			            </div>

			            <div class="form-group">
			              <label for="password">Password</label>
			              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
			            </div>

			            <div class="form-group">
			              <label for="passwordConfirm">Confirm Password</label>
			              <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder="Confirm Password">
			            </div>

			            <button type="submit" name="action" class="btn btn-default">Submit</button>
					</form>
				</div>


				<div class="col-md-6">
					<h1>Login</h1>

					<!-- Affiche les erreurs stockés en session avec la clé loginErrors -->
					<?php if(isset($_SESSION['loginErrors'])): ?>
						<div class="alert alert-danger">
							<?php foreach ($_SESSION['loginErrors'] as $keyError => $error): ?>
								<p><?php echo $error; ?></p>
							<?php endforeach; ?>
						</div>
						<!-- Supprime les erreurs après les avoir affiché 1 fois -->
						<?php unset($_SESSION['loginErrors']); ?>
					<?php endif; ?>


					<form method="POST" action="loginHandler.php">
						<div class="form-group">
			              <label for="email">Email</label>
			              <input type="text" class="form-control" id="email" name="email" placeholder="Email">
			            </div>

			            <div class="form-group">
			              <label for="password">Password</label>
			              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
			            </div>

			            <div class="form-group">
			            	<p class="help-block"><a href="forgotPassword.php">Forgot your password ?</a></p>
			            </div>

			            <button type="submit" name="action" class="btn btn-default">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>