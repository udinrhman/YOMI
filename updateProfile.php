<?php
$username = $_POST["username"];
$fullname = addslashes($_POST['fullname']);
$email = $_POST["email"];
$oriEmail = $_POST["oriEmail"];
$bio = addslashes($_POST['bio']);

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

$newFullname = trim($fullname);
$newEmail = trim($email);

$sql1 = "SELECT * FROM user WHERE username = '" . $username . "'";
$result1 = mysqli_query($link, $sql1);
$sql2 = "SELECT * FROM user WHERE user_email = '$email'";
$result2 = mysqli_query($link, $sql2);
$sql3 = "SELECT * FROM user WHERE user_email = '" . $oriEmail . "'";
$result3 = mysqli_query($link, $sql3);

$row = mysqli_fetch_array($result2);
$row3 = mysqli_fetch_array($result3);
if (empty($newFullname) && empty($newEmail) && empty($bio)) {
	$fullname_error = "Please insert your full name!";
	$email_error = "Please insert your email!";
	$bio_error = "Please insert something!";
} else {
	if ($email == $oriEmail) {
		$email_error = "Email already been registered!";
	}
	else if (mysqli_num_rows($result2) >= 1) {
		$email_error = "Email already been registered!";
	}
}

if ((!empty($newFullname)) && (empty($newEmail)) && (empty($bio))) {
	$query = "UPDATE user SET user_fullname = '$fullname' WHERE username= '$username'";

	$resultInsert = mysqli_query($link, $query);
	if (!$resultInsert) {
		die("invalid query" . mysqli_error($link));
	} else if ($resultInsert) {
		header("Location:profile.php");
	}
}
if ((!empty($newFullname)) && (!empty($newEmail)) && (empty($bio)) && (mysqli_num_rows($result2) == 0)) {
	$query = "UPDATE user SET user_fullname = '$fullname', user_email = '$email' WHERE username= '$username'";

	$resultInsert = mysqli_query($link, $query);
	if (!$resultInsert) {
		die("invalid query" . mysqli_error($link));
	} else if ($resultInsert) {
		header("Location:profile.php");
	}
}
if ((empty($newFullname)) && (!empty($newEmail)) && (empty($bio)) && (mysqli_num_rows($result2) == 0)) {
	$query = "UPDATE user SET user_email = '$email' WHERE username= '$username'";

	$resultInsert = mysqli_query($link, $query);
	if (!$resultInsert) {
		die("invalid query" . mysqli_error($link));
	} else if ($resultInsert) {
		header("Location:profile.php");
	}
}
if ((empty($newFullname)) && (empty($newEmail)) && (!empty($bio))) {
	$query = "UPDATE user SET bio = '$bio' WHERE username= '$username'";

	$resultInsert = mysqli_query($link, $query);
	if (!$resultInsert) {
		die("invalid query" . mysqli_error($link));
	} else if ($resultInsert) {
		header("Location:profile.php");
	}
}
if ((!empty($newFullname)) && (!empty($newEmail)) && (!empty($bio)) && (mysqli_num_rows($result2) == 0)) {
	$query = "UPDATE user SET user_fullname = '$fullname', user_email = '$email', bio = '$bio'  WHERE username= '$username'";

	$resultInsert = mysqli_query($link, $query);
	if (!$resultInsert) {
		die("invalid query" . mysqli_error($link));
	} else if ($resultInsert) {
		header("Location:profile.php");
	}
}

include("editProfile.php");
