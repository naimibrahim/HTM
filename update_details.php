<?php 
//start session
session_start(); 
//check user login ke tak
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true) {
$temp_id = new MongoId($_SESSION["id"]) ;
include('db_config.php');
$collection = $db->users; //select collection (table)

$username = $temp_id;
    

$term = array('_id' => $username); //umpukkan username dan password pada array term
$cursor = $collection->find($term);

        $name  = "" ;
        $sex = "" ;
        $age = "" ;
        $last_login = "" ;
    foreach ($cursor as $document) 
      {
        $id_user = $document["_id"] ;
        if(!empty($document["name"])){$name    = $document["name"];}
        if(!empty($document["sex"] )){$sex   = $document["sex"];}
        if(!empty($document["age"] )){$age = $document["age"] ;}
        if(!empty($document["password"] )){$password = $document["password"] ;}
        if(!empty($document["last_login"] )){$last_login = $document["last_login"] ;}
        
        
      }

//if(empty($name)){$name=""};
//if(empty($sex)){$sex=""};
//if(empty($age)){$age=""};


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
          	<h3><i class="fa fa-angle-right"></i> </h3>
          	      	
          	
          	<!-- INPUT MESSAGES -->
          	<div class="row mt">
          		<div class="col-lg-12">
          			<div class="form-panel">

                      <h4 class="mb"><i class="fa fa-angle-right"></i> Update Details</h4>
                          <form class="form-horizontal tasi-form" action="update_details_process.php" method="post">
                              <div class="form-group ">
                                  <label class="col-sm-2 col-sm-2 control-label" >Name</label>
                                  <div class="col-lg-10">
                                      <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ; ?>" placeholder="Your name">
                                  </div>
                              </div>
                              <div class="form-group ">
                                  <label class="col-sm-2 col-sm-2 control-label" >Age</label>
                                  <div class="col-lg-10">
                                      <input type="text" class="form-control" id="age" name="age" value="<?php echo $age ; ?>" placeholder="Your age">
                                  </div>
                              </div>
                              <div class="form-group ">
                              <label class="col-sm-2 col-sm-2 control-label" >Sex</label>
                              <div class="radio">
                                <label>
                                  <input type="radio"  id="optionsRadios1" name="sex" value="male" <?php if($sex=='male') {echo "checked";}?>>
                                  Male
                                </label>

                                <label>
                                  <input type="radio"  id="optionsRadios2" name="sex" value="female" <?php if($sex=='female') {echo "checked";}?>>
                                  Female
                                </label>
                              </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">New Password</label>
                                  <div class="col-sm-10">
                                    <input type="password"  class="form-control" name="password"  placeholder="Your password">
                                  </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Retype New Password</label>
                                  <div class="col-sm-10">
                                    <input type="password"  class="form-control" placeholder="">
                                  </div>
                              </div>
                              <button type="submit" class="btn btn-primary">Update</button>
                          </form>
          			</div><!-- /form-panel -->
          		</div><!-- /col-lg-12 -->
          	</div><!-- /row -->
          	
          	
          		

          	</div><!-- /row -->
          	
          	
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - Alvarez.is
              <a href="form_component.html#" class="go-top">
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


    <!--common script for all pages-->
      <?php include 'bottom.php';?>

  </body>
</html>
<?php } ?>