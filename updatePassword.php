<?php
$username = $_POST["username"];
$newPassword = $_POST["newPassword"];
$confirmPassword = $_POST["confirmPassword"];
$hashedpassword = password_hash($newPassword, PASSWORD_DEFAULT);

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

		if(empty($newPassword) || empty($confirmPassword))
		{
			$password_error="Please insert your new password!";
		}

		if(!empty($newPassword))
        {
            if(preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $newPassword)==0) //Minimum 6 characters, at least one letter and one number
            {
                $password_error="Password must contain combination of numbers and characters!";
            }
            if($confirmPassword != $newPassword)
            {
                $password_error2 = "Passwords do not match!";
            }
        }
		
		
		if((preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $newPassword)) && ($confirmPassword == $newPassword))
		{
			$query="UPDATE user SET user_password = '$hashedpassword' WHERE username = '$username' ";
			
			$resultInsert=mysqli_query($link,$query);
			if(!$resultInsert)
					{
						die ("invalid query" . mysqli_error($link));
					}
			else if($resultInsert)
					{
						header("Location:profile.php");
					}
					
					
		}
        include("editProfile.php");

?>