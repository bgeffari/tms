<?php 
$admin = $_SESSION['id'];

?>


<section id="projs"><br>
<div class="container" style="width: 90%;">
<div id="scrolli">
    <label class="float-right">المهام التي تم إنجازها :</label>
    <br><br>
    <div class="row indic">
        <div class="col text-center num"></div>
        <div class="col text-center">تاريخ المهمة</div>
        <div class="col text-center">طالب الخدمة</div>
        <div class="col text-center"> الخدمة المطلوبه</div>
        <div class="col text-center">تفاصيل الطلب</div>
        <div class="col text-center">تاريخ الانتهاء</div>
        <div class="col text-center">حالة المهمة </div>
        <div class="col text-center">المرفقات</div>
        <div class="col text-center">إضافة ملاحظة</div>
        
    </div>
    
    <!-- Projects rows -->
    <div id="">
<?php
            $query = "SELECT * FROM orders WHERE employee_id = '$admin' AND status_id = '2' ORDER BY id DESC ";
    
    $messages_query = mysqli_query($con, $query);
    $count = 1;

    while($row = mysqli_fetch_array($messages_query))
    {
        $id = $row['id'];
        $employ_details = $row['employ_details'];
        $req_details = $row['req_details'];
        $fnish_date = $row['date_end'];
        $fnish_date = substr($fnish_date , 0,10); // to get the date only without time
        $pro_date = $row['date_added'];
        $pro_date = substr($pro_date , 0,10); // to get the date only without time

        $requester_id = $row['requester_id'];
        $employee_id = $row['employee_id'];
        $mission_id = $row['mission_id'];
        $status_id = $row['status_id'];
        $rate = $row['req_rate'];
        $why = $row['why_rate'];



        $get_mar = mysqli_query($con, "SELECT * FROM requester WHERE id = '$requester_id'");
        $mar_res = mysqli_fetch_array($get_mar);
        $req_name = $mar_res['name'];

        $get_des = mysqli_query($con, "SELECT * FROM employees WHERE id = '$employee_id'");
        $des_res = mysqli_fetch_array($get_des);
        $empl_name = $des_res['name'];
        $empl_phone =$des_res['phone'];

        $get_type = mysqli_query($con, "SELECT * FROM missions WHERE id = '$mission_id'");
        $typ_res = mysqli_fetch_array($get_type);
        $miss_name = $typ_res['name'];

        $get_status = mysqli_query($con, "SELECT * FROM status WHERE id = '$status_id'");
        $status_res = mysqli_fetch_array($get_status);
        $status_button = $status_res['name'];
        if ($employ_details != "") {
            $employ_detailss = $employ_details;
        }else{
            $employ_detailss = 'قم باضافة ملاحظاتك';
        }
        
        if($rate > 2) {
$status = ' <a class="btn " data-toggle="modal" >'.$status_button.'<img src="imgs/icons/double-check.png" class="float-left" height="20">
           </a>';
} else{
$status = ' <a class="btn " data-toggle="modal" data-target="#update_status'.$id.'">'.$status_button.'
           </a>' ;
}
      echo '
      <div class="row prroj py-2">
        <div class="col text-center num">'.$count.'</div>
        <div class="col text-center">'.$pro_date.'</div>
        <div class="col text-center">'.$req_name.'</div>
        <div class="col text-center">'.$miss_name.'</div>
        <div class="col text-center">'.$req_details.'</div>
        <div class="col text-center" style="overflow: hidden;"><a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#end_date'.$id.'">'.$fnish_date.'</a></div>
        <div class="col-1 text-center">
        '. $status .'
      </div>
        
          <div class="col text-center">
            <button class="btn btn-sm btn-status" href="" data-toggle="modal" data-target="#view_attach'.$id.'">مُراجعة المُرفقات</button>
        </div>

        <div class="col text-center" style="overflow: hidden;"><a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_detail'.$id.'">'.$employ_detailss.'</a></div>
       
        
    </div>
      ';
    
        $count++;
    } //end of while
?>
        <!------  here is where the projects are fetched   -->
    </div>
    <br><br>
</div>
</div>
</section>

<?php
$pro_quer = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$admin_loggedin'");
while($p_row = mysqli_fetch_array($pro_quer)){
    $p_id = $p_row['id'];
    $end_date = $p_row['date_end'];
    $end_date = substr($end_date , 0,10); // to get the date only without time
    $employ_details = $p_row['employ_details'];

    // status
    $p_status = $p_row['status_id'];
    $fetch_stats = mysqli_query($con, "SELECT * FROM status");
    
    //section
    $fetch_sec = mysqli_query($con, "SELECT * FROM section");




    // Update status handling
    $para = 'update_status'.$p_id;
    if(isset($_POST[$para])){
        $new_status = $_POST['new_status'];
        $get_status_name = mysqli_query($con, "SELECT * FROM status WHERE id = '$new_status'");
        $sta_res = mysqli_fetch_array($get_status_name);
        $sta_name = $sta_res['name'];

        $date_added = date("Y-m-d H:i:s");

        
        // update database
        $update_db = mysqli_query($con, "UPDATE orders SET status_id = '$new_status' WHERE id ='$p_id'");
        header("Location: index.php?projects&success");
    }




    // Add note handling
    $param = 'add_detail'.$p_id;
    if(isset($_POST[$param])){
        $added_note = $_POST['note'];
        
        // insert note
        $update_db = mysqli_query($con, "UPDATE orders SET employ_details = '$added_note' WHERE id ='$p_id'");
        header("Location: index.php?projects&success");
    }

    // Add note handling
    $param = 'end_date'.$p_id;
    if(isset($_POST[$param])){
        $added_date = $_POST['endDate'];
        
        // insert note
        $update_db = mysqli_query($con, "UPDATE orders SET date_end = '$added_date' WHERE id ='$p_id'");
        header("Location: index.php?projects&success");
    }


    // Update section handling
    $parasec = 'update_sec'.$p_id;
    if(isset($_POST[$parasec])){
        $new_sec = $_POST['new_sec'];
        $get_section_name = mysqli_query($con, "SELECT * FROM section WHERE id = '$new_sec'");
        $sec_res = mysqli_fetch_array($get_section_name);
        $sec_name = $sec_res['name'];

        $date_added = date("Y-m-d H:i:s");

         
    $possible_des = mysqli_query($con, "SELECT employees FROM missions WHERE id = '$miss_type'");
    $des_arr = mysqli_fetch_array($possible_des);
    $designers = $des_arr['employees'];
    $designers = explode("," ,$designers);
    $ii = true;
    foreach($designers as $dess){
        if($dess != ''){
            $projs = mysqli_query($con, "SELECT * FROM order WHERE employee_id = '$dess'");
            $current_projs = mysqli_num_rows($projs);
            if($ii){
                $num_projs = $current_projs;
                $designer = $dess ;
                $ii = false;
            }
            
            if($current_projs < $num_projs){
                $num_projs = $current_projs;
                $designer = $dess ;
            }
        }
        

        
    }

        // update database
 
    $insert_proj = mysqli_query($con, "INSERT INTO orders VALUES (default , '$requester', '$designer', '$date_added', '$section', '1', '', N'$notes', '', '$miss_type',N'mangeCerv')");
        header("Location: index.php?projects&success");
    }
$attachs_fetch = mysqli_query($con, "SELECT * FROM attachs WHERE order_id = '$p_id'");

    ?>
    
    
    
        <!-- Add Note Modal -->
    <div class="modal fade" id="add_detail<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">إضافة ملاحظة</h5>
        </div>
        <div class="modal-body">
        <form action="" method="post">
        <div class="form-group">
            <textarea name="note" rows="5" class="form-control" placeholder="الملاحظة .."><?php echo $employ_details;?></textarea>
        </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
            <button type="submit" class="btn btn-goo" name="add_detail<?php echo $p_id ?>">إضافة</button>
            </form>
        </div>
        </div>
    </div>
    </div>
        <!-- Add Note Modal -->
    <div class="modal fade" id="end_date<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">إضافة ملاحظة</h5>
        </div>
        <div class="modal-body">
        <form action="" method="post">
        <div class="form-group">
            <input type="date" name="endDate" rows="5" class="form-control" ><?php echo $end_date;?></input>
        </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
            <button type="submit" class="btn btn-goo" name="end_date<?php echo $p_id ?>">إضافة</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <!-- ATTACHMENTS Modal -->
    <div class="modal fade" id="view_attach<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">مراجعة  المُرفقات</h5>
        </div>
        <div class="modal-body">
            <?php
            while( $attach_row = mysqli_fetch_array($attachs_fetch)) {
                $namee = $attach_row['name'];

                $short_namee = substr($namee , 0, 20);
                ?>
                <div class="row attach py-1 mb-1">
                <div class="col text-right">
                    <?php echo $short_namee; ?>
                </div>
                <div class="col">
                    <a style="float:left;" href="download.php?id=<?php echo $attach_row['id']; ?>">
                        <img src="imgs/icons/download.png" height="20">
                    </a>
                </div>
                </div>
                <?php
            } // end of while
            
            ?>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
        </div>
        </div>
    </div>
    </div>



    


        <!-- Update Status Modal -->
    <div class="modal fade" id="update_status<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">تحديث الحالة</h5>
        </div>
        <div class="modal-body">
            <form action="" method="post">
            <div class="form-group">
                <select name="new_status" class="form-control">
                    <?php
                    while($s_row = mysqli_fetch_array($fetch_stats)){
                        if($s_row['id'] == $p_status){
                        ?>
                        <option value="<?php echo $s_row['id']; ?>" selected><?php echo $s_row['name']; ?></option>
                        <?php
                        }else{
                        ?>
                        <option value="<?php echo $s_row['id']; ?>"><?php echo $s_row['name']; ?></option>
                        <?php
                        }
                    }
                    
                    ?>
                </select>
            </div>            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
            <button type="submit" class="btn btn-goo" name="update_status<?php echo $p_id ?>">تحديث</button>
            </form>
        </div>
        </div>
    </div>
    </div>
    

    
    
    
    <?php
}// end of while
?>

<script>

$(document).ready(function(){

     $("#close_sea").click(function(){
        $(".pro_sea").fadeOut(400);
    });
 
 var limit = 25;
 var start = 0;
 var action = 'inactive';
 function load_country_data(limit, start)
 {
  $.ajax({
   url:"mar/fetch.php",
   method:"POST",
   data:{limit:limit, start:start},
   cache:false,
   success:function(data)
   {
    $('#load_data').append(data);
    if(data == '')
    {
     action = 'active';
    }
    else
    {
     action = "inactive";
    }
   }
  });
 }

 if(action == 'inactive')
 {
  action = 'active';
  load_country_data(limit, start);
 }
 $(window).scroll(function(){
  if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
  {
   action = 'active';
   start = start + limit;
   setTimeout(function(){
    load_country_data(limit, start);
   }, 1000);
  }
 });
 
});
</script>