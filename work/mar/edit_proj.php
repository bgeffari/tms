<?php

if(isset($_GET['success'])){
    echo '<div class="container text-right succ">تمت إضافة الملاحظة</div>';
}
if(isset($_GET['succ'])){
    echo '<div class="container text-right succ">تم تحديث المشروع</div>';
}
if(isset($_GET['edit_proj'])){
    $project_id = $_GET['edit_proj'];

}

$prro_query = mysqli_query($con, "SELECT * FROM orders WHERE id = '$project_id'");
$row = mysqli_fetch_array($prro_query);
    $date_added = date("Y-m-d H:i:s");
$employ_details = $row['employ_details'];
        $req_details = $row['req_details'];
        $fnish_date = $row['date_end'];
        $fnish_date = substr($fnish_date , 0,10); // to get the date only without time
        $pro_date = $row['date_added'];
        $pro_date = substr($pro_date , 0,10); // to get the date only without time

        $requester_id = $row['requester_id'];
        $employee_id = $row['employee_id'];
        $mission_id = $row['mission_id'];
        $section_id = $row['type_id'];
        $status_id = $row['status_id'];

        $get_attach = mysqli_query($con, "SELECT * FROM attachs WHERE order_id = '$project_id'");
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
         if ($employ_details != "" || $req_details != "") {
            
        }else{
            $employ_details = "لا توجد ملاحظة";
            $req_details = "لا توجد ملاحظة";
        }
        

// update project handling
if(isset($_POST['update_proj'])){
    $miss_type = $_POST['pro_type'];
    $employee = $_POST['designer'];
    $p_stat = $_POST['pro_status'];
    $sec_type = $_POST['section'];
    // update pro query
        $update_db = mysqli_query($con, "UPDATE orders SET status_id = '$p_stat', mission_id = '$miss_type', employee_id = '$employee', type_id = '$sec_type' WHERE id ='$project_id'");


    $noti_bi = "قام رئيس القسم بتحديث أحد مهامك .";
    $noti_adm = "قام رئيس قسم ".$sec_name."  بتحديث مهمة يعمل على انجازها ".$empl_name.".";

    // insert noti
    $in_noti = mysqli_query($con, "INSERT INTO notifics VALUES (default , 'adm', '$admin_loggedin', '$employee', '$noti_bi' ,'$noti_adm' ,'$date_added', 'no', 'no')");

    header("Location: index.php?edit_proj=$project_id&succ");

}




?>
<section dir="rtl" id="pro_edit"><br>
<div class="container">
<div class="form_wrapper">
    <form action="" method="post">
        <div class="row">
            <div class="col-md-6">
                <label class="float-right">أضافه :</label>
                <input type="text" class="form-control" value="<?php echo $req_name; ?>" readonly>
            </div>
            <div class="col-md-6">
                <label class="float-right">بتاريخ :</label>
                <input type="text" class="form-control" value="<?php echo $pro_date; ?>" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="float-right">الموظف المختص :</label>
                <select class="form-control" name="designer">
                    <?php
                    $get_designerrs = mysqli_query($con, "SELECT * FROM missions WHERE id = '$mission_id'");
                    $des_arr = mysqli_fetch_array($get_designerrs);
                    $designer = $des_arr['employees'];
                    $designers = explode("," ,$designer);
                    
                        foreach($designers as $dess){
                    $get_designerrs_id = mysqli_query($con, "SELECT * FROM employees WHERE id = N'$dess'");
                    $des_name = mysqli_fetch_array($get_designerrs_id);
                    $designer_name = $des_name['name'];
                    if (is_null($designer_name)) {
                        # cod
                    }else{

                      if($dess == $employee_id){
                        ?>
                        <option selected value="<?php echo $dess; ?>"><?php echo $designer_name; ?></option>
                        <?php
                        }else{
                        ?>
                        <option value="<?php echo $dess; ?>"><?php echo  $designer_name; ?></option>
                        <?php
                        }
                    }
                        }
                    
                    ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="float-right">المهمة :</label>
                <select class="form-control" name="pro_type">
                    <?php
                    $get_typpes = mysqli_query($con, "SELECT * FROM missions");
                    while($ty_row = mysqli_fetch_array($get_typpes)){
                        if($ty_row['id'] == $mission_id){
                        ?>
                        <option selected value="<?php echo $ty_row['id']; ?>"><?php echo $ty_row['name']; ?></option>
                        <?php
                        }else{
                        ?>
                        <option value="<?php echo $ty_row['id']; ?>"><?php echo $ty_row['name']; ?></option>
                        <?php
                        }
                    }
                    
                    ?>
                </select>
            </div>
         
        </div>
     
        <div class="row">
            <div class="col-md-6">
                <label class="float-right">القسم :</label>
                <select class="form-control" name="section">
                    <?php
                    $get_typpes = mysqli_query($con, "SELECT * FROM section");
                    while($ty_row = mysqli_fetch_array($get_typpes)){
                        if($ty_row['id'] == $section_id){
                        ?>
                        <option selected value="<?php echo $ty_row['id']; ?>"><?php echo $ty_row['name']; ?></option>
                        <?php
                        }else{
                        ?>
                        <option value="<?php echo $ty_row['id']; ?>"><?php echo $ty_row['name']; ?></option>
                        <?php
                        }
                    }
                    
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="float-right">حالة المهمة  :</label>
                <select class="form-control" name="pro_status">
                    <?php
                    $get_statss = mysqli_query($con, "SELECT * FROM status");
                    while($sts_row = mysqli_fetch_array($get_statss)){
                        if($sts_row['id'] == $status_id){
                        ?>
                        <option selected value="<?php echo $sts_row['id']; ?>"><?php echo $sts_row['name']; ?></option>
                        <?php
                        }else{
                        ?>
                        <option value="<?php echo $sts_row['id']; ?>"><?php echo $sts_row['name']; ?></option>
                        <?php
                        }
                    }
                    
                    ?>
                </select>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6">
                <label class="float-right">ملاحظة طالب الخدمة :</label>
                <textarea  class="form-control" readonly><?php echo $req_details; ?> </textarea>
            </div>
            <div class="col-md-6">
                <label class="float-right">ملاحظة الموظف المختص :</label>
                <textarea  class="form-control" readonly><?php echo $employ_details; ?> </textarea>
            </div>
        </div>



        <div class="text-center"><br>
            <button class="btn btn-go" type="submit" name="update_proj">تحديث</button>
        </div>

    </form><br>
  
    <br><br>
</div>
</div>
</section>
