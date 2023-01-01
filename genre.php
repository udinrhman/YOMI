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
        <link href="css/userHomepage.css?V=3" rel="stylesheet">

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
                                    <div class="img">
                                        <a href='search.php?ID=Action'><img src="image/Action.jpg" /></a>
                                        <div class="bottom-middle"><a href='search.php?ID=Action'>ACTION</div></a>
                                    </div>
                                    <div class="img">
                                        <a href='search.php?ID=Fantasy'><img src="image/Fantasy.jpg" /></a>
                                        <div class="bottom-middle"><a href='search.php?ID=Fantasy'>FANTASY</div></a>
                                    </div>
                                    <div class="img">
                                        <a href='search.php?ID=Adventure'><img src="image/Adventure.jpg" /></a>
                                        <div class="bottom-middle"><a href='search.php?ID=Adventure'>ADVENTURE</div></a>
                                    </div>
                                    <div class="img">
                                        <a href='search.php?ID=Isekai'><img src="image/Isekai.jpg" /></a>
                                        <div class="bottom-middle"><a href='search.php?ID=Isekai'>ISEKAI</div></a>
                                    </div>
                                    <div class="img">
                                        <a href='search.php?ID=Supernatural'><img src="image/Supernatural.jpg" /></a>
                                        <div class="bottom-middle"><a href='search.php?ID=Supernatural'>SUPERNATURAL</div></a>
                                    </div>
                                    <div class="img">
                                        <a href='search.php?ID=Romance'><img src="image/Romance.jpg" /></a>
                                        <div class="bottom-middle"><a href='search.php?ID=Romance'>ROMANCE</div></a>
                                    </div>
                                    <div class="img">
                                        <a href='search.php?ID=Comedy'><img src="image/Comedy.jpg" /></a>
                                        <div class="bottom-middle"><a href='search.php?ID=Comedy'>COMEDY</div></a>
                                    </div>
                                    <div class="img">
                                        <a href='search.php?ID=Mystery'><img src="image/Mystery.jpg" /></a>
                                        <div class="bottom-middle"><a href='search.php?ID=Mystery'>MYSTERY</div></a>
                                    </div>
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

            <script type="text/javascript">
                $(document).ready(function() {
                    $('#title,#descriptions,#ingredients,#instructions').on('keyup', function() {
                        var title_value = $("#title").val();
                        var description_value = $("#descriptions").val();
                        var ingredient_value = $("#ingredients").val();
                        var instruction_value = $("#instructions").val();
                        if (!title_value.trim().length || !description_value.trim().length || !ingredient_value.trim().length || !instruction_value.trim().length) { //check if the value insert contain value or not
                            $('button.shareRecipe').prop('disabled', true); //disable button
                        } else {
                            $('button.shareRecipe').prop('disabled', false);
                        }
                    });

                });
            </script>

            <script type="application/javascript">
                $('input[type="file"]').change(function(e) {
                    var fileName = e.target.files[0].name;
                    $('.custom-file-label').text(fileName);
                });
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('.selectpicker').selectpicker();
                    $('.reset').click(function() {
                        $(".selectpicker").val('default').selectpicker("refresh");
                        $('.custom-file-label').text('Choose Image');
                    });
                });
            </script>

        </body>

    </html>

<?php
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shotcut icon" href="image/bugcaticon.png" type="image/png">
    <title> HYORO | Categories </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
    <link href="css/categories.css" rel="stylesheet">
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
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="homepage.php"><img src="image/logo.png" width="100%" height="100%"></a> <!-- LOGO -->
            <form action="GuestSearch.php" method="POST" class="form-inline my-2 my-lg-0">
                <div class="searchNav">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="search" class="form-control enter" placeholder="Search" name="Search">
                </div>
            </form>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"> <a class="nav-link" href="homepage.php">Home</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="categories.php">Categories</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="login.php">Login</a> </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Card -->
    <div class="container-fluid" style="padding:0;margin-top:20px;">
        <div class="card">
            <div class="card-body">
                <h2 class="card- title" style="color:#BF95FC;margin-left:80px;margin-bottom:15px;">Popular Genre</h2>
                <hr style="width:91%;">

                <!-- Image Grid -->
                <div class="main">
                    <div class="gallery">
                        <div class="img">
                            <a href='search.php?ID=Action'><img src="image/Action.jpg" /></a>
                            <div class="bottom-middle"><a href='search.php?ID=Action'>ACTION</div></a>
                        </div>
                        <div class="img">
                            <a href='search.php?ID=Fantasy'><img src="image/Fantasy.jpg" /></a>
                            <div class="bottom-middle"><a href='search.php?ID=Fantasy'>FANTASY</div></a>
                        </div>
                        <div class="img">
                            <a href='search.php?ID=Adventure'><img src="image/Adventure.jpg" /></a>
                            <div class="bottom-middle"><a href='search.php?ID=Adventure'>ADVENTURE</div></a>
                        </div>
                        <div class="img">
                            <a href='search.php?ID=Isekai'><img src="image/Isekai.jpg" /></a>
                            <div class="bottom-middle"><a href='search.php?ID=Isekai'>ISEKAI</div></a>
                        </div>
                        <div class="img">
                            <a href='search.php?ID=Comedy'><img src="image/Comedy.jpg" /></a>
                            <div class="bottom-middle"><a href='search.php?ID=Comedy'>COMEDY</div></a>
                        </div>
                        <div class="img">
                            <a href='search.php?ID=Romance'><img src="image/Romance.jpg" /></a>
                            <div class="bottom-middle"><a href='search.php?ID=Romance'>ROMANCE</div></a>
                        </div>
                        <div class="img">
                            <a href='search.php?ID=Supernatural'><img src="image/Supernatural.jpg" /></a>
                            <div class="bottom-middle"><a href='search.php?ID=Supernatural'>SUPERNATURAL</div></a>
                        </div>
                        <div class="img">
                            <a href='search.php?ID=Mystery'><img src="image/Mystery.jpg" /></a>
                            <div class="bottom-middle"><a href='search.php?ID=Mystery'>MYSTERY</div></a>
                        </div>
                    </div>
                </div>
                <div class="container-fluid" style="padding:70px;">
                    <h5 style="color:#BF95FC;margin-top:15px;padding:10px">All Genre</h5>
                    <table class="table genre">
                        <tbody>
                            <tr>
                                <td><a href="search.php?ID=Action">Action&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Adventure">Adventure&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Comedy">Comedy&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Drama">Drama&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Fantasy">Horror&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Isekai">Isekai&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Mecha">Mecha&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Mystery">Mystery&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Romance">Romance&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=School">School&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Sci-fi">Sci-fi&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Slice of Life">Slice of Life&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Supernatural">Supernatural&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Thriller">Thriller&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
                            <tr>
                                <td><a href="search.php?ID=Vampire">Vampire&nbsp<span style="font-weight:600"></span></a></td>
                            </tr>
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
        $('[data-toggle="popover"]').popover({
            html: true,
            content: function() {
                var id = $(this).attr('id')
                return $('#po' + id).html();
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#title,#descriptions,#ingredients,#instructions').on('keyup', function() {
                var title_value = $("#title").val();
                var description_value = $("#descriptions").val();
                var ingredient_value = $("#ingredients").val();
                var instruction_value = $("#instructions").val();
                if (!title_value.trim().length || !description_value.trim().length || !ingredient_value.trim().length || !instruction_value.trim().length) { //check if the value insert contain value or not
                    $('button.shareRecipe').prop('disabled', true); //disable button
                } else {
                    $('button.shareRecipe').prop('disabled', false);
                }
            });

        });
    </script>

    <script type="application/javascript">
        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $('.custom-file-label').text(fileName);
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
            $('.reset').click(function() {
                $(".selectpicker").val('default').selectpicker("refresh");
                $('.custom-file-label').text('Choose Image');
            });
        });
    </script>

</body>

</html>

<?php
}
?>