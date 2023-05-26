<?php
session_start();
if(!isset($_SESSION['userID'])){
    header("Location: login.php");
    exit();
}
if(isset($_POST['logout'])){
session_destroy();
setcookie("userID","",1);
header("Location: index.php");
exit();
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Confirm Logout</title>
    <link rel="stylesheet" href="../project/styles/index.css">
	<link rel="stylesheet" href="styles/master.css">
</head>
<body>
    <div class="div-form">
        <form method="POST">
            <h2>Confirm Logout:</h2>
            <button type="submit" name="logout" >Logout</button>
            <a href="index.php">Back to Home</a>
        </form>
    </div>
    
	<?php include "includes/footer.php"; ?>

</body>