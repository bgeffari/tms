<?php

require '../../config/config.php';

if(isset($_GET['port_id'])){
	$port_id= $_GET['port_id'];
}
$del_file_query = mysqli_query($con, "SELECT * FROM models WHERE id = '$port_id'");
$the_row = mysqli_fetch_array($del_file_query);
$the_file = $the_row['file'];

$image_full_path = "../../assets/models/" .$the_file;

if(isset($_POST['result'])){
	if($_POST['result'] == true){
		// delete query
		
		$query= mysqli_query($con, "DELETE FROM models WHERE id = '$port_id'");
		unlink($image_full_path);
		
	}
}

?>