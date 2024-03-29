<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION["username"])) {
?>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shotcut icon" href="../image/yomiLogo3.png" type="image/png">
        <title> YOMI | Sales </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="../css/admin.css" rel="stylesheet">
    </head>
    <?php
    $host = "localhost";
    $userid = "root";
    $pass = "";
    $database = "yomi";

    $link = mysqli_connect($host, $userid, $pass, $database);

    $query1 = "SELECT * FROM user WHERE username = '" . $_SESSION["username"] . "'";
    $result1 = mysqli_query($link, $query1);

    $query2 = "SELECT * FROM orders HAVING order_num = order_num ORDER BY order_date DESC";
    $result2 = mysqli_query($link, $query2);

    $query3 = "SELECT order_num FROM orders HAVING order_num = order_num ORDER BY order_date DESC";
    $result3 = mysqli_query($link, $query3);

    while ($row1 = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
    ?>

        <body>
            <!-- NAVBAR -->
            <nav class="navbar navbar-expand-md navbar-custom sticky-top">
                <div class="container-fluid">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"> <a class="nav-link" href="dashboard.php">DASHBOARD</a> </li>
                        <li class="nav-item"> <a style="border-bottom: 2px solid #777AFF" class="nav-link" href="sales.php">SALES</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="products.php">PRODUCTS</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="users.php">USERS</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="news.php">NEWS</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="donate.php">DONATE</a> </li>
                    </ul>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ml-auto">
                            <img src="../<?php echo $row1['user_image'] ?>" class="rounded-circle" width="37" height="37" style="margin-top:2px;object-fit:cover;">
                            <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <?php echo $row1['user_fullname'] ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <a href="../logout.php">
                                        <li>LOGOUT</li>
                                    </a>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid" style="padding:0;padding-top:20px;padding-bottom:20px;">
                <div class="card" style="background-color:#000000">
                    <div class="card-body" style="padding:0px">
                        <div class="card-header" style="background-color:#181818;border-bottom:2px solid #777AFF">
                            <div class="row">
                                <div class="col">
                                    <p style="margin:0">SALES</p>
                                </div>
                                <div class="col">
                                    <div class="searchNav" style="width:300px;float:right">
                                        <span class="fa fa-search form-control-feedback"></span>
                                        <input type="search" class="form-control" placeholder="Search" name="Search" id="searchOrder" style="min-height: 38px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="orders">
                            <table id="myOrders" class="table table-borderless table-hover">
                                <?php
                                if (mysqli_num_rows($result2) == 0) {
                                ?>
                                    <div class="no-result">
                                        <img src="../image/yomiLogo3.png">
                                    </div>
                                    <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">No Users Ordered Anything Yet!</h5>
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
                                        $queryUser = "SELECT * FROM user WHERE username = '$row2[username]' ";
                                        $resultUser = mysqli_query($link, $queryUser);
                                        $queryAddress = "SELECT * FROM addresses WHERE address_id = '$row2[address_id]'";
                                        $resultAddress = mysqli_query($link, $queryAddress);
                                        while ($rowUser = mysqli_fetch_array($resultUser, MYSQLI_BOTH)) {
                                            while ($rowAddress = mysqli_fetch_array($resultAddress, MYSQLI_BOTH)) {
                                                if ($row2['order_date'] != $currentDate) {
                                    ?>
                                                    <tr style="background-color:#777AFF">
                                                        <th colspan="2" class="order_num" style="text-align:left;">
                                                            <img src="../<?php echo $rowUser['user_image'] ?>" class="rounded-circle" width="37" height="37" style="margin-top:2px;object-fit:cover;">
                                                            &nbsp&nbsp&nbsp<?php echo $row2['username'] ?>&nbsp&nbsp&nbsp | &nbsp&nbsp&nbsp
                                                            ORDER ID:&nbsp&nbsp<span style="color:#AAC4FF">#<?php echo $row2['order_num'] ?></span>
                                                        </th>
                                                        <th colspan="3" style="text-align:right;padding-top:20px"><?php echo strtoupper(date("j M Y h:i A", strtotime($row2['order_date']))) ?></th>
                                                    </tr>
                                                    <tr style="background-color:#28282B">
                                                        <th colspan="5" style="text-align:left">Delivery Address</th>
                                                    </tr>
                                                    <tr style="border-bottom:2px solid #3b3b3b">
                                                        <td colspan="5" style="text-align:left;padding:10px">
                                                            <span style="font-weight:600;font-size:20px"><?php echo $rowAddress['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp(+60) <?php echo $rowAddress['phone_number'] ?> <br>
                                                            <?php echo $rowAddress['street'] ?>, <?php echo $rowAddress['floor_unit'] ?> <br>
                                                            <?php echo $rowAddress['town_city'] ?>, <?php echo $rowAddress['postcode'] ?> <?php echo $rowAddress['state_region'] ?>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color:#28282B">
                                                        <th style="text-align:left;">PRODUCT</th>
                                                        <th>VOLUME</th>
                                                        <th>PRICE</th>
                                                        <th>QUANTITY</th>
                                                    </tr>

                                                <?php
                                                    $currentDate = $row2['order_date'];
                                                }
                                                ?>
                                                <tr style="cursor:pointer" onclick="window.location='productDetails.php?ID=<?php echo $row2['mangaln_id'] ?>';">
                                                    <td class="title" style="width:68%;text-align:left;">
                                                        <p style="font-size:20px;font-weight:600;margin-bottom:0;"><?php echo $row2['title'] ?></p>
                                                        <p><?php echo $row2['alternative_title'] ?></p>
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
                                                            <td colspan="2" style="text-align:right;padding:0;padding-top:20px;">Order Total:</td>
                                                            <td colspan="2" style="text-align:right;padding:0;padding-top:20px;padding-right:3%">RM<?php echo $order_total ?></td>
                                                        </tr>
                                                        <tr style="font-weight:500">
                                                            <td colspan="2" style="text-align:right;padding:0">Discount:</td>
                                                            <td colspan="2" style="text-align:right;padding:0;padding-right:3%">-RM<?php echo $row2['discount'] ?></td>
                                                        </tr>
                                                        <tr style="font-weight:500">
                                                            <td colspan="2" style="text-align:right;padding:0">Total Payment:</td>
                                                            <td colspan="2" style="text-align:right;padding:0;padding-right:3%">RM<?php echo $total_payment ?></td>
                                                        </tr>
                                                        <tr style="font-weight:500">
                                                            <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;">Payment Method:</td>
                                                            <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;padding-right:3%"><?php echo $row2['payment_method'] ?></td>
                                                        </tr>
                                                    <?php
                                                        $order_total = 0;
                                                    }
                                                }
                                                if (empty($nextrows[$x])) { ?>
                                                    <tr style="border-top:1px solid #3b3b3b;font-weight:500">
                                                        <td colspan="2" style="text-align:right;padding:0;padding-top:20px;">Order Total:</td>
                                                        <td colspan="2" style="text-align:right;padding:0;padding-top:20px;padding-right:3%">RM<?php echo $order_total ?></td>
                                                    </tr>
                                                    <tr style="font-weight:500">
                                                        <td colspan="2" style="text-align:right;padding:0">Discount:</td>
                                                        <td colspan="2" style="text-align:right;padding:0;padding-right:3%">-RM<?php echo $row2['discount'] ?></td>
                                                    </tr>
                                                    <tr style="font-weight:500">
                                                        <td colspan="2" style="text-align:right;padding:0">Total Payment:</td>
                                                        <td colspan="2" style="text-align:right;padding:0;padding-right:3%">RM<?php echo $total_payment ?></td>
                                                    </tr>
                                                    <tr style="font-weight:500">
                                                        <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;">Payment Method:</td>
                                                        <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;padding-right:3%"><?php echo $row2['payment_method'] ?></td>
                                                    </tr>
                                    <?php
                                                    $order_total = 0;
                                                }
                                                $x = $x + 1;
                                            }
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
                        $.ajax({
                            url: '/YOMI/admin/searchOrder.php',
                            type: "POST",
                            data: {
                                keyword: data,
                            },
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
    header("Location:../login.php");
}
?>