<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if(isset($_POST['delete']))
{

    $username = $_POST['username'];

    $query = "DELETE FROM user WHERE username='$username'";
    $result = mysqli_query($link,$query);

    if($result)
    {
        echo "User Deleted!";
    }
    else{
        echo '<script> alert("Comment did not deleted); </script>';
    }
}

?>