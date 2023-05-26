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
if(isset($_POST['disable-list'])){
  $date=date("Y/m/d"); 
  $query="UPDATE Lists SET dateExpire=? where id=?";
  $stmnt=$pdo->prepare($query);
  $stmnt->execute([$date, $listid]);
  header("Location: viewlist.php");
  exit();
}
if(isset($_POST['delete-list'])){
  $query="DELETE FROM Lists where id=?";
  $stmnt=$pdo->prepare($query);
  $stmnt->execute([$listid]);
  header("Location: viewlist.php");
  exit();
}
if(isset($_POST['delete-item'])){
  $itemid=$_POST['itemid'];
  $query="DELETE FROM items where id=?";
  $stmnt=$pdo->prepare($query);
  $stmnt->execute([$itemid]);
  header("Location: viewitems.php?listID=".$listid);
  exit();
}

if(!isset($authenticationerr)){
    $query="SELECT * FROM items WHERE listID=?";
    $stmnt=$pdo->prepare($query);
    $stmnt->execute([$listid]);
	  $items=$stmnt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Metadata goes here -->
    <head>
      <title>View items</title>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="styles/index.css" />
      <link rel="stylesheet" href="styles/item.css" />
      <script src="https://kit.fontawesome.com/2d3525db96.js" crossorigin="anonymous"></script>
      <script defer src="scripts/items.js"></script>
    </head>
  </head>
  <body>

    <?php include "includes/nav.php"; ?>
    <?php if(!isset($authenticationerr)): ?>
    <div class="nav">
        <a id="create" href="additem.php?listID=<?=$listid?>">Add a new item</a>
        <form class="nav" method="POST">
            <button type="submit" name="delete-list">Delete</button>
            <button type="submit" name="disable-list">Disable</button>
            <a href="editlist.php?listID=<?=$listid?>">Edit</a>
            <a href="sharelist.php?listID=<?=$listid?>">Share</a>
        </form>
    </div>
    <div class="all-items">
        <?php foreach ($items as $item): ?>
            <div class="item">
                <div>
                    <div class="id" hidden><?php echo $item['id']?></div>
                    <h3 class="item-title"><?php echo $item['title']?></h3>
                    <div class="item-bought">Bought?:<?php if($item['bought']==1) echo "yes"; else echo "No";?></div>
                </div>
                <button class="modal-button" type="button">View</button>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="modal-container hidden">
      <div class="modal">
      </div>
    </div>
    <?php else: ?>
    <h1 class="error">Error 404: Sorry we could not find what you were looking for :(</h1>
    <?php endif; ?>
    <?php include "includes/footer.php"; ?>
    

</body>
</html>