
	<div class="container">
		
		<?php
            $cours_q = "SELECT * FROM cours ORDER BY id DESC";	
            $fetch_rcours = mysqli_query($con, $cours_q);	
		?>

				
			<div class="content">
			<br>

			<div class="l_categories text-right" dir="rtl">
				
				
				<h3>الكورسات الأكثر إشتراكا</h3>
				<div class="container">

				
				<?php
				
				while ($row_c= mysqli_fetch_array($fetch_rcours)) {
                    $id = $row_c['id'];
                    $req_q = "SELECT * FROM req_cours WHERE cours_id = '$id' ORDER BY id DESC";	
                    $fetch_req = mysqli_query($con, $req_q);
                    $sum_req = mysqli_num_rows($fetch_req);	
                    if($sum_req > 0){
					echo '
<div class="row message mb-2">
      <div class="col-md-5">كورس :
          '.$row_c['titlle'].'
      </div>
      <div class="col-md-2">
          '.$row_c['cost'].' / ريال
      </div>
      
<div class="col-md-2">
          '.$row_c['score'].' / نقطة
      </div>
      
      
      <div class="col-md-3">
          <button class="btn btn-success">'.$sum_req.' إشتراك</button>
      </div>
  </div>

                    ';
                    }
					?>
				
				
				
             
							
				
				<?php

				} // end of while loop
				
				?>

				</div>
			</div>
		</div>



	</div>
    </section>


	
    
</body>
</html>