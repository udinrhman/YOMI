<?php

$username = $_POST["username"];
$fullname = $_POST["fullname"];
$email = $_POST["email"];
$password = $_POST["password"];
$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
$bio = $_POST["bio"];
$image = $_POST["image"];
$type = $_POST["type"];
$tokens = 200;

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";
// "^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" Minimum 6 characters, at least one letter and one number
$link = mysqli_connect($host, $userid, $pass, $database);

$newFullname = trim($fullname);
date_default_timezone_set("Asia/Kuala_Lumpur");

		$sql1 = "SELECT * FROM user WHERE username = '".$username."'";
		$result1 = mysqli_query($link,$sql1);
		$sql2 = "SELECT * FROM user WHERE user_email = '".$email."'";
		$result2 = mysqli_query($link,$sql2);

		
		if(empty($newFullname))
		{
			$fullname_error="Please insert your full name!";

		}
		if(mysqli_num_rows($result1)>=1)
		{
			$username_error="Username already exists!";
		}
		if(mysqli_num_rows($result2)>=1)
		{
			$email_error="Email already been registered!";
		}
		if(preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $password)==0)
		{
			$password_error="Password must contain combination of numbers and characters";
		}
		
		
		if((!empty($newFullname)) && (!mysqli_num_rows($result1)>=1) && (!mysqli_num_rows($result2)>=1) && (preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $password)))
		{
			$query="INSERT INTO user (username,user_fullname,user_email,user_password,bio,user_image,user_type,yomi_tokens,register_date) 
			VALUES ('".$username."','".$fullname."','".$email."','".$hashedpassword."','".$bio."','".$image."','".$type."','".$tokens."',CURRENT_TIMESTAMP)";
			
			$resultInsert=mysqli_query($link,$query);
			if(!$resultInsert)
					{
						die ("invalid query" . mysqli_error($link));
					}
			else if($resultInsert)
					{
						header("Location:login2.php");
					}
					
					
		}
		include("register.php");

?>