

<section id="projs" style="padding-bottom: 30px;"><br>
<div class="container" style="width: 90%;">
<div id="scrolli">

    <label class="float-right">المهام المضافة :</label>
    
    <br><br>
    <div class="row indic">
        <div class="col text-center num"></div>
        <div class="col text-center">تاريخ المهمة</div>
        <div class="col text-center"> الخدمة المطلوبه</div>
        <div class="col-1 text-center">تفاصيل الطلب</div>
        <div class="col text-center">تاريخ الإنتهاء</div>
        <div class="col text-center">حالة المهمة</div>
        <div class="col text-center">الموظف المختص</div>
        <div class="col text-center">المرفقات</div>
        <div class="col text-center">رقم الموظف</div>
        <div class="col text-center">ملاحظات الموظف</div>
    
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
$pro_quer = mysqli_query($con, "SELECT * FROM orders WHERE requester_id = '$admin_loggedin'");
while($p_row = mysqli_fetch_array($pro_quer)){
    $p_id = $p_row['id'];
    $req_details = $p_row['req_details'];
    $employ_details = $p_row['employ_details'];
    $req_rate = $p_row['req_rate'];
    $emp_id = $p_row['employee_id'];
    $end_date = $p_row['date_end'];
    $status = $p_row['status_id'] ;
    
    
    
    
    $date = date("Y-m-d H:i:s");
        $date = date_create($date);
        $end_date = date_create($end_date);
        $date_diff = date_diff($date , $end_date);
        $date_rate = $date_diff->format("%a");
        if ($status == 2 && $date_rate > 2 && $req_rate == 2) {
                $update_db = mysqli_query($con, "UPDATE orders SET req_rate = '10' WHERE id ='$p_id'");
        }


     $get_emp = mysqli_query($con, "SELECT * FROM employees WHERE id = '$emp_id'");
        $mar_res = mysqli_fetch_array($get_emp);
        global $emp_name;
        $emp_name = $mar_res['name'];
        $date_added = date("Y-m-d H:i:s");

      $attachs_fetch = mysqli_query($con, "SELECT * FROM attachs WHERE order_id = '$p_id' AND is_emp = 'no'");
    // status
    $p_status = $p_row['status_id'];
    $fetch_stats = mysqli_query($con, "SELECT * FROM status WHERE id ='4' ");
    
    //section
    $fetch_sec = mysqli_query($con, "SELECT * FROM section");



    // Update requester details
    $para = 'req_details'.$p_id;
    if(isset($_POST[$para])){
        $new_details = $_POST['req_details'];
       
        // update database
        $update_db = mysqli_query($con, "UPDATE orders SET req_details = '$new_details' WHERE id ='$p_id'");

         $notifi_body = "قام " .$logged_name ." بإضافة تفاصيل لمهمة انت تعمل على إنجازها";
        $admin_body = "قام " .$logged_name ." بإضافة تفاصيل لمهمة   يعمل على انجازها " .$emp_name;

        // insert notifics
        $insert_noti = mysqli_query($con, "INSERT INTO notifics VALUES (default , 'req', '$admin_loggedin', '$emp_id', '$notifi_body', '$admin_body', '$date_added', 'no', 'no')");

        header("Location: index.php?projects&success");
    }


    // Add note handling
    $param = 'add_attach'.$p_id;
    if(isset($_POST[$param])){
          $attach_p_id = $p_id;
        // count files uploaded
        $countfiles = count($_FILES['file']['name']);
         $typeArr = explode("/", $file["type"]);
        // loop files
        for($i=0 ; $i < $countfiles ; $i++){
              $temp= explode('.', $_FILES['file']['name'][$i]); 

$extension = end($temp);
            $file_name = "file-".time().".".$extension;
            if (is_uploaded_file($_FILES['file']['tmp_name'][$i]) || file_exists($_FILES['file']['tmp_name'][$i])) {
                // upload file
                move_uploaded_file($_FILES['file']['tmp_name'][$i], '../attachments/'.$file_name);
                // insert in db
                $insert_attach = mysqli_query($con, "INSERT INTO attachs VALUES (default , '$attach_p_id', N'$file_name', 'no')");
        
            }
            
        }
        
         $notifi_body = "قام " .$logged_name ." بإضافة مفرفقات جديدة لمهمة انت تعمل على إنجازها";
        $admin_body = "قام " .$logged_name ." بإضافة مفرفقات جديدة لمهمة   يعمل على انجازها " .$emp_name;

        // insert notifics
        $insert_noti = mysqli_query($con, "INSERT INTO notifics VALUES (default , 'req', '$admin_loggedin', '$emp_id', '$notifi_body', '$admin_body', '$date_added', 'no', 'no')");

     
        header("Location: index.php?projects&success");
    }

    // Add rate handling
    $param = 'rateing'.$p_id;
    if(isset($_POST[$param])){
          $attach_p_id = $p_id;
        $new_rate = $_POST['rate'];
        $why_rate = $_POST['why'];
        // insert notifics
        $update_db = mysqli_query($con, "UPDATE orders SET req_rate = '$new_rate', why_rate = '$why_rate' WHERE id ='$p_id'");

     
        header("Location: index.php?projects");
    }
    
    
    
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




    
    ?>
    
    
        <!-- Add Note Modal -->
    <div class="modal fade" id="add_note<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">إضافة ملاحظة</h5>
        </div>
        <div class="modal-body">
        <form action="" method="post">
        <div class="form-group">
            <textarea name="note" rows="5" class="form-control" placeholder="الملاحظة .."></textarea>
        </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
            <button type="submit" class="btn btn-goo" name="add_note<?php echo $p_id ?>">إضافة</button>
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
                    <a style="float:left;" href="../work/download.php?id=<?php echo $attach_row['id']; ?>">
                        <img src="../work/imgs/icons/download.png" height="20">
                    </a>
                </div>
                </div>
      
                <?php
            } // end of while
            
            ?><form action="" enctype="multipart/form-data" method="post">
             <div class="form-group">
            <label for="proj_type" class="float-right">أضف مرفق جديد </label>
            <input type="file" class="form-control" name="file[]" multiple>
        </div>
        <button type="submit" class="btn btn-go col-md-12" name="add_attach<?php echo $p_id ?>">إضافة مرفق</button>
        </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
        </div>
        </div>
    </div>
    </div>

    <!-- ATTACHMENTS Modal -->
    <div class="modal fade" id="rate<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">أكمل الموظف المهمة بنجاح الرجاء تقييمه</h5>
        </div>
        <div class="modal-body">
         <form action="" enctype="multipart/form-data" method="post">
             <div class="text-center" dir="rtl">
                <div class="row">
                    
 <div class="col"><input class="inline whye" type="radio" name="rate" value="10" >ممتاز</div> 
            <div class="col"><input class="inline whyv" type="radio" name="rate" value="7.5"> جيد جدا </div>
            <div class="col"><input class="inline whyg" type="radio" name="rate" value="5" checked> جيد </div>
            <div class="col"><input class="inline why" type="radio" name="rate" value="2.5"> مقبول </div><br><br>
            <div class="col-md-12">
            <input class="d-none dis-none" type="text" name="why" placeholder="اكتب تفسير لتقيمك" id="why"  ></div>
            
            
        </div>
    </div><br>
        <button type="submit" class="btn btn-go col-md-12" name="rateing<?php echo $p_id ?>">تقيم الان</button>
        </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
        </div>
        </div>
    </div>
    </div>

    

        <!-- Notes Modal -->
    <div class="modal fade" id="show_detail<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">مراجعة الملاحظات</h5>
        </div>
        <div class="modal-body">
           <p class="lead"><?php echo $employ_details; ?></p><hr>
            <?php
      $attachs_fetch = mysqli_query($con, "SELECT * FROM attachs WHERE order_id = '$p_id' AND is_emp = 'yes'");
            while( $attach_row = mysqli_fetch_array($attachs_fetch)) {
                $namee = $attach_row['name'];

                $short_namee = substr($namee , 0, 20);
                ?>
                <div class="row attach py-1 mb-1">
                <div class="col text-right">
                    <?php echo $short_namee; ?>
                </div>
                <div class="col">
                    <a style="float:left;" href="../work/download.php?id=<?php echo $attach_row['id']; ?>">
                        <img src="../work/imgs/icons/download.png" height="20">
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


        <!-- Notes Modal -->
    <div class="modal fade" id="show_detail_req<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> مراجعة تفاصيل طلبك</h5>
        </div>
        <div class="modal-body">
            <form action="" method="post">
            <textarea name="req_details" rows="5" class="form-control" placeholder="الملاحظة .."><?php echo $req_details; ?></textarea>
            <button type="submit" class="btn btn-goo col-md-12" name="req_details<?php echo $p_id ?>">تعديل تفاصيل الطلب</button>
            </form>
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
 
             $(".why,.whyg").click(function(){
        $(".dis-none").removeClass("d-none").attr('required', 'true' ) ;
    });
    $(".whyv,.whye").click(function(){
        $(".dis-none").addClass("d-none").removeAttr("rquired");
    });
    
    
 var limit = 28;
 var start = 0;
 var action = 'inactive';
 function load_country_data(limit, start)
 { 
  $.ajax({
   url:"des/fetch.php",
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