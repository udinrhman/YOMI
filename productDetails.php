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
        <title> YOMI | Product Detail </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>


        <link href="css/bootstrap-select.min.css" rel="stylesheet">
        <link href="css/productDetail.css" rel="stylesheet">

    </head>

    <?php
    if (isset($_GET['ID'])) {
        $host = "localhost";
        $userid = "root";
        $password = "";
        $database = "yomi";

        $link = mysqli_connect($host, $userid, $password, $database);
        include 'function/timeAgo.php';
        $ID = mysqli_real_escape_string($link, $_GET['ID']);

        $query1 = "SELECT * FROM user where username = '" . $_SESSION["username"] . "'";
        $result1 = mysqli_query($link, $query1);

        $query = "SELECT * FROM mangaln where mangaln_id = '" . $ID . "'";
        $result = mysqli_query($link, $query);

        $countCart = "SELECT count(*) as total FROM cart WHERE username = '" . $_SESSION["username"] . "'";
        $resultCart = mysqli_query($link, $countCart);
        $data = mysqli_fetch_assoc($resultCart);
        while ($row1 = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {

                $time_elapsed = timeAgo($row['mangaln_date']);
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
                                    <div class="container" style="padding:0" id="pover-card" data-toggle="popover" data-trigger="focus" data-placement="bottom" tabindex="-1">
                                        <span class="cart">
                                            <i class="fa fa-shopping-cart"></i>
                                            <?php if ($data['total'] != 0) { ?>
                                                <span class='badge' id='CartCount'><?php echo $data['total'] ?></span>
                                            <?php } ?>
                                        </span>
                                    </div>
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
                            <div class="card" id="cart">
                                <div class="card-header">Recently Added Product</div>
                                <div class="card-body">
                                    <div class="row">
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
                    <div id="result"></div>
                    <!------  Body   ------->
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <div class="col-sm-9 col-sm-offset-3 no-float">
                                <div class="container-fluid" style="padding: 0;">
                                    <div class="details" id="details">
                                        <img src="upload/<?php echo $row['cover'] ?>" class="background">
                                        <div class="coverBox">
                                            <img src="upload/<?php echo $row['cover'] ?>" class="cover">
                                        </div>
                                        <div class="detailBox">
                                            <p style="top:7%;font-size: 42px;font-weight:800;margin-bottom:10px;line-height:40px"><?php echo $row['title']; ?></p>
                                            <p style="font-size: 25px;margin-bottom:4%;line-height:25px"><?php echo $row['alternative_title']; ?></p>
                                            <p style=""><strong>Type: &nbsp</strong><?php echo $row['type']; ?></p>
                                            <p style=""><strong>Author: &nbsp</strong><?php echo $row['author']; ?></p>
                                            <p style=""><strong>Total Volume: &nbsp</strong><?php echo $row['total_volume']; ?></p>
                                            <p style=""><strong>Release Year: &nbsp</strong><?php echo $row['release_year']; ?></p>
                                            <p style=""><strong>Status: &nbsp</strong><?php echo $row['publication']; ?></p>
                                            <span style="top:32%;color:#F5F5F5;font-weight:500;font-size:20px;">Genre:
                                                <?php
                                                $mark = explode(",", $row['genre']); //remove "," from Tags table in database
                                                foreach ($mark as $out) {
                                                    echo "&nbsp<button class='btn-primary' style='min-width:80px;font-size:12px;padding:2px'><a href='search.php?ID=" . $out . "'> " . $out . "</a></button>";       //link based on tags
                                                }
                                                ?>
                                            </span>
                                        </div>

                                        <form id="wishlist" method="POST">
                                            <input type="hidden" name="username" id="username" value="<?php echo $_SESSION["username"] ?>">
                                            <input type="hidden" name="mangaln_id" id="mangaln_id" value="<?php echo $row["mangaln_id"] ?>">

                                            <?php
                                            $saveQuery = "SELECT * FROM wishlist WHERE mangaln_id = '" . $ID . "' AND username = '" . $_SESSION["username"] . "'";
                                            $SVresult = mysqli_query($link, $saveQuery);

                                            if (mysqli_num_rows($SVresult) < 1) //if user haven't save to wishlist
                                            {
                                            ?>
                                                <button class="btn btn-primary savebtn" type="submit" name="saveWishlist" id="saveWishlist" value="Submit" style="float:right;">ADD TO WISHLIST</button>
                                            <?php
                                            } else {
                                            ?>
                                                <button class="btn btn-primary savedbtn" type="submit" name="saveWishlist" id="saveWishlist" value="Submit" style="float:right;">ADDED TO WISHLIST</button>
                                            <?php
                                            }
                                            ?>
                                        </form>

                                    </div>
                                </div>
                                <!------  Product Details  ------->
                                <div class="container-fluid" style="padding: 0;">
                                    <div class="card tbig">
                                        <div class="card-body">
                                            <?php if ($_SESSION["username"] == $row['username']) // Edit & Delete option will only visible if the user that currently logged in is the owner
                                            {
                                            ?>
                                                <h5 class="card-title"><button class="btn btn-primary editbtn" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="Edit Details?"><i class="fas fa-edit"></i></button>
                                                <?php
                                            } else {
                                                ?>
                                                    <h5 class="card-title">Synopsis</h5>
                                                <?php
                                            }
                                                ?>
                                                <p class="card-text"><?php echo nl2br($row['synopsis']); ?></p>
                                                <hr>
                                                <div class="review">
                                                    <h5 class="card-title" style="text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.227);position:relative;display:inline-block;">Admin's Review</h5>&nbsp&nbsp
                                                    <?php
                                                    $fullstar = 5;
                                                    for ($star = 0; $star < $row['admin_rating']; $star++) {
                                                    ?>
                                                        <span class="fa fa-star checked"></span>
                                                        <?php
                                                    }
                                                    if ($row['admin_rating'] != 5) {
                                                        $blankstar = $fullstar - $row['admin_rating'];
                                                        for ($star = 0; $star < $blankstar; $star++) {
                                                        ?>
                                                            <span class="fa fa-star"></span>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    <br>
                                                    <span class="card-text more"><?php echo nl2br($row['admin_review']); ?></span><a class="readmore">... read more</a>
                                                </div>
                                                <br>
                                                <span style="float:right;font-size:13px;color:#AAAAAA">Last updated: <?php echo $time_elapsed; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <!------  Stock  ------->
                                <div class="container-fluid" style="padding: 0;">
                                    <div class="card tbig">
                                        <div class="card-body">
                                            <h5 class="card-title" style="color:#F5F5F5">Buy This Manga?</h5>
                                            <hr>
                                            <form method="POST" id="cart_form">
                                                <div class="row">
                                                    <div class="col-3" style="width:20%">
                                                        <?php
                                                        $queryStock = "SELECT * FROM stock WHERE mangaln_id = '" . $ID . "' ORDER BY stock_id ASC";
                                                        $resultStock = mysqli_query($link, $queryStock) or die(mysqli_error($link));
                                                        $countVolume = mysqli_num_rows($resultStock);

                                                        if ($countVolume >= 1) {
                                                        ?>
                                                            <select name="volume" id="volume" class="selectpicker" data-width="70%" title="Select Volume" required>
                                                            <?php
                                                        } else { ?>
                                                                <select disabled name="volume" id="volume" class="selectpicker" title="OUT OF STOCK" required>
                                                                <?php
                                                            }
                                                                ?>
                                                                </select>
                                                    </div>
                                                    <div class="col-2">
                                                        <input type="number" name="quantity" id="quantity" oninput=calculate(this) value="1" min="1" max="1" step="1" pattern="[0-9]*" required />
                                                    </div>
                                                    <div class="col" id="DynamicPrice" style="margin:0;padding:0">
                                                        <p style="font-size: 20px;margin-right: 10px;;float:right;" id="price">Price: RM<?php echo $row['price']; ?></p>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="mangaln_id" id="mangaln_id" value="<?php echo $row['mangaln_id']; ?>" />
                                                <input type="hidden" name="cover" id="cover" value="<?php echo $row['cover']; ?>" />
                                                <input type="hidden" name="title" id="title" value="<?php echo $row['title']; ?>" />
                                                <input type="hidden" name="alternative_title" id="alternative_title" value="<?php echo $row['alternative_title']; ?>" />
                                                <input type="hidden" name="price" id="price" value="<?php echo $row['price'] ?>" />
                                                <input type="hidden" name="subtotal" id="subtotal" value="<?php echo $row['price'] ?>" />
                                                <input type="hidden" name="username" id="username" value="<?php echo $row1['username'] ?>" />

                                                <input class="btn-tertiary addCart" id="cart_save" name="cart_save" type="submit" value="ADD TO CART" />
                                            </form>
                                        </div>
                                        <div class="card-footer" style="height:70px"></div>
                                    </div>

                                    <script>
                                        $(document).ready(function() {
                                            $('#volume').on('show.bs.select', function() { //everytime select menu open, the options will displayed but will cause duplication
                                                console.log('show.bs.select');
                                                <?php
                                                while ($rowStock = mysqli_fetch_array($resultStock, MYSQLI_BOTH)) {
                                                    if ($rowStock['stock'] >= 1) { ?> //if have stocks
                                                        $(this).append(`<option value="<?php echo $rowStock['volume']; ?>" data-max="<?php echo $rowStock['stock']; ?>"><?php echo $rowStock['volume']; ?></option>`);
                                                    <?php
                                                    } else { ?> //if out of stocks
                                                        $(this).append(`<option disabled value="<?php echo $rowStock['volume']; ?>" data-max="<?php echo $rowStock['stock']; ?>"><?php echo $rowStock['volume']; ?></option>`);
                                                <?php
                                                    }
                                                }
                                                ?>
                                                var optionValues = []; // by using this code, it can remove duplication just now ^
                                                $('#volume option').each(function() {
                                                    if ($.inArray(this.value, optionValues) > -1) {
                                                        $(this).remove()
                                                    } else {
                                                        optionValues.push(this.value);
                                                    }
                                                });
                                                $('#volume').selectpicker('refresh');

                                                $('.selectpicker').selectpicker('refresh'); //refresh the selectpicker
                                            })
                                        });
                                    </script>

                                    <script>
                                        $(document).ready(function() {
                                            $('#cart_form').submit(function(e) {
                                                e.preventDefault(); //prevent from refreshing
                                                $(this).find(':submit').attr('disabled', 'disabled'); //prevent submitting twice
                                                var data = $('#cart_form').serialize() + '&cart_save=cart_save';
                                                $.ajax({
                                                    url: '/YOMI/addToCart.php',
                                                    type: 'post',
                                                    data: data,
                                                    success: function(response) {
                                                        $('#result').text(response); //receive result message from php
                                                        $('.selectpicker').selectpicker('refresh'); //reset selectpicker
                                                        $("#DynamicPrice").load(" #DynamicPrice")
                                                        $("#pover-card").load(" #pover-card");
                                                        $('#cart').load(document.URL + ' #cart');
                                                        $("#quantity").val('0'); //reset input number (bootstrap input spinner)
                                                        $("#result").addClass('alert alert-custom')
                                                        $("#result").show().delay(200).addClass("in").fadeOut(3500);
                                                    },
                                                    error: function(response) {
                                                        alert("Failed")
                                                    }
                                                });
                                            });
                                        });
                                    </script>

                                </div>
                                <!----  Comment Section  ----->
                                <div class="container-fluid" style="padding: 0;">
                                    <div class="card tbig">
                                        <div class="card-body" style="padding-right: 20px;">
                                            <h5 class="card-title">Comment</h5>
                                            <hr>
                                            <?php
                                            $querycom = "SELECT * FROM comments WHERE mangaln_id = '" . $ID . "' ORDER BY comment_id ASC";
                                            $resultcom = mysqli_query($link, $querycom) or die(mysqli_error($link));
                                            $i = 1; //for reply collapse id (individual collapse)
                                            while ($coms = mysqli_fetch_array($resultcom, MYSQLI_BOTH)) {

                                                $queryrep = "SELECT * FROM reply where parent = '" . $coms['comment_id'] . "' ORDER BY reply_id ASC";
                                                $resultrep = mysqli_query($link, $queryrep) or die(mysqli_error($link));

                                                $queryPRcom = "SELECT user_image FROM user WHERE username = '" . $coms['username'] . "'";
                                                $resultPRcom = mysqli_query($link, $queryPRcom) or die(mysqli_error($link));

                                                $queryPRcom = "SELECT * FROM user WHERE username = '" . $coms['username'] . "'";
                                                $resultPRcom = mysqli_query($link, $queryPRcom) or die(mysqli_error($link));

                                                while ($PRcom = mysqli_fetch_array($resultPRcom, MYSQLI_BOTH)) {
                                                    $commentAgo = timeAgo($coms['comment_date']);
                                            ?>
                                                    <!--------------------------  Delete Comment Modal -------------------------------->
                                                    <div class="modal fade DeleteCommentModal" id="DeleteCommentModal<?php echo $coms['comment_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h6 class="modal-title">Delete Comment</h6>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="deleteComment.php" method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-body">
                                                                        <h7> Are you sure you want to delete this comment? </h7>
                                                                        <input type="hidden" name="id" value="<?php echo $row["mangaln_id"] ?>">
                                                                        <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $coms["comment_id"] ?>">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                        <button type="submit" name="deleteComment" value="Submit" class="btn btn-primary">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-------------------------------------------------------------------------------->


                                                    <table class="table table-borderless">
                                                        <tr>
                                                            <table>
                                                                <td style="padding:10px;vertical-align:top"><a href="dynamicProfile.php?ID=<?php echo $coms['username'] ?>"><img src="<?php echo $PRcom['user_image'] ?>" class="rounded-circle" width="50" height="50" style="float:left;margin-bottom:10px;object-fit:cover;"></a></td>
                                                                <td width=100%><span style="font-weight:600;color:#BF95FC;"><a href="dynamicProfile.php?ID=<?php echo $coms['username'] ?>"><?php echo $coms['username']; ?></span></a>&nbsp&nbsp&nbsp<span style="color:#AAAAAA;font-size:12px"><?php echo $commentAgo ?></span>
                                                                    <?php
                                                                    if ($_SESSION["username"] == $coms['username'] || $row['username'] == $_SESSION["username"]) //if comment belongs to currently logged in user / admin
                                                                    {
                                                                    ?>
                                                                        <button class="btn dlcomment" style="padding-top:0px;" data-toggle="modal" data-target="#DeleteCommentModal<?php echo $coms['comment_id']; ?>">Delete</button>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <br><span style="display:inline-block;padding-bottom:5px;margin-right:10px;color:#F5F5F5"><?php echo $coms['user_comment']; ?></span>
                                                                    <div class="reply" id="Reply<?php echo "$i" ?>" data-toggle="collapse" role="button" data-target="#reply<?php echo "$i" ?>">Reply</div>

                                                                    <form action=" reply.php" method="POST">
                                                                        <div id="reply<?php echo "$i" ?>" class="form-group collapse">
                                                                            <textarea name="reply" id="replyy" class="form-control" rows="2" placeholder="Reply" maxlength="300" required></textarea>
                                                                            <input type="hidden" name="replyid" value="Reply<?php echo "$i" ?>">
                                                                            <input type="hidden" name="username" value="<?php echo $_SESSION["username"] ?>">
                                                                            <input type="hidden" name="id" value="<?php echo $row["mangaln_id"] ?>">
                                                                            <input type="hidden" name="parent" value="<?php echo $coms["comment_id"] ?>">
                                                                            <button type="submit" name="Reply" id="Reply" value="Submit" style="float:right; margin-top: 5px;margin-bottom: 10px;" class="btn btn-primary replybtn">Reply</button>
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </table>
                                                        </tr>
                                                        <?php
                                                        while ($reps = mysqli_fetch_array($resultrep, MYSQLI_BOTH)) {
                                                            $replyAgo = timeAgo($reps['reply_date']);
                                                            $queryPRrep = "SELECT * FROM user WHERE username = '" . $reps['username'] . "'";
                                                            $resultPRrep = mysqli_query($link, $queryPRrep) or die(mysqli_error($link));

                                                            while ($PRrep = mysqli_fetch_array($resultPRrep, MYSQLI_BOTH)) {
                                                                if ($coms["comment_id"] == $reps['parent']) {
                                                        ?>
                                                                    <!--------------------------  Delete Reply Modal -------------------------------->
                                                                    <div class="modal fade DeleteCommentModal" id="DeleteReplyModal<?php echo $reps['reply_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h6 class="modal-title">Delete Reply</h6>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <form action="deleteReply.php" method="POST" enctype="multipart/form-data">
                                                                                    <div class="modal-body">
                                                                                        <h7> Are you sure you want to delete this comment? </h7>
                                                                                        <input type="hidden" name="id" value="<?php echo $row["mangaln_id"] ?>">
                                                                                        <input type="hidden" name="reply_id" id="comment_id" value="<?php echo $reps["reply_id"] ?>">
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                                        <button type="submit" name="deleteComment" value="Submit" class="btn btn-primary">Delete</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-------------------------------------------------------------------------------->
                                                                    <tr>
                                                                        <table>
                                                                            <!-- Replies -->
                                                                            <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                                                                            <td style="border-left:2px solid #BF95FC;padding-left:10px;"><a href="dynamicProfile.php?ID=<?php echo $reps['username'] ?>"><img src="<?php echo $PRrep['user_image'] ?>" class="rounded-circle" width="50" height="50" style="float:left;margin-right:10px;margin-bottom:10px;object-fit:cover;"></a></td>
                                                                            <td class="table" style="background-color:#181818;border-top: 0px;">

                                                                                <span style="font-weight:500;color:#BF95FC;"><a href="dynamicProfile.php?ID=<?php echo $reps['username'] ?>"><?php echo $reps['username']; ?></span></a>&nbsp&nbsp&nbsp<span style="color:#AAAAAA;font-size:12px"><?php echo $replyAgo ?></span>
                                                                                <?php
                                                                                if ($_SESSION["username"] == $reps['username'] || $_SESSION["username"] == 'admin')
                                                                                //if replies belongs to current user OR admin
                                                                                {
                                                                                ?>
                                                                                    <button class="btn dlcomment" data-toggle="modal" data-target="#DeleteReplyModal<?php echo $reps['reply_id']; ?>">Delete</button>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                <br>
                                                                                <span style="display:inline-block;color:#F5F5F5"><?php echo $reps['user_comment']; ?></span>

                                                                            </td>
                                                                        </table>
                                                                    </tr>
                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </table>
                                            <?php
                                                    $i++;
                                                }
                                            }
                                            ?>

                                            <form action="comment.php" method="POST">
                                                <div class="form-group" style="margin-top: 10px;">
                                                    <textarea name="comment" id="comment" class="form-control" rows="2" placeholder="Comment" required></textarea>
                                                </div>
                                                <input type="hidden" name="username" value="<?php echo $_SESSION["username"] ?>">
                                                <input type="hidden" name="id" value="<?php echo $row["mangaln_id"] ?>">
                                                <button type="submit" name="Comment" id="Comment" value="Submit" style="float:right" class="btn btn-primary commentbtn">Comment</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----  Product Suggestion  ----->
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="container" style="position:sticky;margin-top:20px;margin-bottom:20px;height:100%;">
                                            <div class="card" style="border:none;border-radius:5px;background-color:transparent">
                                                <div class="card-body" style="padding:0;background-color:transparent">
                                                    <div class="card-header" style="background-color:transparent;padding:0px">
                                                        <p style="margin:0;font-size:20px;font-weight:500;color:#F5F5F5;border-bottom:2px solid #5A2E98">YOU MIGHT LIKE</p>
                                                    </div>
                                                    <div class="container-fluid" style="padding:0">
                                                        <div class="boxRow">
                                                            <?php
                                                            $queryRandomRc = "SELECT * FROM mangaln WHERE LEVENSHTEIN_RATIO(genre, '$row[genre]') > 45 AND mangaln_id != $row[mangaln_id] ORDER BY LEVENSHTEIN(genre, '$row[genre]') LIMIT 5 "; //to retrive random manga
                                                            $resultRC = mysqli_query($link, $queryRandomRc) or die(mysqli_error($link));
                                                            $x   = $resultRC->fetch_all(MYSQLI_ASSOC);
                                                            foreach ($x as $rowRRC) {
                                                            ?>
                                                                <a href="productDetails.php?ID=<?php echo $rowRRC['mangaln_id'] ?>">
                                                                    <div class="row" style="border-radius:5px;background-color:#181818;margin:0px;margin-bottom:10px;margin-top:10px">
                                                                        <div class="col-2" style="padding:0">
                                                                            <div class="popular-frame">
                                                                                <img src="../YOMI/upload/<?php echo $rowRRC['cover'] ?>" class="popular-cover">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col popular-col" style="padding-left:15px;">
                                                                            <div class="popular-info">
                                                                                <div class="popular-details">
                                                                                    <div class="truncate-frame">
                                                                                        <span class="text-truncate" style="font-weight:600;"><?php echo $rowRRC['title'] ?></span>
                                                                                        <p class="text-truncate" style="font-size:12px;margin-bottom:0px"><?php echo $rowRRC['alternative_title'] ?></p>
                                                                                        <?php
                                                                                        $fullstar = 5;
                                                                                        for ($star = 0; $star < $rowRRC['admin_rating']; $star++) {
                                                                                        ?>
                                                                                            <span class="small-star fa fa-star checked"></span>
                                                                                            <?php
                                                                                        }
                                                                                        if ($rowRRC['admin_rating'] != 5) {
                                                                                            $blankstar = $fullstar - $rowRRC['admin_rating'];
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
                                <!----  Popular Products  ----->
                                <div class="row">
                                    <div class="col">
                                        <div class="container">
                                            <div class="card" style="border:none;border-radius:5px;background-color:transparent">
                                                <div class="card-header" style="background-color:transparent;padding:0px">
                                                    <p style="margin:0;font-size:20px;font-weight:500;color:#F5F5F5;border-bottom:2px solid #5A2E98">POPULAR</p>
                                                </div>
                                                <div class="card-body" style="padding:0;background-color:transparent">
                                                    <?php
                                                    $queryPopular = "SELECT mangaln.*, SUM(orders.quantity) AS order_count
                                                                    FROM mangaln LEFT JOIN orders 
                                                                    ON mangaln.mangaln_id = orders.mangaln_id
                                                                    WHERE mangaln.mangaln_id != '" . $ID . "' GROUP BY mangaln.mangaln_id
                                                                    ORDER BY order_count DESC LIMIT 5";
                                                    $resultPopular = mysqli_query($link, $queryPopular);
                                                    $popular   = $resultPopular->fetch_all(MYSQLI_ASSOC);
                                                    foreach ($popular as $populars) {
                                                    ?>
                                                        <a href="productDetails.php?ID=<?php echo $populars['mangaln_id'] ?>">
                                                            <div class="row" style="border-radius:5px;background-color:#181818;margin:0px;margin-bottom:10px;margin-top:10px">
                                                                <div class="col-2" style="padding:0">
                                                                    <div class="popular-frame">
                                                                        <img src="../YOMI/upload/<?php echo $populars['cover'] ?>" class="popular-cover">
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
                            </div>
                        </div>

                    </div>
                    <!--Scripts -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js" integrity="sha512-iceXjjbmB2rwoX93Ka6HAHP+B76IY1z0o3h+N1PeDtRSsyeetU3/0QKJqGyPJcX63zysNehggFwMC/bi7dvMig==" crossorigin="anonymous"></script>

                    <script type="text/javascript" src="js/bootstrap-select.min.js"></script>
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

                    <script type="text/javascript">
                        $("[data-toggle=popover]").popover();
                    </script>

                    <script type="text/javascript">
                        $(document).ready(function() { //comment disable button
                            $('#comment').on('keyup', function() {
                                var comment = $("#comment").val();

                                if (!comment.trim().length) { //check if the value insert contain value or not
                                    $('button.commentbtn').prop('disabled', true); //disable button
                                } else {
                                    $('button.commentbtn').prop('disabled', false);
                                }
                            });

                        });
                    </script>

                    <script type="text/javascript">
                        $(document).ready(function() { //comment disable button
                            $('#replyy').on('keyup', function() {
                                var replyy = $("#replyy").val();

                                if (!replyy.trim().length) { //check if the value insert contain value or not
                                    $('button.replybtn').prop('disabled', true); //disable button
                                } else {
                                    $('button.replybtn').prop('disabled', false);
                                }
                            });

                        });
                    </script>

                    <script type="text/javascript">
                        //add to cart button will be disabled if .selectpicker is not selected
                        var $submitButton = $('#cart_save');
                        var $selectors = $('.selectpicker');
                        $submitButton.attr('disabled', 'disabled');

                        $('#volume').change(function() {
                            var $empty = $selectors.filter(function() {
                                return this.value == "";
                            });
                            console.log("val %o empty len %o", $(this).val(), $empty.length);
                            if ($selectors.filter(function() {
                                    return this.value == "";
                                }).length == $selectors.length) {
                                $submitButton.attr('disabled', 'disabled');
                            } else {
                                $submitButton.removeAttr('disabled');
                            }
                        });

                        $('#cart_save').click(function() {
                            $('#cart_form').submit();
                        });
                    </script>



                    <script type="text/javascript">
                        const more = document.querySelector('.more');
                        const text = more.innerText;
                        more.innerText = text.substring(0, 250);
                        let showAll = false;
                        const button = document.querySelector('.readmore');
                        button.addEventListener('click', () => {
                            showAll = !showAll;
                            more.innerText = showAll ? text : text.substring(0, 250);
                            button.innerText = showAll ? ' read less' : '... read more';
                        });
                    </script>

                    <script>
                        function calculate(input) {
                            var elementValue = input.value;
                            var price = "<?php echo $row['price']; ?>";
                            var total = price * elementValue;
                            document.getElementById("price").innerHTML = "Price: RM" + total;
                            document.getElementById("subtotal").value = total;
                        }
                    </script>



                    <script>
                        $('.selectpicker').change(function() {
                            $('input[type=number]').attr('max', $('option:selected', this).data('max'));
                        });
                    </script>

                    <script>
                        $(document).ready(function() {
                            $('#saveWishlist').click(function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                var data = $('#wishlist').serialize() + '&saveWishlist=saveWishlist';
                                $.ajax({
                                    url: '/YOMI/saveWishlist.php',
                                    type: 'post',
                                    data: data,
                                    success: function(response) {
                                        $('#message').text(response);
                                        $('#mangaln_id').text('');
                                        $('#username').text('');
                                        $("#saveWishlist").html(response);
                                        if (response == 'ADDED TO WISHLIST') { // To change the button's class
                                            $("#saveWishlist").removeClass('btn btn-primary savebtn').addClass('btn btn-primary savedbtn');
                                        } else {
                                            $("#saveWishlist").removeClass('btn btn-primary savedbtn').addClass('btn btn-primary savebtn');
                                        }
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
        }
    }

        ?>
                </body>

    </html>

<?php
} else {
    header("Location:login.php");
}
?>