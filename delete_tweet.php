<?php session_start(); 
include('db_config.php');
$collection = $db->posts; //select collection (table)
$collection2 = $db->users_posts; //select collection (table)
$keyword = $_GET['k'];
$userId = $_SESSION["id"];
$term = array('search_term' => $keyword ); //pilih search term
$cursor = $collection->remove($term);
$cursor2 = $collection2->remove($term);

?>

<meta http-equiv="refresh" content="0; url=manage_keyword.php" />