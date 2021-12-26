
	<?php
	if(isset($_GET['success'])){
		$success= "تم إضافة النموذج بنجاح ! ...";
		echo "<div class='container'><div class='succ text-right' dir='rtl' style='padding-right:20px;color:#000; font-weight:900;'>" .$success ."</div></div>";
	}
	if(isset($_POST['submit_portf'])){
		$fileName= $_POST['name_file'];
		
		
    
	
    // files stuff
    if(isset($_FILES['file']['name'])){

        // count files uploaded
        $countfiles = count($_FILES['file']['name']);   
 $typeArr = explode("/", $file["type"]);
        // loop files
        for($i=0 ; $i < $countfiles ; $i++){
            $file_name = "model-".time().".".$typeArr[$i];

            if (is_uploaded_file($_FILES['file']['tmp_name'][$i]) || file_exists($_FILES['file']['tmp_name'][$i])) {
                // upload file
                move_uploaded_file($_FILES['file']['tmp_name'][$i], '../assets/models/'.$file_name);

            }
            
        }
        
        
    }
    
    
    // files end here
    
		// insert query
		$insert_query= mysqli_query($con, "INSERT INTO models VALUES (default , N'$file_name', N'$fileName')");
		header("Location: track.php?add_models&success");
		
		
	}
	
	?>
    
    <section dir="rtl">
		<div class="container"><h4 class="text-center">
		
		!قم بإضافة النماذج الان</h4></div>
        <div class="container cont">

		
	
	<form method="post" action="" enctype="multipart/form-data">
		
		
		<div class="col-md-6 mb">
			<div class="form_item"><span class="float-right">الملف : </span>
            <input type="file" class="form-control" name="file[]" multiple required>
			</div>
		</div><br>
		
		<div class="col-md-6 mb">
			<div class="form_item float-right"><span>الأسم : </span><input type="text" name="name_file" class="" required></div>
		</div><br>
		
		<div class="preview_image"><img src="" style="display: none;" class="img-thumbnail" id="required"></div><br>
		<div class="col-md-6">
		</div>
		</div>
		<br>
		
		<script>
			function preview(){
				frame.style.display = "block";
				frame.src= URL.createObjectURL(event.target.files[0]);
			}
		</script>
		

		
		
		<center><input type="submit" name="submit_portf" class="btn btn-submit" value="إضافة"></center>
		
	</form>

	</div>
	</section>

	
	
</body>
</html>