<?php
$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);
if ($_POST['viewmoreType'] == "Manga") {
    $query = "SELECT * FROM mangaln WHERE title > '" . $_POST['id'] . "' AND type = '" . $_POST['viewmoreType'] . "' ORDER BY title LIMIT 15";
} 
else if ($_POST['viewmoreType'] == "Light Novel") {
    $query = "SELECT * FROM mangaln WHERE title > '" . $_POST['id'] . "' AND type = '" . $_POST['viewmoreType'] . "' ORDER BY title LIMIT 15";
}
else {
    $query = "SELECT * FROM mangaln WHERE title > '" . $_POST['id'] . "' ORDER BY title LIMIT 15";
}

$result = mysqli_query($link, $query);

$output = '<div class="row">
<div class="col-12">';

while ($row2 = mysqli_fetch_array($result, MYSQLI_BOTH)) {
    $output .= '
            <div class="container">
                    <a href="productDetails.php?ID=' . $row2['mangaln_id'] . '">
                        <div class="details">
                            <p style="font-size:16px;font-weight:500;color:#BF95FC;margin-bottom: 6px;">' . $row2['title'] . '</p>
                            <p class="truncate-overflow">' . $row2['synopsis'] . '</p>
                            <hr>
                            <p><span style="color:#949494">Alternative name: </span>' . $row2['alternative_title'] . '</p>
                            <p><span style="color:#949494">Type: </span>' . $row2['type'] . '</p>
                            <p><span style="color:#949494">Author: </span>' . $row2['author'] . '</p>
                            <p><span style="color:#949494">Total Volume: </span>' . $row2['total_volume'] . '</p>
                            <p><span style="color:#949494">Release Year: </span>' . $row2['release_year'] . '</p>
                            <p><span style="color:#949494">Status: </span>' . $row2['publication'] . '</p>
                            <p><span style="color:#949494">Genre: </span>';

    $mark = explode(",", $row2['genre']);
    $numItems = count($mark);
    $i = 0;
    foreach ($mark as $genre) {
        if (++$i === $numItems) { //if last element, no comma
            $output .= '<a class="product-genre" style="color:#BF95FC" href="search.php?ID=' . $genre . '">' . $genre . '</a>"';
        } else {
            $output .= '<a class="product-genre" style="color:#BF95FC" href="search.php?ID=' . $genre . '">' . $genre . ',</a>';
        }
    }
    $output .= '
                            </p>
                        </div>
                    </a>
                    <div class="cover"><a href="productDetails.php?ID=' . $row2['mangaln_id'] . '"><img src="upload/' . $row2['cover'] . '" /></a></div>
                    <div class="type-wrapper">';
    if ($row2['type'] == 'Manga') {
        $output .= '<div class="type" style="background-color:#645CAA">' . $row2['type'] . '</div>';
    } else {
        $output .= '<div class="type" style="background-color:#CA4E79">' . $row2['type'] . '</div>';
    }
    $output .= '                
                    </div>
                    <div class="price-tag">
                        RM' . $row2['price'] . '
                    </div>';

    $queryStock = "SELECT * FROM stock WHERE mangaln_id = '" . $row2['mangaln_id'] . "'";
    $resultStock = mysqli_query($link, $queryStock) or die(mysqli_error($link));
    $countVolume = mysqli_num_rows($resultStock);

    $stock = mysqli_fetch_array($resultStock, MYSQLI_BOTH);
    if ($countVolume < 1 || $stock['stock'] < 1) {
        $output .= '
                        <div class="status">
                            <p>SOLD OUT</p>
                        </div>';
    }
    $output .= '            
                    <div class="title text-truncate-container">
                        <p class="text-truncate">' . $row2['title'] . '</p>
                    </div>
                </div>
                ';

    $output .= '';
    $id = $row2['title'];
}
if ($_POST['viewmoreType'] == "Manga") {
    $checkQuery = "SELECT * FROM mangaln WHERE title > '" . $id . "' AND type = '" . $_POST['viewmoreType'] . "' ORDER BY title LIMIT 15";
}
else if ($_POST['viewmoreType'] == "Light Novel") {
    $checkQuery = "SELECT * FROM mangaln WHERE title > '" . $id . "' AND type = '" . $_POST['viewmoreType'] . "' ORDER BY title LIMIT 15";
}
else{
    $checkQuery = "SELECT * FROM mangaln WHERE title > '" . $id . "' ORDER BY title LIMIT 15";
}

$checkResult = mysqli_query($link, $checkQuery);
if (mysqli_num_rows($checkResult) > 1) {
    $output .= '
                </div>
            </div>
            <div class="row">
                <div class="col-12" id="remove_row">
                    <button style="width:100%;background-color:transparent;color:#BF95FC;border:none;margin-top:30px;outline:none" id="view_more" data-id="' . $id . '">VIEW MORE</button>
                </div>
            </div>
    ';
}
echo $output;
