<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['editStock']))
{
    $mangaln_id = $_POST['mangaln_id'];
    $stock_id = $_POST['stock_id'];
    $stock = $_POST['stock'];
    date_default_timezone_set("Asia/Kuala_Lumpur");
    
    for($i = 0; $i < count($stock_id); $i++ ){
        $query = "UPDATE stock,mangaln SET stock.stock = '$stock[$i]', mangaln.mangaln_date = CURRENT_TIMESTAMP WHERE stock.stock_id = '$stock_id[$i]' AND mangaln.mangaln_id = '$mangaln_id' ";
        $result = mysqli_query($link, $query);
    }

    if($result) #to move the uploaded file to specific location
    {
        echo 'Stock Updated';
    }
    else{
        echo '<script> alert("Product did not saved); </script>';
    }
}



?>