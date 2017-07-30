<?php
//start session
session_start(); 
//check user login ke tak
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true) {
  // $keyword = $_GET['k'];
$temp_id = new MongoId($_SESSION["id"]) ;
include('db_config.php');
$collection = $db->users_posts; //select collection (table) users_post
$collection2 = $db->posts; //select collection (table) dari posts
   
// $term = array('geo' => 'ne:null' ); //pilih search term dari keyword yang dihantar melalui GET
$term = array('place' => array('$ne' => null) ); //pilih search term dari keyword yang dihantar melalui GET
// $term += array('sentimen' => array('$exists' => false)); //hanya paparkan yang tiada sentimen
$cursor = $collection2->find($term); //cursor utk users_post
$cursor_count = $collection2->count($term); //cursor utk users_post
   // $cursor->limit(25);
   // echo $cursor_count;
   foreach ($cursor as $document) {
                    // $term2 = array('_id' => $document["postId"]); //pilih search term dari keyword yang dihantar melalui GET
						// print "<pre>";
						// var_dump($term2);
						// print "</pre>";
					// $cursor2 = $collection2->find($term2); //cursor utk posts
					// foreach ($cursor2 as $document2) {
						// print "<pre>";
						// print_r($document);
						// print "</pre>"; 
						
						// echo $document['place']['bounding_box']['coordinates'][0][1][0].PHP_EOL;
						// echo "<br>";
						// echo $document['place']['bounding_box']['coordinates'][0][1][1];
						// echo "<br>";
						// echo sizeof($document['place']['bounding_box']['coordinates'][0]).exit();
					// }
   
   }
   // exit;
// }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>MarkerClusterer v3 Advanced Example</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

      function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 3,
          center: {lat: 3.1390, lng: 101.6869}
        });

        // Create an array of alphabetical characters used to label the markers.
        //var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
        var markers = locations.map(function(location, i) {
          // return new google.maps.Marker({
            // position: location,
			// title: 'Uluru (Ayers Rock)'
          // });
		  
		marker = new google.maps.Marker({
		  position: location,
		  map: map
		  ,zIndex:100
		});
		
		return marker;
		  
        });

		// Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

      }
	  

      var locations = [
	
	  <?php
			$i = 0;
			foreach ($cursor as $document) {
				$i++;
						// echo "//$i";
        
				if($i != $cursor_count){
					for($j=0; $j<sizeof($document['place']['bounding_box']['coordinates'][0]); $j++){
						echo "{lat: ". $document['place']['bounding_box']['coordinates'][0][$j][1] .", lng: ". $document['place']['bounding_box']['coordinates'][0][$j][0] .",photos: '". $document['user']['profile_image_url_https'] ."' , text: '" . rawurlencode($document['text']) . "'}," . PHP_EOL;
						
						
					}
					
				}else{
					for($j=0; $j<sizeof($document['place']['bounding_box']['coordinates'][0]); $j++){
						echo "{lat: ". $document['place']['bounding_box']['coordinates'][0][$j][1] .", lng: ". $document['place']['bounding_box']['coordinates'][0][$j][0] .",photos: '". $document['user']['profile_image_url_https'] ."' , text: '" . rawurlencode($document['text']) ."'}".($j<(sizeof($document['place']['bounding_box']['coordinates'][0])-1) ? ',' : '') . PHP_EOL;
					}
				}
			
			}
		  ?>
      ]
	  
	  var text = [
	
	  <?php
			$k = 0;
			foreach ($cursor as $document) {
				$k++;
						// echo "//$i";
        
				if($k != $cursor_count){
					for($l=0; $l<sizeof($document['place']['bounding_box']['coordinates'][0]); $l++){
						echo "{text: '" . rawurlencode($document['text']) . "'}," . PHP_EOL;
						
						
					}
					
				}else{
					for($l=0; $l<sizeof($document['place']['bounding_box']['coordinates'][0]); $l++){
						echo "{text: '" . rawurlencode($document['text']) . "'}" . ($l<(sizeof($document['place']['bounding_box']['coordinates'][0])-1) ? ',' : '') . PHP_EOL;
					}
				}
			
			}
		  ?>
      ]
	  
    </script>
    <script src="markerclusterer.js">
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrnQ1j8mX_uTzEFSQWkKEl3D8sPZcvZ8U&callback=initMap">
    </script>
  </body>
</html>
<?php } ?>	