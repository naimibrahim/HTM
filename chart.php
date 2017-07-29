<?php session_start(); 
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true) { //kalau tak login tak boleh nampak
include('db_config.php');

//dapatkan siapa user dan keyword untuk analisis dari session dan GET
$userId = $_SESSION["id"];
$keyword = $_GET['k'];
//tukarkan userId dari session ke format mongodb
$temp_id = new MongoId($_SESSION["id"]) ;

//semak samaada user punya training penuh atau tidak..kalau kosong beri alert
$cursor_count_semak_penuh =0;
$collection_semak_penuh = $db->users_posts; //select collection (table)
$term_semak_penuh= array('search_term' =>$keyword,"userId"=> $temp_id,"trained"=>"n"); //pilih search term
$cursor_count_semak_penuh = $collection_semak_penuh->count($term_semak_penuh);

if($cursor_count_semak_penuh==0){

        ?>
        <script>
              alert("You have trained all the tweets for <?php echo $keyword; ?>, we don't have any tweets to analyed.");
          </script>
          
      <?php
}
//semak samaada user punya training kosong atau tidak..kalau kosong beri alert
$cursor_count_semak_kosong =0;
$collection_semak_kosong = $db->users_posts; //select collection (table)
$term_semak_kosong = array('search_term' =>$keyword,"userId"=> $temp_id,"trained"=>"y"); //pilih search term
$cursor_count_semak_kosong = $collection_semak_kosong->count($term_semak_kosong);

if($cursor_count_semak_kosong==0){

        ?>
        <script>
              alert("You don't train any tweets, we can't classify the tweet without training data. Or maybe our engine have problems.");
          </script>
          <meta http-equiv="refresh" content="0; url=main_basic.php" /> 
          
      <?php
      }else { 




      
?>
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
          <h3><i class="fa fa-angle-right"></i> Based on your training data, our engine suggest </h3>
              <!-- page start-->
              <div id="morris">
                  <div class="row mt">

                      <div class="col-lg-6">
                          <div class="content-panel">
                              <h4><i class="fa fa-angle-right"></i>Analyzed Sentimen</h4>
                              <div class="panel-body">
                                  <div id="hero-donut" class="graph"></div>
                              </div>
                          </div> 
                      </div> 
                      <div class="col-lg-6">
                          <div class="content-panel">
                              <h4><i class="fa fa-angle-right"></i> Total Sentimen - Trained + Analyzed</h4>
                              <div class="panel-body">
                                  <div id="hero-bar" class="graph"></div>
                              </div>
                          </div>
                      </div>
                      
                      <?php








                              //execute atau panggil python script untuk buat analisis sentimen
                            //$python = `python tw-20g.py "$temp_id" "$keyword"`;
                            exec("python tw-20g.py \"$temp_id\" \"$keyword\"", $output);
                            //var_dump($output);


                              //connect ke mongodb
                            
                            $collection = $db->users_posts; //select collection (table)



                            //kira berapa banyak output dari python
                            $max_myarr= count($output);
                            //print $max_myarr;

                            //------savekan sentimen yang telah dianalisis ke dalam mongodb----
                            $i=0;
                            for($i=0;$i<$max_myarr;$i++)
                            {


                               $senti = substr($output[$i], 26);  //dapatkan sentimen yang telah dianalisis
                              //print $senti . "<br/>" ;



                              if($senti=="not_relevant"||$senti=="forced_labour"||$senti=="sex"||$senti=="child_army"||$senti=="forced_marriage")
                              { 
                                //update collection each_users_posts
                                  $key = substr($output[$i], 0, 24); //dapatkan _id untuk id_each_users_posts
                                  $temp_id1 = new MongoId($key); 
                                  $update = array('nbsentimen'=>$senti);
                                  $collection->update(
                                  array('_id'=>$temp_id1),
                                  array('$set' => $update)
                                );


                               // print "<br/> success save : " . $key2 ;
                              }

                            }

                            //------tamat savekan sentimen yang telah dianalisis ke dalam mongodb----

                            //-------untuk dapatkan statistics ----------------


                          $jum_senti_not_relevant=0;
                          $jum_senti_forced_labour=0;
                          $jum_senti_child_army=0;
                          $jum_senti_sex=0;
                          $jum_senti_forced_marriage=0;







                          $kunci_not_relevant = array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'n','nbsentimen'=> 'not_relevant');
                          $jum_senti_not_relevant= $collection->count($kunci_not_relevant);
                          $senti_not_relevant = $jum_senti_not_relevant;




                          $kunci_forced_labour= array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'n','nbsentimen'=> 'forced_labour');
                          $jum_senti_forced_labour = $collection->count($kunci_forced_labour);
                          $senti_forced_labour = $jum_senti_forced_labour ;



                          $kunci_sex = array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'n','nbsentimen'=> 'sex');
                          $jum_senti_sex = $collection->count($kunci_sex);
                          $senti_sex = $jum_senti_sex;

                          $kunci_child_army = array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'n','nbsentimen'=> 'child_army');
                          $jum_senti_child_army = $collection->count($kunci_child_army);
                          $senti_child_army = $jum_senti_child_army;

                          $kunci_forced_marriage = array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'n','nbsentimen'=> 'forced_marriage');
                          $jum_senti_forced_marriage = $collection->count($kunci_forced_marriage);
                          $senti_forced_marriage= $jum_senti_forced_marriage;



                          $total_senti =  $jum_senti_not_relevant  +  $jum_senti_forced_labour + $jum_senti_child_army + $jum_senti_sex +  $jum_senti_forced_marriage;

                          $total_semua = $total_senti;




                          $peratus_not_relevant = 0;
                          $peratus_forced_labour = 0;
                          $peratus_child_army  = 0;
                          $peratus_sex = 0;
                          $peratus_forced_marriage = 0;

                              
                          if($total_semua!=0){
                            $peratus_not_relevant = $senti_not_relevant / $total_semua * 100;
                            $peratus_forced_labour = $senti_forced_labour / $total_semua * 100;
                            $peratus_child_army = $senti_sex / $total_semua * 100;
                            $peratus_sex = $senti_child_army / $total_semua * 100;
                            $peratus_forced_marriage = $senti_forced_marriage / $total_semua * 100;
                          }


                          }


                          ?>
 
                        <form class="form-horizontal tasi-form" action="chart_process.php" method="post">
                          <br/> <br/><table class="table table-striped table-advance table-hover">
                            <h4><i class="fa fa-angle-right"></i> Tweet and sentimen.. </h4>


                            <hr>

                              <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> Tweet</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i> Sentimen</th>
                                  <th>Check</th>
                              </tr>
                              </thead>
                              <tbody>

                            <?php 
                            
                            echo "Total tweet that we analyze are : " . $total_senti;

                            //kira semua tweet yang telah ditrain
                            $kunci2 = array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'y','sentimen'=> array('$exists' => true));
                            $cursor_semua_tweet_ditrain = $collection->find($kunci2);
                            $jumlah_yg_ditrain = $cursor_semua_tweet_ditrain->count();

                            $kunci_kunci_forced_labour = array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'y','sentimen'=> 'forced_labour');
                            $jumlah_force_labour_yg_ditrain = $collection->count($kunci_kunci_forced_labour);
                                                 

                            $kunci_not_relevant = array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'y','sentimen'=> 'not_relevant');
                            $jumlah_not_relevent_yg_ditrain = $collection->count($kunci_not_relevant);

                            $kunci_child_army = array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'y','sentimen'=> 'child_army');
                            $jumlah_child_army_yg_ditrain = $collection->count($kunci_child_army);

                            $kunci_child_sex = array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'y','sentimen'=> 'sex');
                            $jumlah_sex_yg_ditrain = $collection->count($kunci_sex);

                            $kunci_forced_marriage = array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'y','sentimen'=> 'forced_marriage');
                            $jumlah_forced_marriage_yg_ditrain = $collection->count($kunci_forced_marriage);

                            echo "<br/>Total tweet that you train are : " . $jumlah_yg_ditrain;

                            echo "<br/>Total tweet for keyword <b>" . $keyword . "</b> are : " . ($total_senti + $jumlah_yg_ditrain);

                            echo "<br/><br/>Total forced_labour tweets that our engine classify are : " . $jum_senti_forced_labour . " @ " . $peratus_forced_labour . "%" ;
                            echo "<br/>Total not_relevant tweets that our engine classify are : " . $jum_senti_not_relevant . " @ " . $peratus_not_relevant . "%" ;
                            echo "<br/>Total child_army tweets that our engine classify are : " . $jum_senti_child_army  . " @ " . $peratus_child_army . "%" ;
                            echo "<br/>Total sex tweets that our engine classify are : " . $jum_senti_sex  . " @ " . $peratus_sex . "%" ;
                            echo "<br/>Total forced_marriage tweets that our engine classify are : " . $jum_senti_forced_marriage . " @ " . $peratus_forced_marriage . "%" ;

                            $total_forced_labour = $jum_senti_forced_labour  + $jumlah_force_labour_yg_ditrain;
                            $total_not_relevant = $jum_senti_not_relevant + $jumlah_not_relevent_yg_ditrain;
                            $total_child_army = $jum_senti_child_army   + $jumlah_child_army_yg_ditrain;
                            $total_sex = $jum_senti_sex + $jumlah_sex_yg_ditrain;
                            $total_forced_marriage = $jum_senti_forced_marriage   + $jumlah_forced_marriage_yg_ditrain;
                            

                           $kunci_semua= array('search_term' => $keyword,'userId'=> $temp_id,'trained'=>'n','nbsentimen'=> array('$exists' => true));
                           $cursor_semua_tweet_dianalisis= $collection->find($kunci_semua);

                           function activateUrlStrings($str){
                                  return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $str);
                							}


                            //   $result_chart = $collection->aggregate(
                            //         array(
                            //                 array( '$match' => array( 'search_term' => 'hudud' ) )
                            //         )
                            // );

                            //var_dump($result_chart);

                            // foreach ($result_chart as $document) { 
                            //   print_r("<br/> - ");
                            //  print_r($document['result']['0']['id']['sentimen']);

                            // }

                            $i=0;
                              foreach ($cursor_semua_tweet_dianalisis as $document) { 
                                //print_r($document);
                              	$collection2 = $db->posts;
                              	$postId2 = new MongoId($document['postId']);
                              	$key_posts = array('_id'=>$postId2);
                              	$cursor_posts = $collection2->find($key_posts);
                              	foreach($cursor_posts as $document2){

                              	?>
                              <tr>
                              <td><?php echo "<img src='". $document2["user"]["profile_image_url"] ."'alt='[Unable to retrieve  profile pic]'style='width:25px;height:25px'>[<a href='http://twitter.com/".$document2["user"]["screen_name"]. "'>".$document2["user"]["screen_name"]. "</a>] - " . activateUrlStrings($document2['text']); }?><td>
                              <td>
                                  <?php
                                    echo $document['nbsentimen'];
                                  ?>
                              </td>
                              <td>
                                  <div class="radio">
                                    <label>
                                      <input type="radio" name="check<?php echo $i;?>" id="check" value="right" checked>
                                      Right
                                    </label>
                                  </div>
                                    <div class="radio">
                                    <label>
                                      <input type="radio" name="check<?php echo $i;?>" id="check" value="wrong">
                                      Wrong
                                    </label>
                                  </div>
                              <input type="hidden" name="id_senti[]" id="id_senti[]" value="<?= $document["_id"]; ?>"/>
                              <input type="hidden" name="sentimen[]" id="sentimen[]" value="<?= $document["nbsentimen"]; ?>"/>
                              </td>
                              </tr>
                            <?php
                             $i++; } ?>

                              </tbody>
                          </table>
                          <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>"/>
                              <button type="submit" class="btn btn-primary">Save validation</button>
                          </form>




                  </div>
              </div>
              <!-- page end-->
          </section>
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2015 - Mohd Naim
              <a href="morris.html#" class="go-top">
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



    <!--common script for all pages-->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="assets/js/common-scripts.js"></script>




    <!--script for this page-->
    <script type="text/javascript">




var Script = function () {

    //morris chart

    $(function () {



      // data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type
 Morris.Bar({
        element: 'hero-bar',
        data: [
          {Sentimen: 'Positive', Total: <?php echo $total_positive; ?> },
          {Sentimen: 'Negative', Total: <?php echo $total_negative; ?> },
          {Sentimen: 'Neutral', Total: <?php echo $total_neutral; ?> },

        ],
        xkey: 'Sentimen',
        ykeys: ['Total'],
        labels: ['Total'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto',
        barColors: function (row, series, type) {
        console.log("--> "+row.label, series, type);
        if(row.label == "Positive") return "#32CD30";
        else if(row.label == "Negative") return "#AD1D28";
        else if(row.label == "Neutral") return "#fec04c";
        }
        });





      Morris.Donut({
        element: 'hero-donut',
        data: [
          {label: 'Positive', value: <?php echo $jum_senti_positive; ?>},
          {label: 'Negative', value: <?php echo $jum_senti_negative; ?> },
          {label: 'Neutral', value: <?php echo $jum_senti_neutral; ?> }
        ],
          colors: ['#32CD32', '#FF0000', '#F0E68C'],
        formatter: function (y) { return y}
      });

      

      $('.code-example').each(function (index, el) {
        eval($(el).text());
      });
    });

}();



    </script>
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

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
