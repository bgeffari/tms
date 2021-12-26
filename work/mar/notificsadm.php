<section dir="rtl"><br>
<div class="container">
    <label class="float-right">الاشعارات :</label>
    <br><br>
    <div class="notifi_box">
        <!-- Notifications Rows Here -->
        <!-- Projects rows -->
        <div id="load_data">
            <!------  here is where the Notifications are fetched   ------>
        </div>
    </div>
</div>
</section>

<script>

$(document).ready(function(){
 
 var limit = 25;
 var start = 0;
 var action = 'inactive';
 function load_country_data(limit, start)
 {
  $.ajax({
   url:"mar/fetch_notiadm.php",
   method:"POST",
   data:{limit:limit, start:start},
   cache:false,
   success:function(data)
   {
    $('#load_data').append(data);
    if(data == '')
    {
     action = 'active';
    }
    else
    {
     action = "inactive";
    }
   }
  });
 }

 if(action == 'inactive')
 {
  action = 'active';
  load_country_data(limit, start);
 }
 $(window).scroll(function(){
  if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
  {
   action = 'active';
   start = start + limit;
   setTimeout(function(){
    load_country_data(limit, start);
   }, 1000);
  }
 });
 
});
</script>


<?php
if(isset($_GET['notifics'])){
    $update_noti = mysqli_query($con ,"UPDATE notifics SET ad_read = 'yes' WHERE ( admin_body != 'na' )");

}

?>