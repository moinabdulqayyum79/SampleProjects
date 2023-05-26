<?php
session_start();
if (isset($_SESSION['userID'])||isset($_COOKIE['userID'])){
    header("Location: index.php");
    exit();
}
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$remember=$_POST['remember']??null;
$errors = array();
if (isset($_POST["submit"])) {
    require 'includes/library.php';
    $pdo = connectdb();
    if (!isset($username) || strlen($username) === 0)
        $errors['username'] = true;
    if (!isset($password) || strlen($password) === 0)
        $errors['pwd'] = true;
    if (count($errors) === 0) {
        $query = "SELECT id, password FROM users WHERE username=?";
        $stmnt = $pdo->prepare($query);
        $stmnt->execute([$username]);
        $row = $stmnt->fetch();
        if (!empty($row)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['userID'] = $row['id'];
                if(isset($remember)){
                    setcookie("userID",$row['id'],time()+60*60*24*365);
                }
                header("Location: index.php");
                exit();
            } else {
                $errors['fail'] = true;
            }
        } else {
            $errors['fail'] = true;
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
    <title>Log-in</title>
</head>

<body>
    
    <div class="div-form">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <a href="index.php" class="brandcolor">
                <div class="brand-div">
                    <h1>Go2Registry</h1>
                </div>
            </a>
            <?php
            if(isset($_SESSION['registered'])) echo '<p class="update">Registration Complete: Please Log in</p>';
            else if(isset($_SESSION['passreset'])) echo '<p class="update">Password Change successful: Please Log in</p>';
            ?>
            <label for="username">Username</label>
            <div class="input">
                <input type="text" name="username" id="username" placeholder="Type your username" value="<?= $username ?>" />
                <span class="fa-solid fa-user"></span>
            </div>
            <div class="error" <?= !isset($errors['username']) ? 'hidden' : ""; ?>>Please enter a username</div>
            
            <label for="password">Password</label>
            <div class="input">
                <input type="password" name="password" id="password" placeholder="Type your password" />
                <span class="fa-solid fa-lock"></span>
            </div>
            <div class="error" <?= !isset($errors['pwd']) ? 'hidden' : ""; ?>>Please enter a password</div>
            <div class="error" <?= !isset($errors['fail']) ? 'hidden' : ""; ?>>Incorrect username and/or password</div>
            <div class="rememberUser">
                <input type="checkbox" class="check-box" name="remember" />
                <label for="rememberUser">Remember me</label>
            </div>

            <button type="submit" class="submit-btn" name="submit">Login</button>
            <span class="psw"><a href="reset.php">Forgot password?</a></span>
            <span>Don't have an account? <a href="register.php">Sign up</a></span>
        </form>
    </div>
    <?php include "includes/footer.php"; ?>
</body>

</html>

<?php
session_destroy();
?>