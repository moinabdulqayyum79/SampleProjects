<?php
$fname = $_POST['fname'] ?? null;
$lname = $_POST['lname'] ?? null;
$username = $_POST['username'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$errors = array();
if (isset($_POST["submit"])) {
    require 'includes/library.php';
    $pdo = connectdb();
    //validate user has entered a name
    if (!isset($fname) || strlen($fname) === 0)
        $errors['name'] = true;
    if (!isset($lname) || strlen($lname) === 0)
        $errors['name'] = true;
    //check user entered username
    if (!isset($username) || strlen($username) === 0)
        $errors['username'] = true;
    //validate and sanitize email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors['email'] = true;
    if (!isset($password) || strlen($password) === 0)
        $errors['pwd'] = true;
    else {
        if(checkpwd($password))
            $errors['pwdweak']=true;
    }
    if ($password != $_POST['repassword'])
        $errors['pwdmatch'] = true;
    $query = "SELECT email FROM users WHERE email=?";
    $stmnt = $pdo->prepare($query);
    $stmnt->execute([$email]);
    $checkEmail = $stmnt->fetchall();
    if (!empty($checkEmail)) {
        $errors['emailExist'] = true;
    }
    $query = "SELECT username FROM users WHERE username=?";
    $stmnt = $pdo->prepare($query);
    $stmnt->execute([$username]);
    $checkUser = $stmnt->fetchall();
    if (!empty($checkUser)) {
        $errors['userExist'] = true;
    }
    if (count($errors) === 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users(email, firstName, lastName, username, password) VALUES (?,?,?,?,?)";
        $stmnt = $pdo->prepare($query);
        $stmnt->execute([$email, $fname, $lname, $username, $hash]);
        session_start();
        $_SESSION['registered']=true;
        header("Location: login.php");
        exit();
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
    
    <title>Sign-up</title>
</head>

<body>
    <div class="div-form">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" novalidate>
            <a href="index.php" class="brandcolor">
                <div class="brand-div">
                    <h1 class="brand-name">Go2Registry</h1>
                </div>
            </a>
            <label for="fname">First Name</label>
            <div class="input">
                <input type="text" name="fname" id="fname" placeholder="Type your first name" value="<?= $fname ?>" />
                <span class="fa-solid fa-id-card"></span>
            </div>
            <label for="lname">Last Name</label>
            <div class="input">
                <input type="text" name="lname" id="lname"  placeholder="Type your last name" value="<?= $lname ?>" />
                <span class="fa-solid fa-id-card"></span>
            </div>
            <div class="error" <?= !isset($errors['name']) ? 'hidden' : ""; ?>>Please enter your name</div>

            <label for="username">Username</label>
            <div class="input">
                <input type="text" name="username" id="username" placeholder="Type your username" value="<?= $username ?>" />
                <span class="fa-solid fa-user"></span>
            </div>

            <div class="error" <?= !isset($errors['username']) ? 'hidden' : ""; ?>>Please enter a username</div>
            <div class="error" <?= !isset($errors['userExist']) ? 'hidden' : ""; ?>>Username already in use</div>
            
            <label for="email">E-mail</label>
            <div class="input">
                <input type="email" name="email" id="email" placeholder="Type your e-mail" value="<?= $email ?>" />
                <span class="fa-solid fa-envelope"></span>
            </div>
            <div class="error" <?= !isset($errors['email']) ? 'hidden' : ""; ?>>Incorrect email</div>
            <div class="error" <?= !isset($errors['emailExist']) ? 'hidden' : ""; ?>>Email already in use</div>

            <label for="password">Password</label>
            <div class="input">
                <input type="password" name="password" id="password" placeholder="Type your password" onkeyup="getPassword()">
                <span class="fa-solid fa-lock"></span>
            </div>
            <!-- all the html that shows error for passwords -->
            <?php include "includes/pwdcheck.php"; ?>

            <label for="repassword">Re-enter your password</label>
            <div class="input">
                <input type="password" name="repassword" id="repassword" placeholder=" Re-type your password">
                <span class="fa-solid fa-user-lock"></span>
            </div>
            <div class="error" <?= !isset($errors['pwdmatch']) ? 'hidden' : ""; ?>>Password do not match</div>
            <button type="submit" name="submit">Sign up</button>
            <span class="signup">Already have an account? <a href="login.php">Log in</a></span>

        </form>
    </div>
    <?php include "includes/footer.php"; ?>

</body>

</html>