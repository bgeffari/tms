
	<div class="container">
		
		<?php
		
	

			$cours_q = "SELECT * FROM cours ORDER BY id DESC";
		
		?>
		<div class="content">
			<br>
			
			
			<div class="l_categories text-right" dir="rtl">
				
				
				<h3>قائمة الكورسات  المضافة :</h3>
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
				
					?>
					


					
				

				<div class="col-md-4">
				<div class="card mb-5" style="width: 18rem;">
					<img class="card-img-top" src="../assets/courses/<?php echo $cours_image; ?>" alt="Card image cap" style="max-height:300px;">
					<div class="card-body">
						<h5 class="card-title"><?php echo $cours_name; ?><br><?php echo $row['cost']; ?>ريال/ <?php echo $row['score']; ?>نقاط</h5>
						<p class="card-text" style="max-height: 120px; overflow:hidden; min-height:120px;"><?php echo $row['discrip']; ?></p>
						<button class="btn btn-primary" data-toggle="modal" data-target="#show<?php echo $cours_id; ?>">العرض و التعديل</button>
					</div>
				</div>
				</div>
				<br>
				
                <script>
					$(document).ready(function(){

						$('#delete<?php echo $cours_id; ?>').on('click', function(){
							
							bootbox.confirm("هل انت واثق بحذفك لهذا الكورس ?", function(result){

								if(result == true){
								
									$.post("handlers/delete_cours.php?cours_id=<?php echo $cours_id; ?>", {result:result});
									window.location.reload();
								}
							});

						});


					}); // end of all document.ready
				</script>

					
				<!-- Modal -->
				<div class="modal fade" id="show<?php echo $cours_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اسم الكورس : <?php echo $row['titlle']; ?></h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
			<form action="#" method="POST">
			<div class="form_item  mb-4"><input type="text" name="title"  value="<?php echo $row['titlle']; ?>" placeholder="العنوان .." required></div>
			<div class="form_item  mb-4"><input type="text" name="cost" value="<?php echo $row['cost']; ?>" placeholder="المبلغ .." required></div>
			<div class="form_item  mb-4"><input type="text" name="score"  value="<?php echo $row['score']; ?>" placeholder="النقاط .." required></div>
			<div class="form_item  mb-4"><input type="text" name="linke" value="<?php echo $row['linke']; ?>" placeholder="الرابط .." required></div>
			<div class="form_item "><textarea name="discrip" col="90" class="form-control" placeholder="الوصف .."><?php echo $row['discrip']; ?></textarea></div>
                <br>
            </div>
            <div class="modal-footer">
			<button type="submit" name="update<?php echo $cours_id; ?>" class="btn btn-success">تعديل </button>  
				</form>
				<button id="delete<?php echo $cours_id; ?>" class="btn btn-danger">حذف </button>
            </div>
            </div>
        </div>
        </div>  <!---- Modal End ----->
							
				
				<?php
					$update = 'update'.$cours_id;
					if(isset($_POST[$update])){
						$title= $_POST['title'];
						$cost= $_POST['cost'];
						$linke= $_POST['linke'];
						$score= $_POST['score'];
						$discrip= $_POST['discrip'];
						// delte Query
						$update_query = mysqli_query($con, "UPDATE cours SET titlle = N'$title' , discrip = N'$discrip' , score = '$score' , linke = N'$linke' , cost = '$cost' WHERE id = '$cours_id' ");
						header('Refresh: 0');
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