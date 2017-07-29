<?php session_start(); 
include('db_config.php');
$collection = $db->users; //select collection (table)
$id = $_GET['id'];
$id = new MongoId($_GET["id"]) ;
$userId = $_SESSION["id"];
$term = array('_id' => $id); //pilih search term
$cursor = $collection->remove($term);

$collection2 = $db->users_posts;
$term2 = array('userId' => $id); 
$cursor2 = $collection2->remove($term2);

?>

<meta http-equiv="refresh" content="0; url=manage_users.php" />