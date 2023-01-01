<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['donate'])) {
    $username = $_POST['username'];
    $yomi_tokens = $_POST['yomi_tokens'];

    $query = "INSERT INTO donation (username, yomi_tokens) VALUES ('" . $username . "', '" . $yomi_tokens . "')";
    $result = mysqli_query($link, $query);

    if ($result) {
        $query2 = "SELECT * FROM user WHERE username = '$username'";
        $result2 = mysqli_query($link, $query2);

        while ($row = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
            $query3 = "UPDATE user SET yomi_tokens = " . $row['yomi_tokens'] . " - '$yomi_tokens' WHERE username = '$username' ";
            $result3 = mysqli_query($link, $query3);
        }
        echo 'Thank You for your donation!';
    } else {
        echo '<script> alert("Failed to donate yomi tokens); </script>';
    }
}
