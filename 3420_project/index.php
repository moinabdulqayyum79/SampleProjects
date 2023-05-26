<?php
session_start();
if (isset($_SESSION['userID'])) {
	include 'includes/library.php';
	$pdo = connectdb();
	$id = $_SESSION['userID'];
	$query = "SELECT firstName FROM users WHERE id=?";
	$stmnt = $pdo->prepare($query);
	$stmnt->execute([$id]);
	$row = $stmnt->fetch();
	$name = $row['firstName'];
}
else if(isset($_COOKIE['userID'])){
	include 'includes/library.php';
	$pdo = connectdb();
	$id = $_COOKIE['userID'];
	$query = "SELECT firstName FROM users WHERE id=?";
	$stmnt = $pdo->prepare($query);
	$stmnt->execute([$id]);
	$row = $stmnt->fetch();
	$name = $row['firstName'];
	$_SESSION['userID']=$_COOKIE['userID'];
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registry</title>
	<link rel="stylesheet" href="styles/index.css">
	<script src="https://kit.fontawesome.com/53592b4a53.js" crossorigin="anonymous"></script>
</head>

<body>
	<main>
		<?php include "includes/nav.php"; ?>


		<h2 <?= !isset($name) ? 'hidden' : ""; ?>>Welcome <?= $name ?>!</h2>
		<div class="mainIndex">
			<div class="slogan">
				<h2>Registry for all your needs!</h2>
			</div>
		</div>

		<div class="info">
			<h3>Who we are?</h3>
			<p>
				Are you tired of event specific gift registeries? Would you like to have a registry for events
				other than a wedding or birthday? Well, we got you covered. Go2Registry is a universal gift 
				registry to fulfill your needs regardless of what event you are celebrating.
			</p>

		</div>
		<div class="info">
			<h3>How it works?</h3>
			<p>
				Its all very simple. First create an account. Then just go ahead and create all the registeries
				you need for all your events. Share your registeries with your friends and family, and await
				you exciting gifts.
			</p>

		</div>
	</main>

	<?php include "includes/footer.php"; ?>
</body>

</html>