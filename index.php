<?php 
session_start();
// session_destroy();
?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>The Wall</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<style>

		label{
			font-size: 2em;
		}
		header{
			font-size: 5em;
			padding-bottom: 40px;
		}
		input{
			margin-bottom: 5px;
		}
	</style>
</head>
<body>




	<header align="center">The Wall</header>

	<div class="container">

		<div class="row">
		<!-- LOGIN Form-->
		<div class="col-md-2 col-md-offset-4" align="left">
			<label>Login</label>
				<form action="process.php" method="post">
					Email: <input type="email" name="email" placeholder="Enter email address">
					Password: <input type="password" name="password" placeholder="Enter password">
					<input type="submit" class="btn btn-primary btn-sm"value="Login">
					<input type="hidden" name="action" value="login">
				</form>

	<!-- Error / Success  Messages-->
	<?php 
		if(isset($_SESSION['error'])) {
			foreach ($_SESSION['error'] as $error) {
				echo "<p> {$error} </p>";
			}
			unset($_SESSION['error']);
		}
		
		if(isset($_SESSION['success'])){
				echo "<p class='success'>{$_SESSION['success']} </p>";
		}		unset($_SESSION['success']);
	?>
	
		</div>

		<!-- REGISTER Form-->
		<div class="col-md-2 col-md-offset-1" align="left">
			<label>Register</label>
				<form action="process.php" method="post">
					First Name: <input type="text" name="first_name">
					Last Name: <input type="text" name="last_name">
					Email: <input type="email" name="email">
					Password: <input type="password" name="password">
					Confirm Password: <input type="password" name="confirm_password">
					<input type="submit" class="btn btn-primary btn-sm" value="Register">
					<input type="hidden" name="action" value="register">
				</form>
		</div>

	</div>
	</div>

</body>
</html>

