<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION["username"])) {
?>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shotcut icon" href="image/yomiLogo3.png" type="image/png">
        <title> YOMI | Home </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="css/userHomepage.css?v=1" rel="stylesheet">
    </head>
    <?php
    $host = "localhost";
    $userid = "root";
    $pass = "";
    $database = "yomi";

    $link = mysqli_connect($host, $userid, $pass, $database);

    $query1 = "SELECT * FROM user WHERE username = '" . $_SESSION["username"] . "'";
    $result1 = mysqli_query($link, $query1);

    $countCart = "SELECT count(*) as total FROM cart WHERE username = '" . $_SESSION["username"] . "'";
    $resultCart = mysqli_query($link, $countCart);
    $data = mysqli_fetch_assoc($resultCart);
    while ($row1 = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
    ?>

        <body>
            <!-- LOGO -->
            <nav class="navbar navbar-expand-md navbar-custom sticky-top">
                <div class="container-fluid">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"> <a style="border-bottom: 2px solid #5A2E98" class="nav-link" href="userHomepage.php">HOME</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="mangaln.php">MANGA & LN</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="genre.php">GENRE</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="news.php">NEWS</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="donate.php">DONATE</a> </li>
                    </ul>
                    <form action="search.php" method="POST" class="form-inline my-2 my-lg-0">
                        <div class="searchNav">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="search" class="form-control" placeholder="Search" name="Search" style="min-height: 38px;">
                        </div>
                    </form>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ml-auto">
                            <span class="cart" id="pover-card" data-toggle="popover" data-trigger="focus" data-placement="bottom" tabindex="-1">
                                <i class="fa fa-shopping-cart"></i>
                                <?php if ($data['total'] != 0) { ?>
                                    <span class='badge' id='CartCount'><?php echo $data['total'] ?></span>
                                <?php } ?>
                            </span>
                            <img src="<?php echo $row1['user_image'] ?>" class="rounded-circle" width="37" height="37" style="margin-top:2px;object-fit:cover;">
                            <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <?php echo $row1['user_fullname'] ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li class="token">YOMI TOKENS:&nbsp&nbsp<?php echo $row1['yomi_tokens'] ?>&nbsp&nbsp</li>
                                    <a href="profile.php">
                                        <li>PROFILE</li>
                                    </a>
                                    <a href="address.php">
                                        <li>MY ADDRESSES</li>
                                    </a>
                                    <a href="wishlist.php">
                                        <li>WISHLIST</li>
                                    </a>
                                    <a href="orders.php">
                                        <li>ORDERS</li>
                                    </a>
                                    <a href="logout.php">
                                        <li>LOGOUT</li>
                                    </a>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="popover-content">
                <div id="popover-card">
                    <div class="card">
                        <div class="card-header">Recently Added Product</div>
                        <div class="card-body">
                            <div class="row" id="cart">
                                <?php
                                $queryCartPop = "SELECT * FROM cart WHERE username = '" . $_SESSION["username"] . "' ORDER BY mangaln_id LIMIT 2 ";
                                $resultCartPop = mysqli_query($link, $queryCartPop);
                                $prevID = NULL;
                                $prevCover = NULL;
                                $prevTitle = NULL;
                                if (mysqli_num_rows($resultCartPop) < 1) { ?>
                                    <p class="cartText">No Products Yet</p>
                                    <?php
                                } else {
                                    while ($cart = mysqli_fetch_array($resultCartPop, MYSQLI_BOTH)) {
                                    ?>

                                        <div class="col-3">
                                            <?php if ($cart['cover'] != $prevCover) { ?>
                                                <img src="upload/<?php echo $cart['cover'] ?>" />
                                            <?php }
                                            $prevCover = $cart['cover'];
                                            $prevID = $cart['mangaln_id']; ?>
                                        </div>
                                        <div class="col">
                                            <?php if ($cart['title'] != $prevTitle) { ?>
                                                <p><?php echo $cart['title'] ?></p>
                                            <?php }
                                            $prevTitle = $cart['title']; ?>
                                        </div>
                                        <div class="col-3">
                                            <p><?php echo $cart['volume'] ?></p>
                                        </div>
                                        <div class="col-2">
                                            <p>× <?php echo $cart['quantity'] ?></p>
                                        </div>

                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="card-footer">

                            <?php
                            if ($data['total'] != 0) {
                                if ($data['total'] > 2) { ?>
                                    <span class="totalCart"><?php echo $data['total'] - 2 ?> more product in cart</span><?php } ?><a href="cart.php" class="btn btn-tertiary">View My Shopping Cart</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Search Box-->

            <div class="card imagebox">
                <div class="card-body gradient" style="padding-left:0px;padding-right:0px;padding-top:0px;padding-bottom:0px;">
                    <p class="center"> YOMI </p>
                    <p class="center" style="top:42%;font-size:20px;font-weight:300;">The internet’s source of all the manga and light novels you'll ever need.</p>
                    <form action="search.php" method="POST">
                        <div class="searchbox">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="search" class="form-control" placeholder="Search" name="Search">
                        </div>
                    </form>
                    <p class="trending">Genre you might like:&nbsp<a href="search.php?ID=Action"><button class="btn-genre">ACTION</button></a> <a href="search.php?ID=Comedy"><button class="btn-genre">COMEDY</button></a> <a href="search.php?ID=Romance"><button class="btn-genre">ROMANCE</button></a> <a href="search.php?ID=Fantasy"><button class="btn-genre">FANTASY</button></a> <a href="search.php?ID=Isekai"><button class="btn-genre">ISEKAI</button></a></button></p>
                </div>
            </div>

            <!-- Product Slider -->
            <div class="container-fluid" style="padding:0;padding-top:20px;padding-bottom:20px;">

                <div class="product">
                    <h2 class="product-category">LATEST UPDATE</h2>
                    <button class="pre-btn"><img src="image/arrow.png" alt=""></button>
                    <button class="nxt-btn"><img src="image/arrow.png" alt=""></button>
                    <div class="product-container">
                        <?php
                        $queryLatest = "SELECT * FROM mangaln ORDER BY mangaln_date DESC LIMIT 15";
                        $resultLatest = mysqli_query($link, $queryLatest);
                        while ($latest = mysqli_fetch_array($resultLatest, MYSQLI_BOTH)) {
                            $queryStock = "SELECT * FROM stock WHERE mangaln_id = '" . $latest['mangaln_id'] . "'";
                            $resultStock = mysqli_query($link, $queryStock) or die(mysqli_error($link));
                            $countVolume = mysqli_num_rows($resultStock);

                            $stock = mysqli_fetch_array($resultStock, MYSQLI_BOTH);
                        ?>
                            <div class="product-card">

                                <a href='productDetails.php?ID=<?php echo $latest['mangaln_id'] ?>'>
                                    <div class="product-details">
                                        <p style="font-size:16px;font-weight:500;color:#BF95FC;margin-bottom: 6px;"><?php echo $latest['title'] ?></p>
                                        <p class="truncate-overflow"><?php echo $latest['synopsis'] ?></p>
                                        <hr>
                                        <p><span style="color:#949494">Alternative name: </span><?php echo $latest['alternative_title'] ?></p>
                                        <p><span style="color:#949494">Type: </span><?php echo $latest['type'] ?></p>
                                        <p><span style="color:#949494">Author: </span><?php echo $latest['author'] ?></p>
                                        <p><span style="color:#949494">Total Volume: </span><?php echo $latest['total_volume'] ?></p>
                                        <p><span style="color:#949494">Release Year: </span><?php echo $latest['release_year'] ?></p>
                                        <p><span style="color:#949494">Status: </span><?php echo $latest['publication'] ?></p>
                                        <p><span style="color:#949494">Genre: </span>
                                            <?php
                                            $mark = explode(",", $latest['genre']);
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
                                <div class="product-image">
                                    <a href="productDetails.php?ID=<?php echo $latest['mangaln_id'] ?>">
                                        <img src="../YOMI/upload/<?php echo $latest['cover'] ?>" class="product-thumb" alt="">
                                        <div class="type-wrapper">
                                            <?php
                                            if ($latest['type'] == 'Manga') {
                                            ?>
                                                <div class="type" style="background-color:#645CAA"><?php echo $latest['type'] ?></div>
                                            <?php } else { ?>
                                                <div class="type" style="background-color:#CA4E79"><?php echo $latest['type'] ?></div>
                                            <?php } ?>
                                        </div>
                                        <span class="price-tag">RM<?php echo $latest['price'] ?></span>
                                        <?php
                                        if ($countVolume < 1 || $stock['stock'] < 1) { ?>
                                            <!-- if no volume or all volume out of stock -->

                                            <div class="status">
                                                <p>SOLD OUT</p>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div class="product-info">
                                    <a href="productDetails.php?ID=<?php echo $latest['mangaln_id'] ?>">
                                        <p class="product-short-description text-truncate"><?php echo $latest['title'] ?></p>
                                    </a>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                </div>

                <div class="product">
                    <h2 class="product-category">RECENTLY ADDED</h2>
                    <button class="pre-btn"><img src="image/arrow.png" alt=""></button>
                    <button class="nxt-btn"><img src="image/arrow.png" alt=""></button>
                    <div class="product-container">
                        <?php
                        $queryRecent = "SELECT * FROM mangaln ORDER BY mangaln_id DESC LIMIT 15";
                        $resultProduct = mysqli_query($link, $queryRecent);
                        while ($recent = mysqli_fetch_array($resultProduct, MYSQLI_BOTH)) {
                            $queryStock = "SELECT * FROM stock WHERE mangaln_id = '" . $recent['mangaln_id'] . "'";
                            $resultStock = mysqli_query($link, $queryStock) or die(mysqli_error($link));
                            $countVolume = mysqli_num_rows($resultStock);

                            $stock = mysqli_fetch_array($resultStock, MYSQLI_BOTH);
                        ?>


                            <div class="product-card">
                                <a href='productDetails.php?ID=<?php echo $recent['mangaln_id'] ?>'>
                                    <div class="product-details">
                                        <p style="font-size:16px;font-weight:500;color:#BF95FC;margin-bottom: 6px;"><?php echo $recent['title'] ?></p>
                                        <p class="truncate-overflow"><?php echo $recent['synopsis'] ?></p>
                                        <hr>
                                        <p><span style="color:#949494">Alternative name: </span><?php echo $recent['alternative_title'] ?></p>
                                        <p><span style="color:#949494">Type: </span><?php echo $recent['type'] ?></p>
                                        <p><span style="color:#949494">Author: </span><?php echo $recent['author'] ?></p>
                                        <p><span style="color:#949494">Total Volume: </span><?php echo $recent['total_volume'] ?></p>
                                        <p><span style="color:#949494">Release Year: </span><?php echo $recent['release_year'] ?></p>
                                        <p><span style="color:#949494">Status: </span><?php echo $recent['publication'] ?></p>
                                        <p><span style="color:#949494">Genre: </span>
                                            <?php
                                            $mark = explode(",", $recent['genre']);
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

                                    <div class="product-image">
                                        <a href="productDetails.php?ID=<?php echo $recent['mangaln_id'] ?>">
                                            <img src="../YOMI/upload/<?php echo $recent['cover'] ?>" class="product-thumb" alt="">
                                            <div class="type-wrapper">
                                                <?php
                                                if ($recent['type'] == 'Manga') {
                                                ?>
                                                    <div class="type" style="background-color:#645CAA"><?php echo $recent['type'] ?></div>
                                                <?php } else { ?>
                                                    <div class="type" style="background-color:#CA4E79"><?php echo $recent['type'] ?></div>
                                                <?php } ?>
                                            </div>
                                            <span class="price-tag">RM<?php echo $recent['price'] ?></span>
                                            <?php
                                            if ($countVolume < 1 || $stock['stock'] < 1) { ?>
                                                <!-- if no volume or all volume out of stock -->

                                                <div class="status">
                                                    <p>SOLD OUT</p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <a href="productDetails.php?ID=<?php echo $recent['mangaln_id'] ?>">
                                            <p class="product-short-description text-truncate"><?php echo $recent['title'] ?></p>
                                        </a>
                                    </div>
                            </div>
                            </a>
                        <?php }
                        ?>
                    </div>
                </div>
            </div>
        <?php }
        ?>
        <!--Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js" integrity="sha512-iceXjjbmB2rwoX93Ka6HAHP+B76IY1z0o3h+N1PeDtRSsyeetU3/0QKJqGyPJcX63zysNehggFwMC/bi7dvMig==" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/product-slider.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous"></script>

        <script>
            $('form').attr('autocomplete', 'off'); //turn off autocomplete
        </script>

        <script>
            $('[data-toggle="popover"]').popover({
                html: true,
                content: function() {
                    var id = $(this).attr('id')
                    return $('#po' + id).html();
                }
            });
        </script>
        <script>
            var i = 1;
            var last = document.querySelectorAll(".product-details");
            while (i < 30) {
                last[last.length - i].style.left = '-70%'; //to change css of every 5 product starting from the last to first
                i += 5;
            }
        </script>

        </body>

    </html>

<?php
} else {
    header("Location:login.php");
}
?>