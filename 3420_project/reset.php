<?php
$email = $_POST['email'] ?? null;
$errors = array();
if (isset($_POST["submit"])) {
    require 'includes/library.php';
    $pdo = connectdb();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors['email'] = true;
    $query = "SELECT email, password FROM users WHERE email=?";
    $stmnt = $pdo->prepare($query);
    $stmnt->execute([$email]);
    $checkEmail = $stmnt->fetchall();
    if (empty($checkEmail)) {
        $errors['emailNotExist'] = true;
    }
    if (count($errors) === 0) {
        include "includes/sendmail.php";
        $config = parse_ini_file(DOCROOT . "pwd/config.ini");
        $link="https://loki.trentu.ca/~".$config['username']."/3420/project/newpass.php?email=".$email."&pass=".$checkEmail[0]['password']."";
        $from="Password System Reset <noreply@loki.trentu.ca>";
        $to=$email;
        $subject="Password Reset";
        $body="Click the link to reset your password:\n".$link;
        $emailsent=sendMail($from,$to,$subject,$body);
        if($emailsent){
            header("Location: emailsent.php");
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
    <title>Reset password</title>
</head>

<body>
    <div class="div-form">
        <form method="POST" novalidate>
            <a href="index.php" class="brandcolor">
                <div class="brand-div">
                    <h1>Go2Registry</h1>
                </div>
            </a>

            <label for="email">E-mail</label>
            <div class="input">
                <input type="email" name="email" id="email" placeholder="Type your e-mail" />
                <span class="fa-solid fa-envelope"></span>
            </div>
            <div class="error" <?= !isset($errors['email']) ? 'hidden' : ""; ?>>Incorrect email</div>
            <div class="error" <?= !isset($errors['emailNotExist']) ? 'hidden' : ""; ?>>Email does not exist</div>
            <button type="submit" name="submit">Send E-mail</button>
            <span>Back to <a href="login.php">login</a> page</span>

        </form>
    </div>
    <?php include "includes/footer.php"; ?>

</body>

</html>