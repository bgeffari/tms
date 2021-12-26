<?php include('includes/header.php'); ?>

<?php

$get_notis_num = mysqli_query($con ,"SELECT * FROM notifics WHERE ( admin_body != 'na' ) AND ( ad_read != 'yes' )");
$noti_num = mysqli_num_rows($get_notis_num);
if($noti_num == 0){
	$noti_num = '';
}
$noti_badge = '<span class="badge badge-primary noti_badge">'.$noti_num.'</span>';

?>
					<li class="nav-item "><a href="track.php?projects">متابعة الخدمات </a></li>
					<li class="nav-item"><a href="track.php?manges">ألإدارة العامة</a></li>
					<li class="nav-item"><a href="track.php?notifics">الاشعارات <?php echo $noti_badge; ?></a></li>
					<li class="nav-item"><a href="track.php?rate">تقييم الموظفين</a></li>
					<li class="nav-item"><a href="track.php?repo"> تقاريير الموظفيين</a></li>
					<li class="nav-item"><a href="track.php?cours">  الكورسات</a></li>
					</ul>
				</div>
				</center>
			</div>
		</div>
	</header>
	<section class="admin-bg">
		<div class="container">
			<div class="content">
				<center><br><br>
					<h2>Welcome to your admin Panel</h2><br><br>
					<h4>Start Admining by Clicking one of the Functions Above ..</h4>
					
				</center>
			</div>
		</div>
	</section>
	
	
	
	
	
	
	
	
	
	
	
	
	
</body>
</html>
