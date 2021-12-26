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
    <div id="">
        <!------  here is where the projects are fetched   -->
        <?php

            $query = "SELECT * FROM orders WHERE status_id = '2' AND type_id = '$admin_id_sec' ORDER BY id DESC ";

                $messages_query = mysqli_query($con, $query);
    $count = 1;

        while($row = mysqli_fetch_array($messages_query))
    {
        $id = $row['id'];
        $employ_details = $row['employ_details'];
        $req_details = $row['req_details'];
        $fnish_date = $row['date_end'];
        $rate = $row['req_rate'];
        $fnish_date = substr($fnish_date , 0,10); // to get the date only without time
        $pro_date = $row['date_added'];
        $pro_date = substr($pro_date , 0,10); // to get the date only without time

        $requester_id = $row['requester_id'];
        $employee_id = $row['employee_id'];
        $mission_id = $row['mission_id'];
        $section_id = $row['type_id'];
        $status_id = $row['status_id'];
        $mange_cerv = $row['mange_cerv'];

        $get_attach = mysqli_query($con, "SELECT * FROM attachs WHERE order_id = '$id'");
        $attach_res = mysqli_fetch_array($get_attach);
        $attach_name = $attach_res['name'];

        $get_mar = mysqli_query($con, "SELECT * FROM requester WHERE id = '$requester_id'");
        $mar_res = mysqli_fetch_array($get_mar);
        $req_name = $mar_res['name'];

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
        
        if($rate > 2 && $status_id == 2) {
$status = ' <a class="btn " data-toggle="modal" >'.$status_button.'<img src="../work/imgs/icons/double-check.png" class="float-left" height="20">
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
        <div class="col text-center">'.$mange_cerv.'</div>
        <div class="col text-center">'.$miss_name.'</div>
        <div class="col text-center">'.$sec_name.'</div>
        <div class="col-1 text-center" style="overflow: hidden;"><a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#show_detailreq'.$id.'">'.$req_details.'</a></div>
        <div class="col text-center">'.$status.'</div>
  
        <div class="col-1 text-center">
            '.$fnish_date.'
        </div>
        <div class="col text-center">'.$empl_name.'</div>
        <div class="col text-center"><a class="btn btn-success" href="" data-toggle="modal" data-target="#view_attach'.$id.'">مُراجعة المُرفقات</a></div>
        <div class="col text-center" style="overflow: hidden;"><a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#show_detail'.$id.'">'.$employ_details.'</a></div>
        <div class="col-1">
        
            <button id="delet'.$id.'" class="btn btn-danger col-md-12 py-0 mr-1">حذف</button>
        
        </div>
        
    </div>



    <script>
        $(document).ready(function(){

            $("#delet'.$id.'").on("click", function(){
                
                bootbox.confirm("Are you sure you want to delete this Project perminantly ?", function(result){

                    if(result == true){
                    
                        $.post("../admin/handlers/delete_proj.php?port_id='.$id.'", {result:result});
                        location.reload();
                        
                        
                    }
                });

            });


        }); // end of all document.ready
    </script>
      ';
  
    
        $count++;
    } //end of while

    ?>
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