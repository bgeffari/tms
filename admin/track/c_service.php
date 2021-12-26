<?php
if(isset($_GET['success'])){
    echo '<div class="container text-right succ">تمت اضافة القسم ، قم بتحديد المهام داخل القسم ..</div>';
}
?>

<section dir="rtl">
      

    <!-- Modal -->
<div class="modal fade" id="add_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" dir="rtl">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> أضف قسم جديد </h5>
        
      </div>
      <div class="modal-body">
        <form action="#" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="إسم القسم .." required>
            </div>
            
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
        <button type="submit" class="btn btn-go" name="add_section">إضافة</button>
      </div>
      </form>
    </div>
  </div>
</div>

    <?php

    if(isset($_POST['add_section'])){

        $name= $_POST['name'];
        
        
        // insert into database
        $insert_query= mysqli_query($con, "INSERT INTO section VALUES(default , N'$name', '')");
        
        header("Location: track.php?c_service&success");
        


    }

    ?>

    <!-------  End of Add Marketer -->


    <div class="container"><br>
        <div class="text-center">
            <button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#add_section">
                <img src="imgs/icons/plus.png" height="22">
                إضافة قسم
            </button>
        </div>
    </div><br>
    <div class="list" dir="rtl">
        <div class="container">
            <div class="text-right">
                <h5>قائمة الأقسام المضافة :</h5>
            </div>
            <?php
            $d_rows_query = mysqli_query($con, "SELECT * FROM section ORDER BY id DESC");
            while($d_row = mysqli_fetch_array($d_rows_query)){
            $in_id = $d_row['id'];
            ?>

            <div class="row text-right row_line py-1 mb-1">
                <div class="col">
                    <?php echo $d_row['name']; ?>
                </div>
                <div class="col">
                    <button class="btn btn-sm btn-danger py-0" id="dele<?php echo $in_id; ?>" style="float: left;">حذف</button>
                    <a class="btn btn-sm btn-dark py-0" name="select_miss" href="track.php?edit_miss=<?php echo $in_id; ?>" style="float: left; margin-left: 7px; color:#fff;">تحديد المهام</a>
                </div>
            </div>

            <script>
                $(document).ready(function(){

                    $('#dele<?php echo $in_id; ?>').on('click', function(){
                        
                        bootbox.confirm("هل أنت واثق بحذفك لهذا القسم ?", function(result){

                            if(result == true){
                            
                                $.post("handlers/delete_section.php?port_id=<?php echo $in_id; ?>", {result:result});
                                location.reload();
                                
                                
                            }
                        });

                    });


                }); // end of all document.ready
            </script>
            <?php
            
            } // while loop ends
            ?>
            
        </div>
    </div>
</section>
  