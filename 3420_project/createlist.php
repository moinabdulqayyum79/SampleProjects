<?php
session_start();
if(isset($_SESSION['userID'])){
	include 'includes/library.php';
	$pdo = connectdb();
	$id=$_SESSION['userID'];
}
else{
  header("Location: login.php");
  exit();
}
$title=$_POST['title']??null;
$description=$_POST['description']??null;
$password=$_POST['password'] ??null;
$dateExpire=$_POST['expiry']??null;
$dateCreated= date("Y/m/d"); 
$errors=array();

if(isset($_POST["submit"])){
  if (!isset($title) || strlen($title) === 0) 
      $errors['title'] = true;
  if (!isset($password) || strlen($password) === 0) 
      $errors['pwd'] = true;
  if (!isset($dateExpire) || strlen($dateExpire) === 0) 
    $errors['expire'] = true;
  if(count($errors)===0){
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query="INSERT INTO Lists(title, description, password, dateExpire, dateCreated, userID) VALUES(?,?,?,?,?,?)";
    $stmnt=$pdo->prepare($query);
    $stmnt->execute([$title, $description, $hash, $dateExpire, $dateCreated, $id]);
    header("Location: viewlist.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">



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
      <script src="https://cdn.jsdelivr.net/npm/color-calendar/dist/bundle.min.js"></script>
      <script defer src="scripts/lists.js"></script>
    </head>
  </head>
  <body>
    
    <?php include "includes/nav.php"; ?>
    <div class="div-form">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post" novalidate>
          <h1>Create a List</h1>
          <label for="title">List Title: </label>
          <div class="input">
            <input type="text" name="title" id="title" />
            <span class="fa-solid fa-t"></span>
          </div>
          <div class="error" <?= !isset($errors['title']) ? 'hidden' : ""; ?>>Please enter a title</div>
          <label for="description">Description: </label>
          <div class="input">
            <textarea name="description" id="description" ></textarea>
          </div>
          <label for="password">Password: </label>
          <div class="input">
            <input type="password" name="password" id="password" />
            <span class="fa-solid fa-lock"></span>
          </div>
          <div class="error" <?= !isset($errors['pwd']) ? 'hidden' : ""; ?>>Please enter a password</div>
          <label for="expiry">Expiry Date: </label>
          <div class="input"> 
            <input type="text" name="expiry" id="expiry" readonly>
            <span class="fa-solid fa-calendar"></span>
          </div>
          <div class="error" <?= !isset($errors['expiry']) ? 'hidden' : ""; ?>>Please select a date</div>
          <div id="color-calendar"></div>
          <button type="submit" name="submit" id="submit" class="btn">Create List</button>
        </form>
    </div> 
    <?php include "includes/footer.php"; ?>
</body>
</html>
