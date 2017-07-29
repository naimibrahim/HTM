<?php
if(isset($_POST['id_search']))
{

$keyword = $_POST['id_search'];
$language = $_POST['bahasa'];
$latitude = $_POST['3.147564'];	# geographical centre of search - Dataran Merdeka Kuala Lumpur
$longitude = $_POST['101.693125'];	# geographical centre of search - Dataran Merdeka Kuala Lumpur
$max_range = $_POST['500']; # search range in kilometres

$python = `python grabtweeter.py "$keyword" "$bahasa" "$latitude" "$longitude" "$max_range"`;
print $keyword;
?><meta http-equiv="refresh" content="0; url=manage_keyword.php" /> <?php
}
?>
