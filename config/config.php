<?php
	ob_start(); // turns on output buffering helps when hosting
	
	$timezone= date_default_timezone_set("Asia/Riyadh");
	$con = mysqli_connect("localhost","awptms_Hrwatania", "Alwatania@HR", "awptms_watania");
		if(mysqli_connect_errno()){
			echo "Failed to Connect to MySQL ." .mysqli_connect_errno();
		}
session_start();
	$arabic_char = mysqli_query($con, "SET CHARACTER SET UTF8");








		

	/*************************************************************** DEVELOPED BY AbdulRahman Amer , Contact at : czool82@gmail.com ************************************************************/

?>