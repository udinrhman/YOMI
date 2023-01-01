<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['deleteWishlist']) && $_POST['deleteWishlist'] == "Submit") {

    $wishlist_id = $_POST['wishlist_id'];
    $username = $_POST['username'];

    $query = "DELETE FROM wishlist WHERE wishlist_id='$wishlist_id' AND username ='$username'";
    $result = mysqli_query($link, $query);

    if ($result) {
        header("Location:wishlist.php");
    } else {
        echo '<script> alert("Wishlist did not deleted); </script>';
    }
}
