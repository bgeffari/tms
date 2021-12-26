
	<div class="container">
		
		<?php
		if(isset($_GET['success'])){
		$success= "تم التقديم في الكورس بنجاح الرجاء انتظار قبول المسؤول! ...";
		echo "<div class='container'><div class='succ text-right' dir='rtl' style='padding-right:20px;color:#fff; font-weight:900;'>" .$success ."</div></div>";
	}
	
	if(isset($_GET['sorry'])){
		$success= "لقد قدمت طلب اشتراك من قبل ...";
		echo "<div class='container'><div class='sorr text-right' dir='rtl' style='padding-right:20px;color:#fff; font-weight:900;'>" .$success ."</div></div>";
	}

			$req_cours_q = "SELECT * FROM req_cours WHERE status = '0' ORDER BY id DESC";
			$ok_cours_q = "SELECT * FROM req_cours WHERE status = '1' ORDER BY id DESC";
		
		?>

				
			<div class="content">
			<br>
			<?php
				$fetch_rcours= mysqli_query($con, $req_cours_q);
			if (mysqli_num_rows($fetch_rcours) ==0) {
				}else{?>
			<div class="l_categories text-right" dir="rtl">
				
				
				<h3>قائمة الطلبات المعلقه :</h3>
				<div class="container">

				
				<?php
				
				while ($row_ok= mysqli_fetch_array($fetch_rcours)) {
					$req_id = $row_ok['id'];
					$id = $row_ok['cours_id'];
					$user_id = $row_ok['user_id'];
					$user_rolle = $row_ok['user_roll'];
					if ($user_rolle == 'mar') {
						$user_q = "SELECT * FROM employees WHERE id = '$user_id'";
					}else{
						$user_q = "SELECT * FROM requester WHERE id = '$user_id'";
					}
				$okcours_q = "SELECT * FROM cours WHERE id = '$id' ORDER BY id DESC";
				$fetch_ocours= mysqli_query($con, $okcours_q);
				$fetch_user= mysqli_query($con, $user_q);
				$row_user = mysqli_fetch_array($fetch_user);
				while($rowo= mysqli_fetch_array($fetch_ocours)){
                    $cours_id= $rowo['id'];
					$cours_image = $rowo['image'];
					$cours_name = $rowo['titlle'];
					$cours_discrip = $rowo['discrip'];
					$cours_score = $rowo['score'];
					$cours_cost = $rowo['cost'];
					$cours_linke = $rowo['linke'];
					echo '
<div class="row message mb-2">
      <div class="col-md-2">
          '.$row_user['name'].'
      </div>
      <div class="col-md-2">
          '.$row_user['phone'].'
      </div>
      
<div class="col-md-2">كورس :
          '.$cours_name.'
      </div>
      
      
      <div class="col-md-2">
          '.$cours_score.'/نقطة
      </div>

      <div class="col-md-2">
          '.$cours_cost.'/ريال
      </div>
      
      <div class="col-md-1">
          <button class="btn btn-success" data-toggle="modal" data-target="#viewModal'.$req_id.'">قبول</button>
      </div>
  </div>
  <!-- Modal -->
        <div class="modal fade" id="viewModal'.$req_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اسم الكورس : '.$cours_name.'</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                اسم الموظف : '.$row_user['name'].'
                </div>
                <div>
                    التكلفه : '.$cours_cost.'
                </div>
                <div>
                    عدد النقاط : '.$cours_score.'
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <form action="#" method="POST"><button type="submit" name="accept'.$req_id.'" class="btn btn-success">قبول</button></form>
            </div>
            </div>
        </div>
        </div>  <!---- Modal End ----->
					';
					?>
				
				
				
             
							
				
				<?php

				$accept = 'accept'.$req_id;
        if(isset($_POST[$accept])){
            // delte Query
            $update_query = mysqli_query($con, "UPDATE req_cours SET status = '1' WHERE id = '$req_id' ");
            header('Refresh: 0');
        }
				} // end of while loop
				}
				?>

				</div>
			</div>
		</div>
		<?php }?>


		<div class="content">
			<br>
			<?php
				$fetch_okcours= mysqli_query($con, $ok_cours_q);
			if (mysqli_num_rows($fetch_okcours) ==0) {
				}else{?>
			<div class="l_categories text-right" dir="rtl">
				
				
				<h3>قائمة الكورسات جاريه :</h3>
				<div class="container">

				
				<?php
				
				while ($row_ok= mysqli_fetch_array($fetch_okcours)) {
					$req_id = $row_ok['id'];
					$id = $row_ok['cours_id'];
					$user_id = $row_ok['user_id'];
					$user_rolle = $row_ok['user_roll'];
					if ($user_rolle == 'mar') {
						$user_q = "SELECT * FROM employees WHERE id = '$user_id'";
					}else{
						$user_q = "SELECT * FROM employees WHERE id = '$user_id'";
					}
				$okcours_q = "SELECT * FROM cours WHERE id = '$id' ORDER BY id DESC";
				$fetch_ocours= mysqli_query($con, $okcours_q);
				$fetch_user= mysqli_query($con, $user_q);
				$row_user = mysqli_fetch_array($fetch_user);
				while($rowo= mysqli_fetch_array($fetch_ocours)){
                    $cours_id= $rowo['id'];
					$cours_image = $rowo['image'];
					$cours_name = $rowo['titlle'];
					$cours_discrip = $rowo['discrip'];
					$cours_score = $rowo['score'];
					$cours_cost = $rowo['cost'];
					$cours_linke = $rowo['linke'];
					echo '
<div class="row message mb-2">
      <div class="col-md-2">
          '.$row_user['name'].'
      </div>
      <div class="col-md-2">
          '.$row_user['phone'].'
      </div>
      
<div class="col-md-2">كورس :
          '.$cours_name.'
      </div>
      
      
      <div class="col-md-2">
          '.$cours_score.'/نقطة
      </div>

      <div class="col-md-2">
          '.$cours_cost.'/ريال
      </div>
      
      <div class="col-md-1">
          <button class="btn btn-success" data-toggle="modal" data-target="#viewModal'.$req_id.'">في الانتظار</button>
      </div>
  </div>
  <!-- Modal -->
        <div class="modal fade" id="viewModal'.$req_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اسم الكورس : '.$cours_name.'</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                اسم الموظف : '.$row_user['name'].'
                </div>
                <div>
                    التكلفه : '.$cours_cost.'
                </div>
                <div>
                    عدد النقاط : '.$cours_score.'
                </div>
                 <div>
                    التاكد من إكمال الموظف لهذا الكورس قبل تصنيفه مكتمل
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <form action="#" method="POST"><button type="submit" name="fnish'.$req_id.'" class="btn btn-success">مكتمل</button>
                <button type="submit" name="notfnish'.$req_id.'" class="btn btn-danger">غير مكتمل</button>
                </form>
            </div>
            </div>
        </div>
        </div>  <!---- Modal End ----->
					';
					?>
				
				
				
             
							
				
				<?php

                $accept = 'fnish'.$req_id;
                $not = 'notfnish'.$req_id;
        if(isset($_POST[$accept])){
            
            $update_query = mysqli_query($con, "UPDATE req_cours SET status = '2' WHERE id = '$req_id' ");
            header('Refresh: 0');
        }elseif(isset($_POST[$not])){
            $update_query = mysqli_query($con, "UPDATE req_cours SET status = '3' WHERE id = '$req_id' ");
            header('Refresh: 0');
        }
				} // end of while loop
				}
				?>

				</div>
			</div>
		</div>
		<?php }?>






	</div>
    </section>


	
    
</body>
</html>