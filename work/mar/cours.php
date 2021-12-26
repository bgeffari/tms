
	<?php
	if(isset($_GET['success'])){
		$success= "تم إضافة الكورس بنجاح ! ...";
		echo "<div class='container'><div class='succ text-right' dir='rtl' style='padding-right:20px;color:#000; font-weight:900;'>" .$success ."</div></div>";
	}
	if(isset($_POST['submit_cours'])){
		$title= $_POST['title'];
		$cost= $_POST['cost'];
		$linke= $_POST['linke'];
		$score= $_POST['score'];
		$discrip= $_POST['discrip'];

	
    // files stuff
    if(isset($_FILES['file']['name'])){

        // count files uploaded
        $countfiles = count($_FILES['file']['name']);
         $typeArr = explode("/", $file["type"]);
        // loop files
        for($i=0 ; $i < $countfiles ; $i++){
            $file_name = "cours-".time().".".$typeArr[$i];
            if (is_uploaded_file($_FILES['file']['tmp_name'][$i]) || file_exists($_FILES['file']['tmp_name'][$i])) {
                // upload file
                move_uploaded_file($_FILES['file']['tmp_name'][$i], '../assets/courses/'.$file_name);

            }
            
        }
        
        
    }
    $imge = $file_name;
    
    // files end here
    
		// insert query
		$insert_query= mysqli_query($con, "INSERT INTO cours VALUES (default , N'$title', N'$discrip', '$score', '$linke' , N'$imge' , '$cost')");
		header("Location: index.php?cours&success");
		
		
	}
	
	?>
    
    <section dir="rtl">
		<div class="container"><h4 class="text-center">!قم بإضافة الكورسات الان</h4></div>
        <div class="container cont">

		
	
	<form method="post" action="" enctype="multipart/form-data">
		
		
		<div class="col-md-12 mb">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
			<div class="form_item col-md-12 mb-5"><span class="float-right"> صوره رمزيه: </span>
            <input type="file" class="form-control" name="file[]" multiple onchange="preview()" required>
		</div><br>
		
		
			
			<div class="form_item col-md-6 mb-4"><input type="text" name="title"  value="" placeholder="العنوان .." required></div>
			<div class="form_item col-md-6 mb-4"><input type="text" name="cost"  placeholder="المبلغ .." required></div>
			<div class="form_item col-md-6 mb-4"><input type="text" name="score"  placeholder="النقاط .." required></div>
			<div class="form_item col-md-6 mb-4"><input type="text" name="linke"  placeholder="الرابط .." required></div>
			<div class="form_item col-md-12"><textarea name="discrip" col="90" class="form-control" placeholder="الوصف .."></textarea></div>
			<div class="col-md-12"><input type="submit" name="submit_cours" class="btn btn-success col-md-12" value="إضافة"></div>
		</div>
		</div><br>
		<div class="col-md-6">
		<div class="preview_image col-md-12"><img src="" style="display: none;" class="img-thumbnail" id="frame"></div><br>
		
		</div>
		</div>
		</div>
		<br>
		
		<script>
		
			function preview(){
				frame.style.display = "block";
				frame.src= URL.createObjectURL(event.target.files[0]);
			}
			$(".title").change(function(){
				$("#t").text(title);
				$(".testt").val() = "tt";
			});
		</script>
		

		
		
		
		
	</form>

	</div>
	</section>

	
	
</body>
</html>