<?php

include "../config/config.php";

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Admin Login</title>

    
	  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    
    <script src="../assets/script/jquery.min.js"></script>
	  <link rel="stylesheet" type="text/css" href="css/style.css">

    


    <style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap');

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
		
		html,
body {
  height: 100%;
  direction: rtl;
  text-align: right;
  
}
*{
	font-family: 'Tajawal', sans-serif;
}
body {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color:#dae0e5;
  
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
		.h3{
			color: black!important;
		}	
		.btn-primary{
		background-color: #7585B3;
		transition: ease 1s;
	}
  .messagePhone{
    color: #000;
    text-align: right;
  }
    </style>
      </head>
  <body class="text-center">
	  <form action="access.php" class="form-signin" method="post">
      <img class="mb-4" src="imgs/logoo.png"  height="72">
      <h1 class="h3 mb-3 font-weight-normal">الدخول</h1>

      <select name="role" id="role" class="form-control py-2" required>
        <option disabled selected value>الدور ..</option>
        <option value="des">طالب خدمة</option>
        <option value="mar">مقدم خدمة</option>
			
      </select>
      <div class="messagePhone"><p>الرجاء إدخال الرقم الصحيح ..!</p></div>
                  <input type="text" id="inputEmail" class="form-control" placeholder="رقم الهاتف" name="username" required autofocus>
			

		  
		  <input type="password" id="inputPassword" class="form-control" name="password" placeholder="كلمة المرور" required>
		  
		  <button class="btn btn-lg btn-warning btn-block" name="login" type="submit">أدخل</button>
		  <p class="mt-5 mb-3 text-muted">&copy; Private</p>
    </form>
   
</body>

</html>
