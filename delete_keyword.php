<?php session_start(); 
include('db_config.php');
$collection = $db->users_posts; //select collection (table)
$keyword = $_GET['k'];
$userId = $_SESSION["id"];
$term = array('search_term' => $keyword,'userId' => $userId ); //pilih search term
$cursor = $collection->remove($term);

?>

<meta http-equiv="refresh" content="0; url=main.php" />