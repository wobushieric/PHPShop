<?php  
	require 'connect.php';
	session_start();

	$userIsLogin = false;

	if (isset($_SESSION['currentUser'])) {
		$userIsLogin = true;

		$query = "SELECT * FROM orders WHERE username = :username";

		$statement = $db->prepare($query);
		$statement->bindValue(':username', $_SESSION['currentUser']);
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
						<table>
							<caption><?=$_SESSION['currentUser']?>'s orders</caption>
							<thead>
								<th>Client</th>
								<th>Order Amount</th>
								<th>Order Date</th>
							</thead>
							<?php while ($row = $statement->fetch()): ?>
								<tbody>
									<tr>
										<td><?=$row['clientname']?></td>
										<td>$<?=$row['amount']?></td>
										<td><?=$row['orderdate']?></td>
										<td><a href="edit_delete_orders.php?id=<?=$row['id']?>">edit/delete</a></td>
									</tr>
								</tbody>
							<?php endwhile ?>
							<?php else :?>
								<p>Something is wrong in the database.</p>
							<?php endif ?>
						</table>
				</div>

			<?php endif ?>
		</section>
	</body>
</html>