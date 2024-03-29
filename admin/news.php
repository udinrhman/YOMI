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
        <title> YOMI | News </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="../css/adminProductDetail.css" rel="stylesheet">
        <style>
            .form-control {
                padding: 0;
            }

            button:focus {
                outline: none;
            }

            .news {
                width: 70%;
                border-left: 1px solid #3B3B3B;
                border-right: 1px solid #3B3B3B;
            }

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
    $password = "";
    $database = "yomi";

    $link = mysqli_connect($host, $userid, $password, $database);
    include '../function/timeAgo.php';

    $query1 = "SELECT * FROM user where username = '" . $_SESSION["username"] . "'";
    $result1 = mysqli_query($link, $query1);



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
                        <li class="nav-item"> <a style="border-bottom: 2px solid #777AFF" class="nav-link" href="news.php">NEWS</a> </li>
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

            <div id="result"></div>
            <!------  Body   ------->
            <div class="container-fluid p-0">
                <div class="row no-gutters">
                    <div class="col-sm-9 col-sm-offset-3 no-float">
                        <div class="container-fluid" style="padding: 0;padding-top:20px">
                            <div class="card" style="background-color:#181818">
                                <div class="card-header" style="background-color:#181818;border-bottom:2px solid #777AFF">
                                    <p style="margin:0;font-size:20px;font-weight:500;color:#F5F5F5">NEWS</p>
                                </div>
                                <div class="card-body">
                                    <div class="box">
                                        <table class="news">
                                            <form id="addNewsForm" action="addNews.php" method="POST" enctype="multipart/form-data">
                                                <tr>
                                                    <td style="vertical-align:top;width:37px">
                                                        <img src="../<?php echo $row1['user_image'] ?>" class="rounded-circle" width="37" height="37" style="margin:10px;margin-top:5px;object-fit:cover;">
                                                    </td>
                                                    <td style="padding:10px;padding-left:0">
                                                        <div class="form-group" style="padding-top:10px">
                                                            <textarea name="description" id="description" class="form-control" rows="5" maxlength="1000" placeholder="What's happening?" required></textarea>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" name="image" accept="image/*" class="custom-file-input" id="customFile">
                                                            <label class="custom-file-label" for="customFile">Choose Image</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr style="border-bottom:1px solid #3B3B3B">
                                                    <td colspan=2 style="padding:10px">
                                                        <button type="submit" name="addNews" id="addNews" value="addNews" class="btn btn-primary" style="float:right;border:none;font-size:12px">POST</button>
                                                        <span class="btn btn-secondary reset" onClick="resetFields()" style="float:right;border:none;font-size:12px">RESET</span>
                                                    </td>
                                                </tr>
                                            </form>
                                        </table>
                                    </div>
                                    <div class="box">
                                        <table class="news">
                                            <?php
                                            $queryNews = "SELECT * FROM news ORDER BY news_date DESC";
                                            $resultNews = mysqli_query($link, $queryNews);
                                            while ($news = mysqli_fetch_array($resultNews, MYSQLI_BOTH)) {
                                                $time_elapsed = timeAgo($news['news_date']);
                                            ?>
                                                <tbody class="news-content">
                                                    <tr style="border-bottom:1px solid #3B3B3B">
                                                        <td style="vertical-align:top;">
                                                            <img src="../<?php echo $row1['user_image'] ?>" class="rounded-circle" width="37" height="37" style="margin:10px;margin-top:5px;object-fit:cover;">
                                                        </td>
                                                        <td>
                                                            <table width="100%">
                                                                <tr>
                                                                    <td style="padding-top:0!important;padding-bottom:10px;padding-right:20px;">
                                                                        <span style="font-weight:600;font-size:15px;color:#8FB2FF"><?php echo $row1['user_fullname'] ?></span>
                                                                        <span style="font-size:12px;color:#AAAAAA">&nbsp&nbsp·&nbsp&nbsp<?php echo $time_elapsed ?></span>
                                                                        <span data-toggle="modal" data-target="#DeleteNewsModal<?php echo $news['news_id'] ?>" class="delete">DELETE</span>
                                                                        <p style="text-align:justify;font-size:15px;margin:0"><?php echo nl2br($news['description']) ?></p>
                                                                    </td>
                                                                </tr>
                                                                <?php if (!empty($news['news_image'])) {  //if have image
                                                                ?>
                                                                    <tr>
                                                                        <td style="padding-bottom:10px;padding-top:0!important">
                                                                            <?php
                                                                            list($width, $height) = getimagesize($_SERVER['DOCUMENT_ROOT'] . "/YOMI/upload/$news[news_image]");

                                                                            if ($width > $height) { //if landscape 
                                                                            ?>
                                                                                <img src="../upload/<?php echo $news['news_image'] ?>" style="width:500px;height:auto;object-fit:cover;border-radius:5px">
                                                                            <?php
                                                                            } else { //if potrait 
                                                                            ?>
                                                                                <img src="../upload/<?php echo $news['news_image'] ?>" style="width:300px;height:auto;object-fit:cover;border-radius:5px">
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </td>

                                                                    </tr>
                                                                <?php } ?>
                                                                <tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <!----  Delete News Modal  ----->
                                                    <div class="modal fade DeleteModal" id="DeleteNewsModal<?php echo $news['news_id']; ?>" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h6 class="modal-title">Delete News</h6>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h7> Are you sure you want to delete this news?</h7>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                                                    <button type="submit" name="deleteNews" id="<?php echo $news["news_id"]; ?>" class="btn btn-primary deleteNews">DELETE</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                                ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!----  Top 3 Donators  ----->
                    <div class="col-sm-3">
                        <div class="row">
                            <div class="col">
                                <div class="container" style="position:sticky;margin-top:45px;margin-bottom:20px;">
                                    <div class="card" style="border:none;border-radius:5px;background-color:transparent">
                                        <div class="card-header" style="background-color:transparent;padding:0px">
                                            <p style="margin:0;font-size:20px;font-weight:500;color:#F5F5F5;border-bottom:2px solid #777AFF">TOP 3 DONATORS</p>
                                        </div>
                                        <table class="table table-borderless" style="border-radius:5px">
                                            <?php
                                            $query2 = "SELECT *, SUM(yomi_tokens) as token_sum FROM donation GROUP BY username ORDER BY token_sum DESC LIMIT 3";
                                            $result2 = mysqli_query($link, $query2);
                                            while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
                                                $query3 = "SELECT * FROM user WHERE username = '$row2[username]'";
                                                $result3 = mysqli_query($link, $query3);
                                                while ($row3 = mysqli_fetch_array($result3, MYSQLI_BOTH)) { ?>
                                                    <tr style='cursor: pointer;' onclick="window.location='dynamicProfile.php?ID=<?php echo $row3['username'] ?>';">
                                                        <td style="padding:10px;padding-left:10px">
                                                            <img src="../<?php echo $row3['user_image'] ?>" class="rounded-circle" width="40" height="40" style="object-fit:cover;">
                                                        </td>
                                                        <td style="text-align:left;padding-left:0">
                                                            <p style="font-size:15px;font-weight:600;margin-top:10px"><?php echo $row2['username'] ?>
                                                            <p>
                                                        </td>
                                                        <td style="text-align:right;padding:10px">
                                                            <p style="font-size:15px;font-weight:600;margin-top:10px"><?php echo $row2['token_sum'] ?> YOMI TOKENS</p>
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
                        <div class="row">
                            <div class="col">
                                <div class="container" style="margin-bottom:20px;">
                                    <div class="card" style="border:none;border-radius:5px;background-color:transparent">
                                        <div class="card-header" style="background-color:transparent;padding:0px">
                                            <p style="margin:0;font-size:20px;font-weight:500;color:#F5F5F5;border-bottom:2px solid #777AFF">POPULAR</p>
                                        </div>
                                        <div class="card-body" style="padding:0;background-color:transparent">
                                            <?php
                                            $queryPopular = "SELECT mangaln.*, SUM(orders.quantity) AS order_count
                                                                    FROM mangaln LEFT JOIN orders 
                                                                    ON mangaln.mangaln_id = orders.mangaln_id
                                                                    GROUP BY mangaln.mangaln_id
                                                                    ORDER BY order_count DESC LIMIT 5";
                                            $resultPopular = mysqli_query($link, $queryPopular);
                                            $popular   = $resultPopular->fetch_all(MYSQLI_ASSOC);
                                            foreach ($popular as $populars) {
                                            ?>
                                                <a href="productDetails.php?ID=<?php echo $populars['mangaln_id'] ?>">
                                                    <div class="row" style="border-radius:5px;background-color:#181818;margin:0px;margin-bottom:10px;margin-top:10px">
                                                        <div class="col-2" style="padding:0">
                                                            <div class="popular-frame">
                                                                <img src="../../YOMI/upload/<?php echo $populars['cover'] ?>" class="popular-cover">
                                                            </div>
                                                        </div>
                                                        <div class="col popular-col" style="padding-right:15px;padding-left:15px;">
                                                            <div class="popular-info">
                                                                <div class="popular-details">
                                                                    <div class="truncate-frame">
                                                                        <span class="text-truncate" style="font-weight:600;"><?php echo $populars['title'] ?></span>
                                                                        <p class="text-truncate" style="font-size:12px;margin-bottom:0px"><?php echo $populars['alternative_title'] ?></p>
                                                                        <?php
                                                                        $fullstar = 5;
                                                                        for ($star = 0; $star < $populars['admin_rating']; $star++) {
                                                                        ?>
                                                                            <span class="small-star fa fa-star checked"></span>
                                                                            <?php
                                                                        }
                                                                        if ($populars['admin_rating'] != 5) {
                                                                            $blankstar = $fullstar - $populars['admin_rating'];
                                                                            for ($star = 0; $star < $blankstar; $star++) {
                                                                            ?>
                                                                                <span class="small-star fa fa-star"></span>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="container">
                                    <div class="card" style="border:none;border-radius:5px;background-color:transparent">
                                        <div class="card-header" style="background-color:transparent;padding:0px">
                                            <p style="margin:0;font-size:20px;font-weight:500;color:#F5F5F5;border-bottom:2px solid #777AFF">RECENTLY ADDED</p>
                                        </div>
                                        <div class="card-body" style="padding:0;background-color:transparent">
                                            <?php
                                            $queryRecent = "SELECT * FROM mangaln ORDER BY mangaln_id DESC LIMIT 5";
                                            $resultRecent = mysqli_query($link, $queryRecent);
                                            $recent   = $resultRecent->fetch_all(MYSQLI_ASSOC);
                                            foreach ($recent as $recents) {
                                            ?>
                                                <a href="productDetails.php?ID=<?php echo $recents['mangaln_id'] ?>">
                                                    <div class="row" style="border-radius:5px;background-color:#181818;margin:0px;margin-bottom:10px;margin-top:10px">
                                                        <div class="col-2" style="padding:0">
                                                            <div class="popular-frame">
                                                                <img src="../../YOMI/upload/<?php echo $recents['cover'] ?>" class="popular-cover">
                                                            </div>
                                                        </div>
                                                        <div class="col popular-col" style="padding-right:15px;padding-left:15px;">
                                                            <div class="popular-info">
                                                                <div class="popular-details">
                                                                    <div class="truncate-frame">
                                                                        <span class="text-truncate" style="font-weight:600;"><?php echo $recents['title'] ?></span>
                                                                        <p class="text-truncate" style="font-size:12px;margin-bottom:0px"><?php echo $recents['alternative_title'] ?></p>
                                                                        <?php
                                                                        $fullstar = 5;
                                                                        for ($star = 0; $star < $recents['admin_rating']; $star++) {
                                                                        ?>
                                                                            <span class="small-star fa fa-star checked"></span>
                                                                            <?php
                                                                        }
                                                                        if ($recents['admin_rating'] != 5) {
                                                                            $blankstar = $fullstar - $recents['admin_rating'];
                                                                            for ($star = 0; $star < $blankstar; $star++) {
                                                                            ?>
                                                                                <span class="small-star fa fa-star"></span>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            <script type="application/javascript">
                $('input[type="file"]').change(function(e) {
                    var fileName = e.target.files[0].name;
                    $('.custom-file-label').text(fileName);
                });
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('.reset').click(function() {
                        document.getElementById("addNewsForm").reset();
                        $('.custom-file-label').text('Choose Image');
                    });
                });
            </script>

            <script>
                $(document).on('click', '.deleteNews', function(e) {
                    e.preventDefault(); //prevent from refreshing
                    var id = $(this).attr("id");
                    $.ajax({
                        url: '/YOMI/admin/deleteNews.php',
                        type: 'post',
                        data: ({
                            id: id
                        }),
                        success: function(response) {
                            $('.DeleteModal').modal('hide');
                            $(".modal-backdrop").remove();
                            $(".news-content").load(" .news-content");
                        },
                        error: function(response) {
                            alert("Failed")
                        }
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
    header("Location:../login.php");
}
?>