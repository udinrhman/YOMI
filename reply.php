<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if(isset($_POST['Reply']) && $_POST['Reply']=="Submit")
{
    $id = $_POST['id'];
    $parent = $_POST['parent'];
    $username = $_POST['username'];
    $reply = $_POST['reply'];
    $replyid = $_POST['replyid'];
    date_default_timezone_set("Asia/Kuala_Lumpur");

    $query = "INSERT INTO reply (parent, mangaln_id, username, user_comment, reply_date) VALUES ('".$parent."','".$id."','".$username."','".$reply."',CURRENT_TIMESTAMP)";
    $result=mysqli_query($link,$query);

    if($result)
    {
        header("Location:productDetails.php?ID=$id#$replyid"); //inserting #replyid for the page navigate to the comment section instead of top of the page
    }
    else{
        echo '<script> alert("Failed to post comment); </script>';
    }
}



?>