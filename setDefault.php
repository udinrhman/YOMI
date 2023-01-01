<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['setDefault']) && $_POST['setDefault'] == "Submit") {
    $username = $_POST['username'];
    $address_id = $_POST['address_id'];

    $query = "SELECT * FROM addresses WHERE username = '$username' AND mode = 'default'";
    $result = mysqli_query($link, $query);


    if (mysqli_num_rows($result) < 1) { //if no addresses, set mode as Default
        $query2 = "UPDATE addresses SET mode = 'default' WHERE address_id = '$address_id' AND username = '$username' ";
        $result2 = mysqli_query($link, $query2);
    } else {
        $query2 = "UPDATE addresses SET mode = 'default' WHERE address_id = '$address_id' AND username = '$username' ";
        $result2 = mysqli_query($link, $query2);

        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $query3 = "UPDATE addresses SET mode = '' WHERE address_id = $row[address_id] AND username = '$username' ";
            $result3 = mysqli_query($link, $query3);
            break;
        }
    }

    if ($result2) {
        header("Location:address.php");
    } else {
        echo '<script> alert("Failed to save address); </script>';
    }
}



