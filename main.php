<?php 
//start session
session_start(); 
//check user login ke tak
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true) {
  if($_SESSION["user_level"] == "1"){?> <meta http-equiv="refresh" content="0; url=main_basic.php" /> <?php ;}
$temp_id = new MongoId($_SESSION["id"]) ;
include('db_config.php');
$collection = $db->users_posts; //select collection (table)
$cursor = $collection->distinct('search_term',array("userId"=> $temp_id));

$collection2 = $db->posts; //select collection (table)
$cursor_term_sedia_ada = $collection2->distinct('search_term');
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
          	<h3 color="white"> <font color="white"> <i class="fa fa-angle-right"></i> Welcome back <?php $user = $_SESSION['name']; echo $user; ?></font></h3>
				

              <div class="row mt">
                  <div class="col-md-12">
                      <div class="content-panel">
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
                                  print " Trained : " . $cursor_count3;
                                  ?>
                              </td>
                              <td>
                                      <a href="<?php echo "train.php?k=".$document ;?>" class="btn btn-warning btn-xs "><i class="fa fa-compass"> Train</i></a>
                                      <a href="<?php echo "semak_train.php?k=".$document ;?>" class="btn btn-success btn-xs"><i class="fa fa-check-square-o"> Retrain</i></a>
                                      <a href="<?php echo "chart.php?k=".$document ;?>" class="btn btn-primary btn-xs"><i class="fa fa-gears"></i> Analyze</a>
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