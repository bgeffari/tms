<?php

require '../../config/config.php';

if(isset($_GET['cours_id'])){
	$cours_id= $_GET['cours_id'];
}
$del_file_query = mysqli_query($con, "SELECT * FROM cours WHERE id = '$cours_id'");

$del_req_query = mysqli_query($con, "SELECT * FROM req_cours WHERE cours_id = '$cours_id'");
$the_row = mysqli_fetch_array($del_file_query);
$the_file = $the_row['image'];

$image_full_path = "../../assets/courses/" .$the_file;

if(isset($_POST['result'])){
	if($_POST['result'] == true){
		// delete query
		if(mysqli_num_rows($del_req_query) > 0){
		$del_rreq_cours = mysqli_query($con, "DELETE  FROM req_cours WHERE cours_id = '$cours_id'");
		}
		
		$query= mysqli_query($con, "DELETE FROM cours WHERE id = '$cours_id'");
		unlink($image_full_path);
		
	}
}

?>