 <?php

        if(isset($_GET['success'])){
        $success= "تم إضافة طالب الخدمة بنجاخ ..";
        echo "<div class='container text-right'><div class='succ' style='padding-right:8px;'> <p dir='rtl'>" .$success ."</p></div></div>";
    }




            $rows_query = mysqli_query($con, "SELECT * FROM requester ORDER BY id DESC");
            while($m_row = mysqli_fetch_array($rows_query)){
            $inn_id = $m_row['id'];
                        $orders = mysqli_query($con, "SELECT * FROM orders WHERE requester_id  = '$inn_id'");
            $num_projs = mysqli_num_rows($orders);
            global $num_projs_t;
            $num_projs_t +=$num_projs;
        }
            ?>
<section dir="rtl">

    <!-- Modal -->
<div class="modal fade" id="add_requester" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" dir="rtl">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> أضف طالب خدمة جديد </h5>
        
      </div>
      <div class="modal-body">
        <form action="#" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="الإسم .." required>
            </div>
            <div class="form-group">
                <input type="tel" class="form-control" name="phone" placeholder="رقم الجوال .." required>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
        <button type="submit" class="btn btn-go" name="add_requester">إضافة</button>
      </div>
      </form>
    </div>
  </div>
</div>

    <?php

    if(isset($_POST['add_requester'])){

        $name= $_POST['name'];
        $phone= $_POST['phone'];
        $password = md5("1234567");
        
        // insert into database
        $insert_query= mysqli_query($con, "INSERT INTO requester VALUES(default , N'$name', '$phone', '$password')");
        
        header("Location: track.php?manges&success");
        


    }

    ?>

    <!-------  End of Add requester -->


    <div class="container"><br>
        <div class="text-center">
            <button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#add_requester">
                <img src="imgs/icons/plus.png" height="22">
                إضافة طالب خدمة جديد
            </button>
        </div>
    </div><br>
    
    <div class="list" dir="rtl">
        <div class="container">
            <div class="text-right">
                <h5>قائمة طالبي الخدمات :</h5>
            </div>
            <?php
            $rows_query = mysqli_query($con, "SELECT * FROM requester ORDER BY id DESC");
            while($r_row = mysqli_fetch_array($rows_query)){
            $inn_id = $r_row['id'];
            ?>

            <div class="row text-right row_line py-1 mb-1">
                <div class="col">
                  <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#openMar_modal<?php echo $inn_id; ?>">  <?php echo $r_row['name']; ?></nutton>
                </div>
                <div class="col">
                <div class="float-left">
                    <button class="btn btn-sm btn-primary py-0" data-toggle="modal" data-target="#edit_modal<?php echo $inn_id; ?>">تعديل</button>
                    <button class="btn btn-sm btn-danger py-0" id="del<?php echo $inn_id; ?>">حذف</button>
                </div>
                </div>
            </div>

            <script>
                $(document).ready(function(){

                    $('#del<?php echo $inn_id; ?>').on('click', function(){
                        
                        bootbox.confirm("هل أنت واثق بحذفك لأحد موظفي طالبي الخدمات", function(result){

                            if(result == true){
                            
                                $.post("handlers/delete_marke.php?port_id=<?php echo $inn_id; ?>", {result:result});
                                location.reload();
                                
                                
                            }
                        });

                    });


                }); // end of all document.ready
            </script>
            <!-- Edit Modal -->
            <div class="modal fade" id="edit_modal<?php echo $inn_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> تعديل بيانات طالب الخدمة </h5>
                        
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="الإسم .." value="<?php echo $r_row['name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control" name="phone" placeholder="رقم الجوال .." value="<?php echo $r_row['phone']; ?>" required>
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
                        <button type="submit" class="btn btn-go" name="update_requester<?php echo $inn_id; ?>">تحديث</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            <?php
            // update doer
            $parra = "update_requester".$inn_id;
            if(isset($_POST[$parra])){
                $namee = $_POST['name'];
                $phonee = $_POST['phone'];
                //update db
                $update_db = mysqli_query($con, "UPDATE requester SET phone = '$phonee', name = N'$namee' WHERE id='$inn_id'");
                header("Refresh: 0");
            }
            ?>

            <?php
            // update doer
            $parra = $inn_id;
            if(isset($_POST[$parra])){
                $namee = $_POST['name'];
                $phonee = $_POST['phone'];

                $result= mysqli_query($con , "SELECT *FROM doers WHERE ( phone='$phonee' AND name='$namee' )");
                $admin_id = $parra;
                    $result_num= mysqli_num_rows($result);


                if($result_num > 0){
            $roledes = "marketers";
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