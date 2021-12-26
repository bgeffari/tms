<?php
include "../config/config.php";


$id= $_GET['id'];
$get_name = mysqli_query($con, "SELECT * FROM attachs WHERE id = '$id'");
$att_row = mysqli_fetch_array($get_name);
$filename = $att_row['name'];


$f = $filename;   

$file = ("../attachments/$f");




header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            flush(); // Flush system output buffer
            readfile($file);
            die();





?>