  <?php // connect to mongodb
   $m = new MongoClient();
 //<dbuser>:<dbpassword>@ds034348.mongolab.com:34348/mysentimen1
  // $m = new MongoClient( "mongodb://naim:naim@ds034348.mongolab.com:34348/mysentimen1" ); 
  //echo "Connection to database successfully";   
   $db = $m->tweet_database; // select a database
   //echo "<br/>Database $db selected";

   //echo "<br/>Collection selected succsessfully";
   
   ?>