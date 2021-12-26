<?php

require '../../config/config.php';

if(isset($_GET['por_id'])){
	$port_id= $_GET['por_id'];
}


if(isset($_POST['result'])){
	if($_POST['result'] == true){
		// delete query
		
		$query= mysqli_query($con, "DELETE FROM missions WHERE id = '$port_id'");
		
	}
}

?>