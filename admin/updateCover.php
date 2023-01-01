<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if(isset($_POST['saveCover']) && $_POST['saveCover']=="Submit")
{
    $mangaln_id = $_POST['mangaln_id'];
    $image = rand(1000,10000)."-".$_FILES["image"]["name"]; #file name with a random number so that similar dont get replaced
    $tname = $_FILES["image"]["tmp_name"];#temporary file name to store file
    $uploads_dir = '../upload/'; #directory path
    
    $query = "SELECT * FROM orders WHERE mangaln_id = '$mangaln_id'";
    $result = mysqli_query($link,$query);

    if(mysqli_num_rows($result) == 0) {
        $query1 = "UPDATE mangaln SET cover = '$image'WHERE mangaln_id = '$mangaln_id'";
        $result1 = mysqli_query($link,$query1);
    } else {
        $query1 = "UPDATE mangaln, orders SET mangaln.cover = '$image', orders.cover = '$image' WHERE mangaln.mangaln_id = '$mangaln_id' AND orders.mangaln_id = '$mangaln_id'";
        $result1 = mysqli_query($link,$query1);

    }
    
    if($result1 && move_uploaded_file($tname, $uploads_dir. $image))
    {
        header("Location:productDetails.php?ID=$mangaln_id");
    }
    else{
        echo '<script> alert("Cover did not saved); </script>';
    }
}



?>