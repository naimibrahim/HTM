<?php 
//start session
session_start(); 
//check user login ke tak
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true) {
  if($_SESSION["user_level"] == "99"){?> <meta http-equiv="refresh" content="0; url=main.php" /> <?php ;}
  if($_SESSION["user_level"] == "2"){?> <meta http-equiv="refresh" content="0; url=main.php" /> <?php ;}
$temp_id = new MongoId($_SESSION["id"]) ;
include('db_config.php');
$collection = $db->users_posts; //select collection (table)
$cursor = $collection->distinct('search_term',array("userId"=> $temp_id));

$collection2 = $db->posts; //select collection (table)
$cursor_term_sedia_ada = $collection2->distinct('search_term');


$term_upgrade = array('search_term' => "malaysia","userId"=>$temp_id,"trained"=>"y"); //pilih search term
$cursor_count_upgrade = $collection->count($term_upgrade);

$term_upgrade2 = array('search_term' => "maybank","userId"=>$temp_id,"trained"=>"y"); //pilih search term
$cursor_count_upgrade2 = $collection->count($term_upgrade2);

$user_level = $_SESSION['user_level'];

if($user_level=="1"){
if($cursor_count_upgrade>=25 && $cursor_count_upgrade2>=25 ){
        $update = array('user_level'=>"2");
$collection->update(
  array('_id'=>$temp_id ),
  array('$set' => $update)   );
    $_SESSION['user_level'] = "2";
      }
    }
?>
<!DOCTYPE html>
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
    <?php include 'sidebar.php'; ?>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3 color="white"> <font color="white"> <i class="fa fa-angle-right"></i> You logged in as <?php $user = $_SESSION['name']; echo $user; ?></font></h3>
				

              <div class="row mt">
                  <div class="col-md-12">
                      <div class="content-panel">

                          <table class="table table-striped table-advance table-hover">
                            <p>Hello, welcome to MySentiment. This program is created to fulfil my master dissertation. I need your help to <br/>
<ol>
<li>Train two (2) keyword below. For each keyword, you need to trained at least 25 tweets out of 50 selected tweets. To start train, please click ‘(1) Train’.</li>
<li>After you complete the training, you can start analysing the sentiment of the keyword. To start the analysing, you can click ‘(2) Analyze’.</li>
<li>After that, I hope that you can complete the process by checking back the analysis that has been perform by the MySentiment whether it is correct or wrong. </li>
<li>Please repeat the process to next keyword.
<li>After you has been complete all the process, you will be reward by having access to using MySentiment to analyze keywords that you like. This feature will only available after you has been complete all the task. </li>
</ol>
</p>
<br/><br/>
<p>
Hi, selamat datang ke MySentiment. Aplikasi ini dicipta untuk memenuhi keperluan disertasi master saya. Saya perlukan pertolongan anda untuk<br/><br/>
<ol>
<li>Melatih dua (2) katakunci atau ‘keyword’ dibawah. Untuk setiap kata kunci, anda perlu melatih sekurang-kurangnya 25 tweet daripada 50 tweet yang telah dipilih. Untuk memulakan latihan, sila klik ‘(1) Train’.</li>
<li>Selepas anda selesai sesi latihan, anda boleh mula menganalisis sentiment bagi setiap kata kunci. Untuk memulakan analisis, klik pada ‘(2) Analyze’.</li>
<li>Selepas itu, saya berharap agar anda dapat melengkapkan proses ini dengan menyemak semula analisis yang telah dibuat oleh MySentiment samaada ianya betul ataupun salah.</li>
<li>Sila ulang proses yang sama untuk kata kunci yang satu lagi.
<li>Setelah selesai proses untuk kedua-dua kata kunci, anda akan diberikan penghargaan untuk menggunakan aplikasi MySentiment untuk menganalisis kata kunci pilihan ada. Kemudahan ini akan dipaparkan selepas anda selesai semua tugasan.</li>
</ol></p>



                            <hr>
                              <thead>
                              <tr>

                              </tr>
                              </thead>
                              <tbody>



                              </tbody>
                          </table>



                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> My Keyword</h4>




	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> Keyword</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i> Status</th>
                                  <th></th>
                              </tr>
                              </thead>
                              <tbody>

                            <?php 
                            $i=0;
                              foreach ($cursor as $document) { ?>
                              <tr>
                              <td><?= $document; ?></td>
                              <td>
                                  <?php
                                  $term2 = array('search_term' => $document,"userId"=> $temp_id); //pilih search term
                                  $cursor_count = $collection->count($term2);
                                  print "Total tweet : " . $cursor_count . " | ";
                                  $term3 = array('search_term' => $document, 'sentimen' => array('$exists' => true),"userId"=> $temp_id); //pilih search term
                                  $cursor_count3 = $collection->count($term3);
                                  //$cursor_count3 -= 25;
                                  print " Trained : " . $cursor_count3 . "/25    ";

                                  if($cursor_count3 < 25) {
                                    $kena_train = 25-$cursor_count3;

                                    echo "<span class='label label-danger'> You need to train another ". $kena_train ." tweets.</span>";}
                                  if($cursor_count3 >= 25) {echo "<span class='label label-success'> Training complete</span>";}
                                  ?>
                              </td>
                              <td>
                                      <a href="<?php echo "train.php?k=".$document ;?>" class="btn btn-warning btn-xs "><i class="fa fa-compass"> (1) Train</i></a>
                                      <a href="<?php echo "semak_train.php?k=".$document ;?>" class="btn btn-success btn-xs"><i class="fa fa-check-square-o"> Retrain</i></a>
                                      <a href="<?php echo "chart.php?k=".$document ;?>" class="btn btn-primary btn-xs"><i class="fa fa-gears"></i> (2) Analyze</a>
                                      <a href="<?php echo "delete_keyword.php?k=".$document ;?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "> Delete</i></a>
                                  </td>
                              </tr>
                            <?php } ?>

                              </tbody>
                          </table>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2015 - Mohd Naim Mohd Ibrahim
              <a href="basic_table.html#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>





<?php include 'bottom.php';?>


  </body>


</html>


<?php
 //kalau tak login paparkan ini   
} else {    echo "Please log in first to see this page.";}?>