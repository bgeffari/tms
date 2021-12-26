<?php

include('../../config/config.php');
$admin = $_SESSION['id'];
$rolle = $_SESSION['role'];


$options = "id = 0"; //something that is always false
$get_all_adm = mysqli_query($con, "SELECT * FROM notifics WHERE origin = 'adm' ");
while($adn_row = mysqli_fetch_array($get_all_adm)){
    if($rolle == "mar"){
        $options = "origin = 'adm' AND to_id = '".$admin."'";
        
    }else{
        $options = "origin = 'adm' AND from_id = '".$admin."'";
    }
}


if(isset($_POST["limit"], $_POST["start"]))
{

    
	$query = "SELECT * FROM notifics WHERE ( (to_id = '$admin' AND origin = 'emp') OR ($options) ) ORDER BY id DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
	
    $messages_query = mysqli_query($con, $query);

	while($row = mysqli_fetch_array($messages_query))
	{
        $if_read = $row['if_read'];
        if($if_read == "no"){
            $bg = "unread";
        }elseif($if_read == "red"){
            $bg = "red_alert";
        }else{
            $bg = "";
        }

        
        
	  echo '
      <div class="row noti text-right '.$bg.' py-2 px-2 mb-1">
            <div class="col-9">
                
                <img src="imgs/icons/notification.png" height="20">&nbsp;
                
                '.$row['body'].'
            </div>
            <div class="col-2">
                <img src="imgs/icons/clock.png" height="17" style="margin-top: -3px;">
                <span dir="ltr">
                    '.$row['date_added'].'
                </span>
                
            </div>
            <div class="col-1">
                <img src="imgs/icons/double-check.png" class="float-left" height="20">
            </div>
        </div>
      ';
    
	} //end of while
} // end of if


?>



