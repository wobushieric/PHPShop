<?php  
	require 'connect.php';
	session_start();

	$productName = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$mfr = filter_input(INPUT_POST, 'mfr', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$command = filter_input(INPUT_POST, 'command', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$productId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
	$productimgN = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$userIsLogin = false;

	if (isset($_SESSION['currentUser'])) {
		$userIsLogin = true;
	}

	if ($userIsLogin) {
		if (isset($productName) and isset($price) and isset($mfr)) {

			$errorFlag = false;

			if ($price < 0) {
				$errorFlag = true;
			}

			if ($command == "Add" && !$errorFlag) {
				$query = "INSERT INTO produts (productname, username, price, mfr, productimg) values (:productname, :username, :price, :mfr, :productimg)";
			
				$statement = $db->prepare($query);
				$statement->bindValue(':productname', $productName);
				$statement->bindValue(':username', $_SESSION['currentUser']);
				$statement->bindValue(':price', $price);
				$statement->bindValue(':mfr', $mfr);
				$statement->bindValue(':productimg', $productimgN);

				echo $productimgN;

				$statement->execute();
			}

			if ($command == "Update" && !$errorFlag) {
				$query = "UPDATE produts SET productname = :productname, price = :price, mfr=:mfr WHERE id = :id";

				$statement = $db->prepare($query);
				$statement->bindValue(':productname', $productName);
				$statement->bindValue(':price', $price);
				$statement->bindValue(':mfr', $mfr);
				$statement->bindValue(':id', $productId);

				$statement->execute();

			}

			if ($command == "Delete" && !$errorFlag) {
				
				$query = "SELECT productimg FROM produts WHERE productname = :productname";

				$statement = $db->prepare($query);
				$statement->bindValue(':productname', $productName);
				$statement->execute();

				if ($statement->rowCount() > 0) {
					$row = $statement->fetch();
				
					if ($row['productimg'] != '') {
						$imgPath = "productimgs/" . $row['productimg'];

						unlink($imgPath);

						$pos = strpos($row['productimg'], '.');

						$imgN = substr_replace($row['productimg'], '_medium', $pos, 0); 

						$imgPath = "productimgs/" . $imgN;

						unlink($imgPath);

						$imgN = substr_replace($row['productimg'], '_thumbnail', $pos, 0); 

						$imgPath = "productimgs/" . $imgN;

						unlink($imgPath);
					}
				}

				$query = "DELETE FROM produts WHERE productname = :productname AND username = :username";

				$statement = $db->prepare($query);
				$statement->bindValue(':productname', $productName);
				$statement->bindValue(':username', $_SESSION['currentUser']);

				$statement->execute();
			}

			header("Location: userProducts.php");
			exit;		
		}
	}
?>