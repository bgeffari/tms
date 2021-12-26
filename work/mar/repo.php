
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
            </div>
            <?php
            $sec_id= $_SESSION['sec_id'];
            $e_rows_query = mysqli_query($con, "SELECT * FROM employees WHERE sec_id = '$sec_id' AND is_admin = 'no' ");
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
    header("LOcation:../../admin/pdfs/ripo.php?id=$in_id&start=$start&end=$end");
            }
            } // while loop ends
            
            $parra = "all_repo";
             if(isset($_POST[$parra])){
                $start = $_POST['start'];
                $end = $_POST['end'];
    header("LOcation:../../admin/pdfs/ripo.php?sec_id=$sec_id&start=$start&end=$end");
            }
            ?>
            </form>
            </div>
        </div>
    </div>
</section>