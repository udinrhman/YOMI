<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if(isset($_POST['saveWishlist']))
{

    $username = $_POST['username'];
    $mangaln_id = $_POST['mangaln_id'];

    $query = "SELECT * FROM wishlist WHERE mangaln_id = '$mangaln_id' AND username = '$username'";
    $result = mysqli_query($link,$query);


    if(mysqli_num_rows($result)>0){
        $query = "DELETE FROM wishlist WHERE wishlist.username = '$username' AND wishlist.mangaln_id = '$mangaln_id'";
        $result2 = mysqli_query($link,$query);
        $wishlist = "removed";
    }
    else{
        $query = "INSERT INTO wishlist (mangaln_id,username) values ('".$mangaln_id."','".$username."')";
        $result2 = mysqli_query($link,$query);
        $wishlist = "added";
    }

    if($result2 && $wishlist == "added")
    {
        echo "ADDED TO WISHLIST";
    }
    if($result2 && $wishlist == "removed")
    {
        echo "ADD TO WISHLIST";
    }
}
