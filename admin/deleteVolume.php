<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['delete'])) {
    $stock_id = $_POST['stock_id'];

    $query = "DELETE FROM stock WHERE stock_id = '$stock_id'";
    $result = mysqli_query($link, $query);


    if ($result) {
        echo $stock_id;
        
    } else {
        echo '<script> alert("Volume did not deleted); </script>';
    }
}
