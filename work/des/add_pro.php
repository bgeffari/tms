<?php
  $req_query = mysqli_query($con, "SELECT * FROM requester WHERE id = '$admin_loggedin' ");
  $req_row =mysqli_fetch_array($req_query);
  $req_phone = $req_row['phone'];

?>
<section><br>
<div class="container">
<div class="form_wrapper">

    <form action="" enctype="multipart/form-data" method="post">
        <label class="float-right" >حدد طلبك ..</label><br>
       <div class="form-group">
            <select name="section" class="form-control" id="sections" class="sections" required>
                <option disabled selected value >أختار القسم ..</option>
                <?php
                $get_p_types = mysqli_query($con, "SELECT * FROM section WHERE mission != '' ");
                while($p_row = mysqli_fetch_array($get_p_types)){
                    $p_type_n = $p_row['name'];
                    global $p_type_id;
                    $p_type_id = $p_row['id'];




                ?>
                <option value="<?php echo $p_type_id; ?>" ><?php echo $p_type_n; ?></option>
                <?php
               }

                ?>

            </select>
        </div>
       <div class="form-group">
            <select name="miss_type" class="form-control" id="miss_type" class="miss_type" required>
                <option disabled selected value>أختار المهمة ..</option>
                     
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="mangeCerv" placeholder="الاإدارة طالبة الخدمة .."  required>
        </div>
        <div class="form-group">
            <input type="tel" class="form-control" name="client_phone" placeholder="رقم التحويله .." required>
        </div>
        
         <div class="form-group text-right ">
             <lable>رقم الجوال</lable>
            <input type="tel" class="form-control" name="req_phone" placeholder="رقم الجوال .." 
            value="<?php echo $req_phone ;?>"
            required>
        </div>
        <hr class="separator">
    
  
        
        <div class="form-group text-right">
            <textarea name="notes" col="90" class="form-control" placeholder="الوصف .."></textarea>
            <label>أولوية الطلب</label><br>
            <input type="radio" name="sep" value="عالية" > عالية
            <input type="radio" name="sep" value="متوسطة" checked> متوسطة
            <input type="radio" name="sep" value="عادية"> عادية
        </div>
      <div class="row">
        <div class="col-md-12">
                    <label for="proj_type" class="float-right">المرفقات</label>
        </div>
        <div class="form-group col-md-6">
            <input type="file" class="form-control" name="file[]" multiple>
        </div>
      
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-go" name="add_order">تأكيد</button>
        </div>
    </form>
</div>
</div>
</section>
 
<?php
if(isset($_POST['add_order'])){
    $mangeCerv = $_POST['mangeCerv'];
    $miss_type = $_POST['miss_type'];
    $notes = $_POST['notes'];
    $client_phone = $_POST['client_phone'];
    $r_phone = $_POST['req_phone'];
    $section = $_POST['section'];
    $sep = $_POST['sep'];
    $date_added = date("Y-m-d H:i:s");

    
    des:
 $possible_des = mysqli_query($con, "SELECT * FROM missions WHERE id = '$miss_type'");
    $des_arr = mysqli_fetch_array($possible_des);
    $count_des = $des_arr['count'];
    $designer = $des_arr['employees'];
    $designers = explode("," ,$designer);
        $count_arr = count($designers);
if ($count_des == 0) {
    $count_des = $count_arr - 1;

$id_des = $count_des;
    $designer = $designers[$id_des];

                $new_count = $count_des -1;
        $update_count = mysqli_query($con, "UPDATE missions SET count = '$new_count' WHERE id = '$miss_type'");

}else{
    $id_des = $count_des;
    $designer = $designers[$id_des];

                $new_count = $count_des - 1;
        $update_count = mysqli_query($con, "UPDATE missions SET count = '$new_count' WHERE id = '$miss_type'");

}

    $requester = $admin_loggedin;

 // get employee name for notification purpose
    $get_des_name = mysqli_query($con, "SELECT * FROM employees WHERE id = '$designer'");
    $fetch_des = mysqli_fetch_array($get_des_name);
    $des_name = $fetch_des['name'];
    $des_status = $fetch_des['status'];
    if($des_status == 1) {

            $notifi_body = "قام " .$logged_name ." بإضافة مهمة جديد لك .";

    $admin_body = "قام " .$logged_name ." بإضافة مهمة ليقوم بتنفيذها " .$des_name ." .";
    
 // insert notification
    $insert_noti = mysqli_query($con, "INSERT INTO notifics VALUES (default , 'req', '$admin_loggedin', '$designer', '$notifi_body', '$admin_body', '$date_added', 'no', 'no')");
    

    // get designer name for notification purpose
    $get_req_name = mysqli_query($con, "SELECT * FROM requester WHERE id = '$requester'");
    $fetch_req = mysqli_fetch_array($get_req_name);
    $req_name = $fetch_req['name'];
    $req_phone = $fetch_req['phone'];
    $get_des_name = mysqli_query($con, "SELECT * FROM employees WHERE id = '$designer'");
    $fetch_des = mysqli_fetch_array($get_des_name);
    $des_name = $fetch_des['name'];
    $desinger_phone = $fetch_des['phone'];
    $get_date_name = mysqli_query($con, "SELECT * FROM missions WHERE id = '$miss_type'");
    $fetch_date = mysqli_fetch_array($get_date_name);
    $da = $fetch_date['end_date'];
    $end_date = date("Y-m-d H:i:s",strtotime($date_added .' + '.$da.' days'));
    // insert project query************
    $insert_proj = mysqli_query($con, "INSERT INTO orders VALUES (default , '$requester', '$designer', '$date_added', '$section', '1', '$end_date', N'$notes', '', '$miss_type',N'$mangeCerv', '$client_phone' , '0' , '$req_name' , '$r_phone' , '$sep', default, default )");

}else{
goto des;
} 
    // files stuff
    if(isset($_FILES['file']['name'])){

        // get id
        $get_last_id = mysqli_query($con, "SELECT id FROM orders ORDER BY id DESC LIMIT 1;");
        $last_res = mysqli_fetch_array($get_last_id);
        $last_id = $last_res['id'];

        $attach_p_id = $last_id;
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
                $insert_attach = mysqli_query($con, "INSERT INTO attachs VALUES (default , '$attach_p_id', N'$file_name', 'no')");
        
            }
            
        }
        
        
    }
    
    
    // files end here
    



    header("Location: index.php?projects&success");
}

?>
<script>

$(document).ready(function(){

 var action = 'inactive';

 $("#sections").change(function(){
 $.ajax({
   url:"des/getlist.php",
   method:"POST",
   data:{val:$(this).val()},
   cache:false,
   success:function(data)
   {
    $('#miss_type').html(data);
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
 });
});
</script>