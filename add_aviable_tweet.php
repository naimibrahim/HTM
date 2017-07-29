<?php session_start(); 
include('db_config.php');
$collection = $db->users_posts; //select collection (table)
$collection2 = $db->posts; //select collection (table)

//echo $_GET['k'];
echo "Adding ". $_GET['k'] . " to your list...";

	
		
$keyword = $_GET['k'];
$term2 = array('search_term' => $keyword);
$cursor2 = $collection2->find($term2);
foreach ($cursor2 as $document2) {
				$userId = $_SESSION["id"];
				$postId = $document2['_id'];
				$text = $document2['text'];
				$screen_name = $document2['user']['screen_name'];
				$date_tweet = $document2['created_at'];
				$search_term = $keyword;
				$trained = "n";

				//echo "userId : " . $userId . "- postId : " . $postId . " - search_term : " .$search_term. "- trained : " . $trained. "text : ". $text ."<br/>";


				$insert = array('userId'=>$userId,"postId" => $postId,"search_term"=>$search_term,"trained"=>$trained,"text"=>$text,"screen_name"=>$screen_name,"date_tweet"=>$date_tweet);

				$collection->insert($insert);
	?>   <meta http-equiv="refresh" content="0; url=main_basic.php" />  <?php
	


}


		
	
	




?>