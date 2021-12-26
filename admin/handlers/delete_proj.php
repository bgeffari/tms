<?php

require '../../config/config.php';

if(isset($_GET['port_id'])){
	$port_id= $_GET['port_id'];
}


if(isset($_POST['result'])){
	if($_POST['result'] == true){

		// remove attachments
		$attach_q = mysqli_query($con, "SELECT * FROM attachs WHERE order_id = '$port_id'");
		while($rrow  = mysqli_fetch_array($attach_q)){
			$fullpath = "../../attachments/".$rrow['name'];
			unlink($fullpath);
		}
		// delete attach
		$delet_attach = mysqli_query($con, "DELETE FROM attachs WHERE order_id = '$port_id'");

		// delete query
		$query= mysqli_query($con, "DELETE FROM orders WHERE id = '$port_id'");
		
	}
}

?>