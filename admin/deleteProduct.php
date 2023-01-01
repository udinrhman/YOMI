<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

    $mangaln_id = $_POST['id'];

    $checkStock = "SELECT * FROM stock WHERE mangaln_id='$mangaln_id'";
    $stock = mysqli_query($link, $checkStock) or die(mysqli_error($link));

    $checkWishlist = "SELECT * FROM wishlist WHERE mangaln_id='$mangaln_id'";
    $wishlist = mysqli_query($link, $checkWishlist) or die(mysqli_error($link));

    if (mysqli_num_rows($stock) != 0 && mysqli_num_rows($wishlist) != 0) { // if stock and wishlist related to product is available, delete product and it's stocks and wishlist 
        $query = "DELETE FROM mangaln, stock, wishlist USING mangaln, stock, wishlist WHERE mangaln.mangaln_id='$mangaln_id' AND stock.mangaln_id='$mangaln_id' AND  wishlist.mangaln_id='$mangaln_id'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
    }
    else if (mysqli_num_rows($stock) != 0 && mysqli_num_rows($wishlist) == 0) { // if stock related to product is available but no wishlist related, delete product and it's stocks
        $query = "DELETE FROM mangaln, stock USING mangaln, stock WHERE mangaln.mangaln_id='$mangaln_id' AND stock.mangaln_id='$mangaln_id'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
    }
    else if (mysqli_num_rows($stock) == 0 && mysqli_num_rows($wishlist) != 0) { // if wishlist related to product is available but no stock related, delete product and wishlist
        $query = "DELETE FROM mangaln, wishlist USING mangaln, wishlist WHERE mangaln.mangaln_id='$mangaln_id' AND wishlist.mangaln_id='$mangaln_id'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
    } else if (mysqli_num_rows($stock) == 0 && mysqli_num_rows($wishlist) == 0){ //if no stock and wishlist related to product is available, delete product only
        $query = "DELETE FROM mangaln WHERE mangaln_id='$mangaln_id'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
    }


    if ($result) {
        header("Location:products.php");
    } else {
        echo '<script> alert("Product did not deleted); </script>';
    }

