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
        <title> YOMI | Genre </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="css/userhomepage.css" rel="stylesheet">

        <style>
            .box {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        </style>
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
            <!-- Navigation Bar -->
            <nav class="navbar navbar-expand-md navbar-custom sticky-top">
                <div class="container-fluid">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"> <a class="nav-link" href="userHomepage.php">HOME</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="mangaln.php">MANGA & LN</a> </li>
                        <li class="nav-item"> <a style="border-bottom: 2px solid #5A2E98" class="nav-link" href="genre.php">GENRE</a> </li>
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
            <!-- Card -->
            <div class="container-fluid" style="padding:0;margin-top:20px;">
                <div class="card">
                    <div class="card-header" style="background-color:#181818;border-bottom:2px solid #5A2E98">
                        <p style="margin:0;font-size:20px;font-weight:500;color:#F5F5F5">POPULAR GENRE</p>
                    </div>
                    <div class="card-body">
                        <!-- Image Grid -->
                        <div class="box">
                            <div class="main">
                                <div class="gallery">
                                    <?php
                                    $genreArr = array(
                                        array("Action", 0),
                                        array("Adventure", 0),
                                        array("Comedy", 0),
                                        array("Fantasy", 0),
                                        array("Horror", 0),
                                        array("Isekai", 0),
                                        array("Mecha", 0),
                                        array("Mystery", 0),
                                        array("Psychological", 0),
                                        array("Romance", 0),
                                        array("School", 0),
                                        array("Sci-fi", 0),
                                        array("Slice of Life", 0),
                                        array("Supernatural", 0),
                                        array("Thriller", 0),
                                        array("Tragedy", 0),
                                        array("Vampire", 0)
                                    );

                                    $sort = array(
                                        array("Action", 0),
                                        array("Adventure", 0),
                                        array("Comedy", 0),
                                        array("Fantasy", 0),
                                        array("Horror", 0),
                                        array("Isekai", 0),
                                        array("Mecha", 0),
                                        array("Mystery", 0),
                                        array("Psychological", 0),
                                        array("Romance", 0),
                                        array("School", 0),
                                        array("Sci-fi", 0),
                                        array("Slice of Life", 0),
                                        array("Supernatural", 0),
                                        array("Thriller", 0),
                                        array("Tragedy", 0),
                                        array("Vampire", 0)
                                    );
                                    $popularProduct = "SELECT mangaln.*, SUM(orders.quantity) AS order_count
                                                        FROM mangaln LEFT JOIN orders 
                                                        ON mangaln.mangaln_id = orders.mangaln_id
                                                        GROUP BY mangaln.mangaln_id
                                                        ORDER BY order_count LIMIT 3";
                                    $resultPopular = mysqli_query($link, $popularProduct);

                                    while ($popular = mysqli_fetch_array($resultPopular, MYSQLI_BOTH)) {
                                        for ($i = 0; $i < count($genreArr); $i++) {
                                            $countGenre = "SELECT count(*) as countGenre FROM mangaln WHERE mangaln_id = '" . $popular['mangaln_id'] . "' AND genre LIKE '%" . $genreArr[$i][0] . "%'";
                                            $resultCountGenre = mysqli_query($link, $countGenre);
                                            while ($popularGenre = mysqli_fetch_array($resultCountGenre, MYSQLI_BOTH)) {
                                                $sort[$i][1] = $sort[$i][1] + $popularGenre['countGenre'];
                                            }
                                        }
                                    }
                                    function sortByOrder($a, $b)
                                    {
                                        return $b[1] - $a[1]; // $b[1] - $a[1] because it need to be descending order
                                    }

                                    usort($sort, 'sortByOrder');

                                    for ($i = 0; $i < 8; $i++) {
                                    ?>
                                        <div class="img">
                                            <a href='search.php?ID=<?php echo $sort[$i][0] ?>'><img src="image/<?php echo $sort[$i][0] ?>.jpg" /></a>
                                            <div class="bottom-middle"><a href='search.php?ID=<?php echo $sort[$i][0] ?>'><?php echo $sort[$i][0] ?></div></a>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid" style="padding:70px;padding-top:20px">
                            <h5 style="color:#BF95FC;margin-top:15px;padding:10px">All Genre</h5>
                            <table class="table genre">
                                <tbody>
                                    <?php
                                    $arr = array('Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Isekai', 'Mecha', 'Mystery', 'Psychological', 'Romance', 'School', 'Sci-fi', 'Slice of Life', 'Supernatural', 'Thriller', 'Tragedy', 'Vampire');
                                    for ($i = 0; $i < count($arr); $i++) {
                                        $queryCountGenre = "SELECT COUNT(*) as total FROM mangaln WHERE genre LIKE '%" . $arr[$i] . "%'";
                                        $resultCount = mysqli_query($link, $queryCountGenre);
                                        $countGenre = mysqli_fetch_assoc($resultCount); ?>
                                        <tr>
                                            <td><a href="search.php?ID=<?php echo $arr[$i] ?>"><?php echo $arr[$i] ?>&nbsp<span style="font-weight:600"></span><span style="color:#525252;font-size:12px;font-weight:600">&nbsp&nbsp-&nbsp&nbsp<?php echo $countGenre['total'] ?></span></a></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--Scripts -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js" integrity="sha512-iceXjjbmB2rwoX93Ka6HAHP+B76IY1z0o3h+N1PeDtRSsyeetU3/0QKJqGyPJcX63zysNehggFwMC/bi7dvMig==" crossorigin="anonymous"></script>

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
        </body>

    </html>

<?php
    }
} else { //guest view
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shotcut icon" href="image/yomiLogo3.png" type="image/png">
    <title> YOMI | Genre </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
    <link href="css/userhomepage.css" rel="stylesheet">

    <style>
        .box {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<?php
    $host = "localhost";
    $userid = "root";
    $pass = "";
    $database = "yomi";

    $link = mysqli_connect($host, $userid, $pass, $database);

?>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-md navbar-custom sticky-top">
        <div class="container-fluid">
            <!-- LOGO -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"> <a class="nav-link" href="homepage.php">HOME</a> </li>
                <li class="nav-item"> <a class="nav-link" href="mangaln.php">MANGA & LN</a> </li>
                <li class="nav-item"> <a style="border-bottom: 2px solid #5A2E98" class="nav-link" href="genre.php">GENRE</a> </li>
                <li class="nav-item"> <a class="nav-link" href="news.php">NEWS</a> </li>
                <li class="nav-item"> <a class="nav-link" href="donate.php">DONATE</a> </li>
            </ul>
            <form action="search.php" method="POST" class="form-inline my-2 my-lg-0">
                <div class="searchNav">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="search" class="form-control enter" placeholder="Search" name="Search" style="min-height: 38px;">
                </div>
            </form>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"> <a class="nav-link" href="login.php">LOGIN </a> </li>
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
    <!-- Card -->
    <div class="container-fluid" style="padding:0;margin-top:20px;">
        <div class="card">
            <div class="card-header" style="background-color:#181818;border-bottom:2px solid #5A2E98">
                <p style="margin:0;font-size:20px;font-weight:500;color:#F5F5F5">POPULAR GENRE</p>
            </div>
            <div class="card-body">
                <!-- Image Grid -->
                <div class="box">
                    <div class="main">
                        <div class="gallery">
                            <?php
                            $genreArr = array(
                                array("Action", 0),
                                array("Adventure", 0),
                                array("Comedy", 0),
                                array("Fantasy", 0),
                                array("Horror", 0),
                                array("Isekai", 0),
                                array("Mecha", 0),
                                array("Mystery", 0),
                                array("Psychological", 0),
                                array("Romance", 0),
                                array("School", 0),
                                array("Sci-fi", 0),
                                array("Slice of Life", 0),
                                array("Supernatural", 0),
                                array("Thriller", 0),
                                array("Tragedy", 0),
                                array("Vampire", 0)
                            );

                            $sort = array(
                                array("Action", 0),
                                array("Adventure", 0),
                                array("Comedy", 0),
                                array("Fantasy", 0),
                                array("Horror", 0),
                                array("Isekai", 0),
                                array("Mecha", 0),
                                array("Mystery", 0),
                                array("Psychological", 0),
                                array("Romance", 0),
                                array("School", 0),
                                array("Sci-fi", 0),
                                array("Slice of Life", 0),
                                array("Supernatural", 0),
                                array("Thriller", 0),
                                array("Tragedy", 0),
                                array("Vampire", 0)
                            );
                            $popularProduct = "SELECT mangaln.*, SUM(orders.quantity) AS order_count
                                                        FROM mangaln LEFT JOIN orders 
                                                        ON mangaln.mangaln_id = orders.mangaln_id
                                                        GROUP BY mangaln.mangaln_id
                                                        ORDER BY order_count LIMIT 3";
                            $resultPopular = mysqli_query($link, $popularProduct);

                            while ($popular = mysqli_fetch_array($resultPopular, MYSQLI_BOTH)) {
                                for ($i = 0; $i < count($genreArr); $i++) {
                                    $countGenre = "SELECT count(*) as countGenre FROM mangaln WHERE mangaln_id = '" . $popular['mangaln_id'] . "' AND genre LIKE '%" . $genreArr[$i][0] . "%'";
                                    $resultCountGenre = mysqli_query($link, $countGenre);
                                    while ($popularGenre = mysqli_fetch_array($resultCountGenre, MYSQLI_BOTH)) {
                                        $sort[$i][1] = $sort[$i][1] + $popularGenre['countGenre'];
                                    }
                                }
                            }
                            function sortByOrder($a, $b)
                            {
                                return $b[1] - $a[1]; // $b[1] - $a[1] because it need to be descending order
                            }

                            usort($sort, 'sortByOrder');

                            for ($i = 0; $i < 8; $i++) {
                            ?>
                                <div class="img">
                                    <a href='search.php?ID=<?php echo $sort[$i][0] ?>'><img src="image/<?php echo $sort[$i][0] ?>.jpg" /></a>
                                    <div class="bottom-middle"><a href='search.php?ID=<?php echo $sort[$i][0] ?>'><?php echo $sort[$i][0] ?></div></a>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="container-fluid" style="padding:70px;padding-top:20px">
                    <h5 style="color:#BF95FC;margin-top:15px;padding:10px">All Genre</h5>
                    <table class="table genre">
                        <tbody>
                            <?php
                            $arr = array('Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Isekai', 'Mecha', 'Mystery', 'Psychological', 'Romance', 'School', 'Sci-fi', 'Slice of Life', 'Supernatural', 'Thriller', 'Tragedy', 'Vampire');
                            for ($i = 0; $i < count($arr); $i++) {
                                $queryCountGenre = "SELECT COUNT(*) as total FROM mangaln WHERE genre LIKE '%" . $arr[$i] . "%'";
                                $resultCount = mysqli_query($link, $queryCountGenre);
                                $countGenre = mysqli_fetch_assoc($resultCount); ?>
                                <tr>
                                    <td><a href="search.php?ID=<?php echo $arr[$i] ?>"><?php echo $arr[$i] ?>&nbsp<span style="font-weight:600"></span><span style="color:#525252;font-size:12px;font-weight:600">&nbsp&nbsp-&nbsp&nbsp<?php echo $countGenre['total'] ?></span></a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js" integrity="sha512-iceXjjbmB2rwoX93Ka6HAHP+B76IY1z0o3h+N1PeDtRSsyeetU3/0QKJqGyPJcX63zysNehggFwMC/bi7dvMig==" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous"></script>

    <script>
        $('form').attr('autocomplete', 'off'); //turn off autocomplete
    </script>
</body>

</html>

<?php
}
?>