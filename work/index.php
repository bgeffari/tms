<?php include('includes/header.php'); 

?>

</div>
</div>
</header>
<?php


$options = "id = 0"; //something that is always false
$get_all_adm = mysqli_query($con, "SELECT * FROM notifics WHERE origin = 'adm' ");
while($adn_row = mysqli_fetch_array($get_all_adm)){
    if($rolle == "mar"){
        $options = "origin = 'adm' AND to_id = '".$admin_loggedin."'";
        
    }else{
        $options = "origin = 'adm' AND from_id = '".$admin_loggedin."'";
    }
}


if($rolle == "mar"){



$get_notis_num = mysqli_query($con ,"SELECT * FROM notifics WHERE ( (to_id = '$admin_loggedin' AND origin = 'req') OR ($options) ) AND ( if_read != 'yes' )");
}else{
$get_notis_num = mysqli_query($con ,"SELECT * FROM notifics WHERE ( (to_id = '$admin_loggedin' AND origin = 'emp') OR ($options) ) AND ( if_read != 'yes' )");
}


$noti_num = mysqli_num_rows($get_notis_num);
if($noti_num == 0){
$noti_num = '';
}
$noti_badge = '<span class="badge badge-primary noti_badge">'.$noti_num.'</span>';

?>

<?php
if($rolle == "mar" && $is_adm == 'no'){
?>

<nav class="navbar navbar-expand-md navbar-light bg-light" id="innerNav">
        <div class="container">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#innernav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="innernav">
<ul class="navbar-nav">
<?php
if(isset($_GET['projects'])){
echo '<li class="nav-item"><a href="index.php?projects" class="nav-link actv">المهام الجديده</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?projects" class="nav-link">المهام الجديده</a></li>';
}

if(isset($_GET['add_p'])){
echo '<li class="nav-item"><a href="index.php?add_p" class="nav-link actv">المهام المنجزة</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?add_p" class="nav-link">المهام المنجزة</a></li>';
}


if(isset($_GET['notifics'])){
echo '<li class="nav-item"><a href="index.php?notifics" class="nav-link actv">الاشعارات</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?notifics" class="nav-link">الاشعارات'.$noti_badge.'</a></li>';
}


if(isset($_GET['fcours'])){
echo '<li class="nav-item"><a href="index.php?fcours" class="nav-link actv">متابعة الكورسات</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?fcours" class="nav-link">متابعة الكورسات</a></li>';
}
?>

</ul>
</div>
        </div>
</nav>

<?php
}elseif($rolle == "mar" && $is_adm == 'yes'){
?>

<nav class="navbar navbar-expand-md navbar-light bg-light" id="innerNav">
        <div class="container">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#innernav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="innernav">
<ul class="navbar-nav">
<?php
if(isset($_GET['projectsadm']) || isset($_GET['edit_proj']) ){
echo '<li class="nav-item"><a href="index.php?projectsadm" class="nav-link actv">متابعة المهام الجديده</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?projectsadm" class="nav-link">متابعة المهام الجديده</a></li>';
}
if(isset($_GET['projects']) ){
echo '<li class="nav-item"><a href="index.php?projects" class="nav-link actv">المهام اليوميه</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?projects" class="nav-link">المهام اليوميه</a></li>';
}

if(isset($_GET['add_p'])){
echo '<li class="nav-item"><a href="index.php?add_p" class="nav-link actv">استعراض المهام المنجزة</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?add_p" class="nav-link">استعراض المهام المنجزة</a></li>';
}

if(isset($_GET['emp'])){
echo '<li class="nav-item"><a href="index.php?emp" class="nav-link actv">متابعه موظفي القسم</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?emp" class="nav-link">متابعه موظفي القسم</a></li>';
}


if(isset($_GET['notifics'])){
echo '<li class="nav-item"><a href="index.php?notifics" class="nav-link actv">الاشعارات</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?notifics" class="nav-link">الاشعارات'.$noti_badge.'</a></li>';
}


if(isset($_GET['fcours'])){
echo '<li class="nav-item"><a href="index.php?fcours" class="nav-link actv">متابعة الكورسات</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?fcours" class="nav-link">متابعة الكورسات</a></li>';
}

if ($admin_id_sec == 27) {
  if(isset($_GET['cours'])){
echo '<li class="nav-item"><a href="index.php?cours" class="nav-link actv">إضافة كورس</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?cours" class="nav-link">إضافة كورس</a></li>';
}
if(isset($_GET['vcours'])){
echo '<li class="nav-item"><a href="index.php?vcours" class="nav-link actv">الكورسات المضافة</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?vcours" class="nav-link">الكورسات المضافة</a></li>';
}
if(isset($_GET['rcours'])){
echo '<li class="nav-item"><a href="index.php?rcours" class="nav-link actv">طلبات الكورسات</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?rcours" class="nav-link">طلبات الكورسات</a></li>';
}

}

?>

</ul>
</div>
        </div>
</nav>

<?php
}
elseif($rolle == "des"){
?>

<nav class="navbar navbar-expand-md navbar-light bg-light" id="innerNav">
        <div class="container">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#innernav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="innernav">
<ul class="navbar-nav">
<?php
if(isset($_GET['projects']) || isset($_GET['designs'])){
echo '<li class="nav-item"><a href="index.php?projects" class="nav-link actv">المهام المقدمة</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?projects" class="nav-link">المهام المقدمة</a></li>';
}

if(isset($_GET['add_p'])){
echo '<li class="nav-item"><a href="index.php?add_p" class="nav-link actv">أضف طلب</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?add_p" class="nav-link">أضف طلب</a></li>';
}


if(isset($_GET['models'])){
echo '<li class="nav-item"><a href="index.php?models" class="nav-link actv">تحميل نموذج</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?models" class="nav-link">تحميل نموذج</a></li>';
}


if(isset($_GET['notifics'])){
echo '<li class="nav-item"><a href="index.php?notifics" class="nav-link actv">الاشعارات</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?notifics" class="nav-link">الاشعارات'.$noti_badge.'</a></li>';
}

if(isset($_GET['fcours'])){
echo '<li class="nav-item"><a href="index.php?fcours" class="nav-link actv">متابعة الكورسات</a></li>';
}else{
echo '<li class="nav-item"><a href="index.php?fcours" class="nav-link">متابعة الكورسات</a></li>';
}
?>
</ul>
</div>
        </div>
</nav>

</ul>
</div>
        </div>
</nav>

<?php
}
?>

<?php
if($rolle == "mar" && $is_adm == 'no' ){
if(isset($_GET['projects'])){
include "mar/projects.php";
}elseif(isset($_GET['add_p'])){
include "mar/projectsfnish.php";
}elseif(isset($_GET['notifics'])){
include "mar/notifics.php";
}elseif(isset($_GET['edit_proj'])){
    include "mar/edit_proj.php";
  }elseif(isset($_GET['fcours'])){
    include "fcours.php";
  }
}elseif($rolle == "mar" && $is_adm == 'yes'){
if(isset($_GET['projectsadm'])){
include "mar/projectsadm.php";
}elseif(isset($_GET['notifics'])){
include "mar/notifics.php";
}elseif(isset($_GET['edit_proj'])){
  include "mar/edit_proj.php";
}elseif(isset($_GET['add_p'])){
  include "mar/projectsfnishadm.php";
}elseif(isset($_GET['projects'])){
include "mar/projects.php";
}elseif(isset($_GET['emp'])){
include "mar/doers.php";
}elseif(isset($_GET['cours'])){
include "mar/cours.php";
}elseif(isset($_GET['vcours'])){
include "mar/vcours.php";
}elseif(isset($_GET['rcours'])){
include "mar/rcours.php";
}elseif(isset($_GET['fcours'])){
    include "fcours.php";
  }
}elseif($rolle == "des"){
if(isset($_GET['projects'])){
include "des/projects.php";
}elseif(isset($_GET['add_p'])){
include "des/add_pro.php";
}elseif(isset($_GET['models'])){
include "des/models.php";
}elseif(isset($_GET['notifics'])){
  include "des/notifics.php";

}elseif(isset($_GET['fcours'])){
    include "fcours.php";
  }
}

?>









</body>
</html>
<!-- Change pass Modal -->
<div class="modal fade" id="password_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">تغيير كملة المرور :</h5>
      </div>
      <div class="modal-body">
        <form action="" method="post">
<div class="form-group">
<input type="password" class="form-control" name="pass" placeholder="كلمة المرور الجديدة .." required autofocus>
</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>&nbsp;
<button type="submit" class="btn btn-goo" name="update_pass">تحديث</button>
</form>
      </div>
    </div>
  </div>
</div>