<?php 
include('db_config.php');
$collection = $db->users_posts; //select collection (table)

$term= 'malaysia';
$key_posts = array('search_term' => $term, 'nbsentimen'=> array('$exists' => true),'nb.check'=>'right');

$term2 = array('search_term' => $term); //
$cursor_count = $collection->count($term2);
 print "Total tweet : " . $cursor_count . " | ";
 $term3 = $key_posts; //pilih search term
$cursor_count3 = $collection->count($term3);
 print " Trained : " . $cursor_count3 ."<br/><hr/>";


$cursor_posts = $collection->find($key_posts);
?> <table> <?php

 foreach($cursor_posts as $document2){
?>
 <tr>
 <td><?php echo  $document2["userId"]. "|" . $document2["text"]. "|" . $document2["nbsentimen"]. "|" . $document2["nb"]["check"] ; }?> </td>
 </tr>
print "";
?>
