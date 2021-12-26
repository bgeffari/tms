<?php
if(!isset($_SERVER['HTTP_REFERER'])){
	header("Location: login.php");
	exit;
}
// this php code above is to prevent direct access to this file with writing the url only without acually logging in
?>
<?php include ('../config/config.php'); ?>

<?php 
	


	if(isset($_POST['loginadmin'])){
		$role= mysqli_real_escape_string($con ,$_POST['role']);
        
        $id= mysqli_real_escape_string($con, $_POST['username']); // name returns id
        $password= mysqli_real_escape_string($con, $_POST['password']);
		
		if($role == "des"){
			$result= mysqli_query($con , "SELECT *FROM requester WHERE ( phone='$id' AND password='$password' )");

while($m_row = mysqli_fetch_array($result)){
      $admin_id = $m_row['id'];
    }
		}elseif($role == "mar"){
			$result= mysqli_query($con , "SELECT *FROM employees WHERE ( phone='$id' AND password='$password' )");

while($m_row = mysqli_fetch_array($result)){
      $admin_id = $m_row['id'];
      $admin_id_sec = $m_row['sec_id'];
      $is_admin = $m_row['is_admin'];
    }

		}
        
	}
	
	// $result_num_adm= mysqli_num_rows($result_adm);
	$result_num= mysqli_num_rows($result);

	
	
?>




<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Connecting ..</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css">
</head>
<style>
	
	html,body{
		height: 100%;
        background-color:#0D122F;
        
	}
	.bt {
		margin: auto;
		position: absolute;
		top: 50%; left: 0; bottom: 50%; right: 0;
	}
	h2{
		color: aliceblue;
		font-family: aladin;
    }
    .btn{
        font-family: "Times New Roman";
    }
	
</style>
<body>
	
	
	<?php 
		
		if($result_num > 0){
			
		$_SESSION['role']= $role;
		$_SESSION['id']= $admin_id;
		$_SESSION['is_admin']= $is_admin;
		$_SESSION['sec_id']= $admin_id_sec;
		if ($is_admin == 'yes') {
		header('Location: index.php?projectsadm');	
		}else{
		header('Location: index.php?projects');	
		}

		?>
	
	
		<?php	
		}
		else{
			
			 ?> <div class="text-center bt"><h2>Access denied .. , Wrong Password or User Name !</h2><br><a class="btn btn-warning btn-lg" href='login.php'>Back</a></div><style>body{background-color:#650305;}</style>
			<?php
			}
?>
	
</body>
</html>