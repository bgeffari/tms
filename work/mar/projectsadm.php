<?php
       $admin_sec = $_SESSION['sec_id'];

?>

<section dir="rtl" id="projs" class="desig"><br>
<div class="container" style="max-width: 90%;">
<div id="scrolli">

    <label class="float-right">المهام المضافة في قسمك:</label>
    
    <br><br>
    <div class="row indic">
        <div class="col text-center num"></div>
        <div class="col text-center">تاريخ المهمة</div>
        <div class="col text-center">طالب الخدمة</div>
        <div class="col text-center">الإدارة طالبة الخدمة</div>
        <div class="col text-center"> الخدمة المطلوبه</div>
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



    
    
    
    <?php
}// end of while
?>


<script>

$(document).ready(function(){
  

 var limit = 25;
 var start = 0;
 var action = 'inactive';
 function load_country_data(limit, start)
 {
  $.ajax({
   url:"mar/fetchadm.php",
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