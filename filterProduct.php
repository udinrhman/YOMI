<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['type'])) {
    $type = $_POST['type'];
?>

    <?php
    if ($type == 'All') {
        $query = "SELECT * FROM mangaln ORDER BY title";
    } else {
        $query = "SELECT * FROM mangaln WHERE type = '$type' ORDER BY title";
    }

    $result = mysqli_query($link, $query);
    $countType = mysqli_num_rows($result);
    ?>
    <p class="card-text" style="color:#c0c0c0;float:left;margin-left:1%;"><?php echo $countType ?> result for <strong><?php echo $type ?></strong></p><br>

    <?php
    if (mysqli_num_rows($result) == 0) {
    ?>
        <div class="no-result">
            <img src="image/yomiLogo3.png">
        </div>
        <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">No Manga</h5>
    <?php
    }
    ?>
    <div id="mainparent">
        <div class="centerized">
            <?php while ($row2 = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            ?>
                <div class="container">
                    <a href='productDetails.php?ID=<?php echo $row2['mangaln_id'] ?>'>
                        <div class="details">
                            <p style="font-size:16px;font-weight:500;color:#BF95FC;margin-bottom: 6px;"><?php echo $row2['title'] ?></p>
                            <p class="truncate-overflow"><?php echo $row2['synopsis'] ?></p>
                            <hr>
                            <p><span style="color:#949494">Alternative name: </span><?php echo $row2['alternative_title'] ?></p>
                            <p><span style="color:#949494">Type: </span><?php echo $row2['type'] ?></p>
                            <p><span style="color:#949494">Author: </span><?php echo $row2['author'] ?></p>
                            <p><span style="color:#949494">Total Volume: </span><?php echo $row2['total_volume'] ?></p>
                            <p><span style="color:#949494">Release Year: </span><?php echo $row2['release_year'] ?></p>
                            <p><span style="color:#949494">Status: </span><?php echo $row2['publication'] ?></p>
                            <p><span style="color:#949494">Genre: </span>
                                <?php
                                $mark = explode(",", $row2['genre']);
                                $numItems = count($mark);
                                $i = 0;
                                foreach ($mark as $genre) {
                                    if (++$i === $numItems) { //if last element, no comma
                                        echo "<a class='product-genre' style='color:#BF95FC' href='search.php?ID=" . $genre . "'>" . $genre . "</a> ";       //link based on tags
                                    } else {
                                        echo "<a class='product-genre' style='color:#BF95FC' href='search.php?ID=" . $genre . "'>" . $genre . ",</a> ";
                                    }
                                }
                                ?>
                            </p>
                        </div>
                    </a>
                    <div class="cover"><a href='productDetails.php?ID=<?php echo $row2['mangaln_id'] ?>'><img src="upload/<?php echo $row2['cover'] ?>" /></a></div>
                    <div class="type-wrapper">
                        <?php
                        if ($row2['type'] == 'Manga') {
                        ?>
                            <div class="type" style="background-color:#645CAA"><?php echo $row2['type'] ?></div>
                        <?php } else { ?>
                            <div class="type" style="background-color:#CA4E79"><?php echo $row2['type'] ?></div>
                        <?php } ?>
                    </div>
                    <div class="price-tag">
                        RM<?php echo $row2['price'] ?>
                    </div>
                    <?php
                    $queryStock = "SELECT * FROM stock WHERE mangaln_id = '" . $row2['mangaln_id'] . "'";
                    $resultStock = mysqli_query($link, $queryStock) or die(mysqli_error($link));
                    $countVolume = mysqli_num_rows($resultStock);

                    $stock = mysqli_fetch_array($resultStock, MYSQLI_BOTH);
                    if ($countVolume < 1 || $stock['stock'] < 1) { ?>
                        <!-- if no volume or all volume out of stock -->

                        <div class="status">
                            <p>SOLD OUT</p>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="title text-truncate-container">
                        <p class="text-truncate"><?php echo $row2['title'] ?> </p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <script>
        $(function() {
            var main = $('#mainparent'),
                centerized = $('.centerized'),
                itemWidth = $('.container').outerWidth(true);

            $(window).resize(function() {
                var fitItems = (main.width() / itemWidth) | 0;
                centerized.width(fitItems * itemWidth);
            }).trigger('resize');
        });
    </script>

<?php
} else {
    echo 'error';
}
?>