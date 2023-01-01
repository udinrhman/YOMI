<?php

$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['all']) || isset($_POST['manga']) || isset($_POST['ln']) || isset($_POST['stock'])) {

    $type = $_POST['type'];
    if ($type == 'Stock') {
        $count = 0;
        $query = "SELECT mangaln_id FROM mangaln ORDER BY mangaln_id DESC";
        $result = mysqli_query($link, $query);
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $countProduct = "SELECT mangaln.*FROM mangaln LEFT JOIN stock ON stock.mangaln_id = mangaln.mangaln_id WHERE (stock.mangaln_id = '$row[mangaln_id]' AND stock.stock='0')
                             GROUP BY mangaln.mangaln_id ORDER BY mangaln_id DESC"; //to count NEED RESTOCK product
            $resultCount = mysqli_query($link, $countProduct);
            $count = $count + mysqli_num_rows($resultCount);
        }

        $queryNoStock = "SELECT mangaln.*
                        FROM mangaln
                        LEFT JOIN stock ON stock.mangaln_id = mangaln.mangaln_id
                        WHERE stock.mangaln_id IS NULL
                        ORDER BY mangaln_id DESC";
        $resultNoStock = mysqli_query($link, $queryNoStock);

        $count = $count + mysqli_num_rows($resultNoStock) //count NEED STOCK product + NO STOCK product 
?>
        <h4 style="margin-left:15px;margin-top:20px;margin-bottom:0;font-weight:600;text-transform:uppercase">OUT OF STOCK</h4>
        <p class="card-text" style="color:#c0c0c0;float:left;margin-left:15px;"><?php echo $count ?> results for <strong>OUT OF STOCK</strong> products</p><br><br>
        <?php
        $query1 = "SELECT mangaln_id FROM mangaln ORDER BY mangaln_id DESC";
        $result1 = mysqli_query($link, $query1);
        while ($row1 = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
            $queryProduct = "SELECT mangaln.*
                        FROM mangaln
                        LEFT JOIN stock ON stock.mangaln_id = mangaln.mangaln_id
                        WHERE (stock.mangaln_id = '$row1[mangaln_id]' AND stock.stock='0')
                        GROUP BY mangaln.mangaln_id
                        ORDER BY mangaln_id DESC";
            $resultProduct = mysqli_query($link, $queryProduct); ?>

            <table style="background-color:#000000">
                <?php
                if (mysqli_num_rows($resultProduct) != 0) {
                    while ($product = mysqli_fetch_array($resultProduct, MYSQLI_BOTH)) {
                ?>
                        <tr>
                            <td style="width:100px;padding:15px;">
                                <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                    <div class="container" style="width:100%;height:100%">
                                        <div class="cover"><img width="100px" height="150px" src="../upload/<?php echo $product['cover'] ?>" /></div>
                                        <div class="status">
                                            <p style="font-size:12px">NEED RESTOCK</p>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td style="text-align:left">
                                <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                    <p style="font-size:30px;font-weight:600;margin-top:-10px;"><?php echo $product['title'] ?></p>
                                    <p><?php echo $product['alternative_title'] ?></p>
                                    <p>Author: <?php echo $product['author'] ?></p>
                                    <p>Type: <?php echo $product['type'] ?></p>
                                    <span style="color:#F5F5F5">Genre:
                                        <?php
                                        $mark = explode(",", $product['genre']); //remove "," from Genre table in database
                                        foreach ($mark as $out) {
                                            echo "&nbsp<button class='btn-primary' style='margin-top:5px;'><a style='color:#F5F5F5;' href='search.php?ID=" . $out . "'> " . $out . "</a></button>";       //link based on tags
                                        }
                                        ?>
                                    </span>
                                </a>
                            </td>
                            <td style="width:5%;vertical-align:top;padding-top:20px;position:relative">
                                <span data-toggle="modal" data-target="#DeleteProductModal<?php echo $product['mangaln_id']; ?>"><i class="fa fa-window-close"></i></span>
                                <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                    <button class="btn btn-tertiary" style="position:absolute;bottom:0%;right:0%;margin-bottom:20px">VIEW DETAILS</button>
                                </a>
                            </td>
                        </tr>
                        <!----  Delete Product Modal  ----->
                        <div class="modal fade DeleteModal" id="DeleteProductModal<?php echo $product['mangaln_id']; ?>">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Delete Product</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h7> Are you sure you want to delete this product?</h7>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                        <input type="submit" value="DELETE" name="deleteProduct" id="<?php echo $product["mangaln_id"]; ?>" class="btn btn-primary deleteMangaln">
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php }
                }
            }
            ?>
            <table style="background-color:#000000">
                <?php
                if (mysqli_num_rows($resultNoStock) != 0) {
                    while ($noStock = mysqli_fetch_array($resultNoStock, MYSQLI_BOTH)) {
                ?>
                        <tr>
                            <td style="width:100px;padding:15px;">
                                <a href="productDetails.php?ID=<?php echo $noStock['mangaln_id'] ?>">
                                    <div class="container" style="width:100%;height:100%">
                                        <div class="cover"><img width="100px" height="150px" src="../upload/<?php echo $noStock['cover'] ?>" /></div>
                                        <div class="status">
                                            <p style="font-size:12px">NO STOCK</p>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td style="text-align:left">
                                <a href="productDetails.php?ID=<?php echo $noStock['mangaln_id'] ?>">
                                    <p style="font-size:30px;font-weight:600;margin-top:-10px;"><?php echo $noStock['title'] ?></p>
                                    <p><?php echo $noStock['alternative_title'] ?></p>
                                    <p>Author: <?php echo $noStock['author'] ?></p>
                                    <p>Type: <?php echo $noStock['type'] ?></p>
                                    <span style="color:#F5F5F5">Genre:
                                        <?php
                                        $mark = explode(",", $noStock['genre']); //remove "," from Genre table in database
                                        foreach ($mark as $out) {
                                            echo "&nbsp<button class='btn-primary' style='margin-top:5px;'><a style='color:#F5F5F5;' href='search.php?ID=" . $out . "'> " . $out . "</a></button>";       //link based on tags
                                        }
                                        ?>
                                    </span>
                                </a>
                            </td>
                            <td style="width:5%;vertical-align:top;padding-top:20px;position:relative">
                                <span data-toggle="modal" data-target="#DeleteProductModal<?php echo $noStock['mangaln_id']; ?>"><i class="fa fa-window-close"></i></span>
                                <a href="productDetails.php?ID=<?php echo $noStock['mangaln_id'] ?>">
                                    <button class="btn btn-tertiary" style="position:absolute;bottom:0%;right:0%;margin-bottom:20px">VIEW DETAILS</button>
                                </a>
                            </td>
                        </tr>
                        <!----  Delete Product Modal  ----->
                        <div class="modal fade DeleteModal" id="DeleteProductModal<?php echo $noStock['mangaln_id']; ?>">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Delete Product</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h7> Are you sure you want to delete this product?</h7>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                        <input type="submit" value="DELETE" name="deleteProduct" id="<?php echo $noStock["mangaln_id"]; ?>" class="btn btn-primary deleteMangaln">
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
            </table>
            <?php if (mysqli_num_rows($resultProduct) == 0 && mysqli_num_rows($resultNoStock) == 0) { ?>
                <div class="no-result">
                    <img src="../image/yomiLogo3.png">
                </div>
                <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">NO OUT OF STOCK PRODUCT</h5>
            <?php } ?>
        <?php
    } else if ($type == 'Manga' || $type == 'Light Novel') {
        $queryProduct = "SELECT * FROM mangaln WHERE type = '$type' ORDER BY mangaln_id DESC";
        $resultProduct = mysqli_query($link, $queryProduct);
        $count = mysqli_num_rows($resultProduct);

        ?>
            <h4 style="margin-left:15px;margin-top:20px;margin-bottom:0;font-weight:600;text-transform:uppercase"><?php echo $type ?></h4>
            <p class="card-text" style="color:#c0c0c0;float:left;margin-left:15px;"><?php echo $count ?> results for <strong style="text-transform:uppercase"><?php echo $type ?></strong></p><br><br>
            <table style="background-color:#000000">
                <?php
                if (mysqli_num_rows($resultProduct) != 0) {
                    while ($product = mysqli_fetch_array($resultProduct, MYSQLI_BOTH)) {
                ?>
                        <tr>
                            <td style="width:100px;padding:15px;">
                                <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                    <div class="container" style="width:100%;height:100%">
                                        <div class="cover"><img width="100px" height="150px" src="../upload/<?php echo $product['cover'] ?>" /></div>
                                        <?php
                                        $queryStock = "SELECT * FROM stock WHERE mangaln_id = '" . $product['mangaln_id'] . "'";
                                        $resultStock = mysqli_query($link, $queryStock);
                                        if (mysqli_num_rows($resultStock) == 0) { ?>
                                            <!-- if no volume or all volume out of stock -->
                                            <div class="status">
                                                <p style="font-size:12px">NO STOCK</p>
                                            </div>
                                            <?php
                                        }
                                        while ($stock = mysqli_fetch_array($resultStock, MYSQLI_BOTH)) {

                                            if ($stock['stock'] < 1) { ?>
                                                <!-- if no volume or all volume out of stock -->
                                                <div class="status">
                                                    <p style="font-size:12px">NEED RESTOCK</p>
                                                </div>
                                        <?php
                                            }
                                        } ?>
                                    </div>
                                </a>
                            </td>
                            <td style="text-align:left">
                                <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                    <p style="font-size:30px;font-weight:600;margin-top:-10px;"><?php echo $product['title'] ?></p>
                                    <p><?php echo $product['alternative_title'] ?></p>
                                    <p>Author: <?php echo $product['author'] ?></p>
                                    <p>Type: <?php echo $product['type'] ?></p>
                                    <span style="color:#F5F5F5">Genre:
                                        <?php
                                        $mark = explode(",", $product['genre']); //remove "," from Genre table in database
                                        foreach ($mark as $out) {
                                            echo "&nbsp<button class='btn-primary' style='margin-top:5px;'><a style='color:#F5F5F5;' href='search.php?ID=" . $out . "'> " . $out . "</a></button>";       //link based on tags
                                        }
                                        ?>
                                    </span>
                                </a>
                            </td>
                            <td style="width:5%;vertical-align:top;padding-top:20px;position:relative">
                                <span data-toggle="modal" data-target="#DeleteProductModal<?php echo $product['mangaln_id']; ?>"><i class="fa fa-window-close"></i></span>
                                <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                    <button class="btn btn-tertiary" style="position:absolute;bottom:0%;right:0%;margin-bottom:20px">VIEW DETAILS</button>
                                </a>
                            </td>
                        </tr>
                        <!----  Delete Product Modal  ----->
                        <div class="modal fade DeleteModal" id="DeleteProductModal<?php echo $product['mangaln_id']; ?>">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Delete Product</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h7> Are you sure you want to delete this product?</h7>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                        <input type="submit" value="DELETE" name="deleteProduct" id="<?php echo $product["mangaln_id"]; ?>" class="btn btn-primary deleteMangaln">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
            </table>

        <?php
                } else { ?>
            <div class="no-result">
                <img src="../image/yomiLogo3.png">
            </div>
            <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">No <?php echo $type ?> Yet.</h5>
        <?php }
            } else {
                $queryProduct = "SELECT * FROM mangaln ORDER BY mangaln_id DESC";
                $resultProduct = mysqli_query($link, $queryProduct);
                $count = mysqli_num_rows($resultProduct);

        ?>
        <h4 style="margin-left:15px;margin-top:20px;margin-bottom:0;font-weight:600;text-transform:uppercase"><?php echo $type ?></h4>
        <p class="card-text" style="color:#c0c0c0;float:left;margin-left:15px;"><?php echo $count ?> results for <strong style="text-transform:uppercase"><?php echo $type ?></strong> products</p><br><br>
        <table style="background-color:#000000">
            <?php
                if (mysqli_num_rows($resultProduct) != 0) {
                    while ($product = mysqli_fetch_array($resultProduct, MYSQLI_BOTH)) {
            ?>
                    <tr>
                        <td style="width:100px;padding:15px;">
                            <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                <div class="container" style="width:100%;height:100%">
                                    <div class="cover"><img width="100px" height="150px" src="../upload/<?php echo $product['cover'] ?>" /></div>
                                    <?php
                                    $queryStock = "SELECT * FROM stock WHERE mangaln_id = '" . $product['mangaln_id'] . "'";
                                    $resultStock = mysqli_query($link, $queryStock);
                                    if (mysqli_num_rows($resultStock) == 0) { ?>
                                        <!-- if no volume or all volume out of stock -->
                                        <div class="status">
                                            <p style="font-size:12px">NO STOCK</p>
                                        </div>
                                        <?php
                                    }
                                    while ($stock = mysqli_fetch_array($resultStock, MYSQLI_BOTH)) {

                                        if ($stock['stock'] < 1) { ?>
                                            <!-- if no volume or all volume out of stock -->
                                            <div class="status">
                                                <p style="font-size:12px">NEED RESTOCK</p>
                                            </div>
                                    <?php
                                        }
                                    } ?>
                                </div>
                            </a>
                        </td>
                        <td style="text-align:left">
                            <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                <p style="font-size:30px;font-weight:600;margin-top:-10px;"><?php echo $product['title'] ?></p>
                                <p><?php echo $product['alternative_title'] ?></p>
                                <p>Author: <?php echo $product['author'] ?></p>
                                <p>Type: <?php echo $product['type'] ?></p>
                                <span style="color:#F5F5F5">Genre:
                                    <?php
                                    $mark = explode(",", $product['genre']); //remove "," from Genre table in database
                                    foreach ($mark as $out) {
                                        echo "&nbsp<button class='btn-primary' style='margin-top:5px;'><a style='color:#F5F5F5;' href='search.php?ID=" . $out . "'> " . $out . "</a></button>";       //link based on tags
                                    }
                                    ?>
                                </span>
                            </a>
                        </td>
                        <td style="width:5%;vertical-align:top;padding-top:20px;position:relative">
                            <span data-toggle="modal" data-target="#DeleteProductModal<?php echo $product['mangaln_id']; ?>"><i class="fa fa-window-close"></i></span>
                            <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                <button class="btn btn-tertiary" style="position:absolute;bottom:0%;right:0%;margin-bottom:20px">VIEW DETAILS</button>
                            </a>
                        </td>
                    </tr>
                    <!----  Delete Product Modal  ----->
                    <div class="modal fade DeleteModal" id="DeleteProductModal<?php echo $product['mangaln_id']; ?>">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">Delete Product</h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h7> Are you sure you want to delete this product?</h7>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                    <input type="submit" value="DELETE" name="deleteProduct" id="<?php echo $product["mangaln_id"]; ?>" class="btn btn-primary deleteMangaln">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
        </table>

    <?php
                } else { ?>
        <div class="no-result">
            <img src="../image/yomiLogo3.png">
        </div>
        <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">No Products Yet.</h5>
<?php }
            }
        } ?>