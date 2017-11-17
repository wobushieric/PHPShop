<?php  
	require 'connect.php';
	session_start();
	require('imageResize.php');
    use \Eventviva\ImageResize;

	$userIsLogin = false;

	if (isset($_SESSION['currentUser'])) {
		$userIsLogin = true;	
	}

    //return the save path for the uploaded file
    function file_upload_path($original_filename, $upload_subfolder_name = 'productimgs') {
       $current_folder = dirname(__FILE__);
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
       return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    $image_upload_detected = isset($_FILES['imagefile']) && ($_FILES['imagefile']['error'] === 0);
    
    if ($image_upload_detected) {
        $image_filename       = $_FILES['imagefile']['name'];
        $temporary_image_path = $_FILES['imagefile']['tmp_name'];
        $new_image_path       = file_upload_path($image_filename);

        if (file_is_an_image($temporary_image_path, $new_image_path)) { 
            move_uploaded_file($temporary_image_path, $new_image_path);

            if ($_FILES["imagefile"]["type"] != 'pdf') {
                $image = new ImageResize($new_image_path);
                $image->resizeToWidth(400);

                $actual_file_extension   = pathinfo($new_image_path, PATHINFO_EXTENSION);
                $pos = strpos($new_image_path,$actual_file_extension,1) - 1;

                $newFileName = substr_replace($new_image_path, '_medium', $pos, 0);
                $image->save($newFileName);

                $image = new ImageResize($new_image_path);
                $image->resizeToWidth(50);

                $newFileName = substr_replace($new_image_path, '_thumbnail', $pos, 0);
                $image->save($newFileName);
            }

        }
    }

    function file_is_an_image($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        //$actual_mime_type        = getimagesize($temporary_path)['mime'];
        $actual_mime_type        = $_FILES["imagefile"]["type"];

        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
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

				<div id="userorders" style="border: solid 1px;">
					<h3>Add New Product</h3>
					<?php if (isset($_FILES['imagefile']) && $_FILES['imagefile']['error'] > 0): ?>
				        <p>Error Number: <?= $_FILES['imagefile']['error'] ?></p>
				    <?php elseif (isset($_FILES['imagefile'])): ?>
				    	<img  style="width: 200px; height: auto;" src="productimgs/<?= $_FILES['imagefile']['name'] ?>" alt="newimage" />
				    <?php endif ?>
					<form method="post" enctype="multipart/form-data">
				        <label for="imagefile">Image:</label>
				        <input type="file" name="imagefile" id="imagefile">
				        <input type="submit" name="submit" value="Upload Image">
				    </form>

					<form action="productPost.php" method="post">
						<fieldset style="border: none;">						
							<p>
								<label for="productName">Product Name</label>
								<input name="productName" id="productName" />
							</p>
							<p>
								<label for="price">Price</label>
								<input name="price" id="price" />
							</p>
							<p>
								<label for="mfr">Product Manufactor</label>
								<input name="mfr" id="mfr" />
							</p>
							<?php if (isset($_FILES['imagefile'])): ?>
								<input style="display: none;" name="image" id="image" value="<?= $_FILES['imagefile']['name'] ?>" />
							<?php endif ?>
							<p>
								<input type="submit" name="command" value="Add" />
							</p>
						</fieldset>						
					</form>
				</div>

			<?php endif ?>
		</section>
	</body>
</html>