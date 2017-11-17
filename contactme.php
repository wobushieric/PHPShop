<!doctype html>
<html>
	<head>
		<title>Order Management System</title>
		<link rel="stylesheet" type="text/css" href="projectstyles.css" />
		<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css' />
		<script src="js/loginValidate.js" type="text/javascript"></script>
		<script src="js/utilityFunctions.js" type="text/javascript"></script>
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
	</head>
	<body>
		<header>
			<h1>Order Management System</h1>
			<img src="images/Logo.png" alt="LOGO" />
			<a class="alooklikebutton" href="index.php">Login Page</a>
		</header>
		<section id="contactContainer">
			<h2>GET IN TOUCH</h2>
			<div id="contactdetails">
				<h4>CONTACT DETAILS</h4>
				<ul>
					<li>Winnipeg, MB, Canada</li>
					<li>+1 204-202-7539</li>
					<li>dgxeric@gmail.com</li>
				</ul>
			</div>
			<form id="leaveMessage" action="sendemailpost.php" method="post">
				<fieldset class="regularfiled">
					<legend>DROP ME A MESSAGE</legend>
					<ul>
						<li>
							<label for="name">Name</label>
							<input id="name" name="name" type="text" placeholder="Your Name" />
							<div class="name_error error" id="name_error">* Please enter your name.</div>
						</li>
						<li>
							<label for="phone">Phone</label>
							<input id="phone" name="phone" type="tel" placeholder="E.g. 000-000-0000"/>
							<div class="phone_error error" id="phone_error">* Please enter your phone number.</div>
							<div class="invalidphone_error error" id="invalidphone_error">* Please enter ten digit number.</div>
						</li>
						<li>
							<label for="email">E-mail</label>
							<input id="email" name="email" type="email" placeholder="E.g. 123@abc.com" />
							<div class="email_error error" id="email_error">* Please enter your email address.</div>
							<div class="invalidemail_error error" id="invalidemail_error">* Please enter a valid email address.</div>
						</li>
						<li>
							<label for="message">Message</label>
							<textarea id="message" name="message" rows="15"></textarea>
						</li>
					</ul>
				</fieldset>
				<fieldset id="formbuttons">					
					<button type="reset">Reset</button>
					<button type="submit" id="submit">Send</button>
				</fieldset>
			</form>
		</section>
	</body>
</html>