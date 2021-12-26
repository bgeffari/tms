<?php
include 'DBController.php';
include '../config/config.php';
$db_handle = new DBController();
$productResult = $db_handle->runQuery("select * from orders");

if (isset($_POST["export"])) {
    $filename = "Export_excel.csv";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    if (! empty($productResult)) {
        $counnt = 0;
        foreach ($productResult as $row) {
            $counnt++;
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
            $mange_cerv = $row['mange_cerv'];
            $phone = $row['phone'];

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
            $status_button = $status_res['name_only'];
    


            if (! $isPrintHeader) {
                // $setData =  implode("\t", array_keys($row)) . "\n";
                $setData =  "الرقم" ."\t" ."  تاريخ المهمة" . "\t" . "طالب الخدمة" . "\t" . "الإدارة طالبة الخدمة" . "\t" ."رقم التحويلة" ."\t" . "الخدمة المطلوبه" . "\t" . "القسم" . "\t" ."تفاصيل الطلب" ."\t" ."حالة المهمة" ."\t" ."تاريخ الإنتهاء" ."\t" ."الموظف المختص" ."\t" ." ملاحظات الموظف". "\n";

                $isPrintHeader = true;
            }
            $setData .= $counnt ."\t" .$pro_date."\t" .$req_name."\t" .$mange_cerv."\t" .$phone."\t" .$miss_name."\t" .$sec_name."\t" .$req_details."\t" .$status_button."\t" .$fnish_date."\t" .$empl_name. "\t" .$employ_details ."\n";
            // $setData .= implode("\t", array_values($row)) . "\n";
        }
        $setData = chr(255) . chr(254) . mb_convert_encoding($setData, "UTF-16LE", "UTF-8");
        echo $setData;
    }
    exit();
}
?>
<?php
// if (! empty($productResult)) {
//     foreach ($productResult as $row) {
//         if (! $isPrintHeader) {
//             // $setData =  implode("\t", array_keys($row)) . "\n";
//             $setData =  "  تاريخ المشروع" . "\t" . "إسم العميل" . "\t" . "رقم جواله" . "\t" . "نوع المشروع" . "\t" . "أضافه" . "\t" . "المنفذ" . "\t" . "الحالة" . "\t" . "Last Name" . "\t" . "Last Name" . "\t" . "\n";

//             $isPrintHeader = true;
//         }
//         $setData .= implode("\t", array_values($row)) . "\n";
//     }
//     $setData = chr(255) . chr(254) . mb_convert_encoding($setData, "UTF-16LE", "UTF-8");
//     echo $setData;
// }
// exit();
?>