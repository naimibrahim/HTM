<?php
  session_start(); 
  date_default_timezone_set("Asia/Kuala_Lumpur");
  include('db_config.php');
  $collection = $db->users; //select collection (table)
  $collection2 = $db->users_posts; //select collection (table)
  include 'head.php'; 

  	//$username = array();
	//$password = array();
	//$sentimen = array();
	
	if(!empty($_POST['username'])){
			$username = $_POST['username'];
			$password= $_POST['password'];
			//echo "<br/> username : " . $username;
			//echo "<br/> password : " . $password;
		

		$term = array('username' => $username, 'password'=>$password); //umpukan username dan password pada array term
		$cursor = $collection->find($term);


			
		

		foreach ($cursor as $document) 
			{
			  $id_user = $document["_id"] ;
			  $name = $document["name"] ;
			  $last_login = $document["last_login"] ;
			  $user_level = $document["user_level"] ;



			}
		if(empty($id_user))
		{
			//echo "salah";
			?>        

			 <script>
              alert("Your username/password is wrong.");
          </script>

			<meta http-equiv="refresh" content="0; url=login.php" /> <?php
		}
		else{


				//echo "<br/> id : ". $id_user;
				//echo "<br/> Last Login : ". $last_login;

				if(empty($last_login)){
					//echo "<br/> 1st time";
				}
				else{
					//echo "<br/> Last Login : ". $last_login;

				}

			    //update last login back to database
				$temp_id = new MongoId($id_user);
			    $update = array('last_login'=>date("Y-m-d h:i:sa"));
				$collection->update(
					array('_id'=>$temp_id ),
					array('$set' => $update)
				);

			  $myusername = $username;
			  //session_register("myusername");
			  $_SESSION["username"] = $myusername ;
			  $_SESSION["name"] = $name ;
			  $_SESSION["id"] = $id_user;
			  $_SESSION['user_level'] = $user_level;
			  $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] = true;

			  	//----untuk check user dah siap trained 25 data atau belum..kalau dah cukup, upgrade level---
 			  $term_upgrade = array('search_term' => "malaysia","userId"=>$temp_id,"trained"=>"y"); //pilih search term
              $cursor_count_upgrade = $collection2->count($term_upgrade);
              $term_upgrade2 = array('search_term' => "maybank","userId"=>$temp_id,"trained"=>"y"); //pilih search term
              $cursor_count_upgrade2 = $collection2->count($term_upgrade2);

             if($user_level=="1"){
              if($cursor_count_upgrade>=25&&$cursor_count_upgrade2>=25){
              	$update = array('user_level'=>"2");
				$collection->update(
					array('_id'=>$temp_id ),
					array('$set' => $update)					
				);
				$_SESSION['user_level'] = "2";
              }
          	}
              //----untuk check user dah siap trained 25 data atau belum..kalau dah cukup, upgrade level---

			  //echo "session : " . $_SESSION["username"];
			 // echo "   level: " . $_SESSION["user_level"];
			  if($_SESSION["user_level"]>"1"){
 				?> <a href="main.php" class="btn btn-success">Teruskan</a>
					<meta http-equiv="refresh" content="0; url=main.php" />
					<?php
			  }
			  else{
 				?> <a href="main_basic.php" class="btn btn-success">Teruskan</a>
					<meta http-equiv="refresh" content="0; url=main_basic.php" />


				<?php
			}

		}
	}
	else
	{
		echo "please key username";
	}




?>