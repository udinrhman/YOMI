<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if(isset($_POST['addProduct']) && $_POST['addProduct']=="Submit")
{
    $genre = '';
    foreach ($_POST['genre'] as $value){
        $genre .= $value . ','; #save inputs from bootstrap-select as arrays (adding ',' after value)
        
    }$genre = rtrim($genre,',');

    $username = $_POST['username'];
    $title = addslashes($_POST['title']);
    $image = rand(1000,10000)."-".$_FILES["image"]["name"]; #file name with a random number so that similar dont get replaced
    $tname = $_FILES["image"]["tmp_name"];#temporary file name to store file
    $alternative_title = addslashes($_POST['alternative_title']);
    $author = addslashes($_POST['author']);
    $total_volume = $_POST['total_volume'];
    $release_year = $_POST['release_year'];
    $price = $_POST['price'];
    $publication = $_POST['publication'];
    $synopsis = addslashes($_POST['synopsis']);
    $admin_review = addslashes($_POST['admin_review']);
    $admin_rating = $_POST['admin_rating'];
    $type = $_POST['type'];
    $uploads_dir = '../upload/'; #directory path
    date_default_timezone_set("Asia/Kuala_Lumpur");
    
    $query = "INSERT INTO mangaln (username,title,alternative_title,type,cover,synopsis,author,genre,total_volume,release_year,publication,price,admin_review,admin_rating,mangaln_date)
    values ('".$username."','".$title."','".$alternative_title."','".$type."','".$image."','".$synopsis."','".$author."','".$genre."','".$total_volume."','".$release_year."','".$publication."','".$price."','".$admin_review."','".$admin_rating."',CURRENT_TIMESTAMP)";
    $result=mysqli_query($link,$query) or die(mysqli_error($link));

    if($result && move_uploaded_file($tname, $uploads_dir. $image)) #to move the uploaded file to specific location
    {
        header("Location:products.php");
    }
    else{
        echo '<script> alert("Product did not saved); </script>';
    }
}



?>