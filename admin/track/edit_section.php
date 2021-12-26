<?php

if(isset($_GET['edit_section'])){
    unset($_SESSION['edit_section']);
    $sec_id = $_GET['edit_section'];
    $_SESSION['edit_section'] = $sec_id;
    $get_mission_name = mysqli_query($con, "SELECT * FROM missions WHERE id ='$sec_id'");
    $sec_res = mysqli_fetch_array($get_mission_name);
    $sec_name= $sec_res['name'];

    $get_designers = $sec_res['employees'];
    $designers = explode("," ,$get_designers);
}
if(isset($_POST['add_des_ts'])){
    $new_id = $_POST['des_id'];

    $get_sec = mysqli_query($con, "SELECT * FROM missions WHERE id = '$sec_id'");
    $fetch_des = mysqli_fetch_array($get_sec);
    $sec_designers = $fetch_des['employees'];

    $new_designers = $sec_designers ."," .$new_id;

    // update add des query
    $upd_q = mysqli_query($con, "UPDATE missions SET employees = '$new_designers' WHERE id ='$sec_id'");
    header("LOcation: track.php?edit_section=$sec_id");


}
?>


<section dir="rtl">
<div class="container"><br>
    <div class="list" dir="rtl">
        <div class="container">
            <div class="add_des">
            <form method="post" action="">
                <div class="row">
                    <div class="col-10">
                        <select name="des_id" class="form-control" required>
                        <option disabled selected value>إختر ..</option>
                        <?php
                        $get_dds = mysqli_query($con, "SELECT * FROM employees ");

                        while($d_row = mysqli_fetch_array($get_dds)){
                            $d_id = $d_row['id'];
                            $d_name = $d_row['name'];

                            $get_sec = mysqli_query($con, "SELECT * FROM missions WHERE id = '$sec_id'");
                            $fetch_des = mysqli_fetch_array($get_sec);
                            $sec_designers = $fetch_des['employees'];
                            $sec_designers = explode("," , $sec_designers);


                            if(in_array($d_id , $sec_designers)){
                            ?>
                            <option value="<?php echo $d_id; ?>" disabled class="disabled_option"><?php echo $d_name; ?></option>
                            <?php
                            }else{
                            ?>
                            <option value="<?php echo $d_id; ?>"><?php echo $d_name; ?></option>
                            <?php
                            }
                            
                        ?>
                        
                        <?php
                        }
                
                        ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success form-control" name="add_des_ts">أضف</button>
                    </div>
                </div>
            </form>
            </div><br>
            <div class="text-right">
                <h5>قائمة المتخصصين في هذه المهمة <strong>&nbsp; "<?php echo $sec_name; ?>" &nbsp;</strong>:</h5>
            </div>
            <?php
            $de_num = 0;
            foreach($designers as $dess){
                $get_des_name = mysqli_query($con, "SELECT * FROM employees WHERE id = '$dess'");
                $fetch_dess = mysqli_fetch_array($get_des_name);
                $des_name = $fetch_dess['name'];
                $de_num++;

            if($dess != ''){
            ?>
            
            
            
            <div class="row text-right row_line py-1 mb-1">
                <div class="col">
                    <?php echo $des_name; ?>
                </div>
                <div class="col">
                    <button class="btn btn-sm btn-danger py-0" id="delete<?php echo $dess; ?>" style="float: left;">حذف</button>
                </div>
            </div>

            <script>
                $(document).ready(function(){

                    $('#delete<?php echo $dess; ?>').on('click', function(){
                        
                        bootbox.confirm("هل أنت واثق بحذفك لموظف الخدمة في هذه المهمة ?", function(result){

                            if(result == true){
                            
                                $.post("handlers/delete_employf_section.php?port_id=<?php echo $dess; ?>", {result:result});
                                location.reload();
                                
                                
                            }
                        });

                    });


                }); // end of all document.ready
            </script>
            <?php
            } // if end
            ?>
            <?php
            } // foreach loop ends
            if($de_num <= 1){
            ?>
            <br><br>
            <div class="text-center">
            لا يوجد مختصون ، قم بإضافة احد الموظفين
            </div>
            <?php
            }
            ?>
            
            
        </div>
    </div>
</div>
</section>