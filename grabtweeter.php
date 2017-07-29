<?php
if(isset($_POST['id_search']))
{

$keyword = $_POST['id_search'];
$language = $_POST['bahasa'];
$python = `python grabtweeter.py "$keyword" "$bahasa"`;
print $keyword;
?><meta http-equiv="refresh" content="0; url=manage_keyword.php" /> <?php
}
?>
