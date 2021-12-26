<?php
if(!isset($_SERVER['HTTP_REFERER'])){
	header("Location: login.php");
	exit;
}
// this php code above is to prevent direct access to this file with writing the url only without acually logging in
?>
<?php include ('../config/config.php'); ?>

<?php 
	

	if(isset($_POST['login'])){
		$username= mysqli_real_escape_string($con ,$_POST['username']);
        
        $password= mysqli_real_escape_string($con, $_POST['password']);
        $password= md5($password);
        
	}
	
	$result= mysqli_query($con , "SELECT *FROM tbl_admin WHERE username='$username' AND password='$password'");
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
			
		$_SESSION['me']= 'YES';
		$_SESSION['username']= $username;

		header('Location: index.php')		


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