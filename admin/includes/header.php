<?php
if(!isset($_SERVER['HTTP_REFERER'])){
	header("Location: login.php");
	exit;
}
// this php code above is to prevent direct access to this file with writing the url only without acually logging in
?>
<?php include('../config/config.php'); ?>
<?php
if(isset($_SESSION['username'])){
		$admin_loggedin = $_SESSION['username'];
		
	}else{
	header("Location: login.php");
}
	
?>

<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" >
<meta name="viewport" content="width= device-width , initial-scale= 1">
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/styless.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" integrity="sha512-F5QTlBqZlvuBEs9LQPqc1iZv2UMxcVXezbHzomzS6Df4MZMClge/8+gXrKw2fl5ysdk4rWjR0vKS7NNkfymaBQ==" crossorigin="anonymous"></script>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap');
	*{
		font-family: 'Tajawal', sans-serif!important;
	}
	.act {
	    background-color:#218838 !important ;
	} 
	.bootbox-body{
		float: right;
		padding-right: 10px;
	}
</style>




<title>Admin@Private</title>
</head>

<body style="background-color: rgb(0,0,120,0.1);" dir="rtl">
	
	
	<header class="header">
		<div class="container-fluid np">
			<div class="topbar">
				<a href="index.php"><img class="mb-4 fl" src="imgs/logoo.png"  height="50"></a>
				<div title="Log out" class="logout"><a href="logout.php"><img src="imgs/logout.png" height="19"></a></div>
				<center>
				<h2 class="welcome">Welcome Back  .. ! 
				</h2>
				<div class="menu">
					<ul>
					