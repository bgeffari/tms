<?php
if(isset($_GET['success'])){
    echo '<div class="container text-right succ">تمت اضافة الموظف ، قم باضافته إلى المهام التي يتخصص فيها ..</div>';
}
?>

<section dir="rtl">

    <br>
    <div class="list" dir="rtl">
        <div class="container">
            <div class="text-right">
                <h5>قائمة موظفي الخدمات مع التقييم للمستوى :</h5>
                <p class="lead">تنبيه يتم احتساب التقيم فقط للمهام المنجزة "مكتملة"</p>
            </div>
            <div class="text-center">
                    <a type="button" class="btn btn-success" href="pdfs/orderall.php">مهام الموظفين</a>
                    <a type="button" class="btn btn-success" href="pdfs/orderp.php">مهام الموظفين الاساسيه</a>
            </div>
                <p class="lead text-right">الموظفين المميزين</p>
            <?php
            $e_rows_query = mysqli_query($con, "SELECT * FROM employees ORDER BY id DESC");
            while($e_row = mysqli_fetch_array($e_rows_query)){
            $in_id = $e_row['id'];
            $r_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$in_id' AND status_id = '2'");
            $r_green_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$in_id' AND rate = '100'");
            $r_blue_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$in_id' AND rate > '100'");
            $r_yello_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$in_id' AND (rate < '100' AND rate > '69' )");
            $r_red_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$in_id' AND rate <'70' AND rate != '0'");
            $green = mysqli_num_rows($r_green_query);
            $blue = mysqli_num_rows($r_blue_query);
            $yello = mysqli_num_rows($r_yello_query);
            $red = mysqli_num_rows($r_red_query);
            $num = mysqli_num_rows($r_query);

            if ($blue > 0) {
            ?>
            <?php
                  $r =0;
                  while ($a_row = mysqli_fetch_array($r_query)) {
                   $r += $a_row['req_rate'];

                  }
                  ?>

            <div class="row text-right row_line py-1 mb-1">
                <div class="col">
                 <a type="button" class="btn btn-sm btn-success" href="pdfs/order.php?id=<?php echo $e_row['id'];?>">   <?php echo $e_row['name']; ?></a>
                </div>
                <div class="col">
                    <p>عدد المهام الكلي : <?php echo $num; ?></p>
                </div> 
                <div class="col">
                    <p>تصنيف الموظف : <?php 
                    if ($num > 0) {
                    $d_blue = ($blue/$num) * 100;
                    $d_green = ($green/$num) * 100;
                    $d_yello = ($yello/$num) * 100;
                    $d_red = ($red/$num) * 100;
                    $d_rate = $d_blue + $d_yello + $d_green +$r /$num  - 10;
                   
                    if ($d_rate > 80) {
                        ?>
                    <button class="btn btn-sm btn-primary py-0">ممتاز</button>
                    <?php
                    }elseif ($d_rate > 70 && $d_rate < 80) {
                        ?>
                    <button class="btn btn-sm btn-success py-0">جيد جدا</button>
                    <?php
                    }elseif ($d_rate >60 && $d_rate <70) {
                        ?>
                    <button class="btn btn-sm btn-warning py-0">جيد</button>
                    <?php
                    }elseif ($d_rate >= 50 && $d_rate < 60) {
                    ?>
                    <button class="btn btn-sm btn-warning py-0">مقبول</button>
                    <?php
                    }elseif ($d_rate < 50) {
                    ?>
                    <button class="btn btn-sm btn-danger py-0">سيء</button>
                    <?php
                    }
                }else{
                    ?>
                    <button class="btn btn-sm btn-info py-0">لم يتم حساب التصنيف بعد</button>
                <?php
                }

                     ?></p>
                </div>
                 <div class="col">
                    التصنيف بالنسبة : <?php 
                    if ($num >0) {
                        
                    $d_blue = ($blue/$num) * 100;
                    $d_green = ($green/$num) * 100;
                    $d_yello = ($yello/$num) * 100;
                    $d_red = ($red/$num) * 100;
                    $d_rate = $d_blue + $d_yello + $d_green + $r /$num -10;
                    if ($d_rate > 100){
                    echo "100+";
                    }else{
                    echo $d_rate;
                    }
                    $update_db = mysqli_query($con, "UPDATE employees SET rate = '$d_rate' WHERE id = '$in_id' ");
                    }else{
                        echo 0;
                    }?> %
                </div>
                
                <div class="col">
تقييم طالب الخدمة : <?php 
if($r > 100){
echo " 100+";
} else{
echo $r;} 
?> %
</div>
                <div class="col">
                <div class="float-left">
                    <button class="btn btn-sm btn-primary py-0"><?php echo $blue; ?></button>
                    <button class="btn btn-sm btn-success py-0"><?php echo $green; ?></button>
                    <button class="btn btn-sm btn-warning py-0"><?php echo $yello; ?></button>
                    <button class="btn btn-sm btn-danger py-0"><?php echo $red; ?></button>
                </div>
                </div>
            </div>            
            <?php
        }
            } // while loop ends
            ?>
<!--          ======================    --> 
                                <p class="lead text-right">تقييم الموظفين</p>
       <?php
            $e_rows_query = mysqli_query($con, "SELECT * FROM employees ORDER BY id DESC");
            while($e_row = mysqli_fetch_array($e_rows_query)){
            $in_id = $e_row['id'];
            $r_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$in_id' AND status_id = '2'");
            $r_green_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$in_id' AND rate = '100'");
            $r_blue_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$in_id' AND rate > '100'");
            $r_yello_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$in_id' AND (rate < '100' AND rate > '69' )");
            $r_red_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$in_id' AND rate <'70' AND rate != '0'");
            $green = mysqli_num_rows($r_green_query);
            $g_row = mysqli_fetch_array($r_green_query);
            $blue = mysqli_num_rows($r_blue_query);
            $b_row = mysqli_fetch_array($r_blue_query);
            $yello = mysqli_num_rows($r_yello_query);
            $y_row = mysqli_fetch_array($r_yello_query);
            $red = mysqli_num_rows($r_red_query);
            $r_row = mysqli_fetch_array($r_red_query);
            $num = mysqli_num_rows($r_query);
            
            if($blue == 0) {

            
            ?>
            <?php
                  $r =0;
                  while ($a_row = mysqli_fetch_array($r_query)) {
                   $r += $a_row['req_rate'];

                  }
                  ?>

            <div class="row text-right row_line py-1 mb-1">
                <div class="col">
                 <a type="button" class="btn btn-sm btn-success" href="pdfs/order.php?id=<?php echo $e_row['id'];?>">   <?php echo $e_row['name']; ?></a>
                </div>
                <div class="col">
                    <p>عدد المهام الكلي : <?php echo $num; ?></p>
                </div> 
                <div class="col">
                    <p>تصنيف الموظف : <?php 
                    if ($num > 0) {
                    $d_blue = ($blue/$num) * 100;
                    $d_green = ($green/$num) * 100;
                    $d_yello = ($yello/$num) * 100;
                    $d_red = ($red/$num) * 100;
                    $d_rate = $d_blue + $d_yello + $d_green +  $r /$num - 10;

                    if ($d_rate > 80 ) {
                        ?>
                    <button class="btn btn-sm btn-primary py-0">ممتاز</button>
                    <?php
                    }elseif ($d_rate > 70 && $d_rate < 80) {
                        ?>
                    <button class="btn btn-sm btn-success py-0">جيد جدا</button>
                    <?php
                    }elseif ($d_rate >60 && $d_rate <70) {
                        ?>
                    <button class="btn btn-sm btn-warning py-0">جيد</button>
                    <?php
                    }elseif ($d_rate >= 50 && $d_rate < 60) {
                    ?>
                    <button class="btn btn-sm btn-warning py-0">مقبول</button>
                    <?php
                    }elseif ($d_rate < 50) {
                    ?>
                    <button class="btn btn-sm btn-danger py-0">سيء</button>
                    <?php
                    }
                }else{
                    ?>
                    <button class="btn btn-sm btn-info py-0">لم يتم حساب التصنيف بعد</button>
                <?php
                }

                     ?></p>
                </div>
                  <div class="col">
                    التصنيف بالنسبة : <?php  
                    if ($num >0) {
                        
                    $d_blue = ($blue/$num) * 100;
                    $d_green = ($green/$num) * 100;
                    $d_yello = ($yello/$num) * 100;
                    $d_red = ($red/$num) * 100;
                    $d_rate = $d_blue + $d_yello + $d_green + $r /$num - 10;
                    if ($d_red > 90) {
                        $d_rate = $r/$num;
                    }
                    if ($d_rate >100){
                    echo "100+";
                    }else{
                    echo $d_rate;}
                    $update_db = mysqli_query($con, "UPDATE employees SET rate = '$d_rate' WHERE id = '$in_id' ");
                    }else{
                        echo 0;
                    }?> %
                </div>
                <div class="col">
تقييم طالب الخدمة : <?php 
if($r > 100){
echo " 100+";
}else{
echo $r;}
?> %
</div>
                
                <div class="col">
                <div class="float-left">
                    <button class="btn btn-sm btn-primary py-0"><?php echo $blue; ?></button>
                    <button class="btn btn-sm btn-success py-0"><?php echo $green; ?></button>
                    <button class="btn btn-sm btn-warning py-0"><?php echo $yello; ?></button>
                    <button class="btn btn-sm btn-danger py-0"><?php echo $red; ?></button>
                </div>
                </div>
            </div>            
            <?php
           } 
        
            } // while loop ends
            ?>

       </div>
    </div>
</section>