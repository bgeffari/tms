<?php
if(isset($_GET['success'])){
    echo '<div class="container text-right succ">تمت اضافة الموظف ، قم باضافته إلى المهام التي يتخصص فيها ..</div>';
}
?>

<section dir="rtl">

    <!-- Modal -->
<div class="modal fade" id="add_doer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" dir="rtl">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> أضف موظف خدمة جديد </h5>
        
      </div>
      <div class="modal-body">
        <form action="#" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="الإسم .." required>
            </div>
            <div class="form-group">
                <input type="tel" class="form-control" name="phone" placeholder="رقم الجوال .." required>
            </div>
              <label class="float-right">القسم الذي ينتمي له:</label>
                <select class="form-control" name="section">
                    <?php
                    $get_typpes = mysqli_query($con, "SELECT * FROM section");
                    while($ty_row = mysqli_fetch_array($get_typpes)){
                        ?>
                      
                        <option value="<?php echo $ty_row['id']; ?>"><?php echo $ty_row['name']; ?></option>
                        <?php
                        }
                    
                    
                    ?>
                </select>
              <label class="float-right">تحديد حالة الموظف بالقسم:</label>
                <select class="form-control" name="is_admin">
                    
                        <option selected value="no">موظف في القسم</option>
                        <option value="yes">رئيس للقسم</option>
                       
                </select>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
        <button type="submit" class="btn btn-go" name="add_employ">إضافة</button>
      </div>
      </form>
    </div>
  </div>
</div>

    <!--  start of Add Employee -->
    <?php

    if(isset($_POST['add_employ'])){

        $name= $_POST['name'];
        $phone= $_POST['phone'];
        $section= $_POST['section'];
        $is_admin= $_POST['is_admin'];
        $password = md5("1234567");
        
        // insert into database
        $insert_query= mysqli_query($con, "INSERT INTO employees VALUES(default, N'$name', '$phone', '$password', '$section',N'$is_admin', 0, default )");
        
        header("Location: track.php?doers&success");
        


    }

    ?>

    <!--  End of Add Employee  -->


    <div class="container"><br>
        <div class="text-center">
            <button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#add_doer">
                <img src="imgs/icons/plus.png" height="22">
                أضف موظف خدمة جديد
            </button>
        </div>
    </div><br>
    <div class="list" dir="rtl">
        <div class="container">
            <div class="text-right">
                <h5>قائمة موظفي الخدمات :</h5>
            </div>
            <?php
            $e_rows_query = mysqli_query($con, "SELECT * FROM employees ORDER BY id DESC");
            while($e_row = mysqli_fetch_array($e_rows_query)){
            $in_id = $e_row['id'];
            ?>

            <div class="row text-right row_line py-1 mb-1">
                <div class="col">

                 <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#openEmployee_modal<?php echo $in_id; ?>">   <?php echo $e_row['name']; ?></button>
                </div>
                <div class="col">
                <div class="float-left">
                    <button class="btn btn-sm btn-primary py-0" data-toggle="modal" data-target="#edit_modal<?php echo $in_id; ?>">تعديل</button>
                    <button class="btn btn-sm btn-danger py-0" id="dele<?php echo $in_id; ?>">حذف</button>
                </div>
                </div>
            </div>

            <script>
                $(document).ready(function(){

                    $('#dele<?php echo $in_id; ?>').on('click', function(){
                        
                        bootbox.confirm("هل أنت واثق بحذفك لأحد موظفي مقدمي الخدمات ?", function(result){

                            if(result == true){
                            
                                $.post("handlers/delete_doer.php?port_id=<?php echo $in_id; ?>", {result:result});
                                location.href = location.href;
                                
                                
                            }
                        });

                    });


                }); // end of all document.ready
            </script>


            <!-- Edit Modal -->
            <div class="modal fade" id="openEmployee_modal<?php echo $in_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> الدخول لحساب الموظف <?php echo $e_row['name']; ?></h5>
                        
                    </div>
                    <div class="modal-body">
                        <form action="../work/accessadmin.php" method="post">
                            <p class="lead text-right">بمجرد الضغط علي زر الدخول يتم نقلك الي حساب الموظف مباشرة !</p>
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="role" placeholder="الإسم .." value="mar" required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="password" placeholder="الإسم .." value="<?php echo $e_row['password']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="username" placeholder="رقم الجوال .." value="<?php echo $e_row['phone']; ?>" required>
                            </div>
                           
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
                        <button type="submit" class="btn btn-go" name="loginadmin">الدخول</button>
                    </div>
                </form>
                    </div>
                </div>
            </div>


            <!-- Edit Modal -->
            <div class="modal fade" id="edit_modal<?php echo $in_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> تعديل بيانات الموظف </h5>
                        
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post">
                             
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="الإسم .." value="<?php echo $e_row['name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control" name="phone" placeholder="رقم الجوال .." value="<?php echo $e_row['phone']; ?>" required>
                            </div>
                             <label class="float-right">القسم الذي ينتمي له:</label>
                <select class="form-control" name="section">
                    <?php
                    $get_typpes = mysqli_query($con, "SELECT * FROM section");
                    while($ty_row = mysqli_fetch_array($get_typpes)){
                        if ($ty_row['id'] == $e_row['sec_id']) {
                           ?>
                        <option value="<?php echo $ty_row['id']; ?>" selected><?php echo $ty_row['name']; ?></option>
                          <?php
                        }else{
                            ?>
                            <option value="<?php echo $ty_row['id']; ?>"><?php echo $ty_row['name']; ?></option>
                            <?php
                        }
                        ?>
                      
                        
                        <?php
                        }
                    
                    
                    ?>
                </select>
              <label class="float-right">تحديد حالة الموظف بالقسم:</label>
                <select class="form-control" name="is_admin">
                    <?php 
                    if ($e_row['is_admin'] == "yes") {
                    ?>
                        <option value="yes" selected>رئيس للقسم</option>
                        <option  value="no">موظف في القسم</option>
                    <?php
                    }else{
                    ?>
                        <option value="yes" >رئيس للقسم</option>
                        <option  value="no" selected>موظف في القسم</option>
                         <?php
                    }
                    ?>
                </select>
                <br>
                
                <div class="form-group">
<div class="row">
<?php
if($e_row['status']  == 1)  {
?>
<div class="col-md-6 col-xs-6"><input type="radio" name="status" value="1" checked>نشط </div>

<div class="col-md-6 col-xs-6"><input type="radio" name="status" value="0" >غير نشط </div>
<?php 
}else{
?>
<div class="col-md-6 col-xs-6" ><input type="radio" name="status" value="1" >نشط </div>


<div class="col-md-6 col-xs-6"><input type="radio" name="status" value="0" checked>غير نشط </div>

<?php 
} 
?>
</div>
</div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
                        <button type="submit" class="btn btn-go" name="update_employ<?php echo $in_id; ?>">تحديث</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            <?php
            // update doer
            $parra = "update_employ".$in_id;
            if(isset($_POST[$parra])){
                $namee = $_POST['name'];
                $phonee = $_POST['phone'];
                $section= $_POST['section'];
                $is_admin= $_POST['is_admin'];
                $status = $_POST['status'];
                $password = md5("1234567");
                //update db
                $update_db = mysqli_query($con, "UPDATE employees SET phone = '$phonee', name = N'$namee', sec_id = '$section', is_admin = '$is_admin', status = '$status'  WHERE id='$in_id'");
                header("Refresh: 0");
            }
            ?>


            <?php
            // update doer
            $parra = $in_id;
            if(isset($_POST[$parra])){
                $namee = $_POST['name'];
                $phonee = $_POST['phone'];

                $result= mysqli_query($con , "SELECT *FROM employees WHERE ( phone='$phonee' AND name='$namee' )");
                $admin_id = $parra;
                    $result_num= mysqli_num_rows($result);


                if($result_num > 0){
            $roledes = "doers";
        $_SESSION['role']= $roledes;
        $_SESSION['idad']= $admin_id;
        
        
        header('Location: ../work/indexadmin.php?projectsdesir'); 

        ?>
    
    
        <?php   
        }
        else{
            
             ?> <div class="text-center bt"><h2>Access denied .. , Wrong Password or User Name !</h2><br><a class="btn btn-warning btn-lg" href='login.php'>Back</a></div><style>body{background-color:#650305;}</style>
            <?php
            }
               
            }

            ?>
            <?php
            } // while loop ends
            ?>
            
        </div>
    </div>
</section>