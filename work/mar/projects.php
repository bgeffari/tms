


<section id="projs"><br>
<div class="container" style="width: 90%;">
<div id="scrolli">
    <label class="float-right">المهام المضافة :</label>
    <br><br>
    <div class="row indic">
        <div class="col text-center num"></div>
        <div class="col text-center">تاريخ المهمة</div>
        <div class="col text-center">طالب الخدمة</div>
        <div class="col text-center"> الخدمة المطلوبه</div>
        <div class="col text-center"> رقم التحويلة</div>
        <div class="col text-center">الإدارة طالبة الخدمة</div>
        <div class="col text-center">تفاصيل الطلب</div>
        <div class="col text-center">تاريخ الانتهاء</div>
        <div class="col text-center">حالة المهمة </div>
        <div class="col text-center">المرفقات</div>
        <div class="col text-center">إضافة ملاحظة</div>
        
    </div>
    
    <!-- Projects rows -->
    <div id="load_data">
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
    $mission_id = $p_row['mission_id'];
    $pro_date = $p_row['date_added'];
    $req_id = $p_row['requester_id'];
    $end_date = $p_row['date_end'];
    $end_date = substr($end_date , 0,10); // to get the date only without time
    $employ_details = $p_row['employ_details'];
    $req_details = $p_row['req_details'];

     $get_mar = mysqli_query($con, "SELECT * FROM requester WHERE id = '$req_id'");
        $mar_res = mysqli_fetch_array($get_mar);
        global $req_name;
        $req_name = $mar_res['name'];
        $date_added = date("Y-m-d H:i:s");
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
        $sta_id = $sta_res['id'];


                $notifi_body = "قام " .$logged_name ." بتحديث حالة مهمة لك إلى " .$sta_name;
        $admin_body = "قام " .$logged_name ." بتحديث حالة مهمة " .$req_name ." إلى " .$sta_name;

        // insert notifics
        $insert_noti = mysqli_query($con, "INSERT INTO notifics VALUES (default , 'emp', '$admin_loggedin', '$req_id', '$notifi_body', '$admin_body', '$date_added', 'no', 'no')");


        // update database
         // if employees fnish the missions it update the fnish date in database
        if ($sta_id == 2) {
        $date_fnish = date("Y-m-d H:i:s");
        $date_fni = date_create($date_fnish);
        $pro_date = date_create($pro_date);
        
        $date_diff = date_diff($date_fni , $pro_date);
        $date_rate = $date_diff->format("%a");
        $get_date_name = mysqli_query($con, "SELECT * FROM missions WHERE id = '$mission_id'");
    $fetch_date = mysqli_fetch_array($get_date_name);
    $da = $fetch_date['end_date'];
    if ($date_rate == 0) {
        if ($da == 1) {
            $rate = 1.2 * 100;
        }else{
        $rate = $da * 100;
        }
    }else{
        $rate = ($da/$date_rate)*100;
    }

                $update_db = mysqli_query($con, "UPDATE orders SET status_id = '$new_status' , date_end = '$date_fnish' , rate = '$rate' WHERE id ='$p_id'");


        }else{
        $update_db = mysqli_query($con, "UPDATE orders SET status_id = '$new_status' WHERE id ='$p_id'");
        }

        header("Location: index.php?projects&success");
    }




    // Add note handling
    $param = 'add_detail'.$p_id;
    if(isset($_POST[$param])){
        $added_note = $_POST['note'];
          $attach_p_id = $p_id;

              $attach_p_id = $p_id;
        // count files uploaded
        $countfiles = count($_FILES['file']['name']);
         // loop files
        for($i=0 ; $i < $countfiles ; $i++){
              $temp= explode('.', $_FILES['file']['name'][$i]); 

$extension = end($temp);
            $file_name = "file-".time().".".$extension;
            if (is_uploaded_file($_FILES['file']['tmp_name'][$i]) || file_exists($_FILES['file']['tmp_name'][$i])) {
                // upload file
                move_uploaded_file($_FILES['file']['tmp_name'][$i], '../attachments/'.$file_name);
                // insert in db
                $insert_attach = mysqli_query($con, "INSERT INTO attachs VALUES (default , '$attach_p_id', N'$file_name', 'yes')");
        
            }
            
        }


                $notifi_body = "قام " .$logged_name ." بإرفاق بعض الملاحظات على مهمة لك";
        $admin_body = "قام " .$logged_name ." بإرفاق بعض الملاحظات على مهمة " .$req_name;

        // insert notifics
        $insert_noti = mysqli_query($con, "INSERT INTO notifics VALUES (default , 'emp', '$admin_loggedin', '$req_id', '$notifi_body', '$admin_body', '$date_added', 'no', 'no')");


        // insert note
        $update_db = mysqli_query($con, "UPDATE orders SET employ_details = '$added_note' WHERE id ='$p_id'");
        header("Location: index.php?projects&success");
    }

    // Add note handling
    $param = 'end_date'.$p_id;
    if(isset($_POST[$param])){
        $end_date = $_POST['endDate'];
        

                $notifi_body = "قام " .$logged_name ." بتحديث تاريخ نهاية مهمة لك في " .$end_date;
        $admin_body = "قام " .$logged_name ." بتحديث تاريخ نهاية مهمة " .$req_name ." في " .$end_date;

        // insert notifics
        $insert_noti = mysqli_query($con, "INSERT INTO notifics VALUES (default , 'emp', '$admin_loggedin', '$req_id', '$notifi_body', '$admin_body', '$date_added', 'no', 'no')");

        // insert note
        $update_db = mysqli_query($con, "UPDATE orders SET date_end = '$end_date' WHERE id ='$p_id'");
        header("Location: index.php?projects&success");
    }


    // Update section handling
    $parasec = 'update_sec'.$p_id;
    if(isset($_POST[$parasec])){
        $new_sec = $_POST['new_sec'];
        $get_section_name = mysqli_query($con, "SELECT * FROM section WHERE id = '$new_sec'");
        $sec_res = mysqli_fetch_array($get_section_name);
        $sec_name = $sec_res['name'];


         
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

                $notifi_body = "قام " .$logged_name ." بتغير قسم مهمة لك إلى " .$new_sec;
        $admin_body = "قام " .$logged_name ." بتغير قسم مهمة " .$req_name ." إلى " .$new_sec;

        // insert notifics
        $insert_noti = mysqli_query($con, "INSERT INTO notifics VALUES (default , 'emp', '$admin_loggedin', '$req_id', '$notifi_body', '$admin_body', '$date_added', 'no', 'no')");


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
        <form action="" enctype="multipart/form-data"  method="post">
        <div class="form-group">
            <textarea name="note" rows="5" class="form-control" placeholder="الملاحظة .."><?php echo $employ_details;?></textarea>
        </div>
         <div class="form-group">
            <label for="proj_type" class="float-right">أضف مرفق للرد </label>
            <input type="file" class="form-control" name="file[]" multiple>
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



        <!-- Notes Modal -->
    <div class="modal fade" id="show_detailreq<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">مراجعة الملاحظات</h5>
        </div>
        <div class="modal-body">
           <p class="lead" style="overflow-wrap: break-word;"><?php echo $req_details; ?></p>
           
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
        </div>
        </div>
    </div>
    </div>


        <!-- Add Note Modal -->
    <div class="modal fade" id="end_date<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">تاريخ انتهاء المهمة</h5>
        </div>
        <div class="modal-body">
        <form action="" method="post">
        <div class="form-group">
            <input type="date" name="endDate" rows="5" class="form-control" ></input>
            <P class="lead"><?php echo $end_date;?></P>
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
                        
                        ?>
                        <option value="<?php echo $s_row['id']; ?>"><?php echo $s_row['name']; ?></option>
                        <?php
                        
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
    





        <!-- Update client info Modal -->
    <div class="modal fade" id="edit_client<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">تعديل بيانات العميل</h5>
        </div>
        <div class="modal-body">
            <form action="" method="post">
            <div class="form-group">
                <input type="text" class="form-control" value="<?php echo $p_row['client_name']; ?>" name ="client_name" placeholder="إسم العميل .." required>
            </div>
            <div class="form-group">
                <input type="tel" class="form-control" value="<?php echo $p_row['phone']; ?>" name ="client_phone" placeholder="رقم الجوال .." required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" value="<?php echo $p_row['city']; ?>" name ="city" placeholder="المدينة .." required>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
            <button type="submit" class="btn btn-goo" name="update_client<?php echo $p_id ?>">تحديث</button>
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