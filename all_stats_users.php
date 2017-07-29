<?php 
//start session
session_start(); 
//check user login ke tak
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true && $_SESSION["user_level"] == "99") {
$temp_id = new MongoId($_SESSION["id"]) ;
include('db_config.php');
$collection = $db->users; //select collection (table)
$cursor = $collection->find();

$collection2 = $db->users_posts; 
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
          <section class="wrapper">
          	<h3 color="white"> <font color="white"> <i class="fa fa-angle-right"></i> You logged in as <?php $user = $_SESSION['name']; echo $user; ?></font></h3>
				

              <div class="row mt">
                  <div class="col-md-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> User Managment</h4>




	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> User</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i> Level</th>
                                  <th></th>
                              </tr>
                              </thead>
                              <tbody>

                            <?php 
                            $i=0;
                              foreach ($cursor as $document) { ?>
                              <tr>
                              <td><?= $document['name'] .",". $document['username']; ?></td>
                              <td>
                                  <?php
                                   
                                   $term2 = array('search_term' => "maybank","userId"=> $document['_id'],"trained"=>"y"); //pilih search term
                                   $cursor_count2 = $collection2->count($term2);
                                   print "," . $cursor_count2 . " ";

                                   $term2a = array('search_term' => "maybank","userId"=> $document['_id'],"nb.check"=>"right"); //pilih search term
                                   $cursor_count2a = $collection2->count($term2a);
                                   print "," . $cursor_count2a . "";

                                   $term2b = array('search_term' => "maybank","userId"=> $document['_id'],"nb.check"=>"right"); //pilih search term
                                   $cursor_count2a = $collection2->count($term2b);
                                   print "," . $cursor_count2a . "";

                                  
                                   $term3 = array('search_term' => "malaysia","userId"=> $document['_id'],"trained"=>"y"); //pilih search term
                                   $cursor_count3 = $collection2->count($term3);
                                   print "," . $cursor_count3 . "";

                                   $term3a = array('search_term' => "malaysia","userId"=> $document['_id'],"nb.check"=>"right"); //pilih search term
                                   $cursor_count3a = $collection2->count($term3a);
                                   print "," . $cursor_count3a . "";

                                  if (!empty($document['user_level'])){;}
                                  ?>
                              </td>
                              <td>

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
} else {    echo "You don't have access to this page.";}?>