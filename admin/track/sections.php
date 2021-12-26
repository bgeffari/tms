<?php
if(isset($_GET['success'])){
    echo '<div class="container text-right succ">تمت اضافة المهمة ، قم بتعيين الموظفين المعنيين بالانجاز في هذه المهمة ..</div>';
}
?>

<section dir="rtl">



    <!-- Modal -->
<div class="modal fade" id="add_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" dir="rtl">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> أضف مهمة </h5>
        
      </div>
      <div class="modal-body">
        <form action="#" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="إسم المهمة .." required>
            </div>
             <div class="form-group">
                <input type="number" class="form-control" name="end_date" placeholder="عدد الايام للإنجاز .." required>
            </div>
            
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
        <button type="submit" class="btn btn-go" name="add_miss">إضافة</button>
      </div>
      </form>
    </div>
  </div>
</div>

    <?php

    if(isset($_POST['add_miss'])){

        $name= $_POST['name'];
        $date_end= $_POST['end_date'];
        
        
        // insert into database
        $insert_query= mysqli_query($con, "INSERT INTO missions VALUES(default , N'$name', '','0','$date_end')");
        
        header("Location: track.php?sections&success");
        


    }


    ?>

    <!-------  End of Add Marketer -->


    <div class="container"><br>
        <div class="text-center">
            <button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#add_section">
                <img src="imgs/icons/plus.png" height="22">
                إضافة مهمة
            </button>
        </div>
    </div><br>
    <div class="list" dir="rtl">
        <div class="container">
            <div class="text-right">
                <h5>قائمة المهام المضافة :</h5>
            </div>
            <?php
            $d_rows_query = mysqli_query($con, "SELECT * FROM missions ORDER BY id DESC");
            while($d_row = mysqli_fetch_array($d_rows_query)){
                global $in_id;
            $in_id = $d_row['id'];
            ?>

            <div class="row text-right row_line py-1 mb-1">
                <div class="col">
                    
                 <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#openmiss_modal<?php echo $in_id; ?>">  <?php echo $d_row['name']; ?></button>
                </div>
                <div class="col">
                    <button class="btn btn-sm btn-danger py-0" id="dele<?php echo $in_id; ?>" style="float: left;">حذف</button>
                    <a class="btn btn-sm btn-dark py-0" href="track.php?edit_section=<?php echo $in_id; ?>" style="float: left; margin-left: 7px;">المعنيين بالإنجاز</a>
                </div>
            </div>

               <script>
                $(document).ready(function(){

                    $('#dele<?php echo $in_id; ?>').on('click', function(){
                        
                        bootbox.confirm("هل أنت واثق بحذفك لهذه المهمة ?", function(result){

                            if(result == true){
                            
                                $.post("handlers/delete_missf_section.php?por_id=<?php echo $in_id; ?>", {result:result});
                                location.reload();
                                
                                
                            }
                        });

                    });


                }); // end of all document.ready
            </script>

            <!-- Edit Mission Modal -->
            <div class="modal fade" id="openmiss_modal<?php echo $in_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> أستعراض بيانات المهمة</h5>
                        
                    </div>
                    <div class="modal-body">
        <form action="#" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="إسم المهمة .." value="<?php echo $d_row['name']; ?>" required>
            </div>
             <div class="form-group">
                <input type="number" class="form-control" name="end_date" placeholder="عدد الايام للإنجاز .." value="<?php echo $d_row['end_date']; ?>" required>
            </div>
            
        <button type="submit" class="btn btn-go col-md-12" name="edit_miss<?php echo $in_id; ?>">تحديث بيانات المهمة</button>
      </div>
                   <div class="modal-footer">
         <button type="button" class="btn btn-secondary col-md-12" data-dismiss="modal">إغلاق</button>&nbsp;
      </div>
      </form>
                    </div>
                </div>
            </div>

             <?php
            $parra = "edit_miss".$in_id;
    if(isset($_POST[$parra])){

        $name= $_POST['name'];
        $date_end= $_POST['end_date'];
        
        
        // insert into database
        $update_db = mysqli_query($con, "UPDATE missions SET name = '$name', end_date = '$date_end' WHERE id ='$in_id'");
        
                header("Refresh: 0");
        


    }
    ?>
         
            <?php
         
            } // while loop ends
            ?>

           


            
        </div>
    </div>


</section>