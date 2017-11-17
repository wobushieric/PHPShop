<?php  
	require 'connect.php';
	session_start();
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
			<form action="index.php" id="registFailForm">
				<p>Goodbye! <?=$_SESSION['currentUser']?></p>
				<?php  
					session_destroy();
				?>
				<button>OK</button>
			</form>
		</section>
	</body>
</html>