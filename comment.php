<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if(isset($_POST['Comment']) && $_POST['Comment']=="Submit")
{
    $id = $_POST['id'];
    $username = $_POST['username'];
    $comment = addslashes($_POST['comment']);
    date_default_timezone_set("Asia/Kuala_Lumpur");
    
    $query = "INSERT INTO comments (mangaln_id, username, user_comment, comment_date) VALUES ('".$id."','".$username."','".$comment."',CURRENT_TIMESTAMP)";

    $result=mysqli_query($link,$query);

    if($result)
    {
        header("Location:productDetails.php?ID=$id#Comment"); //inserting #Comment for the page navigate to the comment section instead of top of the page
    }
    else{
        echo '<script> alert("Failed to post comment); </script>';
    }
}



?>