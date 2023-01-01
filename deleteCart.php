<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if(isset($_POST['deleteCart']) && $_POST['deleteCart']=="Submit")
{

    $cart_id = $_POST['cart_id'];
    $username = $_POST['username'];

        $query = "DELETE FROM cart WHERE cart_id='$cart_id' AND username='$username'"; //deleting from 1 tables
        $result = mysqli_query($link,$query);

    if($result)
    {
        header("Location:cart.php"); //inserting #Comment for the page navigate to the comment section instead of top of the page
    }
    else{
        echo '<script> alert("Cart item did not deleted); </script>';
    }
}

?>