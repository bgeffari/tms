<?php include('includes/header.php'); ?>

<?php

$get_notis_num = mysqli_query($con ,"SELECT * FROM notifics WHERE ( admin_body != 'na' ) AND ( ad_read != 'yes' )");
$noti_num = mysqli_num_rows($get_notis_num);
if($noti_num == 0){
	$noti_num = '';
}
$noti_badge = '<span class="badge badge-primary noti_badge">'.$noti_num.'</span>';

?>

				<?php
						if (isset($_GET['projects'])) {
						echo '
						<li class="nav-item pro"><a href="track.php?projects" class="active">متابعة الخدمات </a></li>
						<li class="nav-item mange"><a href="track.php?manges" >ألإدارة العامة</a></li>
						<li class="nav-item mange"><a href="track.php?notifics" > الاشعارات'.$noti_badge.'</a></li>
						<li class="nav-item"><a href="track.php?rate">تقييم الموظفين</a></li>
						<li class="nav-item"><a href="track.php?repo">تقارير الموظفين</a></li>
						<li class="nav-item"><a href="track.php?cours">الكورسات</a></li>
						';
						}elseif (isset($_GET['manges']) || isset($_GET['doers']) || isset($_GET['c_service']) || isset($_GET['sections']) || isset($_GET['add_models']) || isset($_GET['models'])) {
							echo '
						<li class="nav-item pro"><a href="track.php?projects" >متابعة الخدمات </a></li>
						<li class="nav-item mange"><a href="track.php?manges" class="active">ألإدارة العامة</a></li>
						<li class="nav-item mange"><a href="track.php?notifics" >الاشعارات'.$noti_badge.'</a></li>
						<li class="nav-item"><a href="track.php?rate">تقييم الموظفين</a></li>
						<li class="nav-item"><a href="track.php?repo">تقارير الموظفين</a></li>
						<li class="nav-item"><a href="track.php?cours">الكورسات</a></li>
						';
						}elseif(isset($_GET['notifics'])){
							echo '
						<li class="nav-item pro"><a href="track.php?projects" >متابعة الخدمات </a></li>
						<li class="nav-item mange"><a href="track.php?manges" >ألإدارة العامة</a></li>
						<li class="nav-item mange"><a href="track.php?notifics" class="active">الاشعارات</a></li>
						<li class="nav-item"><a href="track.php?rate" >تقييم الموظفين</a></li>
						<li class="nav-item"><a href="track.php?repo">تقارير الموظفين</a></li>
						<li class="nav-item"><a href="track.php?cours">الكورسات</a></li>
						';
						}elseif(isset($_GET['rate'])){
							echo '
						<li class="nav-item pro"><a href="track.php?projects" >متابعة الخدمات </a></li>
						<li class="nav-item mange"><a href="track.php?manges" >ألإدارة العامة</a></li>
						<li class="nav-item mange"><a href="track.php?notifics">الاشعارات</a></li>
						<li class="nav-item"><a href="track.php?rate" class="active">تقييم الموظفين</a></li>
						<li class="nav-item"><a href="track.php?repo">تقارير الموظفين</a></li>
						<li class="nav-item"><a href="track.php?cours">الكورسات</a></li>

						';
						}elseif(isset($_GET['repo'])){
							echo '
						<li class="nav-item pro"><a href="track.php?projects" >متابعة الخدمات </a></li>
						<li class="nav-item mange"><a href="track.php?manges" >ألإدارة العامة</a></li>
						<li class="nav-item mange"><a href="track.php?notifics">الاشعارات</a></li>
						<li class="nav-item"><a href="track.php?rate" >تقييم الموظفين</a></li>
						<li class="nav-item"><a href="track.php?repo" class="active">تقارير الموظفين</a></li>
						<li class="nav-item"><a href="track.php?cours">الكورسات</a></li>
						';
						}elseif(isset($_GET['cours']) || isset($_GET['vcours']) || isset($_GET['rcours']) || isset($_GET['bcours'])){
							echo '
						<li class="nav-item pro"><a href="track.php?projects" >متابعة الخدمات </a></li>
						<li class="nav-item mange"><a href="track.php?manges" >ألإدارة العامة</a></li>
						<li class="nav-item mange"><a href="track.php?notifics">الاشعارات</a></li>
						<li class="nav-item"><a href="track.php?rate" >تقييم الموظفين</a></li>
						<li class="nav-item"><a href="track.php?repo" >تقارير الموظفين</a></li>
						<li class="nav-item"><a href="track.php?cours" class="active">الكورسات</a></li>
						';
						}
						?>
                   
						
					</ul>
					<script type="text/javascript">
					$(".pro")click(function(){
						$(".pro").addClass("active");
						$(".mange").removeClass("active");

					})


					</script>
				</div>
				</center>
			</div>
		</div>
	</header>
	<script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
	<script src="js/bootbox.min.js"></script>    
    

    <section dir="rtl">
		<nav class="navbar navbar-expand-md navbar-light bg-light" id="innerNav">
        <div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#innernav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse " id="innernav">
				<?php 
				if (isset($_GET['projects'])) {
				}elseif (isset($_GET['manges']) || isset($_GET['doers']) || isset($_GET['c_service']) || isset($_GET['sections']) || isset($_GET['add_models']) || isset($_GET['models'])|| isset($_GET['edit_section'])|| isset($_GET['edit_miss'])) {
				?>
				<ul class="navbar-nav ">
					<?php
					$cash = '';
					if(isset($_GET['manges']) ){
						echo '<li class="nav-item"><a href="track.php?manges" class="nav-link actv">طالبي الخدمات</a></li>';
					}else{
						echo '<li class="nav-item"><a href="track.php?manges" class="nav-link">طالبي الخدمات</a></li>';
					}

					if(isset($_GET['doers'])){
						echo '<li class="nav-item"><a href="track.php?doers" class="nav-link actv">موظفي الخدمات</a></li>';
					}else{
						echo '<li class="nav-item"><a href="track.php?doers" class="nav-link">موظفي الخدمات</a></li>';
					}

					
					if(isset($_GET['c_service']) || isset($_GET['edit_miss'])){
						echo '<li class="nav-item"><a href="track.php?c_service" class="nav-link actv">الأقسام</a></li>';
					}else{
						echo '<li class="nav-item"><a href="track.php?c_service" class="nav-link">الأقسام</a></li>';
					}

					if(isset($_GET['sections']) || isset($_GET['edit_section'])){
						echo '<li class="nav-item"><a href="track.php?sections" class="nav-link actv">المهام</a></li>';
					}else{
						echo '<li class="nav-item"><a href="track.php?sections" class="nav-link">المهام</a></li>';
					}

					if(isset($_GET['add_models'])){
						echo '<li class="nav-item"><a href="track.php?add_models" class="nav-link actv">إضافة نموذج</a></li>';
					}else{
						echo '<li class="nav-item"><a href="track.php?add_models" class="nav-link">إضافة نموذج</a></li>';
					}

				
					if(isset($_GET['models'])){
						echo '<li class="nav-item"><a href="track.php?models" class="nav-link actv">النماذج المضافة</a></li>';
					}else{
						echo '<li class="nav-item"><a href="track.php?models" class="nav-link">النماذج المضافة</a></li>';
					}

					
					
					?>
					
				</ul>
				<?php }elseif(isset($_GET['cours']) || isset($_GET['vcours']) || isset($_GET['rcours']) || isset($_GET['bcours'])){
					?>
					<ul class="navbar-nav ">
					<?php
					$cash = '';
					if(isset($_GET['cours']) ){
						echo '<li class="nav-item"><a href="track.php?cours" class="nav-link actv"> إضافة كورس</a></li>';
					}else{
						echo '<li class="nav-item"><a href="track.php?cours" class="nav-link">إضافة كورس</a></li>';
					}

					if(isset($_GET['vcours'])){
						echo '<li class="nav-item"><a href="track.php?vcours" class="nav-link actv">عرض الكورسات</a></li>';
					}else{
						echo '<li class="nav-item"><a href="track.php?vcours" class="nav-link">عرض الكورسات</a></li>';
					}

					if(isset($_GET['rcours'])){
						echo '<li class="nav-item"><a href="track.php?rcours" class="nav-link actv">عرض الطلبات</a></li>';
					}else{
						echo '<li class="nav-item"><a href="track.php?rcours" class="nav-link">عرض الطلبات</a></li>';
					}

					if(isset($_GET['bcours'])){
						echo '<li class="nav-item"><a href="track.php?bcours" class="nav-link actv">الأكثر إشتراكا</a></li>';
					}else{
						echo '<li class="nav-item"><a href="track.php?bcours" class="nav-link">الأكثر إشتراكا</a></li>';
					}
					
					
					?>
					
				</ul>
					<?php
				}
				?>
			</div>
        </div>
        </nav>
	</section>

	<?php
	if(isset($_GET['manges'])){
		include "track/manges.php";
	}elseif(isset($_GET['doers'])){
		include "track/doers.php";
	}elseif(isset($_GET['edit_proj'])){
		include "track/edit_proj.php";
	}elseif(isset($_GET['c_service'])){
		include "track/c_service.php";
	}elseif(isset($_GET['edit_section'])){
		include "track/edit_section.php";
	}elseif(isset($_GET['edit_miss'])){
		include "track/edit_miss.php";
	}elseif(isset($_GET['sections'])){
		include "track/sections.php";
	}elseif(isset($_GET['projects'])){
		include "track/projects.php";
	}elseif(isset($_GET['models'])){
		include "track/manage_model.php";
	}elseif(isset($_GET['add_models'])){
		include "track/add_model.php";
	}elseif(isset($_GET['notifics'])){
		include "track/notifics.php";
	}elseif(isset($_GET['rate'])){
		include "track/rate.php";
	}elseif(isset($_GET['repo'])){
		include "track/repo.php";
	}elseif(isset($_GET['cours'])){
		include "track/cours.php";
	}elseif(isset($_GET['vcours'])){
		include "track/vcours.php";
	}elseif(isset($_GET['rcours'])){
		include "track/rcours.php";
	}elseif(isset($_GET['bcours'])){
		include "track/bcours.php";
	}

	?>


	
	
</body>
</html>