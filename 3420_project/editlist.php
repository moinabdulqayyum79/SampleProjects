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
  $title=$_POST['title']??null;
  $description=$_POST['description']??null;
  $password=$_POST['password'] ??null;
  $dateExpire=$_POST['expiry']??null;
  $errors=array();
  
  if(isset($_POST["submit"])){
    if (!isset($title) || strlen($title) === 0) 
        $errors['title'] = true;
    if (!isset($dateExpire) || strlen($dateExpire) === 0) 
      $errors['expire'] = true;
    if(count($errors)===0){
      $query="UPDATE Lists SET title=?, description=?, dateExpire=? where id=?";
      $stmnt=$pdo->prepare($query);
      $stmnt->execute([$title, $description, $dateExpire, $listid]);
      header("Location: viewlist.php");
      exit();
    }
  }
  if(isset($_POST["updatepass"])){
    if (!isset($password) || strlen($password) === 0) 
      $errors['pwd'] = true;
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $query="UPDATE Lists SET password=? where id=?";
      $stmnt=$pdo->prepare($query);
      $stmnt->execute([$hash, $listid]);
      $passwordupdate=true;
  }

if(!isset($authenticationerr)){
    $query = "SELECT * FROM Lists WHERE id=?";
    $stmnt = $pdo->prepare($query);
	$stmnt->execute([$listid]);
    $row = $stmnt->fetch();
    $title=$row['title'];
    $description=$row['description'];
    $expdate=$row['dateExpire'];
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Metadata goes here -->
    <head>
      <title>Edit List</title>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="styles/master.css" />
      <link rel="stylesheet" href="styles/index.css" />
      <script src="https://kit.fontawesome.com/a56541cbd2.js" crossorigin="anonymous"></script>
      <!-- from https://www.cssscript.com/event-calendar-color/ -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-basic.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-glass.css" />
      <script src="https://cdn.jsdelivr.net/npm/color-calendar/dist/bundle.min.js"></script>
      <script defer src="scripts/lists.js"></script>
    </head>
  </head>
  <body>
    <?php include "includes/nav.php"; ?>
    <?php if(!isset($authenticationerr)): ?>
        <div class="div-form">
        <form method="post" novalidate>
          <h1>Edit your List</h1>
          
          <div class="update" <?= !isset($passwordupdate) ? 'hidden' : ""; ?>>Password Updated</div>
          <label for="title">List Title: </label>
          <div class="input">
            <input type="text" name="title" id="title" value="<?=$title?>" />
            <span class="fa-solid fa-t"></span>
          </div>
          <div class="error" <?= !isset($errors['title']) ? 'hidden' : ""; ?>>Please enter a title</div>
          <label for="description">Description: </label>
          <div class="input">
            <textarea name="description" id="description" ><?=$description?></textarea>
          </div>
          
          <div>Expiry: <?=$expdate?></div>
          <label for="expiry">New Expiry Date: </label>
          <div class="input"> 
            <input type="text" name="expiry" id="expiry" readonly>
            <span class="fa-solid fa-calendar"></span>
          </div>
          <div class="error" <?= !isset($errors['expiry']) ? 'hidden' : ""; ?>>Please select a date</div>
          <div id="color-calendar"></div>
          <button type="submit" name="submit" id="submit" class="btn">Update List</button>

          <label for="password">New Password: </label>
          <div class="input">
            <input type="password" name="password" id="password" />
            <span class="fa-solid fa-lock"></span>
          </div>
          <div class="error" <?= !isset($errors['pwd']) ? 'hidden' : ""; ?>>Please enter a password</div>
          <button type="submit" name="updatepass" class="btn">Update Password</button>
        </form>
        </div> 
    
    <?php else: ?>
    <h1 class="error">Error 404: Sorry we could not find what you were looking for :(</h1>
    <?php endif; ?>
    <?php include "includes/footer.php"; ?>
  </body>
</html>