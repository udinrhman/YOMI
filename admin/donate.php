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
        <title> YOMI | Donate </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="../css/admin.css?V=1" rel="stylesheet">

        <style>
            #top3 tr:hover td {
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

    $query2 = "SELECT *, SUM(yomi_tokens) as token_sum FROM donation GROUP BY username ORDER BY token_sum DESC LIMIT 3";
    $result2 = mysqli_query($link, $query2);

    $countCart = "SELECT count(*) as total FROM cart WHERE username = '" . $_SESSION["username"] . "'";
    $resultCart = mysqli_query($link, $countCart);
    $data = mysqli_fetch_assoc($resultCart);
    while ($row1 = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
    ?>

        <body>
            <!-- NAVBAR -->
            <nav class="navbar navbar-expand-md navbar-custom sticky-top">
                <div class="container-fluid">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"> <a class="nav-link" href="dashboard.php">DASHBOARD</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="sales.php">SALES</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="products.php">PRODUCTS</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="users.php">USERS</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="news.php">NEWS</a> </li>
                        <li class="nav-item"> <a class="nav-link" style="border-bottom: 2px solid #777AFF" href="donate.php">DONATE</a> </li>
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

            <div id="result" style="background-color:#BF95FC;color:#5A2E98;border:none"></div>
            <div class="container-fluid" style="padding:0;padding-top:20px;">
                <div class="card" style="background-color:#000000">
                    <div class="card-body" style="padding:0">
                        <div class="row" style="background-color:#777AFF;margin:0px;border-radius:5px">
                            <div class="col-10" style="padding:20px;">
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
                                <span style="font-size:50px;font-weight:600"><?php echo $tokens ?></span> <br>
                                <span style="font-size:20px;font-weight:500">YOMI Tokens received</span>
                            </div>
                        </div>
                        <div class="container-fluid" style="padding:0;padding-top:20px">
                            <table class="table table-borderless" id="top3" style="border-radius:5px">
                                <th colspan="3" style="text-align:left;font-size:20px;">
                                    TOP 3 DONATORS
                                </th>
                                <?php
                                while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
                                    $query3 = "SELECT * FROM user WHERE username = '$row2[username]'";
                                    $result3 = mysqli_query($link, $query3);
                                    while ($row3 = mysqli_fetch_array($result3, MYSQLI_BOTH)) { ?>
                                        <tr onclick="window.location='dynamicProfile.php?ID=<?php echo $row3['username'] ?>';">
                                            <td style="width:100px;padding:20px">
                                                <img src="../<?php echo $row3['user_image'] ?>" class="rounded-circle" width="80" height="80" style="object-fit:cover;">
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
                    </div>
                </div>
            </div>

            <div class="container-fluid" style="padding:0;padding-top:20px;">
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
                                <a href="dynamicProfile.php?ID=<?php echo $donation['username'] ?>">
                                    <p><span style="color:#8FB2FF;font-weight:500;"><?php echo $donation['username'] ?></span>&nbsp&nbsp&nbsp donated <?php echo $donation['yomi_tokens'] ?> YOMI Tokens</p>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid" style="padding:0;padding-top:20px;padding-bottom:20px;">
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
        <?php
    }
        ?>
        </body>

    </html>

<?php
} else {
    header("Location:login.php");
}
?>