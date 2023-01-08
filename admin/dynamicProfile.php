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
        <title> YOMI | Profile </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="../css/admin.css?V=1" rel="stylesheet">
    </head>
    <?php
    if (isset($_GET['ID'])) {
        $host = "localhost";
        $userid = "root";
        $pass = "";
        $database = "yomi";

        $link = mysqli_connect($host, $userid, $pass, $database);

        $ID = mysqli_real_escape_string($link, $_GET['ID']);

        $queryPR = "SELECT * FROM user WHERE username = '" . $ID . "'";
        $resultPR = mysqli_query($link, $queryPR);

        $query1 = "SELECT * FROM user WHERE username = '" . $_SESSION["username"] . "'";
        $result1 = mysqli_query($link, $query1);

        $countCart = "SELECT count(*) as total FROM cart WHERE username = '" . $ID . "'";
        $resultCart = mysqli_query($link, $countCart);
        $data = mysqli_fetch_assoc($resultCart);
        while ($row1 = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
            while ($rowPR = mysqli_fetch_array($resultPR, MYSQLI_BOTH)) {
    ?>

                <body>
                    <!-- NAVBAR -->
                    <nav class="navbar navbar-expand-md navbar-custom sticky-top">
                        <div class="container-fluid">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item"> <a class="nav-link" href="dashboard.php">DASHBOARD</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="sales.php">SALES</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="products.php">PRODUCTS</a> </li>
                                <li class="nav-item"> <a style="border-bottom: 2px solid #777AFF" class="nav-link" href="users.php">USERS</a> </li>
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
                    <!----- Body  ------->
                    <div class="container-fluid">
                        <div class="row" style="height:auto;">
                            <div class="card profile" style="border-bottom: none">
                                <div class="card-body" style="padding-left:0px;padding-right:0px;padding-top:0px;padding-bottom:0px;">
                                    <div class="twPc-div">
                                        <a class="twPc-bg twPc-block"></a>
                                        <div class="avatarLink">
                                            <img src="../<?php echo $rowPR['user_image'] ?>" width="100%" height="100%" style="object-fit:cover;" class="profilePic">
                                        </div>
                                        <div class="User">
                                            <div class="name">
                                                <?php echo $rowPR['user_fullname'] ?>
                                            </div>
                                            <span class="username">@<?php echo $rowPR['username'] ?></span>
                                        </div><br>
                                        <span class="email"><i class="far fa-envelope"></i> <?php echo $rowPR['user_email'] ?></span>
                                        <div class="stats">
                                            <?php
                                            $query3 = "SELECT * FROM wishlist WHERE username = '" . $ID . "'";
                                            $result3 = mysqli_query($link, $query3);

                                            $countWishlist = mysqli_num_rows($result3);
                                            ?>

                                            <div class="twPc-ArrangeSizeFit">
                                                <span class="value"><?php echo $rowPR['yomi_tokens']; ?></span>&nbspYOMI TOKENS
                                            </div>
                                            <div class="twPc-ArrangeSizeFit">
                                                <span class="value"><?php echo $countWishlist; ?></span>&nbspWISHLIST
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="container-fluid" style="padding:0;padding-bottom:20px;">
                                    <div class="card-body" style="width:100%">
                                        <div class="bio">
                                            <p><?php echo $rowPR['bio'] ?></P>
                                        </div>
                                    </div>



                            <?php
                        }
                    }
                            ?>
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
} else {
    header("Location:../login.php");
}
?>