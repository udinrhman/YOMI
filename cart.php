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
        <title> YOMI | Shopping Cart </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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

            <!----  Cart Items  ----->
            <div class="container-fluid" style="padding:0;margin-top:20px;">
                <div class="card">
                    <form action="updateCart.php" method="POST">
                        <div class="card-header">
                            <span>YOUR CART</span>
                        </div>
                        <div class="card-body" style="padding:40px;padding-top:5px;padding-bottom:0">
                            <?php
                            $query6 = "SELECT * FROM cart WHERE username = '" . $_SESSION["username"] . "' ORDER BY mangaln_id ASC";
                            $result6 = mysqli_query($link, $query6);
                            if (mysqli_num_rows($result6) == 0) { ?>
                                <div class="container-fluid" style="height:300px;padding-top:100px">
                                    <div class="no-result">
                                        <p>You dont have any products yet.</p>
                                    </div>
                                    <div class="no-result">
                                        <a href="userHomepage.php" style="width:200px"><span class="btn btn-primary" style="width:200px">BROWSE</span></a>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <table id="myCart" class="table">
                                    <thead>
                                        <tr>
                                            <th> </th>
                                            <th style="text-align:left">PRODUCT</th>
                                            <th>VOLUME</th>
                                            <th>PRICE</th>
                                            <th>QUANTITY</th>
                                            <th>SUBTOTAL</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $subtotal = 0;
                                        $price = 0;
                                        $yomi = 0;
                                        $i = 0;
                                        while ($row6 = mysqli_fetch_array($result6, MYSQLI_BOTH)) {
                                            $query7 = "SELECT * FROM stock WHERE mangaln_id = '" . $row6['mangaln_id'] . "' AND volume = '" . $row6['volume'] . "'";
                                            $result7 = mysqli_query($link, $query7);
                                            while ($row7 = mysqli_fetch_array($result7, MYSQLI_BOTH)) {
                                                ${'subtotal' . $i} = $row6['price'] * $row6['quantity'];
                                                ${'price' . $i} = $row6['price']; ?>
                                                <tr>
                                                    <td class="cartCover" style="width:6%;padding-top:25px">
                                                        <div style="display:flex;justify-content:center;">
                                                            <img src="upload/<?php echo $row6['cover'] ?>" />
                                                        </div>
                                                    </td>
                                                    <td class="title" style="width:54%;text-align:left">
                                                        <p style="font-size:30px;font-weight:600;margin-bottom:0;line-height:35px"><?php echo $row6['title'] ?></p>
                                                        <p><?php echo $row6['alternative_title'] ?></p>
                                                    </td>
                                                    <td style="width:10%">
                                                        <p style="margin:0;"><?php echo $row6['volume'] ?></p>
                                                    </td>
                                                    <td style="width:10%">
                                                        <p style="margin:0;">RM<?php echo $row6['price'] ?></p>
                                                    </td>
                                                    <td style="width:10%">
                                                        <div style="display:flex;justify-content:center;">
                                                            <input type="number" name="quantity[]" id="quantity" value="<?php echo $row6['quantity'] ?>" oninput=calculate<?php echo $i ?>(this) min="1" max="<?php echo $row7['stock'] ?>" step="1" pattern="[0-9]*" required />
                                                        </div>
                                                    </td>
                                                    <td style="width:10%">
                                                        <p id="subtotal<?php echo $i ?>" style="margin:0;">RM<?php echo ${'subtotal' . $i} ?></p>
                                                    </td>
                                                    <td style="width:5%">
                                                        <span data-toggle="modal" data-target="#DeleteCartModal<?php echo $row6['cart_id']; ?>"><i class="fa fa-window-close"></i></span>
                                                    </td>
                                                </tr>
                                                <input type="hidden" name="price[]" value="<?php echo $row6['price'] ?>">
                                                <input type="hidden" name="cart_id[]" value="<?php echo $row6['cart_id'] ?>">
                                                <input type="hidden" name="username" value="<?php echo $_SESSION["username"] ?>">
                                                <script>
                                                    function calculate<?php echo $i ?>(input) {
                                                        var elementValue = input.value;
                                                        var price = "<?php echo ${'price' . $i}; ?>";
                                                        var subtotal = price * elementValue;
                                                        document.getElementById("subtotal<?php echo $i ?>").innerHTML = "RM" + subtotal;
                                                    }
                                                </script>
                                                <!----  Delete Cart Modal  ----->
                                                <div class="modal fade DeleteModal" id="DeleteCartModal<?php echo $row6['cart_id']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Delete Cart Item</h6>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div id="gap_form<?php echo $row6['cart_id']; ?>">
                                                                <div class="modal-body">
                                                                    <h7> Are you sure you want to delete this from cart? </h7>
                                                                    <input type="hidden" name="cart_id" value="<?php echo $row6["cart_id"] ?>">
                                                                    <input type="hidden" name="username" value="<?php echo $row1["username"] ?>">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" name="deleteCart" value="Submit" class="btn btn-primary" href="javascript:deleteCartForm.submit()">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        (function() {
                                                            $('#gap_form<?php echo $row6['cart_id']; ?>').wrap('<form id="deleteCartForm" action="deleteCart.php" method="POST"></form>');
                                                        })();
                                                    });
                                                </script>
                                        <?php
                                                $i = $i + 1;
                                                $yomi = $yomi + $row6['quantity'];
                                            }
                                        }
                                        $totalYomi = $yomi * 10 ?>
                                    </tbody>
                                </table>
                                <div class="card-footer" style="padding-right:0;border-top:2px solid #525252">
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" name="saveCart" value="Submit" class="btn btn-primary" style="float:right">CHECKOUT</button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                    </form>
                </div>
            </div>
            </div>

            </div>
        <?php
    }
        ?>

        </div>
        </div>

        <!--Scripts -->
        <script src=" https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous">
        </script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js" integrity="sha512-iceXjjbmB2rwoX93Ka6HAHP+B76IY1z0o3h+N1PeDtRSsyeetU3/0QKJqGyPJcX63zysNehggFwMC/bi7dvMig==" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/bootstrap-input-spinner.js"></script>

        <script>
            $('form').attr('autocomplete', 'off'); //turn off autocomplete
        </script>

        <script>
            function mergeCells() {
                let db = document.getElementById("myCart");
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

        </body>

    </html>

<?php
} else {
    header("Location:login.php");
}
?>