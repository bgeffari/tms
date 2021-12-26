
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

			$cours_q = "SELECT * FROM cours ORDER BY id DESC";
			$req_cours_q = "SELECT * FROM req_cours WHERE user_id = '$admin_loggedin' AND user_roll = '$rolle' AND status = '0' ORDER BY id DESC";
			$ok_cours_q = "SELECT * FROM req_cours WHERE user_id = '$admin_loggedin' AND user_roll = '$rolle' AND status = '1' ORDER BY id DESC";
			$fnish_q = "SELECT * FROM req_cours WHERE user_id = '$admin_loggedin' AND user_roll = '$rolle' AND status = '2' ORDER BY id DESC";
		
		?>


			<div class="content">
			<br>
			<?php
				$fetch_fcours= mysqli_query($con, $fnish_q);
			if (mysqli_num_rows($fetch_fcours) ==0) {
				}else{?>
			<div class="l_categories text-right" dir="rtl">
				
				
				<h3>قائمة الكورسات المكتمله :</h3>
				<div class="row">

				
				<?php
				
				while ($row_f= mysqli_fetch_array($fetch_fcours)) {
					$id = $row_f['cours_id'];
				$fcours_q = "SELECT * FROM cours WHERE id = '$id' ORDER BY id DESC";
				$fetch_fcours= mysqli_query($con, $fcours_q);

				while($rowf= mysqli_fetch_array($fetch_fcours)){
                    $cours_id= $rowf['id'];
					$cours_image = $rowf['image'];
					$cours_name = $rowf['titlle'];
					$cours_discrip = $rowf['discrip'];
					$cours_score = $rowf['score'];
					$cours_cost = $rowf['cost'];
					$cours_linke = $rowf['linke'];
				
					?>
					


					
				

				<div class="col-md-4">
				<div class="card mb-5" style="width: 18rem;">
					<img class="card-img-top" src="../assets/courses/<?php echo $cours_image; ?>" alt="Card image cap" style="max-height:300px;">
					<div class="card-body">
						<h5 class="card-title"><?php echo $cours_name; ?><br><?php echo $row['cost']; ?>ريال/ <?php echo $row['score']; ?>نقاط</h5>
						<p class="card-text" style="max-height: 120px; overflow:hidden; min-height:120px;">
						<button class="btn btn-primary" data-toggle="modal" data-target="#show<?php echo $cours_id; ?>"> عرض التفاصيل</button>
						تهانينا لقد اكملت الكورس بنجاح و حصلت على <?php echo $cours_score; ?>   نقاط</p>
						<a href="http://<?php echo $cours_linke;?>" class="btn btn-sm py-0 btn-primary" >linke</a>
					</div>
				</div>
				</div>
				<br>
				
             
							
				
				<?php

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
				
				
				<h3>قائمة الكورسات المقبوله :</h3>
				<div class="row">

				
				<?php
				
				while ($row_ok= mysqli_fetch_array($fetch_okcours)) {
					$id = $row_ok['cours_id'];
				$okcours_q = "SELECT * FROM cours WHERE id = '$id' ORDER BY id DESC";
				$fetch_ocours= mysqli_query($con, $okcours_q);

				while($rowo= mysqli_fetch_array($fetch_ocours)){
                    $cours_id= $rowo['id'];
					$cours_image = $rowo['image'];
					$cours_name = $rowo['titlle'];
					$cours_discrip = $rowo['discrip'];
					$cours_score = $rowo['score'];
					$cours_cost = $rowo['cost'];
					$cours_linke = $rowo['linke'];
				
					?>
					


					
				
				<div class="col-md-4">
				<div class="card mb-5" style="width: 18rem;">
					<img class="card-img-top" src="../assets/courses/<?php echo $cours_image; ?>" alt="Card image cap" style="max-height:300px;">
					<div class="card-body">
						<h5 class="card-title"><?php echo $cours_name; ?><br><?php echo $row['cost']; ?>ريال/ <?php echo $row['score']; ?>نقاط</h5>
						<p class="card-text" style="max-height: 120px; overflow:hidden; min-height:120px;">
						<button class="btn btn-primary" data-toggle="modal" data-target="#show<?php echo $cours_id; ?>"> عرض التفاصيل</button>
						<?php echo $row['discrip']; ?></p>
						<a href="http://<?php echo $cours_linke;?>" class="btn btn-sm py-0 btn-primary" >linke</a>
					</div>
				</div>
				</div>
				<br>
				
             
							
				
				<?php

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
				$fetch_reqcours= mysqli_query($con, $req_cours_q);
			if (mysqli_num_rows($fetch_reqcours) ==0) {
				}else{?>
			
			<div class="l_categories text-right" dir="rtl">
				
				
				<h3>قائمة الكورسات المعلقة :</h3>
				<div class="row">

				
				<?php
				
				while ($row_req= mysqli_fetch_array($fetch_reqcours)) {
					$id = $row_req['cours_id'];
				$rcours_q = "SELECT * FROM cours WHERE id = '$id' ORDER BY id DESC";
				$fetch_rcours= mysqli_query($con, $rcours_q);

				while($rowr= mysqli_fetch_array($fetch_rcours)){
                    $cours_id= $rowr['id'];
					$cours_image = $rowr['image'];
					$cours_name = $rowr['titlle'];
					$cours_discrip = $rowr['discrip'];
					$cours_score = $rowr['score'];
					$cours_cost = $rowr['cost'];
				
					?>
					


					
				


				<div class="col-md-4">
				<div class="card mb-5" style="width: 18rem;">
					<img class="card-img-top" src="../assets/courses/<?php echo $cours_image; ?>" alt="Card image cap" style="max-height:300px;">
					<div class="card-body">
						<h5 class="card-title"><?php echo $cours_name; ?><br><?php echo $rowr['cost']; ?>ريال/ <?php echo $rowr['score']; ?>نقاط</h5>
						<p class="card-text" style="max-height: 120px; overflow:hidden; min-height:120px;">
						<button class="btn btn-primary" data-toggle="modal" data-target="#show<?php echo $cours_id; ?>"> عرض التفاصيل</button>
						<?php echo $rowr['discrip']; ?></p>
						<button class="btn btn-sm py-0 btn-primary" >جاري معالجة الطلب</button>
					</div>
				</div>
				</div>
				<br>
				
             
							
				
				<?php

				} // end of while loop
				}
				?>

				</div>
			</div>
		</div>
		<?php } ?>



		<div class="content">
			<br>
			
			
			<div class="l_categories text-right" dir="rtl">
				
				
				<h3>قائمة الكورسات المضافة :</h3>
				<div class="row">

				
				<?php
				$fetch_cours= mysqli_query($con, $cours_q);

				if(mysqli_num_rows($fetch_cours) == 0){
					?> <div class="no_items"><center><p>There is no courses To show , Go ahead and Add one ..</p></center></div> <?php
				}

				while($row= mysqli_fetch_array($fetch_cours)){
                    $cours_id= $row['id'];
					$cours_image = $row['image'];
					$cours_name = $row['titlle'];
					$cours_discrip = $row['discrip'];
					$cours_score = $row['score'];
					$cours_cost = $row['cost'];
				
					?>
					


				<div class="col-md-4">
				<div class="card mb-5" style="width: 18rem;">
					<img class="card-img-top" src="../assets/courses/<?php echo $cours_image; ?>" alt="Card image cap" style="max-height:300px;">
					<div class="card-body">
					
						<h5 class="card-title"><?php echo $cours_name; ?><br><?php echo $row['cost']; ?>ريال/ <?php echo $row['score']; ?>نقاط</h5>
						<p class="card-text" style="max-height: 120px; overflow:hidden; min-height:120px;">
						<button class="btn btn-primary" data-toggle="modal" data-target="#show<?php echo $cours_id; ?>"> عرض التفاصيل</button>
						<?php echo $row['discrip']; ?></p>
						<form method="post" action="" enctype="multipart/form-data">
						<input type="hidden" name="cours" value="<?php echo $cours_id; ?>">
						<input type="hidden" name="rolle" value="<?php echo $rolle; ?>">
						<button type="submit"  class="btn btn-success py-0 btn-del" name="port<?php echo $cours_id; ?>">التقديم في الكورس</button>
					</form>
					</div>
				</div>
				</div>
				<br>
				
             
					<!-- Modal -->
				<div class="modal fade" id="show<?php echo $cours_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['titlle']; ?></h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
			<div class="form_item  mb-4">عنوان الكورس : <?php echo $row['titlle']; ?></div>
			<div class="form_item  mb-4">تكلفه الكورس : <?php echo $row['cost']; ?></div>
			<div class="form_item  mb-4">عدد النقاط : <?php echo $row['score']; ?></div>
			<div class="form_item ">الوصف : <?php echo $row['discrip']; ?></div>
                <br>
            </div>
            </div>
        </div>
        </div>  <!---- Modal End ----->		
				
				<?php
				$port = 'port'.$cours_id;
				if(isset($_POST[$port])){
					$cours_id= $_POST['cours'];
					$roll= $_POST['rolle'];
					$date_added = date("Y-m-d H:i:s");
					$cours_q = "SELECT * FROM req_cours WHERE user_id = '$admin_loggedin' AND user_roll = N'$roll' AND cours_id = '$cours_id' ORDER BY id DESC";

			$fetch_reqcours= mysqli_query($con, $cours_q);

				if(mysqli_num_rows($fetch_reqcours) > 0){
					header("Location: index.php?fcours&sorry");
		
				}else{
					$insert_query= mysqli_query($con, "INSERT INTO req_cours VALUES (default, '$admin_loggedin', N'$roll','$cours_id',default, '$date_added')");
		header("Location: index.php?fcours&success");
		
				}


		
	}
				} // end of while loop
				
				?>

				</div>
			</div>
		</div>

	</div>
    </section>


	
    
</body>
</html>