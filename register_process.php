<?php
  session_start(); 
  date_default_timezone_set("Asia/Kuala_Lumpur");
  include('db_config.php');
  $collection = $db->users; //select collection (table)
  include 'head.php'; 

  	//$username = array();
	//$password = array();
	//$sentimen = array();
  ?>
	 <html lang="en">
  <head>
    <?php include 'head.php'; ?>
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <?php include 'header.php'; ?>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->

      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start--> <?php


	if(!empty($_POST['username_reg'])){
			$username = $_POST['username_reg'];
			$password= $_POST['password_reg'];
			$name = $_POST['name'];
			$age = $_POST['age'];
			$sex = $_POST['sex'];
			//echo "<br/> username : " . $username;
			//echo "<br/> password : " . $password;
		

		$term = array('username' => $username, 'password'=>$password); //umpukan username dan password pada array term
		$cursor = $collection->find($term);

		$term2 = array('username'=>$username);
		$cursor2 = $collection->find($term2);

	foreach ($cursor2 as $document2) 
		{
		  $id_user2 = $document2["_id"] ;

		}

		if(!empty($id_user2))

			{ echo "The email/username already registered, please using another email/username..";
		        ?>
		        <a href='register.php' type="button">Back</a>

				 <script>
		              alert("he email/username already registered, please using another email/username..")
		          </script>
		          <meta http-equiv="refresh" content="0; url=register.php" />
		          <?php 
		      }
		else
		{
		


			
		

				foreach ($cursor as $document) 
					{
					  $id_user = $document["_id"] ;
					  $last_login = $document["last_login"] ;



					}
				if(empty($id_user))
				{
					//echo "yeah";
					//echo "<br/> username:".$username . " password:" . $password . " name:" . $name . " sex:" . $sex . " age:" .$age ;
					echo "Processing your registration...";
					    //inseert into database
					    $insert = array('username'=>$username,"password" => $password,"name"=>$name,"sex"=>$sex,"age"=>$age,"user_level"=>"1");
						$collection->insert($insert);
						

						//--------untuk add initial keyword kepada setiap new user
						$collection_nw1 = $db->users_posts; 
						$collection_nw2 = $db->posts; 

						$keyword_nw = "candidate";
						$term_nw2 = array('candidate' => $keyword_nw);
						$cursor_nw2 = $collection_nw2->find($term_nw2);
						foreach ($cursor_nw2 as $document_nw2) {
							$userId_nw = $insert['_id'];
							$postId_nw = $document_nw2['_id'];
							$text_nw = $document_nw2['text'];
							$screen_name_nw = $document_nw2['user']['screen_name'];
							$date_tweet_nw = $document_nw2['created_at'];
							$search_term_nw = $document_nw2['search_term'];
							$trained_nw = "n";

							//echo "userId : " . $userId_nw . "- postId : " . $postId_nw . " - search_term : " .$search_term_nw. "- trained : " . $trained_nw ."text : ". $text_nw ."<br/>";


							$insert_nw = array('userId'=>$userId_nw,"postId" => $postId_nw,"search_term"=>$search_term_nw,"trained"=>$trained_nw,"text"=>$text_nw,"screen_name"=>$screen_name_nw,"date_tweet"=>$date_tweet_nw);


							$collection_nw1->insert($insert_nw);

					}
						//--------tamat untuk add initial keyword kepada setiap new user


						?> <a href="register_success.php" class="btn btn-success">Teruskan</a>
						<meta http-equiv="refresh" content="0; url=register_success.php" />
						

						<?php
				}
				else{


						//echo "<br/> id : ". $id_user;
						echo "<br/> Last Login : ". $last_login;

					    //update last login back to database
						$temp_id = new MongoId($id_user);
					    $update = array('last_login'=>date("Y-m-d h:i:sa"));
						$collection->insert(
							array('_id'=>$temp_id ),
							array('$set' => $update)
						);

					  // $myusername = $username;
					  // //session_register("myusername");
					  // $_SESSION["username"] = $myusername ;
					  // $_SESSION["id"] = $id_user;
					  // $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] = true;

					  // echo "session : " . $_SESSION["username"];
						?> <a href="login.php" class="btn btn-success">Teruskan</a>
						

						<?php

				}
			}
		}
			else
			{
				echo "please key username";
			}
		


?>

<!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2015 - Mohd Naim
              <a href="morris.html#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>



    <!--common script for all pages-->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="assets/js/common-scripts.js"></script>


    

  </body>
</html>