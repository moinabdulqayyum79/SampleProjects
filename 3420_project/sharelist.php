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
    var_dump($listid);
    if($userid!=$id){
      $authenticationerr=true;
    }
  }
  else{
    $authenticationerr=true;
  }
}
else{
  header("Location: login.php");
  exit();
}
$email = $_POST['email'] ?? null;
$errors=array();
if(isset($_POST["submit"])){
  //validate and sanitize email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL))
      $errors['email'] = true;
  
  $query = "SELECT email FROM users WHERE email=?";
  $stmnt = $pdo->prepare($query);
  $stmnt->execute([$email]);
  $checkEmail = $stmnt->fetchall();

  $query = "SELECT id FROM users WHERE email=?";
  $stmnt = $pdo->prepare($query);
  $stmnt->execute([$email]);
  $sharedID = $stmnt->fetchall();
  $sharedID = $sharedID[0]['id'];
  var_dump($sharedID);
  if (!empty($checkEmail)) {
    if(count($errors)===0){
      $query="INSERT INTO sharedLists(listID, userID) VALUES(?,?)";
      $stmnt=$pdo->prepare($query);
      $stmnt->execute([$listid, $sharedID]);
      header("Location: viewlist.php?listID=".$listid);
      exit();
    }
  }else{
    $errors['email'] = true;
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
          <h1>Share List</h1>
          <label for="username">Enter email: </label>
          <div class="input">
            <input type="text" name="email" id="email" />
            <span class="fa-solid fa-t"></span>
          </div>
          <div class="error" <?= !isset($errors['email']) ? 'hidden' : ""; ?>>Please enter a valid email</div>
          <button type="submit" name="submit" id="submit" class="btn">Share</button>
        </form>
    </div>
    <?php else: ?>
      <h1 class="error">Error 404: Sorry we could not find what you were looking for :(</h1>
    <?php endif; ?>
    <?php include "includes/footer.php"; ?>
</body>
</html>