<?php
	require 'PHPMailerAutoload.php';

	$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$mail = new PHPMailer;

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'bitwebprojecttest@gmail.com';                 // SMTP username
	$mail->Password = 'Password01web';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

	$mail->From = 'bitwebprojecttest@gmail.com';
	$mail->FromName = 'BITWebProjectEric';
	$mail->addAddress('dgxeric@gmail.com', 'Eric Dai');     // Add a recipient
	// $mail->addAddress('ellen@example.com');               // Name is optional
	$mail->addReplyTo('<?=$email?>', '<?=$name?>');
	// $mail->addCC('cc@example.com');
	// $mail->addBCC('bcc@example.com');

	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'User Email from OMS web project';
	$mail->Body    = $message;
	$mail->AltBody = 'User did not write anything!';

	$emailSendSucsscess = false;
	//echo $message;
	if(!$mail->send()) {
	    // echo 'Message could not be sent.';
	    // echo 'Mailer Error: ' . $mail->ErrorInfo;
	    $emailSendSucsscess = false;
	} else {
	    //echo 'Message has been sent';
	    $emailSendSucsscess = true;
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
			<form action="index.php" id="registFailForm">
				<?php if(!$emailSendSucsscess) :?>
					<p>Send email failure! <?=$mail->ErrorInfo?></p>
				<?php elseif($emailSendSucsscess) :?>
					<p>Thank you for contact me!</p>
				<?php endif ?>
				<button>OK</button>
			</form>
		</section>
	</body>
</html>