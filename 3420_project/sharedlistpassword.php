<?php
session_start();
//checks if the user logged in owns the list
if(isset($_SESSION['userID'])){
	include 'includes/library.php';
	$pdo = connectdb();
	$id=$_SESSION['userID'];
  if(isset($_GET['listID'])){
    $listid = $_GET['listID'];
    $pdo = connectdb();
    $query="SELECT userID FROM Lists where id=?";
    $stmnt=$pdo->prepare($query);
    $stmnt->execute([$listid]);
    $userid=$stmnt->fetch()["userID"];

  }
  else{
    $authenticationerr=true;
  }
}
else{
  header("Location: login.php");
  exit();
}
$password = $_POST['password'] ?? null;
$errors=array();
if(isset($_POST["submit"])){

    //if (!isset($password) || strlen($password) === 0)
    //    $errors['pwd'] = true;
    
    if(count($errors)===0){
        $query = "SELECT * FROM Lists WHERE id=?";
        $stmnt = $pdo->prepare($query);
        $stmnt->execute([$listid]);
        $row = $stmnt->fetch();
        if (!empty($row)) {
            if (password_verify($password, $row['password'])) {
                header("Location: viewitemspublic?listID=".$row['id']);
                exit();
            } else {
                var_dump("haha");
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
    <!-- Metadata goes here -->
    <head>
      <title>Create List</title>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="styles/master.css" />
      <link rel="stylesheet" href="styles/index.css" />
      <script src="https://kit.fontawesome.com/a56541cbd2.js" crossorigin="anonymous"></script>
      <!-- from https://www.cssscript.com/event-calendar-color/ -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-basic.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-glass.css" />
    </head>
  </head>
  <body>
    
    <?php include "includes/nav.php"; ?>
    <?php if(!isset($authenticationerr)): ?>
    <div class="div-form">
        <form  method="post" novalidate>
          <label for="username">Enter password: </label>
          <div class="input">
            <input type="text" name="password" id="password" />
            <span class="fa-solid fa-t"></span>
          </div>
          <div class="error" <?= !isset($errors['pwd']) ? 'hidden' : ""; ?>>Please enter a password</div>
          <div class="error" <?= !isset($errors['fail']) ? 'hidden' : ""; ?>>Incorrect password</div>
          <button type="submit" name="submit" id="submit" class="btn">Enter</button>
        </form>
    </div>
    <?php else: ?>
      <h1 class="error">Error 404: Sorry we could not find what you were looking for :(</h1>
    <?php endif; ?>
    <?php include "includes/footer.php"; ?>
</body>
</html>