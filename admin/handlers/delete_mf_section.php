<?php

require '../../config/config.php';


if(isset($_SESSION['edit_section'])){
    $sect_id = $_SESSION['edit_section'];
}

if(isset($_GET['port_id'])){
    $port_id= $_GET['port_id'];
}
if(isset($_GET['sec_id'])){
    $sec_id= $_GET['sec_id'];
}


if(isset($_POST['result'])){
	if($_POST['result'] == true){

        $get_sec = mysqli_query($con, "SELECT * FROM section WHERE id = '$sec_id'");
        $fetch_des = mysqli_fetch_array($get_sec);
        $sec_designers = $fetch_des['mission'];
        $sec_designers = explode("," , $sec_designers);


        $new_dess = "";
        foreach($sec_designers as $des){
            if($des != ''){
                if($des == $port_id){
                    $new_dess.= "";
                }else{
                    $new_dess.= "," .$des;
                }
            }
        }
		// update query which means delteng
		
        $query= mysqli_query($con, "UPDATE section SET mission = '$new_dess' WHERE id ='$sec_id' ");
		
	}
}

?>