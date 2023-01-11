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
        <title> YOMI | Manga & Light Novels </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>


        <link href="css/bootstrap-select.min.css" rel="stylesheet">
        <link href="css/userHomepage.css?V=1" rel="stylesheet">
        <style>
            .dropdown-item {
                padding-left: 0;
                color: #fff;
            }

            .dropdown-item:hover {
                background-color: transparent;
                color: #fff;
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
                        <li class="nav-item"> <a style="border-bottom: 2px solid #5A2E98" class="nav-link" href="mangaln.php">MANGA & LN</a> </li>
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
            <!-- Image Grid -->
            <div class="card books" style="margin-top:20px;">
                <div class="card-body" style="padding-left:0px;padding-right:0px;margin:0;position:relative">
                    <div id="filters" style="position:absolute;right:0;top:0;margin-right:6.5%">
                        <select name="type" id="type" class="selectpicker" data-width="150">
                            <option value="All" selected>All</option>
                            <option value="Manga">Manga</option>
                            <option value="Light Novel">Light Novel</option>
                        </select>
                        <input type="hidden" id="viewmoreType" value="">
                    </div>
                    <div id="filter">
                        <?php
                        $query2 = "SELECT * FROM mangaln ORDER BY title LIMIT 15";
                        $result2 = mysqli_query($link, $query2);

                        $countAll = "SELECT * FROM mangaln ORDER BY title";
                        $resultCount = mysqli_query($link, $countAll);
                        $countmanga = mysqli_num_rows($resultCount);

                        if (mysqli_num_rows($result2) == 0) {
                        ?>
                            <div class="no-result">
                                <img src="image/yomiLogo3.png">
                            </div>
                            <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">No Manga</h5>
                        <?php
                        }
                        ?>
                        <p class="card-text" style="color:#c0c0c0;float:left;margin-left:1%;"><?php echo $countmanga ?> result for <strong>All</strong></p><br>
                        <div id="mainparent">
                            <div class="centerized">
                                <div class="row">
                                    <div class="col-12">
                                        <?php while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
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
                                            $id = $row2['title'];
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" id="remove_row">
                                        <button style="width:100%;background-color:transparent;color:#BF95FC;border:none;margin-top:30px;outline:none" id="view_more" data-id="<?php echo $id; ?>">VIEW MORE</button>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!--Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js" integrity="sha512-iceXjjbmB2rwoX93Ka6HAHP+B76IY1z0o3h+N1PeDtRSsyeetU3/0QKJqGyPJcX63zysNehggFwMC/bi7dvMig==" crossorigin="anonymous"></script>

        <script type="text/javascript" src="js/bootstrap-select.min.js"></script>
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
            $(document).ready(function() {
                $(document).on('click', '#view_more', function(event) {
                    event.preventDefault();

                    var id = $('#view_more').data('id');
                    var viewmoreType = $('#viewmoreType').val();

                    $.ajax({
                        url: "/YOMI/loadMangaln.php",
                        type: "post",
                        data: {
                            id: id,
                            viewmoreType: viewmoreType,
                        },
                        success: function(response) {
                            $('#remove_row').remove();
                            $('.centerized').append(response);
                        }
                    });

                });
            });
        </script>
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
        <script>
            $(document).ready(function() {
                $("#type").change(function() {
                    var data = $(this).find(":selected").val();
                    $('#viewmoreType').val(data);
                    $.ajax({
                        url: '/YOMI/filterProduct.php',
                        type: "POST",
                        data: 'type=' + data,
                        success: function(response) {
                            $("#filter").html(response);
                        },
                        error: function(response) {
                            alert("Failed")
                        }
                    });
                });
            });
        </script>


        </body>

    </html>

<?php

} else {
    header("Location:login.php");
}
?>