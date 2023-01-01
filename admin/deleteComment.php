<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if(isset($_POST['delete']))
{

    $id = $_POST['id'];
    $comment_id = $_POST['comment_id'];

    $query1 = "SELECT * FROM comments WHERE mangaln_id='$id' AND comment_id = '$comment_id'"; //to check if a comment exist or not on a specific product
    $result1 = mysqli_query($link,$query1);

    $query2 = "SELECT * FROM reply WHERE mangaln_id='$id' AND parent = '$comment_id'"; //to check if a reply exist or not on a specific comment
    $result2 = mysqli_query($link,$query2);

    if((mysqli_num_rows($result1)>=1) && (mysqli_num_rows($result2)>=1)) //if have both comments & replies
    {
        $query = "DELETE FROM comments, reply USING comments INNER JOIN reply 
        ON comments.comment_id = reply.parent WHERE comments.comment_id='$comment_id'"; //deleting from 2 tables
        $result = mysqli_query($link,$query);
    }
    else                                                              //if product does not have replies
    {
        $query = "DELETE FROM comments WHERE comments.comment_id='$comment_id'"; //deleting from 1 tables
        $result = mysqli_query($link,$query);
    }

    if($result)
    {
        echo $comment_id;
    }
    else{
        echo '<script> alert("Comment did not deleted); </script>';
    }
}

?>