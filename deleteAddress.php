<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['deleteAddress']) && $_POST['deleteAddress'] == "Submit") {

    $id = $_POST['id'];
    $username = $_POST['username'];

    $query = "SELECT * FROM addresses WHERE address_id='$id'";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result, MYSQLI_BOTH);

    if ($row['mode'] == 'default') { //if it's the default address, delete and set the next address to be default
        $query2 = "DELETE FROM addresses WHERE address_id='$id' AND username ='$username'"; //delete default address
        $result2 = mysqli_query($link, $query2);

        $query3 = "SELECT * FROM addresses WHERE username ='$username' AND mode != 'default'"; 
        $result3 = mysqli_query($link, $query3);
        

        if (mysqli_num_rows($result3) > 0) { //check if there are any addresses left
            while($row3 = mysqli_fetch_array($result3, MYSQLI_BOTH)){
                $query4 = "UPDATE addresses SET mode = 'default' WHERE address_id = $row3[address_id]";
                $result4 = mysqli_query($link, $query4);
                break; //break to update only the first id
            }
            
        }
    }
    if ($row['mode'] != 'default'){ //if address_id is not the default one proceed to delete
        $query2 = "DELETE FROM addresses WHERE address_id='$id' AND username ='$username'";
        $result2 = mysqli_query($link, $query2);
    }

    if ($result2) {
        header("Location:address.php");
    } else {
        echo '<script> alert("Address did not deleted); </script>';
    }
}
