<?php session_start(); 
//check user login ke tak
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true) {

//dapatkan siapa user dan keyword untuk analisis dari session dan GET
$userId = $_SESSION["id"];
$keyword = $_GET['k'];
//tukarkan userId dari session ke format mongodb
$temp_id = new MongoId($_SESSION["id"]) ;

include('db_config.php');
$collection = $db->users_posts; //select collection (table) users_post
$collection2 = $db->posts; //select collection (table) dari posts
   
$term = array('search_term' => $keyword,'userId' => $temp_id ); //pilih search term dari keyword yang dihantar melalui GET
$term += array('sentimen' => array('$exists' => false)); //hanya paparkan yang tiada sentimen

   function activateUrlStrings($str){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $str);
  }

   	function list_option()
	{
	 $option = '';
	  $option = "<option>Please Choose</option>";
	   $option .= "<option value='not_relevant' >Not Relevant</option>";
	   $option .= "<option value='forced_labour' >Forced Labour</option>";
	   $option .= "<option value='sex' >Sex</option>";
     $option .= "<option value='child_army' >Child Army</option>";
     $option .= "<option value='forced_marriage' >Forced Marriage</option>";


	  return $option;
	}

	
	

   $cursor = $collection->find($term); //cursor utk users_post
   $cursor->limit(25);


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
      

      <?php if($_SESSION["user_level"] ==1){ 
        //-------------------modal box------------------?>


                  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">MySentiment Training</h4>
                  </div>
                  <div class="modal-body">
                    Hi, our engine is based on supervised learning, it mean that you need to train it before it can classify the sentiment for you. Thus make the classification is tailored for you.<br/><br/>
                    Please train the engine by selecting the sentiment that you think right based on your judgement.
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>              
              </div>
              <?php } //-------------------modal box tamat------------------ ?>


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
                      
									  if(!empty($document2["sentimen"])){
									   $sentiment = $document2["sentimen"] ;
									  }	
									 
								  ?>
								  <tr>
									<td><?php echo "<img src='". $document2["user"]["profile_image_url"] ."'alt='[Unable to retrieve profile pic]'style='width:25px;height:25px'> [<a href='http://twitter.com/".$document2["user"]["screen_name"]. "'>".$document2["user"]["screen_name"]. "</a>] - " . activateUrlStrings($document['text']); ?><td>
									<td>
										<select name='filter[]' id='filter[]'>
											<?php  echo list_option($sentiment); ?>
										</select>
										<input type="hidden" name="text[]" id="text[]" value="<?= $document['text']; ?>"/>
										<input type="hidden" name="id_senti[]" id="id_senti[]" value="<?= $document["_id"]; ?>"/>
                    <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>"/>
										
								  </td>
								  </tr>
								  
                            <?php } } ?>

                              </tbody>
                          </table>
                          <input class="btn btn-success" type='submit' value='Train' >
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
   if($_SESSION["user_level"] ==1){ ?>

              <script type="text/javascript">
                $(window).load(function(){
                    $('#myModal').modal('show');
                });
            </script>

      <?php   
    }


 //kalau tak login paparkan ini   
} else {    echo "Please log in first to see this page.";}?>