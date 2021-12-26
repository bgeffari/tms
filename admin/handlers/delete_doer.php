<?php

require '../../config/config.php';

if(isset($_GET['port_id'])){
	$port_id= $_GET['port_id'];
}


if(isset($_POST['result'])){
	if($_POST['result'] == true){
		
		// delete query
		$query= mysqli_query($con, "DELETE FROM employees WHERE id = '$port_id'");

		// delte his id from sections
		// $sec_q = mysqli_query($con, "SELECT * FROM sections WHERE designers != ''");
		// while($sec_row = mysqli_fetch_array($sec_q)){
		// 	$newdes = "";
		// 	$c_id = $sec_row['id'];

		// 	$desingers_array = $sec_row['designers'];
		// 	$dsnrs = explode(",", $desingers_array);
		// 	foreach($dsnrs as $des){
				
		// 		if($des != ''){
		// 			if($des == $port_id){
		// 				$newdes.= "";
		// 			}else{
		// 				$newdes.= "," .$des;
		// 			}
		// 		}
		// 	}
		// 	//
		// 	$updt = mysqli_query($con, "UPDATE sections SET designers = '$newdes' WHERE id = '$c_id'");
		// }
	}
	        header("Location: track.php?doers");

}

?>