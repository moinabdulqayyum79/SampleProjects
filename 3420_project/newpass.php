<?php
$errors=array();
if($_GET['email']&&$_GET['pass']){
    $email=$_GET['email'];
    $pass=$_GET['pass'];
    $errors=array();
    require 'includes/library.php';
    $pdo = connectdb();
    $query = "SELECT email, password FROM users WHERE email=? AND password=?";
    $stmnt = $pdo->prepare($query);
    $stmnt->execute([$email,$pass]);
    $checkEmail = $stmnt->fetchall();
    if (empty($checkEmail)) {
        $errors['authentication']=true;
    }
    $password = $_POST['password'] ?? null;
    if (isset($_POST["submit"])){
        if (!isset($password) || strlen($password) === 0)
            $errors['pwd'] = true;
        else {
            if(checkpwd($password))
            $errors['pwdweak']=true;
        }
        if ($password != $_POST['repassword'])
            $errors['pwdmatch'] = true;
        if (count($errors) === 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password=? WHERE email=?";
        $stmnt = $pdo->prepare($query);
        $stmnt->execute([$hash,$email]);
        session_start();
        $_SESSION['passreset']=true;
        header("Location: login.php");
        exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../project/styles/index.css">
    <link rel="stylesheet" href="../project/styles/master.css">
    <script src="https://kit.fontawesome.com/a56541cbd2.js" crossorigin="anonymous"></script>
    <!-- from https://www.cssscript.com/check-strength-passwords-pwstrength/ -->
    <script src="scripts/checkpw.js"></script>
    <!-- this css has been greatly edited to only contain useful styles -->
    <link rel="stylesheet" href="styles/bootstrap.css">
    <title>New Password</title>
</head>

<body>
    <?php if(!isset($errors['authentication'])): ?>
    <div class="div-form">
        <form method="POST" novalidate>
            <a href="index.php" class="brandcolor">
                <div class="brand-div">
                    <h1>Go2Registry</h1>
                </div>
            </a>
            <input hidden type="text" name="email" id="email" value=<?=$email ?>>
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
            <button type="submit" name="submit">Reset</button>

        </form>
    </div>
    <?php else: ?>
        <h1 class="error">Error 404: Sorry we could not find what you were looking for :(</h1>
    <?php endif; ?>
    <?php include "includes/footer.php"; ?>

</body>

</html>