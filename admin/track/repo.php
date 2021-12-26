
<section dir="rtl">

    <div class="list" dir="rtl">
        <div class="container">
            <div class="text-right">
                <h5>سحب تقارير موظفي الخدمات :</h5>
                <form method="post" action="">
                    <div>
                        <label class="lead">تاريخ البدايه "أصغر "</label>
                        <input type = "date" name="start" value="<?php echo date("Y-m-d"); ?>">
                         <label class="lead">تاريخ النهاية "أكبر"</label>
                        <input type = "date" name="end" value="<?php echo date("Y-m-d"); ?>">
                        <button class="btn btn-sm btn-success " type="submit" name="all_repo">سحب تقرير لكل الموظفين </button>
                        <button class="btn btn-sm btn-success " type="submit" name="all_sec_repo">سحب تقرير الإدارات   </button>
                        <button class="btn btn-sm btn-success " type="submit" name="sys">سحب تقرير الشركة   </button>
                    </div>
                   

            <?php
            $e_rows_query = mysqli_query($con, "SELECT * FROM employees ORDER BY id DESC");
            while($e_row = mysqli_fetch_array($e_rows_query)){
            $in_id = $e_row['id'];
            ?>

            <div class="row text-right row_line py-1 mb-1">
                <div class="col">

                 <button type="submit" name="repo_date<?php echo $in_id; ?>" class="btn btn-sm btn-success " >   <?php echo $e_row['name']; ?></button>
                </div>
            </div>
            <?php

             $parra = "repo_date".$in_id;
             if(isset($_POST[$parra])){
                $start = $_POST['start'];
                $end = $_POST['end'];
    header("LOcation: pdfs/ripo.php?id=$in_id&start=$start&end=$end");
            }


            } // while loop ends

           $parra = "all_repo";
             if(isset($_POST[$parra])){
                $start = $_POST['start'];
                $end = $_POST['end'];
    header("LOcation: pdfs/ripo.php?start=$start&end=$end");
            }
            
            if(isset($_POST['all_sec_repo'])){
                $start = $_POST['start'];
                $end = $_POST['end'];
    header("LOcation: pdfs/secRipo.php?start=$start&end=$end");
            }
            
            if(isset($_POST['sys'])){
                $start = $_POST['start'];
                $end = $_POST['end'];
    header("LOcation: pdfs/sys.php?start=$start&end=$end");
            }
           
            ?>
            
                </form>
            </div>
        </div>
    </div>
</section>