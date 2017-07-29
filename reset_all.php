<?php

include('db_config.php');
$collection_post = $db->posts; //select collection (table) post
$collection_users = $db->users; //select collection (table) users
$collection_nw1 = $db->users_posts; //select collection (table) users_post

$ucursor = $collection_users->find();

foreach ($ucursor as $doc) {
	$keyword_nw = "candidate";
	$term_nw2 = array('candidate' => $keyword_nw);
	$cursor_nw2 = $collection_post->find($term_nw2);
	foreach ($cursor_nw2 as $document_nw2) {

	    $userId = $doc['_id'];
		$postId = $document_nw2['_id'];
		$text = $document_nw2['text'];
		$screen_name = $document_nw2['user']['screen_name'];
		$date_tweet = $document_nw2['created_at'];
		$search_term = $document_nw2['search_term'];
		$trained = "n";

		echo "userId : " . $userId . "- postId : " . $postId . " - search_term : " .$search_term. "- trained : " . $trained. "text : ". $text ."<br/>";


		$insert = array('userId'=>$userId,"postId" => $postId,"search_term"=>$search_term,"trained"=>$trained,"text"=>$text,"screen_name"=>$screen_name,"date_tweet"=>$date_tweet);

		$collection_nw1->insert($insert);
} }

?>