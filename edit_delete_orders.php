<?php
	require 'connect.php';
	session_start();

	$userIsLogin = false;

	if (isset($_SESSION['currentUser'])) {
		$userIsLogin = true;

		$productId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

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
							<form action="productPost.php" method="post">
								<fieldset>
									<legend>Edit <?=$row['productname']?></legend>
									<?php if($row['productimg'] == '') :?>
										<p>
											<img src="productimgs/noimagefound_medium.jpg" alt="noimage" />
										</p>
									<?php else :?>
										<?php 
											$pos = strpos($row['productimg'], '.');
											$imgName = substr_replace($row['productimg'], '_medium', $pos, 0); ?>
										<p>
											<img src="productimgs/<?=$imgName?>" alt="" />
										</p>
									<?php endif	?>
									<form method="post" enctype="multipart/form-data">
								        <label for="imagefile">Image:</label>
								        <input type="file" name="imagefile" id="imagefile">
								        <input type="submit" name="submit" value="Upload Image">
								    </form>
									<p>
										<label for="productName">Product Name</label>
										<input name="productName" id="productName" value="<?=$row['productname']?>" />
									</p>
									<p>
										<label for="price">Price</label>
										<input name="price" id="price" value="<?=$row['price']?>" />
									</p>
									<p>
										<label for="mfr">Product Manufactor</label>
										<input name="mfr" id="mfr" value="<?=$row['mfr']?>" />
									</p>
									<p>
										<input type="submit" name="command" value="Update" />
										<input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
									</p>
									<p style="display: none;">
										<label for="id">Product id</label>
										<input name="id" id="id" value="<?=$row['id']?>" />
									</p>
								</fieldset>
							</form>
						<?php endwhile ?>
					<?php endif ?>
				</div>
			<?php endif ?>
		</section>
	</body>
</html>