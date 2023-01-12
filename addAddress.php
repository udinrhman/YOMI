<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if(isset($_POST['saveAddress']) && $_POST['saveAddress']=="Submit"){
    $fullname = addslashes($_POST['fullname']);
    $phoneNumber = $_POST['phoneNumber'];
    $street = $_POST['street'];
    $floor_unit = $_POST['floor_unit'];
    $town_city = $_POST['town_city'];
    $state_region = $_POST['state_region'];
    $postcode = $_POST['postcode'];
    $username = $_POST['username'];

    $query = "SELECT * FROM addresses WHERE username = '$username'";
    $result = mysqli_query($link, $query);


    if (mysqli_num_rows($result) < 1) { //if no addresses, set mode as Default
        $query2 = "INSERT INTO addresses (fullname, phone_number, street, floor_unit, town_city, state_region, postcode, username, mode) 
        VALUES ('".$fullname."','".$phoneNumber."','".$street."','".$floor_unit."','".$town_city."','".$state_region."','".$postcode."','".$username."', 'default' )";
        $result2 = mysqli_query($link, $query2);
    } else { //if have addresses, set mode as nothing
        $query2 = "INSERT INTO addresses (fullname, phone_number, street, floor_unit, town_city, state_region, postcode, username, mode) 
        VALUES ('".$fullname."','".$phoneNumber."','".$street."','".$floor_unit."','".$town_city."','".$state_region."','".$postcode."','".$username."', '')";
        $result2 = mysqli_query($link, $query2);
    }

    if($result2)
    {
        header("Location:address.php");
    }
    else{
        echo '<script> alert("Failed to save address); </script>';
    }
}
