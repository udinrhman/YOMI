<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['SaveAddress']) && $_POST['SaveAddress'] == "Submit") {
    $username = $_POST['username'];
    $address_id = $_POST['address_id'];

    $query = "SELECT * FROM addresses WHERE username = '$username' AND address_id = $address_id";
    $result = mysqli_query($link, $query);

    $query2 = "SELECT * FROM addresses WHERE username = '$username' AND mode = 'default'";
    $result2 = mysqli_query($link, $query2);

    $query3 = "SELECT * FROM addresses WHERE username = '$username' AND mode = 'selected'";
    $result3 = mysqli_query($link, $query3);

    $data = mysqli_fetch_assoc($result);
    $data2 = mysqli_fetch_assoc($result2);
    $data3 = mysqli_fetch_assoc($result3);

    if ($data['mode'] == 'default') { //if selected address is already default, remove other selected address
        $query4 = "UPDATE addresses SET mode = '' WHERE address_id =  $data3[address_id] AND username = '$username' ";
        $result4 = mysqli_query($link, $query4);
    }
    
    if ($data['mode'] != 'default' && mysqli_num_rows($result3) > 0) { //if address is not default and have other selected address
        $query4 = "UPDATE addresses SET mode = '' WHERE address_id =  $data3[address_id] AND username = '$username' ";
        $result4 = mysqli_query($link, $query4);
        
        $query5 = "UPDATE addresses SET mode = 'selected' WHERE address_id = '$address_id' AND username = '$username' ";
        $result5 = mysqli_query($link, $query5);
    }

    if ($data['mode'] != 'default' && mysqli_num_rows($result3) < 1) { //if address is not default and no other selected address
        $query4 = "UPDATE addresses SET mode = 'selected' WHERE address_id = '$address_id' AND username = '$username' ";
        $result4 = mysqli_query($link, $query4);
    }

    if ($result4) {
        header("Location:checkout.php");
    } else {
        echo '<script> alert("Failed to save address); </script>';
    }
}
