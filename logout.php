<?php
session_start();
if (isset($_SESSION["username"]))
	{
		session_unset();
		session_destroy();
		
		header('Location:login.php');
	}
else
{
	echo "No session exists or session is expired. Please Log in again";
	echo "<br> Click <a href='Login.html'> here </a> to LOGIN again.";
	
}
?>

