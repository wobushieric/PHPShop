<?php  
	require 'connect.php';
	session_start();

	$userIsLogin = false;

	if (isset($_SESSION['currentUser'])) {
		$userIsLogin = true;

		$sortby = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$sortbyquery = "";

		$searchString = filter_input(INPUT_GET, 'searchproduct', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$searchCatagory = filter_input(INPUT_GET, 'searchcondition', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$pageNum = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);

		if (isset($sortby)) {
			if ($sortby == 'product') {
				$sortbyquery = " ORDER BY productname";
			}elseif ($sortby == 'price') {
				$sortbyquery = " ORDER BY price";
			}elseif ($sortby == 'manufactor') {
				$sortbyquery = " ORDER BY mfr";
			}
		}
		
		if (isset($searchString) && $searchString != '' && $searchCatagory != '') {
			$searchBy = '';

			if ($searchCatagory == 'pname') {
				$searchBy = 'productname';
			}
			elseif ($searchCatagory == 'mfrname') {
				$searchBy = 'mfr';
			}
			$sortbyquery = " AND $searchBy LIKE '$searchString%'";
		}

		$query = "SELECT * FROM produts WHERE username = :username" . $sortbyquery;		

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
						<form action="newProduct.php" id="newproduct">
							<button>New Product</button>
						</form>
						<form action="userProducts.php?" method="get" id="searchproductform">
							<label for="searchproduct">Search by:</label>
							<select for="searchcondition" name="searchcondition">
								<option value="pname">Procudt Name</option>
								<option value="mfrname">Manufator</option>
							</select>
							<input name="searchproduct" id="searchproduct">
							<button>Search</button>
						</form>
						<table id="userproducts">
							<caption><?=$_SESSION['currentUser']?>'s products</caption>
							<thead>
								<th></th>
								<th>Icon</th>
								<th><a href="userProducts.php?sort=product">Product</a></th>
								<th><a href="userProducts.php?sort=price">Price</a></th>
								<th><a href="userProducts.php?sort=manufactor">Manufactor</a></th>
							</thead>
							<tbody>
								<?php if($statement->rowCount() < 10) :?>
									<?php while ($row = $statement->fetch()): ?>
										<tr>
											<td><a href="show_product.php?id=<?=$row['id']?>">show</a></td>
											<?php if($row['productimg'] == '') :?>
												<td><img src="productimgs/noimagefound_thumbnail.jpg" alt="noimage" /></td>
											<?php else :?>
												<?php 
													$pos = strpos($row['productimg'], '.');
													$imgName = substr_replace($row['productimg'], '_thumbnail', $pos, 0); 
												?>
												<td><img src="productimgs/<?=$imgName?>" alt="" /></td>
											<?php endif	?>
											<td><?=$row['productname']?></td>
											<td>$<?=$row['price']?></td>
											<td><?=$row['mfr']?></td>
											<td><a href="edit_delete_orders.php?id=<?=$row['id']?>">edit/delete</a></td>
										</tr>
									<?php endwhile ?>
								<?php else : ?>
									<?php $productData = $statement->fetchAll() ?>
									<?php if(!isset($pageNum) || $pageNum < 0) : ?>
										<?php $pageNum = 1 ?>
									<?php endif ?>
									<?php $items = 0; $maxPage = 999999999 ?>
									<?php if($pageNum * 10 < count($productData)) : ?>
										<?php $items = $pageNum * 10 ?>
									<?php else : ?>
										<?php $items = count($productData) ?>
										<?php $maxPage = $pageNum ?>
									<?php endif ?>
									<?php for ($i=($pageNum - 1)*10; $i < $items; $i++) :?>
										<?php $row = $productData[$i] ?>
										<tr>
											<td><a href="show_product.php?id=<?=$row['id']?>">show</a></td>
											<?php if($row['productimg'] == '') :?>
												<td><img src="productimgs/noimagefound_thumbnail.jpg" alt="noimage" /></td>
											<?php else :?>
												<?php 
													$pos = strpos($row['productimg'], '.');
													$imgName = substr_replace($row['productimg'], '_thumbnail', $pos, 0); 
												?>
												<td><img src="productimgs/<?=$imgName?>" alt="" /></td>
											<?php endif	?>
											<td><?=$row['productname']?></td>
											<td>$<?=$row['price']?></td>
											<td><?=$row['mfr']?></td>
											<td><a href="edit_delete_orders.php?id=<?=$row['id']?>">edit/delete</a></td>
										</tr>
									<?php endfor ?>
								<?php endif ?>
							</tbody>			
					<?php else :?>
						<p>Something is wrong in the database.</p>
					<?php endif ?>
						</table>
				</div>
					<?php if($statement->rowCount() > 10) :?>
						<form action="userProducts.php" method="get" id="pageform">
							<?php if(!isset($pageNum)) :?>
								<?php $pageNum = 1 ?>
							<?php endif ?>
							<?php $pre=$pageNum; $next=$pageNum+1 ?>
							<?php if($pre > 1) :?>
								<?php $pre=$pre-1 ?>
							<?php endif ?>
							<?php if($next > $maxPage) :?>
								<?php $next=$maxPage ?>
							<?php endif ?>
							<button value="<?=$pre?>" name="page" >Pre</button>
							<button value="<?=$next?>" name="page" >Next</button>
						</form>
					<?php endif ?>
			<?php endif ?>
		</section>
	</body>
</html>