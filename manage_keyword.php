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
    function list_option_city()
  {
   $option = '';
     $option .= "<option value='kuala_lumpur' >Kuala Lumpur</option>";
     $option .= "<option value='putrajaya' >Putrajaya</option>";
     $option .= "<option value='shah_alam' >Shah Alam</option>";
     $option .= "<option value='seremban' >Seremban</option>";
     $option .= "<option value='ipoh' >Ipoh</option>";


    return $option;
  }
  
  function list_option_radius()
  {
   $option = '';
     $option .= "<option value='5' >5 KM</option>";
     $option .= "<option value='10' >10 KM</option>";
     $option .= "<option value='25' >25 KM</option>";
     $option .= "<option value='50' >50 KM</option>";
     $option .= "<option value='200' >200 KM</option>";
     $option .= "<option value='500' >500 KM</option>";
    $option .= "<option value='1000' >1000 KM</option>";


    return $option;
  }

  function list_option_language()
  {
   $option = '';
     $option .= "<option value='ms' >Bahasa Melayu</option>";
     $option .= "<option value='id' >Bahasa Indonesia</option>";
     $option .= "<option value='en' >English</option>";
     $option .= "<option value='bn' >Bengali</option>";
     $option .= "<option value='zh' >Chinese</option>";
     $option .= "<option value='ta' >Tamil</option>";


    return $option;
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
          <font color="white">
          	<h3><i class="fa fa-angle-right"></i> Discover new keyword</h3>
          </font>


            <div class="dropdown">

            <font color="white">Please Choose City :</font>
            <select name='filter[]' id='filter[]'>
                      <?php  echo list_option_city($sentiment); ?>
             </select>
             
             <font color="white">Please Choose Radius :</font>
             <select name='filter[]' id='filter[]'>
                      <?php  echo list_option_radius($sentiment); ?>
             </select>

             <font color="white">Please Choose Language :</font>
             <select name='filter[]' id='filter[]'>
                      <?php  echo list_option_language($sentiment); ?>
             </select>

            </div>


          	<div class="row mt">
          		<div class="col-lg-12">
          

					
					<! -- 2ND ROW OF PANELS -->
					<div class="row">

						<?php 
              $i=0;
                foreach ($cursor_term_sedia_ada as $document_term_sedia_ada) {
                  $term_sedia_ada = $document_term_sedia_ada;
                  $term2 = array('search_term' => $document_term_sedia_ada); //pilih search term
                  $cursor_count = $collection2->count($term2);
                  //print "Total tweet : " . $cursor_count . " | ";
                  //$term3 = array('search_term' => $document, 'sentimen' => array('$exists' => false),"userId"=> $temp_id); //pilih search term
                  //$cursor_count3 = $collection->count($term3);
                  //print " Not yet trained : " . $cursor_count3;
                  ?>
        						<! -- PROFILE 01 PANEL -->
        						<div class="col-lg-4 col-md-4 col-sm-4 mb">
        							<div class="content-panel pn">
        								<div id="profile-01">
        									<h3><?php echo $document_term_sedia_ada ?></h3>
        									<h6><?php echo "Total tweet : " . $cursor_count; ?></h6>
        								</div>
        								<a href="add_aviable_tweet.php?k=<?php echo $document_term_sedia_ada ?>"><div class="profile-01 centered">
        									<p>ADD TO MY LIST</p>
        								</div></a>
                        <a href="delete_tweet.php?k=<?php echo $document_term_sedia_ada ?>"><div class="profile-01 centered">
                          <p>DELETE ALL TWEET</p>
                        </div></a>
        								<div class="centered">
        									<h6><br/>  </h6>
        								</div>
        							</div><! --/content-panel -->
        						</div><! --/col-md-4 -->


            <?php } ?>

						

					
          		</div>

                <!-- form untuk search dan grab tweet dari twetter -->
                <form action="grabtweeter.php" method="POST">
                <h4>
                <input type="text" id="id_search" name="id_search" placeholder="Type new keyword.." \>
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-plus"></i> Grab new tweet from Twitter
                </button>
                </h4>
                </form>
                  


          	</div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - Alvarez.is
              <a href="panels.html#" class="go-top">
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
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>

    <!--common script for all pages-->
      <?php include 'bottom.php';?>
  </body>
</html>
<?php } ?>
