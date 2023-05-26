<?php
session_start();
//checks if the user logged in owns the item
if(isset($_SESSION['userID'])){
	include 'includes/library.php';
	$pdo = connectdb();
	$id=$_SESSION['userID'];
  if(isset($_GET['itemID'])){
    $itemid = $_GET['itemID'];
    $pdo = connectdb();
    $query="SELECT listID FROM items where id=?";
    $stmnt=$pdo->prepare($query);
    $stmnt->execute([$itemid]);
    $listid=$stmnt->fetch()["listID"];
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
$link=$_POST['link']??null;
$errors=array();
if(isset($_POST["submit"])){
    if (!isset($title) || strlen($title) === 0) 
        $errors['title'] = true;
    if (isset($link) && strlen($link) > 0) {
        if (filter_var($link, FILTER_VALIDATE_URL) === false){
            $errors["link"]=true;
        }
    }
    if(count($errors)===0){
        $query="UPDATE items SET title=?, description=?, link=? where id=?";
        $stmnt=$pdo->prepare($query);
        $stmnt->execute([$title,$description,$link,$itemid]);
        header("Location: viewitems.php?listID=".$listid);
        exit();
      }
}

if(!isset($authenticationerr)){
    $query = "SELECT * FROM items WHERE id=?";
    $stmnt = $pdo->prepare($query);
	$stmnt->execute([$itemid]);
    $row = $stmnt->fetch();
    $title=$row['title'];
    $description=$row['description'];
    $link=$row['link'];
}
?>

<!DOCTYPE html>
<html lang="en">
    <!-- Metadata goes here -->
    <head>
      <title>Edit Item</title>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="styles/master.css" />
      <link rel="stylesheet" href="styles/index.css" />
      <script src="https://kit.fontawesome.com/a56541cbd2.js" crossorigin="anonymous"></script>
    </head>
  <body>

    <?php include "includes/nav.php"; ?>
    <?php if(!isset($authenticationerr)): ?>
    <div class="div-form">
        <form id="add-item" enctype="multipart/form-data" method="post" novalidate> 
          <h1>Add an Item</h1> 

          <label for="title">Item Title: </label>
          <div class="input">
            <input type="text" name="title" id="title" value="<?=$title?>"/>
            <span class="fa-solid fa-t"></span>
          </div>
          <div class="error" <?= !isset($errors['title']) ? 'hidden' : ""; ?>>Please enter a title</div>

          <label for="description">Description: </label>
          <div class="input">
            <textarea name="description" id="description" ><?=$description?></textarea>
          </div>

          <label for="link">Link: </label>
          <div class="input">
            <input type="text" name="link" id="link" value="<?=$link?>" />
            <span class="fa-solid fa-link"></span>
          </div>
          <div class="error" <?= !isset($errors['link']) ? 'hidden' : ""; ?>>Invalid Link</div>

          <button type="submit" name="submit" id="submit" class="btn">Update Item</button>
        </form>
    </div> 
    <?php else: ?>
        <h1 class="error">Error 404: Sorry we could not find what you were looking for :(</h1>
    <?php endif; ?>
    <?php include "includes/footer.php"; ?>
</body>
</html>