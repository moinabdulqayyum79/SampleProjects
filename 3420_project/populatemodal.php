<?php

//get id from GET array
$id = $_GET['id'] ?? null;

//include the library file
require 'includes/library.php';
// create the database connection
$pdo = connectDB();
$query="SELECT * FROM items WHERE id=?";
$stmnt=$pdo->prepare($query);
$stmnt->execute([$id]);
$item=$stmnt->fetch();
if($item['bought']==1) $itembought= "yes"; 
    else $itembought= "No";
$title='<h3 class="item-title">'.$item['title']."</h3>";
$bought='<div class="item-bought">Bought?:'.$itembought.'</div>';
$description='<div class="item-description">'.$item['description'].'</div>';
$link='<a href="'.$item['link'].'">Link to item</a>';
if(isset($item['filename'])){
    $path = WEBROOT."www_data/".$item['filename'];
    $config = parse_ini_file(DOCROOT . "pwd/config.ini");
    $path = "/~".$config['username']."/www_data/".$item['filename'];
    $image='<img src="'.$path.'" alt="Image of the item">';
}
else{
    $image='';
}
$form='<form method="POST">
<input type="hidden" name="itemid" value="'.$id.'"/>
<button type="submit" name="delete-item">Delete</button>
<button type="button"> <a href="edititem.php?itemID='.$id.'">Edit</a></button>
</form>';
$exit='<button type="button">Exit</button>';
echo $title.$description.$bought.$link.$image.$form.$exit;
exit();

?>

