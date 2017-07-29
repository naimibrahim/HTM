<?php session_start(); 
//check user login ke tak
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true) {

//dapatkan siapa user dan keyword untuk analisis dari session dan GET
$userId = $_SESSION["id"];
$keyword = $_GET['k'];
//tukarkan userId dari session ke format mongodb
$temp_id = new MongoId($_SESSION["id"]) ;

include('db_config.php');
$collection = $db->posts; //select collection (table) users_post

//$term1a = array('$exists'=>false);   
$term = array('search_term' => $keyword);//,'candidate'=>$term1a); //pilih search term dari keyword yang dihantar melalui GET



   	function list_option()
	{
	 $option = '';
	  $option = "<option>Sila pilih</option>";
	   $option .= "<option value='candidate' >Candidate</option>";
	   $option .= "<option value='noncandidate' >Noncandidate</option>";


	  return $option;
	}

	
	

   $cursor = $collection->find($term); //cursor utk users_post


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
          	<h3><i class="fa fa-angle-right"></i> Welcome Back <?php $user = $_SESSION['username']; echo $user; ?>!. </h3>
				

              <div class="row mt">
                  <div class="col-md-12">
                      <div class="content-panel">
                      <form name="form1" action="set_keyword_save.php" method="post">
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> My Keyword</h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> Tweet</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i> Candidate?</th>                              
                              </tr>
                              </thead>
                              <tbody>

							   <?php 
									foreach ($cursor as $document) {
                    // $term2 = array('_id' => $document["postId"]); //pilih search term dari keyword yang dihantar melalui GET
                    // $cursor2 = $collection2->find($term2); //cursor utk posts
                    // foreach ($cursor2 as $document2) {
                      

									 
								  ?>
								  <tr>
									<td><?= $document["text"]; ?><td>
									<td> <?= $document["candidate"]; ?>
										<select name='filter[]' id='filter[]'>
											<?php  echo list_option($sentiment); ?>
										</select>
										<input type="hidden" name="text[]" id="text[]" value="<?= $document2["text"]; ?>"/>
										<input type="hidden" name="id_senti[]" id="id_senti[]" value="<?= $document["_id"]; ?>"/>
										
								  </td>
								  </tr>
								  
                            <?php //}
                             } ?>

                              </tbody>
                          </table>
                          <input class="btn btn-success" type='submit' value='Simpan' >
                      </form>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - Alvarez.is
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