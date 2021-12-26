<?php include('../config/config.php'); ?>

<?php
if(!isset($_SERVER['HTTP_REFERER'])){
header("Location: login.php");
exit;
}
// this php code above is to prevent direct access to this file with writing the url only without acually logging in
?>


<?php
if (isset($_SESSION['role']) && $_SESSION['role']== 'mar') {
$rolle = $_SESSION['role'];
$admin_id_sec = $_SESSION['sec_id'];
if(isset($_SESSION['role'])){
$admin_loggedin= $_SESSION['id'];
$is_adm = $_SESSION['is_admin'];

}else{
header("Location: login.php");
}
}elseif(isset($_SESSION['role']) == 'des'){

if(isset($_SESSION['role'])){
$admin_loggedin= $_SESSION['id'];
$is_adm = $_SESSION['is_admin'];
}else{
header("Location: login.php");
}
$rolle = $_SESSION['role'];
}
if(isset($_SESSION['role']) && $_SESSION['role'] == "des"){
$name_q = mysqli_query($con, "SELECT * FROM requester WHERE id = '$admin_loggedin'");

$fetch_admin = mysqli_fetch_array($name_q);
$logged_name = $fetch_admin['name'];
$logged_phone = $fetch_admin['phone'];

}elseif(isset($_SESSION['role']) && $_SESSION['role']== "mar"){
$name_q = mysqli_query($con, "SELECT * FROM employees WHERE id = '$admin_loggedin'");

$fetch_admin = mysqli_fetch_array($name_q);
$is_admin = $fetch_admin['is_admin'];
$sec_id = $fetch_admin['sec_id'];
$logged_name = $fetch_admin['name'];
$logged_rate = $fetch_admin['rate'];
$logged_phone = $fetch_admin['phone'];
//get section name
$section_q = mysqli_query($con, "SELECT * FROM section WHERE id = '$sec_id'");
$fetch_sec = mysqli_fetch_array($section_q);
$sec_name = $fetch_sec['name'];
}
?>
<?php
// update pass stuff
if(isset($_POST['update_pass'])){
$newpass = $_POST['pass'];
$newpass = md5($newpass);

// update pass
if($rolle == "des"){
$update_pass = mysqli_query($con, "UPDATE requester SET password = '$newpass' WHERE id='$admin_loggedin'");

}elseif($rolle == "mar"){
$update_pass = mysqli_query($con, "UPDATE employees SET password = '$newpass' WHERE id='$admin_loggedin'");
}
header("Location: index.php?projects&success");
}

?>



<!doctype html>
<html dir="rtl">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" >
<meta name="viewport" content="width= device-width , initial-scale= 1">
<meta charset="utf-8">


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="../assets/css/rate.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.css">

<script src="../assets/script/jquery.min.js"></script>
<script src="../assets/script/popper.js"></script>
<script src="../assets/script/bootstrap.min.js"></script>
<script src="../admin/js/bootbox.min.js"></script>



<style>
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap');
*{
font-family: 'Tajawal', sans-serif;
}
.float-r{
      float: right !important;
     }
     .float-l{
      float: left !important;
     }
     .activ{
        color: gold;
     }
     ul{
      float: left;
        line-height: 3;
     }

     ul li{
        font-size: 10px;
        direction: rtl;
     }
     h4{
      line-height: 2
     }
     .rating-stars ul > li.star.select > i.fa{
        color:gold;
     }
     .portfb .p_image img{
    max-height: 200px;
}
</style>


<title>Private</title>
</head>

<body style="background-color: rgb(0,0,120,0.1);">




<header class="header">
<div class="container-fluid np">
<div class="topbar">
<a href="index.php?projects"><img class="mb-4 fl" src="imgs/logoo.png"  height="60"></a>
<div title="Log out" class="logout">
<div class="dropdown show">
<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<img src="imgs/icons/profile.png" height="19">
<?php echo $logged_name  ; ?> / <span> التقيم : <?php echo $logged_rate;?> %</span>
</a>

<div class="dropdown-menu drp" aria-labelledby="dropdownMenuLink">
<a class="dropdown-item" href="" data-toggle="modal" data-target="#password_modal">تغيير كلمة المرور</a>
<a class="dropdown-item" href="logout.php">
<div class="text-center">
<img src="imgs/logout.png" height="19">
خروج
</div>
</a>
</div>
</div>
</div>

<h2 class="welcome text-center">مرحبا بك  <?php
 if (isset($is_admin) && $is_admin == 'yes') {
 echo '  '.$logged_name .'  رئيس قسم '.$sec_name; 
 }elseif ( isset($is_admin) && $is_admin =="") {
 echo $logged_name; 
 }else{
 echo $logged_name; 
 }

 ?>! </h2>
