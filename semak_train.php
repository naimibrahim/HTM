<?php session_start(); 
//check user login ke tak
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true) {

$keyword =  $_GET['k'];
include('db_config.php');
$collection = $db->users_posts; //select collection (table) users_post
$collection2 = $db->posts; //select collection (table) dari posts
   
   $term = array('search_term' => $keyword); //pilih search term
   $term += array('sentimen' => array('$ne' => "irrelevent",'$exists' => true)); //hanya paparkan yang ada sentimen
   


   	function list_option($search_by)
	{
	 $option = '';
	  if ($search_by == 'neutral')
	  {
	  $option = '';
	   $option .= "<option value='neutral' selected>Neutral</option>";
	   $option .= "<option value='positive' >Positive</option>";
	   $option .= "<option value='negative' >Negative</option>";
	  }
	  if ($search_by == 'positive')
	  {
	  $option = '';
	   $option .= "<option value='neutral' >Neutral</option>";
	   $option .= "<option value='positive' selected>Positive</option>";
	   $option .= "<option value='negative' >Negative</option>";
	   
	  }
	  if ($search_by == 'negative')
	  {
	  $option = '';
	   $option .= "<option value='neutral' >Neutral</option>";
	   $option .= "<option value='positive' >Positive</option>";
	   $option .= "<option value='negative' selected>Negative</option>";
	   
	  }
	  return $option;
	}

	
	

   $cursor = $collection->find($term);
   

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
                      <form name="form1" action="test4a_save.php" method="post">
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> My Keyword</h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> Tweet</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i> Sentimen</th>                              
                              </tr>
                              </thead>
                              <tbody>

							   <?php 
									foreach ($cursor as $document) {
                    $term2 = array('_id' => $document["postId"]); //pilih search term dari keyword yang dihantar melalui GET
                    $cursor2 = $collection2->find($term2); //cursor utk posts
                    foreach ($cursor2 as $document2) {
                      
                    
                     $sentiment = $document["sentimen"] ;
									  
									 
								  ?>
								  <tr>
									<td><?php echo "[".$document2["user"]["screen_name"]. "] - " . $document2["text"]; ?><td>
									<td> <?php  echo $sentiment; ?>
										<select name='filter[]' id='filter[]'>
											<?php  echo list_option($sentiment); ?>
										</select>
										<input type="hidden" name="text[]" id="text[]" value="<?= $document2["text"]; ?>"/>
										<input type="hidden" name="id_senti[]" id="id_senti[]" value="<?= $document["_id"]; ?>"/>
										
								  </td>
								  </tr>
								  
                            <?php } } ?>

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
              2015 -  Mohd Naim
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