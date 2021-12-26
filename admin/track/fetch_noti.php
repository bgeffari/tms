<?php

include('../../config/config.php');



if(isset($_POST["limit"], $_POST["start"]))
{

	$query = "SELECT * FROM notifics WHERE ( admin_body != 'na' ) ORDER BY id DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
	
    $messages_query = mysqli_query($con, $query);

	while($row = mysqli_fetch_array($messages_query))
	{
        $if_read = $row['ad_read'];
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
                
                <img src="../work/imgs/icons/notification.png" height="20">&nbsp;
                
                '.$row['admin_body'].'
            </div>
            <div class="col-2">
                <img src="../work/imgs/icons/clock.png" height="17" style="margin-top: -3px;">
                <span dir="ltr">
                    '.$row['date_added'].'
                </span>
                
            </div>
            <div class="col-1">
                <img src="../work/imgs/icons/double-check.png" class="float-left" height="20">
            </div>
        </div>
      ';
    
	} //end of while
} // end of if


?>



