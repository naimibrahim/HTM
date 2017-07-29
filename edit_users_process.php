<?php
//start session
session_start(); 
//check user login ke tak
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true) {
$id = $_POST['id1'];
$temp_id = new MongoId($id) ;
echo "Saving the data..";
include('db_config.php');
$collection = $db->users; //select collection (table)



if(!empty($_POST['name']) && !empty($_POST['age'])  && !empty($_POST['id1'])  && !empty($_POST['user_level']) ){
			$id = $temp_id;
			$name = $_POST['name'];
			$sex = $_POST['sex'];
			$age = $_POST['age'];
			$user_level = $_POST['user_level'];

			$update = array('last_login'=>date("Y-m-d h:i:sa"),'name'=>$name,'sex'=>$sex,'age'=>$age,'last_update'=>date("Y-m-d h:i:sa"),'user_level'=>$user_level);
				$collection->update(
					array('_id'=>$id ),
					array('$set' => $update)
				);
				echo "success";
				?> <a href="main.php" class="btn btn-success">Teruskan</a>
				<meta http-equiv="refresh" content="0; url=manage_users.php" />

				<?php
}
else{
	echo "Sila lengkapkan borang";
}

if(!empty($_POST['password'])){
			$password = $_POST['password'];
			$update = array('password'=>$password,'last_update'=>date("Y-m-d h:i:sa"),'last_password_update'=>date("Y-m-d h:i:sa"));
				$collection->update(
					array('_id'=>$temp_id ),
					array('$set' => $update)
				);
				echo "success";
				?> <a href="main.php" class="btn btn-success">Teruskan</a>
				<meta http-equiv="refresh" content="0; url=edit_users.php?id=$temp_id" />

				<?php
}
else{
	echo "Sila lengkapkan borang";
}






}?>