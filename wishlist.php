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
        <title> YOMI | Wishlist </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="css/userHomepage.css?V=2" rel="stylesheet">
    </head>
    <?php
    $host = "localhost";
    $userid = "root";
    $pass = "";
    $database = "yomi";

    $link = mysqli_connect($host, $userid, $pass, $database);

    $query1 = "SELECT * FROM user WHERE username = '" . $_SESSION["username"] . "'";
    $result1 = mysqli_query($link, $query1);

    $query2 = "SELECT * FROM wishlist WHERE username = '" . $_SESSION["username"] . "' ORDER BY wishlist_id DESC";
    $result2 = mysqli_query($link, $query2);

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
                        <li class="nav-item"> <a class="nav-link" href="userHomepage.php">HOME</a> </li>
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
            <div class="container-fluid" style="padding:0;padding-top:20px;">
                <div class="card">
                    <div class="card-header" style="background-color:#181818;border-bottom:2px solid #5A2E98">
                        <p style="margin:0;font-size:20px;font-weight:500;color:#F5F5F5">MY WISHLIST</p>
                    </div>
                    <div class="card-body" style="padding:20px">
                        <table style="text-align:left" class="table-hover">
                            <?php
                            if (mysqli_num_rows($result2) == 0) {
                            ?>
                                <div class="no-result">
                                    <img src="image/yomiLogo3.png">
                                </div>
                                <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">No Wishlist Yet</h5>
                                <?php
                            }

                            while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
                                $query3 = "SELECT * FROM mangaln WHERE mangaln_id = '$row2[mangaln_id]'";
                                $result3 = mysqli_query($link, $query3);
                                while ($row3 = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
                                ?>
                                    <tr>
                                        <td class="cartCover" style="width:120px;">
                                            <div style="display:flex;justify-content:center;">
                                                <a href="productDetails.php?ID=<?php echo $row3['mangaln_id'] ?>"><img src="upload/<?php echo $row3['cover'] ?>" /></a>
                                            </div>
                                        </td>
                                        <td style="vertical-align:top;padding-left:10px">
                                            <a href="productDetails.php?ID=<?php echo $row3['mangaln_id'] ?>">
                                                <p style="font-weight:600;font-size:25px;margin:0"><?php echo $row3['title'] ?></p>
                                                <p style="margin:0;"><?php echo $row3['alternative_title'] ?></p>
                                            </a>
                                            <span style="color:#F5F5F5">Genre:
                                                <?php
                                                $mark = explode(",", $row3['genre']); //remove "," from Tags table in database
                                                foreach ($mark as $out) {
                                                    echo "&nbsp<button class='btn-primary' style='margin-top:5px;'><a style='color:#F5F5F5;' href='search.php?ID=" . $out . "'> " . $out . "</a></button>";       //link based on tags
                                                }
                                                ?>
                                            </span>
                                        </td>
                                        <td style="width:5%;vertical-align:top;padding-top:20px">
                                            <span data-toggle="modal" data-target="#DeleteWishlistModal<?php echo $row2['wishlist_id']; ?>"><i class="fa fa-window-close"></i></span>
                                        </td>
                                    </tr>
                                    <!----  Delete Wishlist Modal  ----->
                                    <div class="modal fade DeleteModal" id="DeleteWishlistModal<?php echo $row2['wishlist_id']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Delete Wishlist Item</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="deleteWishlist.php" method="POST" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <h7> Are you sure you want to delete this from your wishlist? </h7>
                                                        <input type="hidden" name="wishlist_id" value="<?php echo $row2["wishlist_id"] ?>">
                                                        <input type="hidden" name="username" value="<?php echo $row1["username"] ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="deleteWishlist" value="Submit" class="btn btn-primary">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                        </table>
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
} else {
    header("Location:login.php");
}
?>