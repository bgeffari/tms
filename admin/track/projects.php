<div class="text-center" style="max-width:90%" >
    <form action="#" enctype="multipart/form-data" method="post">

        <div class="form-group "style="margin-top: 30px;padding: 10p;">
            <button type="submit" class="btn btn-go" name="search_pro">بحث</button>
            <input type="text" class="" id="" name="search" style="padding: 5px;border: solid 0.8px #cdb30c;border-radius: 5px;">
        </div>
    </form>
</div>
<?php
if (isset($_POST['search_pro'])) {
?>
<section dir="rtl" id="projs" class="pro_sea"><br>
<div class="container" style="max-width: 90%;">
<div id="scrolli">

    <label class="float-right">المهام المضافة :</label>
   
    <br><br>
    <button type="button"  value="close" class="btn btn-info float-right" id="close_sea">close search</button>
    <br><br>
    <div class="row indic">
        <div class="col text-center num"></div>
        <div class="col text-center">تاريخ المهمة</div>
        <div class="col text-center">طالب الخدمة</div>
        <div class="col text-center">رقم طالب الخدمة</div>
        <div class="col text-center">الإدارة طالبة الخدمة</div>
        <div class="col text-center">رقم التحويلة</div>
        <div class="col text-center"> الخدمة المطلوبه</div>
        <div class="col text-center"> أولوية الخدمة</div>
        <div class="col text-center"> القسم</div>
        <div class="col-1 text-center">تفاصيل الطلب</div>
        <div class="col text-center">حالة المهمة</div>
        <div class="col-1 text-center">تاريخ الإنتهاء</div>
        <div class="col text-center">الموظف المختص</div>
        <div class="col text-center">المرفقات</div>
        <div class="col text-center">ملاحظات الموظف</div>
       


        <div class="col-1 text-center"><img src="../work/imgs/icons/setting.png" height="17"></div>
    </div>
    
    <!-- Projects rows -->
    <div id="#">
        <!------  here is where the projects are fetched   -->
        <?php
        $search= mysqli_real_escape_string($con, $_POST['search']); // name returns id

    $query = "SELECT * FROM orders WHERE phone LIKE N'%$search%' OR req_name LIKE N'%$search%' OR req_phone LIKE '$search' ";
    
    $messages_query = mysqli_query($con, $query);
    $search_num= mysqli_num_rows($messages_query);
    $i= 0;
    $count = $i+1;
    if ($search_num >0) {
    
    
    while($row = mysqli_fetch_array($messages_query))
    {
        $id = $row['id'];
        $employ_details = $row['employ_details'];
        $req_details = $row['req_details'];
        $fnish_date = $row['date_end'];
        $prior = $row['prior'];
        $fnish_date = substr($fnish_date , 0,10); // to get the date only without time
        $pro_date = $row['date_added'];
        $pro_date = substr($pro_date , 0,10); // to get the date only without time

        $requester_id = $row['requester_id'];
        $employee_id = $row['employee_id'];
        $mission_id = $row['mission_id'];
        $section_id = $row['type_id'];
        $status_id = $row['status_id'];
        $mange_cerv = $row['mange_cerv'];
        $phone = $row['phone'];

        $get_attach = mysqli_query($con, "SELECT * FROM attachs WHERE order_id = '$id'");
        $attach_res = mysqli_fetch_array($get_attach);
        $attach_name = $attach_res['name'];

        $get_mar = mysqli_query($con, "SELECT * FROM requester WHERE id = '$requester_id'");
        $mar_res = mysqli_fetch_array($get_mar);
        $req_name = $mar_res['name'];
        $req_phone = $mar_res['phone'];

        $get_des = mysqli_query($con, "SELECT * FROM employees WHERE id = '$employee_id'");
        $des_res = mysqli_fetch_array($get_des);
        $empl_name = $des_res['name'];

        $get_type = mysqli_query($con, "SELECT * FROM missions WHERE id = '$mission_id'");
        $typ_res = mysqli_fetch_array($get_type);
        $miss_name = $typ_res['name'];

         $get_sec = mysqli_query($con, "SELECT * FROM section WHERE id = '$section_id'");
        $typ_res = mysqli_fetch_array($get_sec);
        $sec_name = $typ_res['name'];

        $get_status = mysqli_query($con, "SELECT * FROM status WHERE id = '$status_id'");
        $status_res = mysqli_fetch_array($get_status);
        $status_button = $status_res['name'];
         if ($employ_details != "") {
            
        }else{
            $employ_details = "لا توجد ملاحظة";
        }
        
      echo '
      <div class="row prroj py-2">
        <div class="col text-center num">'.$count.'</div>
        <div class="col text-center">'.$pro_date.'</div>
        
        <div class="col text-center">'.$req_name.'</div>
        <div class="col text-center">'.$req_phone.'</div>
        <div class="col text-center">'.$mange_cerv.'</div>
        <div class="col text-center">'.$phone.'</div>
        <div class="col text-center">'.$miss_name.'</div>
        <div class="col text-center">'.$prior.'</div>
        <div class="col text-center">'.$sec_name.'</div>
        <div class="col-1 text-center" style="overflow: hidden;"><a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#show_detailreq'.$id.'">'.$req_details.'</a></div>
        <div class="col text-center">'.$status_button.'</div>
  
        <div class="col-1 text-center">
            '.$fnish_date.'
        </div>
        <div class="col text-center">'.$empl_name.'</div>
        <div class="col text-center"><a class="btn btn-success" href="" data-toggle="modal" data-target="#view_attach'.$id.'">مُراجعة المُرفقات</a></div>
        <div class="col text-center" style="overflow: hidden;"><a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#show_detail'.$id.'">'.$employ_details.'</a></div>
        <div class="col-1">
        
            <button id="delet'.$id.'" class="btn btn-danger float-left py-0 mr-1">حذف</button>
            <a href="track.php?edit_proj='.$id.'" class="btn btn-go py-0">تعديل</a>
        
        </div>
        
    </div>



    <script>
        $(document).ready(function(){

            $("#delet'.$id.'").on("click", function(){
                
                bootbox.confirm("Are you sure you want to delete this Project perminantly ?", function(result){

                    if(result == true){
                    
                        $.post("handlers/delete_proj.php?port_id='.$id.'", {result:result});
                        location.reload();
                        
                        
                    }
                });

            });


        }); // end of all document.ready
    </script>
      ';
  
    
        $count++;
    } //end of while
}else{
?>
<h1 class="text-right lead">لا توجد نتيجة للبحث عن : " <?php echo $search; ?> "</h1>
<?php
}
        ?>
    </div>
    <br><br>
</div>
</div>
</section>
<?php
}
?>

<section dir="rtl" id="projs" class="desig"><br>
<div class="container" style="max-width: 90%;">
<div id="scrolli">

    <label class="float-right">المهام المضافة :</label>
    <div class="float-left">

        <form action="excel.php" method="post">
            <button type="submit" id="btnExport" name="export" value="Export to Excel" class="btn btn-info">
                excel
            </button>
        </form>
    </div>
  
    <br><br>
    <br><br>
    <div class="row indic">
        <div class="col text-center num"></div>
        <div class="col text-center">تاريخ المهمة</div>
        <div class="col text-center">طالب الخدمة</div>
        <div class="col text-center">رقم طالب الخدمة</div>
        <div class="col text-center">الإدارة طالبة الخدمة</div>
        <div class="col text-center">رقم التحويلة</div>
        <div class="col text-center"> الخدمة المطلوبه</div>
        <div class="col text-center"> أولوية الخدمة</div>
        <div class="col text-center"> القسم</div>
        <div class="col-1 text-center">تفاصيل الطلب</div>
        <div class="col text-center">حالة المهمة</div>
        <div class="col-1 text-center">تاريخ الإنتهاء</div>
        <div class="col text-center">الموظف المختص</div>
        <div class="col text-center">المرفقات</div>
        <div class="col text-center">ملاحظات الموظف</div>
       


        <div class="col-1 text-center"><img src="../work/imgs/icons/setting.png" height="17"></div>
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
$pro_quer = mysqli_query($con, "SELECT * FROM orders");
while($p_row = mysqli_fetch_array($pro_quer)){
    $p_id = $p_row['id'];
    $employ_details = $p_row['employ_details'];
    $req_details = $p_row['req_details'];
      $attachs_fetch = mysqli_query($con, "SELECT * FROM attachs WHERE order_id = '$p_id' AND is_emp = 'no'");


    ?>
    
    
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
            
            ?>
            
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



        <!-- Update Status Modal -->
    <div class="modal fade" id="update_status<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" >
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
    

        <!-- Update Status Modal -->
    <div class="modal fade" id="update_sec<?php echo $p_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">الانتقال الى التنفيذ المداني</h5>
        </div>
        <div class="modal-body">
            <form action="" method="post">
            <div class="form-group">
                <select name="new_sec" class="form-control">
                        <option value="11">التنفيذ الميداني</option>
                </select>
            </div>            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
            <button type="submit" class="btn btn-goo" name="update_sec<?php echo $p_id ?>">تحديث</button>
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
   url:"track/fetch.php",
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