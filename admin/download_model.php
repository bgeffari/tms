<?php
include "../config/config.php";


$id= $_GET['id'];
$get_name = mysqli_query($con, "SELECT * FROM models WHERE id = '$id'");
$fill_row = mysqli_fetch_array($get_name);
$filename = $fill_row['file'];


$f = $filename;   

$file = ("../assets/models/$f");

$filetype=filetype($file);

$filename=basename($file);

header ("Content-Type: ".$filetype);

header ("Content-Length: ".filesize($file));

header ("Content-Disposition: attachment; filename=".$filename);

readfile($file);



?>