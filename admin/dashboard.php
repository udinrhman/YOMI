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
        <title> YOMI | Dashboard </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="../css/admin.css?V=1" rel="stylesheet">

        <style>
            p {
                margin: 0;
            }

            h3 {
                margin: 0;
            }

            .card-header {
                padding-left: 0;
                background-color: #181818;
            }

            .recentAdd tr:hover {
                cursor: pointer;
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

    while ($row1 = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
    ?>

        <body>
            <!-- NAVBAR -->
            <nav class="navbar navbar-expand-md navbar-custom sticky-top">
                <div class="container-fluid">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"> <a style="border-bottom: 2px solid #777AFF" class="nav-link" href="dashboard.php">DASHBOARD</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="sales.php">SALES</a> </li>
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
            <?php
            $querySales = "SELECT SUM(subtotal) as sales FROM ORDERS"; //Total Sales
            $resultSales = mysqli_query($link, $querySales);
            $sum = mysqli_fetch_assoc($resultSales);
            if (!is_Null($sum['sales'])) {
                $sums = $sum['sales'];
            } else {
                $sums = 0;
            }
            $queryProducts = "SELECT COUNT(mangaln_id) as products FROM mangaln"; //Number of Products
            $resultProducts = mysqli_query($link, $queryProducts);
            $products = mysqli_fetch_assoc($resultProducts);

            $queryUsers = "SELECT COUNT(username) as users FROM user WHERE username != 'admin'"; //Number of Users
            $resultUsers = mysqli_query($link, $queryUsers);
            $users = mysqli_fetch_assoc($resultUsers);

            $queryDonation = "SELECT SUM(yomi_tokens) as donation FROM donation"; //Donation Tokens
            $resultDonation = mysqli_query($link, $queryDonation);
            $donation = mysqli_fetch_assoc($resultDonation);
            ?>
            <div class="container-fluid" style="padding:0;padding-top:20px;padding-bottom:20px">
                <div class="card">
                    <div class="card-header" style="padding-left: 20px;background-color:#181818;border-bottom:2px solid #777AFF">
                        <p>DASHBOARD</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header" style="padding-left:20px;background-color:#01A65D">
                                        <h3 style="font-weight:600;text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.527);">RM<?php echo $sums ?></h3>
                                        <p style="text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.527)">Total Sales</p>
                                    </div>
                                    <a href="sales.php">
                                        <div class="card-footer" style="background-color:#019554">
                                            <p style="text-align:center">MORE INFO</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-header" style="padding-left:20px;background-color:#8FB2FF">
                                        <h3 style="font-weight:600;text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.527);"><?php echo $products['products'] ?></h3>
                                        <p style="text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.527)">Number of Products</p>
                                    </div>
                                    <a href="products.php">
                                        <div class="card-footer" style="background-color:#6E9AFC">
                                            <p style="text-align:center">MORE INFO</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-header" style="padding-left:20px;background-color:#A1A2FF">
                                        <h3 style="font-weight:600;text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.527);"><?php echo $users['users'] ?></h3>
                                        <p style="text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.527)">Number of Users</p>
                                    </div>
                                    <a href="users.php">
                                        <div class="card-footer" style="background-color:#8B8DFF">
                                            <p style="text-align:center">MORE INFO</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-header" style="padding-left:20px;background-color:#5A2E98">
                                        <h3 style="font-weight:600;text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.527);"><?php echo $donation['donation'] ?></h3>
                                        <p style="text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.527)">Donation Tokens</p>
                                    </div>
                                    <a href="donate.php">
                                        <div class="card-footer" style="background-color:#4D2981">
                                            <p style="text-align:center">MORE INFO</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card" style="padding-top:20px;border:none">
                            <div class="card-header">RECENT SALES</div>
                            <table id="myOrders" class="table table-borderless" style="background-color:#000000">
                                <?php
                                $countOrderNum = "SELECT COUNT(*) as limits FROM orders GROUP BY order_num ORDER BY order_date LIMIT 1"; //to count how many books ordered in 1 order number
                                $resultOrderNum = mysqli_query($link, $countOrderNum);
                                $limit = mysqli_fetch_assoc($resultOrderNum);

                                if (!empty($limit)) {
                                    $query2 = "SELECT * FROM orders HAVING order_num = order_num ORDER BY order_date DESC LIMIT $limit[limits]";
                                    $result2 = mysqli_query($link, $query2);

                                    $query3 = "SELECT order_num FROM orders HAVING order_num = order_num ORDER BY order_date DESC LIMIT $limit[limits]";
                                    $result3 = mysqli_query($link, $query3);
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
                                            while ($rowUser = mysqli_fetch_array($resultUser, MYSQLI_BOTH)) {
                                                if ($row2['order_date'] != $currentDate) {
                                        ?>
                                                    <tr style="background-color:#000000;">
                                                        <td colspan="5"></td>
                                                    </tr>
                                                    <tr style="background-color:#000000">
                                                        <th colspan="2" style="text-align:left;"><img src="../<?php echo $rowUser['user_image'] ?>" class="rounded-circle" width="37" height="37" style="margin-top:2px;object-fit:cover;">&nbsp&nbsp&nbsp<?php echo $row2['username'] ?></th>
                                                        <th colspan="3" style="text-align:right;padding-top:20px"><?php echo strtoupper(date("j M Y h:i A", strtotime($row2['order_date']))) ?></th>
                                                    </tr>

                                                    <tr>
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
                                                    <td class="title" style="text-align:left;">
                                                        <p style="font-size:20px;font-weight:600;margin-bottom:0;"><?php echo $row2['title'] ?></p>
                                                        <p><?php echo $row2['alternative_title'] ?></p>
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
                                    } else { ?>
                                        <td>No Users Ordered Anything Yet!</td>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                            </table>
                            <div class="card-foooter">
                                <a href="sales.php">
                                    <button class="btn btn-primary" style="float:right;margin-top:20px">VIEW MORE</button>
                                </a>
                            </div>
                        </div>

                        <div class="card recentAdd" style="padding-top:20px;border:none">
                            <div class="card-header">
                                <p>RECENTLY ADDED PRODUCT</p>
                            </div>
                            <table style="background-color:#000000">
                                <?php
                                $queryRecentProduct = "SELECT * FROM mangaln ORDER BY mangaln_id DESC LIMIt 1"; //Recently Added Product
                                $resultRecentProduct = mysqli_query($link, $queryRecentProduct);
                                while ($recent = mysqli_fetch_array($resultRecentProduct, MYSQLI_BOTH)) {
                                ?>
                                    <tr onclick="window.location='productDetails.php?ID=<?php echo $recent['mangaln_id'] ?>';">
                                        <td style="width:100px;padding:15px;">
                                            <div class="container" style="width:100%;height:100%;">
                                                <div class="cover"><img width="100px" height="150px" src="../upload/<?php echo $recent['cover'] ?>" /></div>
                                            </div>
                                        </td>
                                        <td style="text-align:left">
                                            <p style="font-size:30px;font-weight:600;margin-top:-10px;"><?php echo $recent['title'] ?></p>
                                            <p><?php echo $recent['alternative_title'] ?></p>
                                            <p>Author: <?php echo $recent['author'] ?></p>
                                            <p>Type: <?php echo $recent['type'] ?></p>
                                            <span style="color:#F5F5F5">Genre:
                                                <?php
                                                $mark = explode(",", $recent['genre']); //remove "," from Genre table in database
                                                foreach ($mark as $out) {
                                                    echo "&nbsp<button class='btn-primary' style='margin-top:5px;border:none'>" . $out . "</button>";       //link based on tags
                                                }
                                                ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <div class="card-foooter">
                                <a href="products.php">
                                    <button class="btn btn-primary" style="float:right;margin-top:20px">VIEW MORE</button>
                                </a>
                            </div>
                        </div>

                        <div class="card" style="padding-top:20px;border:none">
                            <div class="card-header">
                                <p>RECENTLY REGISTERED USERS</p>
                            </div>
                            <?php
                            $queryRecentUser = "SELECT * FROM user WHERE username != 'admin' ORDER BY register_date DESC LIMIt 3"; //Recently Registered Users
                            $resultRecentUser = mysqli_query($link, $queryRecentUser);
                            while ($recentUser = mysqli_fetch_array($resultRecentUser, MYSQLI_BOTH)) {
                            ?>
                                <div class="row" style="background-color:#000000;margin:0;">
                                    <a href="dynamicProfile.php?ID=<?php echo $recentUser['username'] ?>">
                                        <img src="../<?php echo $recentUser['user_image'] ?>" class="rounded-circle" width="37" height="37" style="margin:10px;object-fit:cover;">
                                        <span style="padding-top:15px"><?php echo $recentUser['username'] ?></span>
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="card-foooter">
                                <a href="users.php">
                                    <button class="btn btn-primary" style="float:right;margin-top:20px">VIEW MORE</button>
                                </a>
                            </div>
                        </div>

                        <div class="card" style="padding-top:20px;border:none">
                            <div class="card-header">
                                <p>RECENT DONATIONS</p>
                            </div>
                            <?php
                            $queryRecentDonate = "SELECT * FROM donation ORDER BY donation_id DESC LIMIt 3"; //Recently Donations
                            $resultRecentDonate = mysqli_query($link, $queryRecentDonate);
                            while ($recentDonate = mysqli_fetch_array($resultRecentDonate, MYSQLI_BOTH)) {
                            ?>
                                <div class="row" style="background-color:#000000;margin:0;">
                                    <a href="dynamicProfile.php?ID=<?php echo $recentDonate['username'] ?>">
                                        <p style="margin:10px"><span style="color:#8AAEFF"><?php echo $recentDonate['username'] ?></span>&nbsp&nbsp&nbsp donated <?php echo $recentDonate['yomi_tokens'] ?> YOMI Tokens</p>
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="card-foooter">
                                <a href="donate.php">
                                    <button class="btn btn-primary" style="float:right;margin-top:20px">VIEW MORE</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
        ?>
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
        </body>

    </html>

<?php
} else {
    header("Location:login.php");
}
?>