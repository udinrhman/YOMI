<?php

$username = $_POST["username"];
$password = $_POST["password"];


$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

$newUsername = trim($username);

		$sql1 = "SELECT * FROM user WHERE username = '".$username."'";
		$result = mysqli_query($link,$sql1);
        $row = mysqli_fetch_array($result, MYSQLI_BOTH);
		if(empty($newUsername)) 	//to check if the username is empty or not
		{
			$username_error="Please insert your username!";

        }elseif(mysqli_num_rows($result)==0)
        {
            $username_error="Wrong username or password!";
        }
        elseif(password_verify($password, $row["user_password"])==0) 	// 0 = false , 1 = True;
        {
            $password_error="Wrong username or password!";
        }
        if ( (!empty($newUsername)) && (!mysqli_num_rows($result)==0) && (password_verify($password, $row["user_password"])) )
        {
            session_start();
			$_SESSION["username"] = $username;
			$_SESSION["type"] = $row["user_type"];
			if ($_SESSION["type"] == "admin")
			{
				header("Location:admin/dashboard.php");
			}
			else
			{
				header("Location:userHomepage.php");
			}
        }
        include("login.php");
?>