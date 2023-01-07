<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['updateProduct']) && $_POST['updateProduct'] == "Submit") {
    $genre = '';
    foreach ($_POST['genre'] as $value) {
        $genre .= $value . ','; #save inputs from bootstrap-select as arrays (adding ',' after value)

    }
    $genre = rtrim($genre, ',');

    $mangaln_id = $_POST['mangaln_id'];
    $title = addslashes($_POST['title']);
    $alternative_title = addslashes($_POST['alternative_title']);
    $type = $_POST['type'];
    $synopsis = addslashes($_POST['synopsis']);
    $author = addslashes($_POST['author']);
    $total_volume = $_POST['total_volume'];
    $release_year = $_POST['release_year'];
    $publication = $_POST['publication'];
    $price = $_POST['price'];
    $admin_review = addslashes($_POST['admin_review']);
    $admin_rating = $_POST['admin_rating'];
    date_default_timezone_set("Asia/Kuala_Lumpur");

    $checkCart = "SELECT * FROM cart WHERE mangaln_id = '$mangaln_id'";
    $resultCheck = mysqli_query($link, $checkCart);

    if (mysqli_num_rows($resultCheck) != 0) { //if cart have the product, update product and product in the cart
        while ($cart = mysqli_fetch_array($resultCheck, MYSQLI_BOTH)) {
            $subtotal = $price * $cart['quantity'];
            $queryCart = "UPDATE cart SET price = '$price', subtotal = '$subtotal', title = '$title', alternative_title = '$alternative_title' WHERE  mangaln_id = '$mangaln_id'";
            $resultCart = mysqli_query($link, $queryCart);
        }
        $query = "UPDATE mangaln SET title = '$title', alternative_title = '$alternative_title', type = '$type', 
        synopsis = '$synopsis', author = '$author', genre = '$genre', total_volume = '$total_volume', 
        release_year = '$release_year', publication = '$publication', price = '$price', admin_review = '$admin_review', admin_rating = '$admin_rating',
        mangaln_date = CURRENT_TIMESTAMP WHERE  mangaln_id = '$mangaln_id'";
        $result = mysqli_query($link, $query);
    } else { //update product only
        $query = "UPDATE mangaln SET title = '$title', alternative_title = '$alternative_title', type = '$type', 
        synopsis = '$synopsis', author = '$author', genre = '$genre', total_volume = '$total_volume', 
        release_year = '$release_year', publication = '$publication', price = '$price', admin_review = '$admin_review', admin_rating = '$admin_rating',
        mangaln_date = CURRENT_TIMESTAMP WHERE  mangaln_id = '$mangaln_id'";
        $result = mysqli_query($link, $query);
    }

    if ($result) {
        header("Location:productDetails.php?ID=$mangaln_id");
    } else {
        echo '<script> alert("Product did not saved); </script>';
    }
}
