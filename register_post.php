<?php  
	require 'connect.php';

	$userName = filter_input(INPUT_POST, 'newUsername', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$passWord = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$confirmPassword = filter_input(INPUT_POST, 'passwordAgain', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$registSuccess = true;
	$errorMessage = '';

	if (isset($userName) and isset($passWord) and isset($confirmPassword) and trim($userName) != "" and trim($passWord) != "" and trim($confirmPassword) != "") {
		if ($passWord != $confirmPassword) {
			$errorMessage = 'Two passwords must be the same!';

			$registSuccess = false;
		}else{

			$hasedPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);

			$query = "INSERT INTO users (username, password, isadmin) values (:username, :password, 'n')";

			$statement = $db->prepare($query);

			$statement->bindValue(':username',$userName);
			$statement->bindValue(':password',$hasedPassword);

			$statement->execute();

			session_start();

			$_SESSION['currentUser'] = $userName;			
		}
	}else{
		$errorMessage = 'Please enter new user name and password!';

		$registSuccess = false;
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
		<?php if(!$registSuccess) :?>
			<form action="index.php" id="registFailForm">
				<p><?=$errorMessage?></p>
				<button>OK</button>
			</form>
		<?php else :?>
			<form action='userOrders.php' id="registFailForm">
				<p>Regist successed!</p>
				<button>OK</button>
			</form>
		<?php endif ?>
		</section>
	</body>
</html>