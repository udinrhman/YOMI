<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['editAddress']) && $_POST['editAddress'] == "Submit") {
    $fullname = $_POST['fullname'];
    $phoneNumber = $_POST['phoneNumber'];
    $street = $_POST['street'];
    $floor_unit = $_POST['floor_unit'];
    $town_city = $_POST['town_city'];
    $state_region = $_POST['state_region'];
    $postcode = $_POST['postcode'];
    $username = $_POST['username'];
    $address_id = $_POST['address_id'];

    if (trim($floor_unit) == '') { //check if string have spaces only
        $newFloor_unit = preg_replace('/\s+/', '', $floor_unit); //if yes, remove all whitespaces
    }
    else{
        $newFloor_unit = $_POST['floor_unit'];
    }
    $query = "UPDATE addresses SET fullname = '$fullname', phone_number = '$phoneNumber', street = '$street', floor_unit = '$newFloor_unit', 
    town_city = '$town_city', state_region = '$state_region', postcode = '$postcode' WHERE  address_id = '$address_id' AND username = '$username' ";
    $result = mysqli_query($link, $query);

    if ($result) {
        header("location:checkout.php");
    } else {
        echo '<script> alert("Address did not saved); </script>';
    }
}
