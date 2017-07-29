<?php

include('db_config.php');
$collection = $db->posts; //select collection (table)
	//declaration
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
	
	$x = count($sentimen);
	
	echo $x;
	
	for($i=0;$i<$x; $i++){
	
		$temp_id = new MongoId($id[$i]);
		
		//$temp_id = "ObjectId(".($id[$i]).")";
		//$temp_id = "54e9c9b74dedcb1e882f429b";
		//$temp_id = $id[$i];
		print_r($id[$i]."-");
		echo $temp_id;
		if($sentimen[$i]=='candidate')
		{
			$update = array('candidate'=>$sentimen[$i]);

			$collection->update(
			  array('_id'=>$temp_id),
			  array('$set' => $update)
			);
		}
		//echo $id[$i]." - ".$sentimen[$i]."<br>";
		echo $sentimen[$i]."<br>";
		?> <?php
	}


?>