<?php

include('../../config/config.php');




if(isset($_POST["val"]))
{
$x =$_POST["val"];

     //get list one
  $get_miss_typesone = mysqli_query($con, "SELECT * FROM section WHERE mission != '' AND id = '$x' ");
                  $m_row = mysqli_fetch_array($get_miss_typesone);
                    $missionsone = $m_row['mission'];
    $missionsone = explode("," ,$missionsone);
        $count_arr = count($missionsone);
    $i=$count_arr -1;
    $miss_list_one = "<option disabled selected value>المهمة ..</option>";
    for ($i; $i >0 ; $i--) { 
        $dess = $missionsone[$i];
                       $get_missone = mysqli_query($con , "SELECT * FROM missions WHERE id = '$dess'");
                       $miss_row = mysqli_fetch_array($get_missone);
                           $miss_id = $miss_row['id'];
                           $miss_name = $miss_row['name'];
      $miss_list_one.= "<option value='$miss_id'>$miss_name</option>";
                        
                    
    
}
echo $miss_list_one;

    } // end of if


?>



