<?php
session_start();
$fname = $_POST['fname'] ?? null;
$lname = $_POST['lname'] ?? null;
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$errors = array();
include 'includes/library.php';
$pdo = connectdb();
if(isset($_POST['update-name'])){
    if (!isset($fname) || strlen($fname) === 0)
        $errors['name'] = true;
    if (!isset($lname) || strlen($lname) === 0)
        $errors['name'] = true;
    if (count($errors) === 0){
        $query = "UPDATE users SET firstName=?,lastName=? WHERE id=?";
        $stmnt = $pdo->prepare($query);
        $stmnt->execute([$fname,$lname,$_SESSION['userID']]);
        $nameupdate=true;
    }
}
if(isset($_POST['update-username'])){
    if (!isset($username) || strlen($username) === 0)
        $errors['username'] = true;
    $query = "SELECT username FROM users WHERE username=?";
    $stmnt = $pdo->prepare($query);
    $stmnt->execute([$username]);
    $checkUser = $stmnt->fetchall();
    if (!empty($checkUser)) {
    $errors['userExist'] = true;
    }
    if (count($errors) === 0){
        $query = "UPDATE users SET username=? WHERE id=?";
        $stmnt = $pdo->prepare($query);
        $stmnt->execute([$username,$_SESSION['userID']]);
        $usernameupdate=true;
    }
}
if(isset($_POST['update-pass'])){
    if (!isset($password) || strlen($password) === 0)
        $errors['pwd'] = true;
    else {
        if(checkpwd($password))
            $errors['pwdweak']=true;
    }
    if ($password != $_POST['repassword'])
        $errors['pwdmatch'] = true;
    if(count($errors) === 0){
        $query = "UPDATE users SET password=? WHERE id=?";
        $stmnt = $pdo->prepare($query);
        $stmnt->execute([$password,$_SESSION['userID']]);
        $passwordupdate=true;
    }
}

if (isset($_SESSION['userID'])) {
	$id = $_SESSION['userID'];
	$query = "SELECT firstName, lastName, username FROM users WHERE id=?";
    $stmnt = $pdo->prepare($query);
	$stmnt->execute([$id]);
    $row = $stmnt->fetch();
    $fname=$row['firstName'];
    $lname=$row['lastName'];
    $username=$row['username'];
}
else{
    header("Location: login.php");
    exit();
}
if(isset($_POST['delete-account'])){
    $query="DELETE FROM users where id=?";
    $stmnt=$pdo->prepare($query);
    $stmnt->execute([$id]);
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
	<title>User Settings</title>
    
    <link rel="stylesheet" href="../project/styles/index.css">
	<link rel="stylesheet" href="styles/master.css">
    <script defer src="scripts/delete.js"></script>
	<script src="https://kit.fontawesome.com/a56541cbd2.js" crossorigin="anonymous"></script>
    <!-- from https://www.cssscript.com/check-strength-passwords-pwstrength/ -->
    <script src="scripts/checkpw.js"></script>
    <!-- this css has been greatly edited to only contain useful styles -->
    <link rel="stylesheet" href="styles/bootstrap.css">
</head>

<body>
    <div class="div-form">
        <form method="POST">
            <a href="index.php" class="brandcolor">
                <div class="brand-div">
                    <h1>Go2Registry</h1>
                </div>
            </a>

            <div class="update" <?= !isset($nameupdate) ? 'hidden' : ""; ?>>Name Updated</div>
            <div class="update" <?= !isset($usernameupdate) ? 'hidden' : ""; ?>>Username Updated</div>
            <div class="update" <?= !isset($passwordupdate) ? 'hidden' : ""; ?>>Password Updated</div>

            <label for="fname">First Name</label>
            <div class="input">
                <input type="text" name="fname" id="fname" value="<?= $fname ?>" />
                <span class="fa-solid fa-id-card"></span>
            </div>
            <label for="lname">Last Name</label>
            <div class="input">
                <input type="text" name="lname" id="lname" value="<?= $lname ?>" />
                <span class="fa-solid fa-id-card"></span>
            </div>
            <div class="error" <?= !isset($errors['name']) ? 'hidden' : ""; ?>>Please enter your name</div>
            <button type="submit" class="submit-btn" name="update-name">Update name</button>

            <label for="username">Username</label>
            <div class="input">
                <input type="text" name="username" id="username" value="<?= $username ?>" />
                <span class="fa-solid fa-user"></span>
            </div>
            <div class="error" <?= !isset($errors['username']) ? 'hidden' : ""; ?>>Please enter a username</div>
            <button type="submit" class="submit-btn" name="update-username">Update username</button>
            
            <label for="password">Password</label>
            <div class="input">
                <input type="password" name="password" id="password" placeholder="Type your password" onkeyup="getPassword()">
                <span class="fa-solid fa-lock"></span>
            </div>
            <!-- all the html that shows error for passwords -->
            <?php include "includes/pwdcheck.php"; ?>   
            <label for="repassword">Re-enter your password</label>
            <div class="input">
                <input type="password" name="repassword" id="repassword" placeholder=" Re-type your password" >
                <span class="fa-solid fa-user-lock"></span>
            </div>
            <div class="error" <?= !isset($errors['pwdmatch']) ? 'hidden' : ""; ?>>Password do not match</div>
            <button type="submit" name="update-pass">Update password</button>
        </form>
    </div>
    <div class="div-form">
            <form id="deleteaccount" method="POST">
                <button type="submit" name="delete-account">Delete Account</button>
            </form>
        </div>
</body>
</html>