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
        <title> YOMI | Order History </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="css/userHomepage.css?V=5" rel="stylesheet">
    </head>
    <?php
    $host = "localhost";
    $userid = "root";
    $pass = "";
    $database = "yomi";

    $link = mysqli_connect($host, $userid, $pass, $database);

    $query1 = "SELECT * FROM user WHERE username = '" . $_SESSION["username"] . "'";
    $result1 = mysqli_query($link, $query1);

    $query2 = "SELECT * FROM orders WHERE username = '" . $_SESSION["username"] . "' ORDER BY order_date DESC";
    $result2 = mysqli_query($link, $query2);

    $query3 = "SELECT order_num FROM orders WHERE username = '" . $_SESSION["username"] . "' ORDER BY order_date DESC";
    $result3 = mysqli_query($link, $query3);

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
            <div class="container-fluid" style="padding:0;padding-top:20px;padding-bottom:20px;">
                <div class="card" style="background-color:#000000">
                    <div class="card-header" style="background-color:#181818;border-bottom:2px solid #5A2E98">
                        <div class="row">
                            <div class="col">
                                <p style="margin:0;font-size:20px;font-weight:500;color:#F5F5F5;">ORDER HISTORY</p>
                            </div>
                            <div class="col">
                                <div class="searchNav" style="width:300px;float:right">
                                    <span class="fa fa-search form-control-feedback"></span>
                                    <input type="search" class="form-control" placeholder="Search" name="Search" id="searchOrder" style="min-height: 38px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding:0px">
                        <div id="orders">
                            <table id="myOrders" class="table table-borderless">
                                <?php
                                if (mysqli_num_rows($result2) == 0) {
                                ?>
                                    <div class="no-result">
                                        <img src="image/yomiLogo3.png">
                                    </div>
                                    <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">You Haven't Ordered Anything Yet</h5>
                                <?php
                                } ?>
                                <tbody>
                                    <?php
                                    $currentDate = false;
                                    $order_total = 0;
                                    $x = 1;
                                    $i = 0;
                                    while ($nextrow = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
                                        $nextrows[] = $nextrow[$i];
                                    }

                                    while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
                                        $queryAddress = "SELECT * FROM addresses WHERE address_id = '$row2[address_id]' AND username = '" . $_SESSION["username"] . "'";
                                        $resultAddress = mysqli_query($link, $queryAddress);
                                        while ($rowAddress = mysqli_fetch_array($resultAddress, MYSQLI_BOTH)) {
                                            if ($row2['order_date'] != $currentDate) {
                                    ?>
                                                <tr style="background-color:#000000;">
                                                    <td colspan="5"></td>
                                                </tr>
                                                <tr style="background-color:#000000">
                                                    <th colspan="2" class="order_num" style="text-align:left;">ORDER ID:&nbsp&nbsp<span style="color:#BF95FC">#<?php echo $row2['order_num'] ?></span></th>
                                                    <th colspan="3" style="text-align:right;"><?php echo strtoupper(date("j M Y h:i A", strtotime($row2['order_date']))) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" style="text-align:left;background-color:#5A2E98">Delivery Address</th>
                                                </tr>
                                                <tr style="border-bottom:2px solid #3b3b3b">
                                                    <td colspan="5" style="text-align:left">
                                                        <span style="font-weight:600;font-size:20px"><?php echo $rowAddress['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp(+60) <?php echo $rowAddress['phone_number'] ?> <br>
                                                        <?php echo $rowAddress['street'] ?>, <?php echo $rowAddress['floor_unit'] ?> <br>
                                                        <?php echo $rowAddress['town_city'] ?>, <?php echo $rowAddress['postcode'] ?> <?php echo $rowAddress['state_region'] ?>
                                                    </td>
                                                </tr>
                                                <tr style="background-color:#1a1a1a">
                                                    <th> </th>
                                                    <th style="text-align:left;">PRODUCT</th>
                                                    <th>VOLUME</th>
                                                    <th>PRICE</th>
                                                    <th>QUANTITY</th>
                                                </tr>

                                            <?php
                                                $currentDate = $row2['order_date'];
                                            }
                                            ?>
                                            <tr>
                                                <td style="width:2%;padding:15px;">
                                                    <div class="container" style="width:100%;height:100%;">
                                                        <div class="cover"><img width="100px" height="150px" src="upload/<?php echo $row2['cover'] ?>" /></div>
                                                    </div>
                                                </td>
                                                <td class="title" style="width:68%;text-align:left;">
                                                    <span style="font-size:30px;font-weight:600;margin-bottom:0;"><?php echo $row2['title'] ?></span><br>
                                                    <?php echo $row2['alternative_title'] ?>
                                                    <span style="display:none"><?php echo $row2['order_num'] ?></span>
                                                    <!------ to let the fucntion know that this is a different id ------------>
                                                </td>
                                                <td style="width:10%">
                                                    <p style="margin:0;"><?php echo $row2['volume'] ?></p>
                                                </td>
                                                <td style="width:10%">
                                                    <p style="margin:0;">RM<?php echo $row2['price'] ?></p>
                                                </td>
                                                <td style="width:10%">
                                                    <p style="margin:0;">×<?php echo $row2['quantity'] ?></p>
                                                </td>
                                            </tr>
                                            <?php
                                            $order_total = $order_total + $row2['subtotal'];
                                            $total_payment = $order_total - $row2['discount'];
                                            if (!empty($nextrows[$x])) {
                                                if ($row2['order_num'] != $nextrows[$x]) { ?>
                                                    <tr style="border-top:1px solid #3b3b3b;font-weight:500">
                                                        <td colspan="3" style="text-align:right;padding:0;padding-top:20px;">Order Total:</td>
                                                        <td colspan="2" style="text-align:right;padding:0;padding-top:20px;padding-right:3%">RM<?php echo $order_total ?></td>
                                                    </tr>
                                                    <tr style="font-weight:500">
                                                        <td colspan="3" style="text-align:right;padding:0">Discount:</td>
                                                        <td colspan="2" style="text-align:right;padding:0;padding-right:3%">-RM<?php echo $row2['discount'] ?></td>
                                                    </tr>
                                                    <tr style="font-weight:500">
                                                        <td colspan="3" style="text-align:right;padding:0">Total Payment:</td>
                                                        <td colspan="2" style="text-align:right;padding:0;padding-right:3%">RM<?php echo $total_payment ?></td>
                                                    </tr>
                                                    <tr style="font-weight:500">
                                                        <td colspan="3" style="text-align:right;padding:0;padding-bottom:20px;">Payment Method:</td>
                                                        <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;padding-right:3%"><?php echo $row2['payment_method'] ?></td>
                                                    </tr>
                                                <?php
                                                    $order_total = 0;
                                                }
                                            }
                                            if (empty($nextrows[$x])) { ?>
                                                <tr style="border-top:1px solid #3b3b3b;font-weight:500">
                                                    <td colspan="3" style="text-align:right;padding:0;padding-top:20px;">Order Total:</td>
                                                    <td colspan="2" style="text-align:right;padding:0;padding-top:20px;padding-right:3%">RM<?php echo $order_total ?></td>
                                                </tr>
                                                <tr style="font-weight:500">
                                                    <td colspan="3" style="text-align:right;padding:0">Discount:</td>
                                                    <td colspan="2" style="text-align:right;padding:0;padding-right:3%">-RM<?php echo $row2['discount'] ?></td>
                                                </tr>
                                                <tr style="font-weight:500">
                                                    <td colspan="3" style="text-align:right;padding:0">Total Payment:</td>
                                                    <td colspan="2" style="text-align:right;padding:0;padding-right:3%">RM<?php echo $total_payment ?></td>
                                                </tr>
                                                <tr style="font-weight:500">
                                                    <td colspan="3" style="text-align:right;padding:0;padding-bottom:20px;">Payment Method:</td>
                                                    <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;padding-right:3%"><?php echo $row2['payment_method'] ?></td>
                                                </tr>
                                    <?php
                                                $order_total = 0;
                                            }
                                            $x = $x + 1;
                                        }
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
            <script>
                function mergeCells() {
                    let db = document.getElementById("myOrders");
                    let dbRows = db.rows;
                    let lastValue = "";
                    let lastCounter = 1;
                    let lastRow = 0;
                    for (let i = 0; i < dbRows.length; i++) {
                        let thisValue = dbRows[i].cells[0].innerHTML;
                        if (thisValue == lastValue) {
                            lastCounter++;
                            dbRows[lastRow].cells[0].rowSpan = lastCounter;
                            dbRows[i].cells[0].style.display = "none";
                        } else {
                            dbRows[i].cells[0].style.display = "table-cell";
                            lastValue = thisValue;
                            lastCounter = 1;
                            lastRow = i;
                        }
                    }
                }

                window.onload = mergeCells;
            </script>

            <script>
                $(document).ready(function() {

                    var topMatchTd;
                    var previousValue = "";
                    var rowSpan = 1;

                    $('.title').each(function() {

                        if ($(this).text() == previousValue) {
                            rowSpan++;
                            $(topMatchTd).attr('rowspan', rowSpan);
                            $(this).remove();
                        } else {
                            topMatchTd = $(this);
                            rowSpan = 1;
                        }

                        previousValue = $(this).text();
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    $("#searchOrder").on("keyup", function() {
                        var data = $(this).val();
                        var user = "<?php echo $_SESSION["username"] ?>";
                        $.ajax({
                            url: '/YOMI/searchOrder.php',
                            type: "POST",
                            data: {keyword:data,user:user},
                            success: function(response) {
                                $("#orders").html(response);
                            },
                            error: function(response) {
                                alert("Failed")
                            }
                        });
                    });
                });
            </script>

        <?php    }
        ?>
        </body>

    </html>

<?php
} else {
    header("Location:login.php");
}
?>