<?php

include('../../config/config.php');
$admin = $_SESSION['id'];




if(isset($_POST["limit"], $_POST["start"]))
{

    $query = "SELECT * FROM orders WHERE (requester_id = '$admin')  ORDER BY id DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
    
    $messages_query = mysqli_query($con, $query);
    $count = $_POST["start"]+1;

    while($row = mysqli_fetch_array($messages_query))
    {
        $id = $row['id'];
        $employ_details = $row['employ_details'];
        $req_details = $row['req_details'];
        $req_rate = $row['req_rate'];
        $fnish_date = $row['date_end'];
        $fnish_date = substr($fnish_date , 0,10); // to get the date only without time
        $pro_date = $row['date_added'];
        $pro_date = substr($pro_date , 0,10); // to get the date only without time

        $requester_id = $row['requester_id'];
        $employee_id = $row['employee_id'];
        $mission_id = $row['mission_id'];
        $status_id = $row['status_id'];

        $attach_quer = mysqli_query($con, "SELECT * FROM attachs WHERE order_id = '$id'");
        $a_row = mysqli_fetch_array($attach_quer);
        $attachs = $a_row['name'];

        $get_mar = mysqli_query($con, "SELECT * FROM requester WHERE id = '$requester_id'");
        $mar_res = mysqli_fetch_array($get_mar);
        $req_name = $mar_res['name'];

        $get_des = mysqli_query($con, "SELECT * FROM employees WHERE id = '$employee_id'");
        $des_res = mysqli_fetch_array($get_des);
        $empl_name = $des_res['name'];
        $empl_phone =$des_res['phone'];

        $get_type = mysqli_query($con, "SELECT * FROM missions WHERE id = '$mission_id'");
        $typ_res = mysqli_fetch_array($get_type);
        $miss_name = $typ_res['name'];

        $get_status = mysqli_query($con, "SELECT * FROM status WHERE id = '$status_id'");
        $status_res = mysqli_fetch_array($get_status);
        $status_button = $status_res['name'];
        if ($employ_details != "") {
            
        }else{
            $employ_details = "لا توجد ملاحظة";
        }
        if ($status_id == 2 && $req_rate == 2) {
            $status = '<a class="btn btn-success" href="" data-toggle="modal" data-target="#rate'.$id.'">مكتمله الرجاء تقييم الموظف</a> <a class="btn btn-success" href="" data-toggle="modal" data-target="#update_status'.$id.'">تعديل الحاله</a>';
        }else{
            $status = $status_button;
        }
        
      echo '
      <div class="row prroj py-2">
        <div class="col text-center num">'.$count.'</div>
        <div class="col text-center">'.$pro_date.'</div>
        
        <div class="col text-center">'.$miss_name.'</div>
        <div class="col-1 text-center" style="overflow: hidden;"><a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#show_detail_req'.$id.'">'.$req_details.'</a></div>
        
        <div class="col text-center">
            '.$fnish_date.'
        </div>

        <div class="col text-center">'.$status.'</div>
        <div class="col text-center">'.$empl_name.'</div>
        <div class="col text-center"><a class="btn btn-success" href="" data-toggle="modal" data-target="#view_attach'.$id.'">مُراجعة المُرفقات</a></div>
        <div class="col text-center">'.$empl_phone.'</div>
        <div class="col text-center" style="overflow: hidden;"><a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#show_detail'.$id.'">'.$employ_details.'</a></div>
      
        
    </div>



    <script>
        $(document).ready(function(){

            $("#delet'.$id.'").on("click", function(){
                
                bootbox.confirm("Are you sure you want to delete this Project perminantly ?", function(result){

                    if(result == true){
                    
                        $.post("handlers/delete_proj.php?port_id='.$id.'", {result:result});
                        location.reload();
                        
                        
                    }
                });

            });


        }); // end of all document.ready
    </script>
      ';
  
    
        $count++;
    } //end of while
} // end of if


?>



