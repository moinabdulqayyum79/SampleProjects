<?php
session_start();
if(isset($_SESSION['userID'])){
	include 'includes/library.php';
	$pdo = connectdb();
	$id=$_SESSION['userID'];
	$query="SELECT * FROM Lists WHERE userID=?";
    $stmnt=$pdo->prepare($query);
    $stmnt->execute([$id]);
	$lists=$stmnt->fetchAll();
}
else{
    header("Location: login.php");
    exit();
}
$count = 0;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Metadata goes here -->
    <head>
      <title>View List</title>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="styles/index.css" />
      <link rel="stylesheet" href="styles/item.css" />
      <script src="https://kit.fontawesome.com/2d3525db96.js" crossorigin="anonymous"></script>

    </head>
  </head>
  <body>
    <?php include 'includes/nav.php'; ?>
    <div class="nav">
        <a id="create" href="createlist.php">Create a new List</a>
    </div>
    <div class="all-lists">
        <?php foreach ($lists as $list): ?>
            <div class="list">
                <div class="<?php if(new DateTime($list['dateExpire'])<new DateTime()) echo "disabled"; ?>">
                    <h3 class="list-title"><?php echo $list['title']?></h3>
                    <p class="list-description"><?php echo $list['description']?></p>
                    <p class="list-expiry">Expires: <?php echo $list['dateExpire']?></p>
                </div>
                <a href="viewitems.php?listID=<?=$list['id']?>">View</a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>