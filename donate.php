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
        <title> YOMI | Donate </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="css/userHomepage.css?V=1" rel="stylesheet">
    </head>
    <?php
    $host = "localhost";
    $userid = "root";
    $pass = "";
    $database = "yomi";

    $link = mysqli_connect($host, $userid, $pass, $database);

    $query1 = "SELECT * FROM user WHERE username = '" . $_SESSION["username"] . "'";
    $result1 = mysqli_query($link, $query1);

    $query2 = "SELECT *, SUM(yomi_tokens) as token_sum FROM donation GROUP BY username ORDER BY token_sum DESC LIMIT 3";
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
                        <li class="nav-item"> <a style="border-bottom: 2px solid #5A2E98" class="nav-link" href="donate.php">DONATE</a> </li>
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
                                    <li class="token">YOMI TOKENS:&nbsp&nbsp<span id="token"><?php echo $row1['yomi_tokens'] ?></span>&nbsp&nbsp</li>
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
            <!-- CART ICON -->
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
            <div id="result" style="background-color:#BF95FC;color:#5A2E98;border:none"></div>
            <div class="container-fluid" style="padding:0;padding-top:20px;">
                <div class="card" style="background-color:#000000">
                    <div class="card-body" style="padding:0">
                        <div class="row" style="background-color:#5A2E98;margin:5px;">
                            <div class="col-10" style="padding:20px;">
                                <span style="font-size:30px;font-weight:600;color:#F5F5F5">YOMI TOKENS</span>
                            </div>
                            <div class="col-2" style="padding:10px;">
                                <div class="row">
                                    <div class="col" style="color:#F5F5F5">
                                        YOUR BALANCE:<br>
                                        <span id="balance" style="font-size:25px;font-weight:600;padding:0;text-align:right"><?php echo $row1['yomi_tokens'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="container-fluid" style="padding:5px">
                            <table class="table table-borderless" id="top3" style="border-radius:5px">
                                <th colspan="3" style="text-align:left;font-size:20px;">
                                    TOP 3 DONATORS
                                </th>
                                <?php
                                while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
                                    $query3 = "SELECT * FROM user WHERE username = '$row2[username]'";
                                    $result3 = mysqli_query($link, $query3);
                                    while ($row3 = mysqli_fetch_array($result3, MYSQLI_BOTH)) { ?>
                                        <tr style='cursor: pointer;' onclick="window.location='dynamicProfile.php?ID=<?php echo $row3['username'] ?>';">
                                            <td style="width:100px;padding:20px">
                                                <img src="<?php echo $row3['user_image'] ?>" class="rounded-circle" width="80" height="80" style="object-fit:cover;">
                                            </td>
                                            <td style="text-align:left;padding-top:35px;padding-bottom:35px;">
                                                <span style="font-size:30px;font-weight:600"><?php echo $row2['username'] ?><span>
                                            </td>
                                            <td style="text-align:right;width:400px;padding:35px">
                                                <span style="font-size:30px;font-weight:600"><?php echo $row2['token_sum'] ?> YOMI TOKENS</span>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                        <br>
                        <div class="row" style="background-color:#BF95FC;margin:5px;border-radius:5px">
                            <div class="col" style="padding:20px;">
                                <span style="font-size:20px;font-weight:500;color:#5A2E98">INTRODUCING YOMI TOKENS!</span><br>
                                <span style="color:#5A2E98">You'll earn 10 YOMI tokens for every amount of manga or light novel you purchased. Each 10 YOMI tokens = RM1.<br>Use your tokens to donate to manga & light novel translators or fully redeem it as discount when buying manga or light novels from us!</span>
                            </div>
                        </div>
                        <form method="POST" id="donate_form">
                            <div class="row" style="background-color:#181818;margin:5px;border-radius:5px">

                                <div class="col-2" style="padding:20px;">
                                    <span style="font-size:30px;font-weight:500;">DONATE NOW:</span>
                                </div>
                                <div class="col-2" style="padding:20px;">
                                    <span style="float:left"><input type="number" id="yomi_tokens" name="yomi_tokens" value="10" min="10" max="<?php echo $row1['yomi_tokens'] ?>" step="10" pattern="[0-9]*"></span>
                                </div>
                                <div class="col" style="padding:10px;">
                                    <input type="hidden" id="username" value="<?php echo $row1['username'] ?>" name="username">
                                    <span style="float:right;padding:20px"><input class="btn btn-primary" type="submit" name="donate" value="DONATE"></span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="container-fluid" style="padding-left:5px;padding-right:5px;padding-top:20px;">
                <div class="card">
                    <div class="card-header" style="background-color:#202020">
                        <div class="card-title" style="margin-bottom:0">RECENT DONATIONS</div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid" style="padding:0" id="recentDonate">
                            <?php
                            $queryDonation = "SELECT * FROM donation ORDER BY donation_id DESC LIMIT 4";
                            $resultDonation = mysqli_query($link, $queryDonation);
                            while ($donation = mysqli_fetch_array($resultDonation, MYSQLI_BOTH)) {
                            ?>
                                <p><a href="dynamicProfile.php?ID=<?php echo $donation['username'] ?>"><span style="color:#BF95FC;font-weight:500;"><?php echo $donation['username'] ?></a></span>&nbsp&nbsp&nbsp donated <?php echo $donation['yomi_tokens'] ?> YOMI Tokens</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid" style="padding-left:5px;padding-right:5px;padding-top:20px;padding-bottom:20px;">
                <div class="card">
                    <div class="card-header" style="background-color:#202020">
                        <div class="card-title" style="margin-bottom:0">LIST OF MANGA & LIGHT NOVEL TRANSLATOR GROUPS</div>
                    </div>
                    <div class="card-body">
                        <p>Alpa Scans</p>
                        <p>Dynasty-Scans</p>
                        <p>Disaster Scans</p>
                        <p>Harmless Monsters</p>
                        <p>KS Group</p>
                        <p>LH Translation</p>
                        <p>Maru Scans</p>
                        <p>Purple Cress</p>
                    </div>
                </div>
            </div>
            <!--Scripts -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js" integrity="sha512-iceXjjbmB2rwoX93Ka6HAHP+B76IY1z0o3h+N1PeDtRSsyeetU3/0QKJqGyPJcX63zysNehggFwMC/bi7dvMig==" crossorigin="anonymous"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous"></script>
            <script type="text/javascript" src="js/bootstrap-input-spinner.js"></script>

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
                $('input[type=number]').inputSpinner();
            </script>

            <script>
                $(document).ready(function() {
                    $('#donate_form').submit(function(e) {
                        e.preventDefault(); //prevent from refreshing]
                        var data = $('#donate_form').serialize() + '&donate=donate';
                        $.ajax({
                            url: '/YOMI/donation.php',
                            type: 'post',
                            data: data,
                            success: function(response) {
                                $('#result').text(response); //receive result message from php
                                $("#balance").load(" #balance")
                                $("#top3").load(" #top3")
                                $("#token").load(" #token")
                                $("#recentDonate").load(" #recentDonate")
                                $("#result").addClass('alert alert-success')
                                $("#result").show().delay(200).addClass("in").fadeOut(3500);
                                $('#yomi_tokens').val('10');
                            },
                            error: function(response) {
                                alert("Failed")
                            }
                        });
                    });
                });
            </script>

        <?php
    }
        ?>
        </body>

    </html>

<?php
} else {
?>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shotcut icon" href="image/yomiLogo3.png" type="image/png">
        <title> YOMI | Donate </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="css/userHomepage.css?V=1" rel="stylesheet">
    </head>
    <?php
    $host = "localhost";
    $userid = "root";
    $pass = "";
    $database = "yomi";

    $link = mysqli_connect($host, $userid, $pass, $database);


    $query2 = "SELECT *, SUM(yomi_tokens) as token_sum FROM donation GROUP BY username ORDER BY token_sum DESC LIMIT 3";
    $result2 = mysqli_query($link, $query2);
    ?>

    <body>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-md navbar-custom sticky-top">
            <div class="container-fluid">
                <!-- LOGO -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"> <a class="nav-link" href="homepage.php">HOME</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="mangaln.php">MANGA & LN</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="genre.php">GENRE</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="news.php">NEWS</a> </li>
                    <li class="nav-item"> <a style="border-bottom: 2px solid #5A2E98" class="nav-link" href="donate.php">DONATE</a> </li>
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

        <div id="result" style="background-color:#BF95FC;color:#5A2E98;border:none"></div>
        <div class="container-fluid" style="padding:0;padding-top:20px;">
            <div class="card" style="background-color:#000000">
                <div class="card-body" style="padding:0">
                    <div class="row" style="background-color:#5A2E98;margin:5px;">
                        <div class="col-12" style="padding:20px;">
                            <?php
                            $queryToken = "SELECT SUM(yomi_tokens) as token FROM donation"; //Total YOMI tokens received
                            $resultToken = mysqli_query($link, $queryToken);
                            $sum = mysqli_fetch_assoc($resultToken);
                            if (!is_Null($sum['token'])) {
                                $tokens = $sum['token'];
                            } else {
                                $tokens = 0;
                            }
                            ?>
                            <span style="font-size:50px;font-weight:600;color:#F5F5F5"><?php echo $tokens ?></span> <br>
                            <span style="font-size:20px;font-weight:500;color:#F5F5F5">YOMI Tokens Donated</span>
                        </div>
                    </div>
                    <br>
                    <div class="container-fluid" style="padding:5px">
                        <table class="table table-borderless" id="top3" style="border-radius:5px">
                            <th colspan="3" style="text-align:left;font-size:20px;">
                                TOP 3 DONATORS
                            </th>
                            <?php
                            while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
                                $query3 = "SELECT * FROM user WHERE username = '$row2[username]'";
                                $result3 = mysqli_query($link, $query3);
                                while ($row3 = mysqli_fetch_array($result3, MYSQLI_BOTH)) { ?>
                                    <tr style='cursor: pointer;' onclick="window.location='dynamicProfile.php?ID=<?php echo $row3['username'] ?>';">
                                        <td style="width:100px;padding:20px">
                                            <img src="<?php echo $row3['user_image'] ?>" class="rounded-circle" width="80" height="80" style="object-fit:cover;">
                                        </td>
                                        <td style="text-align:left;padding-top:35px;padding-bottom:35px;">
                                            <span style="font-size:30px;font-weight:600"><?php echo $row2['username'] ?><span>
                                        </td>
                                        <td style="text-align:right;width:400px;padding:35px">
                                            <span style="font-size:30px;font-weight:600"><?php echo $row2['token_sum'] ?> YOMI TOKENS</span>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <br>
                    <div class="row" style="background-color:#BF95FC;margin:5px;border-radius:5px">
                        <div class="col" style="padding:20px;">
                            <span style="font-size:20px;font-weight:500;color:#5A2E98">INTRODUCING YOMI TOKENS!</span><br>
                            <span style="color:#5A2E98">You'll earn 10 YOMI tokens for every amount of manga or light novel you purchased. Each 10 YOMI tokens = RM1.<br>Use your tokens to donate to manga & light novel translators or fully redeem it as discount when buying manga or light novels from us!</span>
                        </div>
                    </div>
                    <div class="row" style="background-color:#181818;margin:5px;border-radius:5px">
                        <div class="col-2" style="padding:20px;">
                            <span style="font-size:30px;font-weight:500;">DONATE NOW:</span>
                        </div>
                        <div class="col-2" style="padding:20px;">
                            <span style="float:left"><input type="number" id="yomi_tokens" name="yomi_tokens" value="10" min="10" max="10" step="10" pattern="[0-9]*" readonly></span>
                        </div>
                        <div class="col" style="padding:10px;">
                            <a href="login.php"><span style="float:right;padding:20px"><button class="btn btn-primary">DONATE</button></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid" style="padding-left:5px;padding-right:5px;padding-top:20px;">
            <div class="card">
                <div class="card-header" style="background-color:#202020">
                    <div class="card-title" style="margin-bottom:0">RECENT DONATIONS</div>
                </div>
                <div class="card-body">
                    <div class="container-fluid" style="padding:0" id="recentDonate">
                        <?php
                        $queryDonation = "SELECT * FROM donation ORDER BY donation_id DESC LIMIT 4";
                        $resultDonation = mysqli_query($link, $queryDonation);
                        while ($donation = mysqli_fetch_array($resultDonation, MYSQLI_BOTH)) {
                        ?>
                            <p><a href="dynamicProfile.php?ID=<?php echo $donation['username'] ?>"><span style="color:#BF95FC;font-weight:500;"><?php echo $donation['username'] ?></a></span>&nbsp&nbsp&nbsp donated <?php echo $donation['yomi_tokens'] ?> YOMI Tokens</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid" style="padding-left:5px;padding-right:5px;padding-top:20px;padding-bottom:20px;">
            <div class="card">
                <div class="card-header" style="background-color:#202020">
                    <div class="card-title" style="margin-bottom:0">LIST OF MANGA & LIGHT NOVEL TRANSLATOR GROUPS</div>
                </div>
                <div class="card-body">
                    <p>Alpa Scans</p>
                    <p>Dynasty-Scans</p>
                    <p>Disaster Scans</p>
                    <p>Harmless Monsters</p>
                    <p>KS Group</p>
                    <p>LH Translation</p>
                    <p>Maru Scans</p>
                    <p>Purple Cress</p>
                </div>
            </div>
        </div>
        <!--Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js" integrity="sha512-iceXjjbmB2rwoX93Ka6HAHP+B76IY1z0o3h+N1PeDtRSsyeetU3/0QKJqGyPJcX63zysNehggFwMC/bi7dvMig==" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/bootstrap-input-spinner.js"></script>

        <script>
            $('form').attr('autocomplete', 'off'); //turn off autocomplete
        </script>

        <script>
            $('input[type=number]').inputSpinner();
        </script>
    </body>

    </html>

<?php
}
?>