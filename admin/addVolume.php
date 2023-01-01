<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['addVolume']))
{
    $mangaln_id = $_POST['mangaln_id'];
    $stock = 0;
    
    $checkStock = "SELECT * FROM stock  WHERE mangaln_id = '$mangaln_id'";
    $stocks=mysqli_query($link,$checkStock) or die(mysqli_error($link));
    $count = mysqli_num_rows($stocks);

    $countVolume = $count  + 1;
    $Volume = "Volume ";
    $volume = $Volume . $countVolume;

    $query = "INSERT INTO stock (mangaln_id, volume, stock) values ('".$mangaln_id."','".$volume."','".$stock."')";
    $result=mysqli_query($link,$query) or die(mysqli_error($link));

    if($result) #to move the uploaded file to specific location
    {
        echo 'Volume Added!';
    }
    else{
        echo '<script> alert("Product did not saved); </script>';
    }
}



?>