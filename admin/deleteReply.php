<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if(isset($_POST['delete']))
{

    $id = $_POST['id'];
    $reply_id = $_POST['reply_id'];

        $query = "DELETE FROM reply WHERE reply.reply_id='$reply_id'"; //deleting from 1 tables
        $result = mysqli_query($link,$query);

    if($result)
    {
        header("Location:productDetails.php?ID=$id#Comment"); //inserting #Comment for the page navigate to the comment section instead of top of the page
    }
    else{
        echo '<script> alert("Comment did not deleted); </script>';
    }
}

?>