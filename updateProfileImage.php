<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if(isset($_POST['saveProfile']) && $_POST['saveProfile']=="Submit")
{
    $username = $_POST['username'];
    $image = rand(1000,10000)."-".$_FILES["image"]["name"]; #file name with a random number so that similar dont get replaced
    $tname = $_FILES["image"]["tmp_name"];#temporary file name to store file
    $uploads_dir = 'upload/'; #directory path
    
    
    $query = "UPDATE user SET user_image = 'upload/$image' WHERE username = '$username' ";
    $result=mysqli_query($link,$query);

    if(move_uploaded_file($tname, $uploads_dir. $image))
    {
        header("location:editProfile.php");
    }
    else{
        echo '<script> alert("Recipe did not saved); </script>';
    }
}



?>