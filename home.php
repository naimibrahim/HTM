<?php
include('db_config_login.php');

	if(!empty($_POST['username']) && !empty($_POST['password'])){
	//echo "username :" . $_POST['username'] . " password : " . $_POST['password'];
	
	
	$username = array('username' => $_POST['username'], 'password' => $_POST['password']);
	$password = array('password' => $_POST['password']);
	$cursor1 = $collection->find($username);
	
	if(!empty($cursor1)){
		 foreach ($cursor1 as $document) {
		 	$age = $document["age"] ;	
		 }
		 echo "Welcome : " . $_POST['username'];
		 echo "<br/>Umur: " . $age ;
	}
	else{
		echo "username & password not match" ;
	}
	
	
	}
?>

<?php
  $col_users_posts = $db->users_posts; 
   
   $username2=$_POST['username'];

   //$users_term = array('username' => $username2); //pilih search term
   
	echo "usern=" . $username2;
   $cursor2 = $col_users_posts->distinct("term");

   
   
   ?>
   <form name="form1" action="test4a_save.php" method="post"> 
   <!-- <form name="form1" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">-->
   
	<table>
	  <tr>
		<td>Term<td>
		<td>Finish Training</td>
		<td>Action</td>
	  </tr>
	  <?php 
		foreach ($cursor2 as $document2) {
		  $term = $document2["term"] ;	
	  ?>
	  <tr>
		<td><?= $document2["term"]; ?><td>
		<td>
			<input type="hidden" name="id_senti[]" id="id_senti[]" value="<?= $document2["_id"]; ?>"/>
			
	  </td>
	  </tr>
	  <?php } ?>
	</table>
	
	<input type='submit' value='Simpan' >
   </form>
   
   
   <?php

	$text = array();
	$id = array();
	$sentimen = array();
	
	if(!empty($_POST['filter'])){
		foreach($_POST['filter'] as $check){
			$text = $_POST['text'];
			$id = $_POST['id_senti'];
			$sentimen = $_POST['filter'];
		}
	
	}
	
	$x = count($sentimen)."<br>";
	
	echo $x;
	
	for($i=0;$i<$x; $i++){
		
		echo $id[$i]." - ".$sentimen[$i]."<br>";
	}


?>