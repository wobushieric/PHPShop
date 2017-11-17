<?php  
	session_start();
	require 'connect.php';

	$userName = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$passWord = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$captcha = filter_input(INPUT_POST, 'captcha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


	if (isset($userName) and isset($passWord)) {
		$query = "SELECT * FROM users WHERE username = '$userName'";
	
		$statement = $db->prepare($query);
		//$statement->bindValud(':userName', $userName);

		$statement->execute();
	}

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
		</header>
		<section id="container">
		<?php if($captcha == $_SESSION['captcha']['code']) : ?>
			<?php if($statement->rowCount() > 0) : ?>
				<?php while ($row = $statement->fetch()): ?>
					<?php if(password_verify($passWord, $row['password'])) : ?>
						<?php $_SESSION['currentUser'] = $row['username']?>
						<?php if($row['isadmin'] == 'n') :?>
							<form action="userOrders.php" id="registFailForm">
								<p>Welcome back <?=$row['username']?></p>
								<button>OK</button>
							</form>
						<?php elseif($row['isadmin'] == 'y') :?>
							<form action="adminlogin.php" id="registFailForm">
								<p>Welcome back administrator: <?=$row['username']?></p>
								<button>OK</button>
							</form>
						<?php endif ?>
					<?php else :?>
						<form action="index.php" id="registFailForm">
							<p>Password is incorrect!</p>
							<button>OK</button>
						</form>
					<?php endif ?>
				<?php endwhile ?>
			<?php else :?>
				<form action="index.php" id="registFailForm">
					<p>User Name is incorrect!</p>
					<button>OK</button>
				</form>
			<?php endif ?>
		<?php else :?>
			<form action="index.php" id="registFailForm">
					<p>Captcha is incorrect!</p>
					<button>OK</button>
			</form>
		<?php endif ?>
		</section>
	</body>
</html>