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
$link=$_POST['link']??null;
$filename=null;
$errors=array();
 

if(isset($_POST["submit"])){
  if (!isset($title) || strlen($title) === 0) 
    $errors['title'] = true;
  //we only check for the file in the title is added
  else{
    $fileerrors=checkErrors('fileToProcess',2097152);
    if(is_uploaded_file($_FILES['fileToProcess']['tmp_name'])){
      if($fileerrors=='0'){
        //get the largest id and add 1 for a unique value
        $query="SELECT MAX(id) FROM items";
        $stmnt=$pdo->prepare($query);
        $stmnt->execute();
        $uniqueID=$stmnt->fetch();
        $uniqueID = $uniqueID['MAX(id)'] + 1;
        $path = WEBROOT."www_data/";
        $fileroot = "upload";
        //Create our original filename
        $filename = $_FILES['fileToProcess']['name'];
        $exts = explode(".", $filename);
        $ext = $exts[count($exts)-1];
        $filename = $fileroot.$uniqueID.".".$ext;
        $newname = $path.$filename; 
        //move file to our created path
        if(!move_uploaded_file($_FILES['fileToProcess']['tmp_name'], $newname)){
          $errors["file"]= 'Something went wrong :(';
        }
      }
      else
        $errors["file"]=$fileerrors;
    }
  }
  if (isset($link) && strlen($link) > 0) {
    if (filter_var($link, FILTER_VALIDATE_URL) === false){
        $errors["link"]=true;
    }
  }
  
  if(count($errors)===0){
    $query="INSERT INTO items(title, description, link, filename, listID, bought) VALUES(?,?,?,?,?,?)";
    $stmnt=$pdo->prepare($query);
    $stmnt->execute([$title, $description, $link, $filename, $listid, 0]);
    header("Location: viewitems.php?listID=".$listid);
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
    <!-- Metadata goes here -->
    <head>
      <title>Add Item</title>
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

          <label for="file">File Name:</label>
          <div class="input">
            <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
            <input type="file" name="fileToProcess" id="file"  />
          </div>
          <div class="error" <?= !isset($errors['file']) ? 'hidden' : ""; ?>><?= $errors['file']?></div>
          <button type="submit" name="submit" id="submit" class="btn">Add Item</button>
        </form>
    </div> 
    <?php else: ?>
        <h1 class="error">Error 404: Sorry we could not find what you were looking for :(</h1>
    <?php endif; ?>
    <?php include "includes/footer.php"; ?>
</body>
</html>