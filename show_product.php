<?php  
	require 'connect.php';
	session_start();

	$userIsLogin = false;

	$productId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

	if (isset($_SESSION['currentUser'])) {
		$userIsLogin = true;

		$query = "SELECT * FROM produts WHERE id = :id AND username = :userName";

		$statement = $db->prepare($query);

		$statement->bindValue(':id', $productId);
		$statement->bindValue(':userName', $_SESSION['currentUser']);

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
			<?php if(!$userIsLogin) :?>
				<form action="index.php" id="registFailForm">
					<p>Please log in!</p>
					<button>OK</button>
				</form>
			<?php else :?>
				<nav id="loggedInNav">
					<ul>
						<li><a href="#"><?=$_SESSION['currentUser']?></a></li>
						<li><a href="userOrders.php">Orders</a></li>
						<li><a href="userProducts.php">Products</a></li>
						<li><a href="#">Clients</a></li>
						<li><a href="logoff.php">Log Off</a></li>
					</ul>
				</nav>

				<div id="userorders">
					<?php if($statement->rowCount() > 0) : ?>
						<?php while ($row = $statement->fetch()): ?>
							<form action="userProducts.php" method="post">
							<fieldset>
								<legend>Info of <?=$row['productname']?></legend>
								<?php if($row['productimg'] == '') :?>
									<img src="productimgs/noimagefound_medium.jpg" alt="noimage" />
								<?php else :?>
									<?php 
										$pos = strpos($row['productimg'], '.');
										$imgName = substr_replace($row['productimg'], '_medium', $pos, 0); 
									?>
									<img src="productimgs/<?=$imgName?>" alt="" />
								<?php endif	?>
								<p>
									<label for="productName">Product Name</label>
									<p><?=$row['productname']?></p>
								</p>
								<p>
									<label for="price">Price</label>
									<p><?=$row['price']?></p>
								</p>
								<p>
									<label for="mfr">Product Manufactor</label>
									<p><?=$row['mfr']?></p>
								</p>
							</fieldset>
								<input type="submit" value="Back" />
							</form>
						<?php endwhile ?>
					<?php endif ?>
				</div>

			<?php endif ?>
		</section>
	</body>
</html>