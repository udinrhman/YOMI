<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['addNews'])) {

    $description = addslashes($_POST['description']);
    $image = rand(1000, 10000) . "-" . $_FILES["image"]["name"]; #file name with a random number so that similar dont get replaced
    $tname = $_FILES["image"]["tmp_name"]; #temporary file name to store file
    $uploads_dir = '../upload/'; #directory path
    date_default_timezone_set("Asia/Kuala_Lumpur");



    if (!empty($_FILES["image"]["name"])) {
        $query = "INSERT INTO news (description,news_image,news_date) values ('" . $description . "','" . $image . "',CURRENT_TIMESTAMP)";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        move_uploaded_file($tname, $uploads_dir . $image);
    }
    else{
        $query = "INSERT INTO news (description,news_image,news_date) values ('" . $description . "','',CURRENT_TIMESTAMP)";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
    }

    if ($result) #to move the uploaded file to specific location
    {
        header('Location:news.php');
    } else {
        echo '<script> alert("Product did not saved); </script>';
    }
}
