<?php  
	session_start();
	$_SESSION = array();

	include("simple-php-captcha.php");
	$_SESSION['captcha'] = simple_php_captcha();

?>

<!doctype html>
<html>
	<head>
		<title>Order Management System</title>
		<link rel="stylesheet" type="text/css" href="projectstyles.css" />
		<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css' />
		<script src="js/loginValidate.js" type="text/javascript"></script>
		<script src="js/utilityFunctions.js" type="text/javascript"></script>
	</head>
	<body>
		<header>
			<h1>Order Management System</h1>
			<img src="images/Logo.png" alt="LOGO" />
			<a class="alooklikebutton" href="contactme.php">Contact Me</a>
		</header>
		<section id="container">
			<form id="userLogin" method="post" action="login_post.php">
				<fieldset class="regularfiled">
				<legend>Sign in</legend>
					<ol>
						<li>
							<label for="username">User Name</label>
							<input id="username" name="username" type="text" placeholder="Please enter your user name" />
							<p class="usernameError error" id="username_error">* User name is required</p>
						</li>
						<li>
							<label for="password">Password</label>
							<input id="password" name="password" type="password" placeholder="Please enter your password" />
							<p class="passwordError error" id="password_error">* Password is required</p>
						</li>
						<li>
							<label for="captcha">Captcha</label>
							<input id="captcha" name="captcha" type="text" />
							<img src="<?=$_SESSION['captcha']['image_src']?>" alt="CAPTCHA" />
						</li>
					</ol>
				</fieldset>
				<fieldset class="regularfiled">					
					<button type="submit" id="submit">Login</button>
				</fieldset>
			</form>
			<button tyep="button" id="registerNow">Register now</button>
			<form id="registerForm" method="post" action="register_post.php">
				<fieldset class="regularfiled">
				<legend>New User</legend>
					<ol>
						<li>
							<label for="newUsername">User Name</label>
							<input id="newUsername" name="newUsername" type="text" placeholder="Please enter your user name" />
						</li>
						<li>
							<label for="newPassword">Password</label>
							<input id="newPassword" name="newPassword" type="password" placeholder="Please enter your password" />
						</li>
						<li>
							<label for="passwordAgain">Confirm Password</label>
							<input id="passwordAgain" name="passwordAgain" type="password" placeholder="Please enter the same password again" />
						</li>
					</ol>
				</fieldset>
				<fieldset class="regularfiled">					
					<button type="submit" id="register">Create Account</button>
				</fieldset>
			</form>
			<button id="closeRegister"></button>
		</section>
	</body>
</html>