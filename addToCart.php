<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['cart_save'])) {
    $mangaln_id = $_POST['mangaln_id'];
    $cover = $_POST['cover'];
    $title = addslashes($_POST['title']);
    $alternative_title = addslashes($_POST['alternative_title']);
    $volume = $_POST['volume'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $subtotal = $_POST['subtotal'];
    $username = $_POST['username'];

    $query = "SELECT * FROM cart WHERE mangaln_id = '$mangaln_id' AND username = '$username' AND volume = '$volume'";
    $result = mysqli_query($link, $query);
    $data   = $result->fetch_all(MYSQLI_ASSOC);

    if ($result->num_rows > 0) { //if item already in cart, update quantity & subtotal
        foreach ($data as $row) {
            $query2 = "UPDATE cart SET quantity = '$quantity' + " . $row['quantity'] . ",  subtotal = (('$quantity' * '$price') + " . $row['subtotal'] . ") WHERE cart_id = " . $row['cart_id'] . " ";
            $result2 = mysqli_query($link, $query2);
        }
        echo 'Added to Cart!';
    } else {
        $query2 = "INSERT INTO cart (mangaln_id, cover, title, alternative_title, volume, price, quantity, subtotal, username) 
        VALUES ('" . $mangaln_id . "','" . $cover . "','" . $title . "','" . $alternative_title . "','" . $volume . "','" . $price . "','" . $quantity . "','" . $subtotal . "','" . $username . "')";

        $result2 = mysqli_query($link, $query2);
        if ($result2) {
            echo 'Added to Cart!';
        }else{
            echo mysqli_error($link);
        }
    }
}
