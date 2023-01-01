<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);


    $news_id = $_POST['id'];

    $query = "DELETE FROM news WHERE news_id = '$news_id'";
    $result = mysqli_query($link, $query);


    if ($result) {
        echo "News Deleted";
        
    } else {
        echo '<script> alert("News did not deleted); </script>';
    }

