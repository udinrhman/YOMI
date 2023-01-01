<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['saveCart']) && $_POST['saveCart'] == "Submit") {
    
    $username = $_POST['username'];
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    for($i = 0; $i < count($cart_id); $i++ ){
        $query = "UPDATE cart SET quantity = '$quantity[$i]', subtotal = ('$price[$i]' * '$quantity[$i]') WHERE cart_id = '$cart_id[$i]' AND username = '$username' ";
        $result = mysqli_query($link, $query);
    }
    
    if ($result) {
        header("location:checkout.php");
    } else {
        echo '<script> alert("Cart did not updated); </script>';
    }
}
