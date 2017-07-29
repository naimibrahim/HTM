<?php session_start(); 
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true) { //kalau tak login tak boleh nampak



include('db_config.php');
$collection = $db->users_posts; //select collection (table)
	//declaration
	$id = array();
	$sentimen = array();
	$validate = array();
	
	//if(!empty($_POST['filter'])){
		foreach($_POST['id_senti'] as $check){
			//$validate = $_POST['check'];
			$id = $_POST['id_senti'];
			$sentimen = $_POST['sentimen'];

		}
	
	//}
	

	
	//echo $x;
	  $userId = $_SESSION["id"];
	  $keyword =  $_POST["keyword"];

	  $users_id = new MongoId($userId);
      




      $collection_padam_nb = $db->users_posts; //select collection (table)
      $padam2 = array('nb'=>true);



      $collection_padam_nb->update(
        array('userId'=>$users_id,'search_term'=>$keyword),
        array('$unset'=>$padam2),array('multiple' => true)
        );

		echo "Saving your data...";
			$x = count($sentimen);
	for($i=0;$i<$x; $i++){
	
		$temp_id = new MongoId($id[$i]);
		$check = "check".$i;
		//print_r( "<br/>"."id:".$id[$i]." sentimen:".$sentimen[$i]." validate:".$_POST[$check]);


		



		 if($sentimen[$i]=="positive"||$sentimen[$i]=="negative"||$sentimen[$i]=="neutral"||$sentimen[$i]=="irrelevent")
		{
			
			


			$update = array('check'=>$_POST[$check],'sentimen'=>$sentimen[$i]);
			$update2 = array('nb'=>$update);

			$collection->update(
			  array('_id'=>$temp_id),
			  array('$set' => $update2)
			  );
		}

	}

	  	//----untuk check user dah siap trained 25 data atau belum..kalau dah cukup, upgrade level---
	  $term_upgrade = array('search_term' => "malaysia","userId"=>$temp_id,"trained"=>"y"); //pilih search term
	  $cursor_count_upgrade = $collection->count($term_upgrade);
	  $user_level = $_SESSION["user_level"];

	 if($user_level=="1"){
	  if($cursor_count_upgrade>25){
	  	$update = array('user_level'=>"2");
		$collection->update(
			array('_id'=>$temp_id ),
			array('$set' => $update)					
		);
		$_SESSION['user_level'] = "2";
		?><meta http-equiv="refresh" content="0; url=main.php" /><?php
	  }
	  ?><meta http-equiv="refresh" content="0; url=main_basic.php" /><?php
	}
  //----untuk check user dah siap trained 25 data atau belum..kalau dah cukup, upgrade level---

			}
?><meta http-equiv="refresh" content="0; url=main_basic.php" /><?php
