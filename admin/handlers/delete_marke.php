<?php

require '../../config/config.php';

if(isset($_GET['port_id'])){
	$port_id= $_GET['port_id'];
}


if(isset($_POST['result'])){
	if($_POST['result'] == true){
		// delete query
		
		$query= mysqli_query($con, "DELETE FROM requester WHERE id = '$port_id'");
		
	}
}

?>