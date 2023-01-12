<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['saveAddress']) && $_POST['saveAddress'] == "Submit") {
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

    $query2 = "SELECT * FROM addresses WHERE username = '$username' AND mode = 'selected'";
    $result2 = mysqli_query($link, $query2);


    if (mysqli_num_rows($result) < 1) { //if no addresses, set mode as Default
        $query3 = "INSERT INTO addresses (fullname, phone_number, street, floor_unit, town_city, state_region, postcode, username, mode) 
        VALUES ('" . $fullname . "','" . $phoneNumber . "','" . $street . "','" . $floor_unit . "','" . $town_city . "','" . $state_region . "','" . $postcode . "','" . $username . "', 'default' )";
        $result3 = mysqli_query($link, $query3);
    } else if (mysqli_num_rows($result2) > 0) { //if an address is already selected, set current address to selected
        $query3 = "INSERT INTO addresses (fullname, phone_number, street, floor_unit, town_city, state_region, postcode, username, mode) 
        VALUES ('" . $fullname . "','" . $phoneNumber . "','" . $street . "','" . $floor_unit . "','" . $town_city . "','" . $state_region . "','" . $postcode . "','" . $username . "', 'selected' )";
        $result3 = mysqli_query($link, $query3);

        $data = mysqli_fetch_assoc($result2);
        $query4 = "UPDATE addresses SET mode = '' WHERE address_id = '$data[address_id]' AND username = '$username' ";
        $result4 = mysqli_query($link, $query4);

    } else { //if have addresses, set mode as nothing
        $query3 = "INSERT INTO addresses (fullname, phone_number, street, floor_unit, town_city, state_region, postcode, username, mode) 
        VALUES ('" . $fullname . "','" . $phoneNumber . "','" . $street . "','" . $floor_unit . "','" . $town_city . "','" . $state_region . "','" . $postcode . "','" . $username . "', '')";
        $result3 = mysqli_query($link, $query3);
    }

    if ($result3) {
        header("Location:checkout.php");
    } else {
        echo '<script> alert("Failed to save address); </script>';
    }
}
