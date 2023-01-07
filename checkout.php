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
        <title> YOMI | Checkout </title>
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

            <div class="container-fluid" style="padding:0;margin-top:20px;">
                <div class="card">
                    <div class="card-header">
                        <span>DELIVERY ADDRESS</span>
                    </div>

                    <div class="card-body" style="padding:30px;">
                        <?php
                        $query2 = "SELECT * FROM addresses WHERE username = '" . $_SESSION["username"] . "' AND mode = 'default'";
                        $result2 = mysqli_query($link, $query2);

                        $query3 = "SELECT * FROM addresses WHERE username = '" . $_SESSION["username"] . "' AND mode != 'default' ORDER BY address_id ASC";
                        $result3 = mysqli_query($link, $query3);

                        $query4 = "SELECT * FROM addresses WHERE username = '" . $_SESSION["username"] . "' ORDER BY mode DESC";
                        $result4 = mysqli_query($link, $query4);

                        $query5 = "SELECT * FROM addresses WHERE username = '" . $_SESSION["username"] . "' AND mode = 'selected' ORDER BY address_id ASC";
                        $result5 = mysqli_query($link, $query5);

                        if (mysqli_num_rows($result4) == 0) { ?>
                            <div class="noAddress">
                                <p>You dont have any addresses yet.</p>
                            </div>
                            <?php
                        } else {
                            if (mysqli_num_rows($result5) > 0) {
                                while ($row5 = mysqli_fetch_array($result5, MYSQLI_BOTH)) {
                                    if (empty($row5['floor_unit'])) {
                            ?>
                                        <div class="default-address">
                                            <span class="selected-tag">SELECTED</span>
                                            <button class="edit-address" data-toggle="modal" data-target="#EditAddressModal<?php echo $row5['address_id']; ?>" style="margin-right:20px">EDIT</button>
                                            <button class="change-address" data-toggle="modal" data-target="#ChangeAddressModal">CHANGE</button>
                                            <p><span style="font-weight:600;font-size:21px"><?php echo $row5['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row5['phone_number'] ?></p>
                                            <p><?php echo $row5['street'] ?></p>
                                            <p><?php echo $row5['town_city'] ?>&nbsp,&nbsp<?php echo $row5['postcode'] ?>&nbsp<?php echo $row5['state_region'] ?></p>
                                        </div>

                                    <?php } else { ?>
                                        <div class="default-address">
                                            <span class="selected-tag">SELECTED</span>
                                            <button class="edit-address" data-toggle="modal" data-target="#EditAddressModal<?php echo $row5['address_id']; ?>" style="margin-right:20px">EDIT</button>
                                            <button class="change-address" data-toggle="modal" data-target="#ChangeAddressModal">CHANGE</button>
                                            <p><span style="font-weight:600;font-size:21px"><?php echo $row5['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row5['phone_number'] ?></p>
                                            <p><?php echo $row5['street'] ?>&nbsp,&nbsp<?php echo $row5['floor_unit'] ?></p>
                                            <p><?php echo $row5['town_city'] ?>&nbsp,&nbsp<?php echo $row5['postcode'] ?>&nbsp<?php echo $row5['state_region'] ?></p>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <!-- Edit Address Modal for Default-->
                                    <div class="modal fade" id="EditAddressModal<?php echo $row5['address_id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Address</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="updateAddressCart.php" method="POST" id="editAddress">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Full Name :</label>
                                                                    <input type="text" name="fullname" id="fullname" class="form-control" maxlength="255" value="<?php echo $row5['fullname']; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Phone Number :</label>
                                                                    <div id="input-wrapper">
                                                                        <label for="text">+60</label>
                                                                        <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" minlength="8" maxlength="11" pattern="[0-9]+" value="<?php echo $row5['phone_number']; ?>" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Street :</label>
                                                                    <input type="text" name="street" id="street" class="form-control" maxlength="255" value="<?php echo $row5['street']; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Floor Unit (Optional) :</label>
                                                                    <input type="text" name="floor_unit" id="floor_unit" class="form-control" maxlength="255" value="<?php echo $row5['floor_unit']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Town / City :</label>
                                                                    <input type="text" name="town_city" id="town_city" class="form-control" maxlength="255" value="<?php echo $row5['town_city']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Postcode :</label>
                                                                    <input type="text" name="postcode" id="postcode" class="form-control" minlength="5" maxlength="5" pattern="[0-9]+" required value="<?php echo $row5['postcode']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <select name="state_region" id="states<?php echo $row5['address_id']; ?>" class="selectpicker show-menu-arrow w-100" data-header="State / Region" title="State / Region" data-size="14" data-live-search="true" data-live-search-placeholder="Search" required>
                                                                        <option class="options" value="WP Kuala Lumpur">WP Kuala Lumpur</option>
                                                                        <option class="options" value="WP Putrajaya">WP Putrajaya</option>
                                                                        <option class="options" value="WP Labuan">WP Labuan</option>
                                                                        <option class="options" value="Terengganu">Terengganu</option>
                                                                        <option class="options" value="Selangor">Selangor</option>
                                                                        <option class="options" value="Sarawak">Sarawak</option>
                                                                        <option class="options" value="Sabah">Sabah</option>
                                                                        <option class="options" value="Pulau Pinang">Pulau Pinang</option>
                                                                        <option class="options" value="Perlis">Perlis</option>
                                                                        <option class="options" value="Perak">Perak</option>
                                                                        <option class="options" value="Pahang">Pahang</option>
                                                                        <option class="options" value="Negeri Sembilan">Negeri Sembilan</option>
                                                                        <option class="options" value="Melaka">Melaka</option>
                                                                        <option class="options" value="Kelantan">Kelantan</option>
                                                                        <option class="options" value="Kedah">Kedah</option>
                                                                        <option class="options" value="Johor">Johor</option>
                                                                    </select>
                                                                    <input type="hidden" name="address_id" value="<?php echo $row5['address_id']; ?>">
                                                                    <input type="hidden" name="username" value="<?php echo $_SESSION["username"] ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <span class="btn btn-secondary reset" id="reset" onClick="resetFields()">RESET</span>
                                                        <button type="submit" name="editAddress" value="Submit" class="btn btn-primary editAddress">UPDATE</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        function resetFields() { //reset form without [input type=reset]
                                            document.getElementById("editAddress").reset();
                                        }
                                    </script>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            var a = "<?php echo $row5['state_region']; ?>"; //insert array from database


                                            $('#states<?php echo $row5['address_id']; ?>').selectpicker('val', a); //insert array value to selected options
                                            $('.reset').click(function() {
                                                setTimeout(function() {
                                                    $('#states<?php echo $row5['address_id']; ?>').selectpicker('val', a);
                                                });
                                            });
                                        });
                                    </script>
                                    <?php
                                }
                            } else {
                                while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
                                    if (empty($row2['floor_unit'])) {
                                    ?>
                                        <div class="default-address">
                                            <span class="default-tag">DEFAULT</span>
                                            <button class="edit-address" data-toggle="modal" data-target="#EditAddressModal<?php echo $row2['address_id']; ?>" style="margin-right:20px">EDIT</button>
                                            <button class="change-address" data-toggle="modal" data-target="#ChangeAddressModal">CHANGE</button>
                                            <p><span style="font-weight:600;font-size:21px"><?php echo $row2['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row2['phone_number'] ?></p>
                                            <p><?php echo $row2['street'] ?></p>
                                            <p><?php echo $row2['town_city'] ?>&nbsp,&nbsp<?php echo $row2['postcode'] ?>&nbsp<?php echo $row2['state_region'] ?></p>
                                        </div>

                                    <?php } else { ?>
                                        <div class="default-address">
                                            <span class="default-tag">DEFAULT</span>
                                            <button class="edit-address" data-toggle="modal" data-target="#EditAddressModal<?php echo $row2['address_id']; ?>" style="margin-right:20px">EDIT</button>
                                            <button class="change-address" data-toggle="modal" data-target="#ChangeAddressModal">CHANGE</button>
                                            <p><span style="font-weight:600;font-size:21px"><?php echo $row2['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row2['phone_number'] ?></p>
                                            <p><?php echo $row2['street'] ?>&nbsp,&nbsp<?php echo $row2['floor_unit'] ?></p>
                                            <p><?php echo $row2['town_city'] ?>&nbsp,&nbsp<?php echo $row2['postcode'] ?>&nbsp<?php echo $row2['state_region'] ?></p>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <!-- Edit Address Modal for Default-->
                                    <div class="modal fade" id="EditAddressModal<?php echo $row2['address_id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Address</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="updateAddressCart.php" method="POST" id="editAddress">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Full Name :</label>
                                                                    <input type="text" name="fullname" id="fullname" class="form-control" maxlength="255" value="<?php echo $row2['fullname']; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Phone Number :</label>
                                                                    <div id="input-wrapper">
                                                                        <label for="text">+60</label>
                                                                        <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" minlength="8" maxlength="11" pattern="[0-9]+" value="<?php echo $row2['phone_number']; ?>" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Street :</label>
                                                                    <input type="text" name="street" id="street" class="form-control" maxlength="255" value="<?php echo $row2['street']; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Floor Unit (Optional) :</label>
                                                                    <input type="text" name="floor_unit" id="floor_unit" class="form-control" maxlength="255" value="<?php echo $row2['floor_unit']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Town / City :</label>
                                                                    <input type="text" name="town_city" id="town_city" class="form-control" maxlength="255" value="<?php echo $row2['town_city']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Postcode :</label>
                                                                    <input type="text" name="postcode" id="postcode" class="form-control" minlength="5" maxlength="5" pattern="[0-9]+" required value="<?php echo $row2['postcode']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <select name="state_region" id="states<?php echo $row2['address_id']; ?>" class="selectpicker show-menu-arrow w-100" data-header="State / Region" title="State / Region" data-size="14" data-live-search="true" data-live-search-placeholder="Search" required>
                                                                        <option class="options" value="WP Kuala Lumpur">WP Kuala Lumpur</option>
                                                                        <option class="options" value="WP Putrajaya">WP Putrajaya</option>
                                                                        <option class="options" value="WP Labuan">WP Labuan</option>
                                                                        <option class="options" value="Terengganu">Terengganu</option>
                                                                        <option class="options" value="Selangor">Selangor</option>
                                                                        <option class="options" value="Sarawak">Sarawak</option>
                                                                        <option class="options" value="Sabah">Sabah</option>
                                                                        <option class="options" value="Pulau Pinang">Pulau Pinang</option>
                                                                        <option class="options" value="Perlis">Perlis</option>
                                                                        <option class="options" value="Perak">Perak</option>
                                                                        <option class="options" value="Pahang">Pahang</option>
                                                                        <option class="options" value="Negeri Sembilan">Negeri Sembilan</option>
                                                                        <option class="options" value="Melaka">Melaka</option>
                                                                        <option class="options" value="Kelantan">Kelantan</option>
                                                                        <option class="options" value="Kedah">Kedah</option>
                                                                        <option class="options" value="Johor">Johor</option>
                                                                    </select>
                                                                    <input type="hidden" name="address_id" value="<?php echo $row2['address_id']; ?>">
                                                                    <input type="hidden" name="username" value="<?php echo $_SESSION["username"] ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <span class="btn btn-secondary reset" id="reset" onClick="resetFields()">RESET</span>
                                                        <button type="submit" name="editAddress" value="Submit" class="btn btn-primary editAddress">UPDATE</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        function resetFields() { //reset form without [input type=reset]
                                            document.getElementById("editAddress").reset();
                                        }
                                    </script>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            var a = "<?php echo $row2['state_region']; ?>"; //insert array from database


                                            $('#states<?php echo $row2['address_id']; ?>').selectpicker('val', a); //insert array value to selected options
                                            $('.reset').click(function() {
                                                setTimeout(function() {
                                                    $('#states<?php echo $row2['address_id']; ?>').selectpicker('val', a);
                                                });
                                            });
                                        });
                                    </script>
                            <?php
                                }
                            }
                        }
                        if (mysqli_num_rows($result3) == 0 && mysqli_num_rows($result2) == 0) { ?>
                            <button class="btn-tertiary addAddress" data-toggle="modal" data-target="#AddAddressModal"><i class="fa fa-plus"></i>ADD NEW ADDRESS</button>
                        <?php } ?>
                        <!-- Add Address Modal -->
                        <div class="modal fade" id="AddAddressModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Address</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="addAddressCart.php" method="POST">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Full Name :</label>
                                                        <input type="text" name="fullname" id="addfullname" class="form-control" maxlength="255" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Phone Number :</label>
                                                        <div id="input-wrapper">
                                                            <label for="text">+60</label>
                                                            <input type="text" name="phoneNumber" id="addphoneNumber" class="form-control" minlength="8" maxlength="11" pattern="[0-9]+" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Street :</label>
                                                        <input type="text" name="street" id="addstreet" class="form-control" maxlength="255" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Floor Unit (Optional) :</label>
                                                        <input type="text" name="floor_unit" id="addfloor_unit" class="form-control" maxlength="255">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Town / City :</label>
                                                        <input type="text" name="town_city" id="addtown_city" class="form-control" maxlength="255" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Postcode :</label>
                                                        <input type="text" name="postcode" id="addpostcode" class="form-control" minlength="5" maxlength="5" pattern="[0-9]+" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <select name="state_region" id="addstates" class="selectpicker show-menu-arrow w-100" data-header="State / Region" title="State / Region" data-size="14" data-live-search="true" data-live-search-placeholder="Search" required>
                                                            <option class="options" value="WP Kuala Lumpur">WP Kuala Lumpur</option>
                                                            <option class="options" value="WP Putrajaya">WP Putrajaya</option>
                                                            <option class="options" value="WP Labuan">WP Labuan</option>
                                                            <option class="options" value="Terengganu">Terengganu</option>
                                                            <option class="options" value="Selangor">Selangor</option>
                                                            <option class="options" value="Sarawak">Sarawak</option>
                                                            <option class="options" value="Sabah">Sabah</option>
                                                            <option class="options" value="Pulau Pinang">Pulau Pinang</option>
                                                            <option class="options" value="Perlis">Perlis</option>
                                                            <option class="options" value="Perak">Perak</option>
                                                            <option class="options" value="Pahang">Pahang</option>
                                                            <option class="options" value="Negeri Sembilan">Negeri Sembilan</option>
                                                            <option class="options" value="Melaka">Melaka</option>
                                                            <option class="options" value="Kelantan">Kelantan</option>
                                                            <option class="options" value="Kedah">Kedah</option>
                                                            <option class="options" value="Johor">Johor</option>
                                                        </select>
                                                        <input type="hidden" name="username" value="<?php echo $_SESSION["username"] ?>">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-secondary reset">RESET</button>
                                            <button type="submit" name="saveAddress" value="Submit" class="btn btn-primary saveAddress">ADD</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Add Address Modal for Inside Another Modal -->
                        <div class="modal fade" id="AddAddressModalCart" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Address</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="addAddressCart.php" method="POST">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Full Name :</label>
                                                        <input type="text" name="fullname" id="addfullname2" class="form-control" maxlength="255" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Phone Number :</label>
                                                        <div id="input-wrapper">
                                                            <label for="text">+60</label>
                                                            <input type="text" name="phoneNumber" id="addphoneNumber2" class="form-control" minlength="8" maxlength="11" pattern="[0-9]+" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Street :</label>
                                                        <input type="text" name="street" id="addstreet2" class="form-control" maxlength="255" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Floor Unit (Optional) :</label>
                                                        <input type="text" name="floor_unit" id="addfloor_unit2" class="form-control" maxlength="255">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Town / City :</label>
                                                        <input type="text" name="town_city" id="addtown_city2" class="form-control" maxlength="255" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Postcode :</label>
                                                        <input type="text" name="postcode" id="addpostcode2" class="form-control" minlength="5" maxlength="5" pattern="[0-9]+" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <select name="state_region" id="states" class="selectpicker show-menu-arrow w-100" data-header="State / Region" title="State / Region" data-size="14" data-live-search="true" data-live-search-placeholder="Search" required>
                                                            <option class="options" value="WP Kuala Lumpur">WP Kuala Lumpur</option>
                                                            <option class="options" value="WP Putrajaya">WP Putrajaya</option>
                                                            <option class="options" value="WP Labuan">WP Labuan</option>
                                                            <option class="options" value="Terengganu">Terengganu</option>
                                                            <option class="options" value="Selangor">Selangor</option>
                                                            <option class="options" value="Sarawak">Sarawak</option>
                                                            <option class="options" value="Sabah">Sabah</option>
                                                            <option class="options" value="Pulau Pinang">Pulau Pinang</option>
                                                            <option class="options" value="Perlis">Perlis</option>
                                                            <option class="options" value="Perak">Perak</option>
                                                            <option class="options" value="Pahang">Pahang</option>
                                                            <option class="options" value="Negeri Sembilan">Negeri Sembilan</option>
                                                            <option class="options" value="Melaka">Melaka</option>
                                                            <option class="options" value="Kelantan">Kelantan</option>
                                                            <option class="options" value="Kedah">Kedah</option>
                                                            <option class="options" value="Johor">Johor</option>
                                                        </select>
                                                        <input type="hidden" name="username" value="<?php echo $_SESSION["username"] ?>">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-secondary reset">RESET</button>
                                            <button type="submit" name="saveAddress" value="Submit" class="btn btn-primary saveAddress2">ADD</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----  Change Address Modal  ----->
                <div class="modal fade ChangeAddressModal" id="ChangeAddressModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Select Address</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="changeAddress.php" method="POST">
                                <div class="modal-body">
                                    <?php while ($row4 = mysqli_fetch_array($result4, MYSQLI_BOTH)) { ?>
                                        <div class="row">
                                            <div class="col-1">
                                                <label class="custom-radio-button">
                                                    <input type="radio" name="address_id" value="<?php echo $row4['address_id'] ?>" <?php if ($row4['mode'] == 'selected') { ?>checked="checked" <?php } ?>required>
                                                </label>

                                            </div>
                                            <div class="col">
                                                <?php if ($row4['mode'] == 'selected' || ($row4['mode'] == 'default' && mysqli_num_rows($result5) < 1)) {
                                                    if (empty($row4['floor_unit'])) {
                                                ?>
                                                        <div class="default-address">
                                                            <span class="selected-tag">SELECTED</span>
                                                            <p><span style="font-weight:600;font-size:21px"><?php echo $row4['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row4['phone_number'] ?></p>
                                                            <p><?php echo $row4['street'] ?></p>
                                                            <p><?php echo $row4['town_city'] ?>&nbsp,&nbsp<?php echo $row4['postcode'] ?>&nbsp<?php echo $row4['state_region'] ?></p>
                                                        </div>

                                                    <?php } else { ?>
                                                        <div class="default-address">
                                                            <span class="selected-tag">SELECTED</span>
                                                            <p><span style="font-weight:600;font-size:21px"><?php echo $row4['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row4['phone_number'] ?></p>
                                                            <p><?php echo $row4['street'] ?>&nbsp,&nbsp<?php echo $row4['floor_unit'] ?></p>
                                                            <p><?php echo $row4['town_city'] ?>&nbsp,&nbsp<?php echo $row4['postcode'] ?>&nbsp<?php echo $row4['state_region'] ?></p>
                                                        </div>
                                                    <?php }
                                                } else {
                                                    if (empty($row4['floor_unit'])) {
                                                    ?>
                                                        <div class="all-address">
                                                            <?php if ($row4['mode'] == 'default') { ?>
                                                                <span class="default-tag">DEFAULT</span>
                                                            <?php } ?>
                                                            <p><span style="font-weight:600;font-size:21px"><?php echo $row4['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row4['phone_number'] ?></p>
                                                            <p><?php echo $row4['street'] ?></p>
                                                            <p><?php echo $row4['town_city'] ?>&nbsp,&nbsp<?php echo $row4['postcode'] ?>&nbsp<?php echo $row4['state_region'] ?></p>
                                                        </div>

                                                    <?php } else { ?>
                                                        <div class="all-address"><?php if ($row4['mode'] == 'default') { ?>
                                                                <span class="default-tag">DEFAULT</span>
                                                            <?php } ?>
                                                            <p><span style="font-weight:600;font-size:21px"><?php echo $row4['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row4['phone_number'] ?></p>
                                                            <p><?php echo $row4['street'] ?>&nbsp,&nbsp<?php echo $row4['floor_unit'] ?></p>
                                                            <p><?php echo $row4['town_city'] ?>&nbsp,&nbsp<?php echo $row4['postcode'] ?>&nbsp<?php echo $row4['state_region'] ?></p>
                                                        </div>
                                                    <?php }
                                                    ?>
                                                <?php
                                                } ?>
                                            </div>
                                        </div>
                                    <?php
                                    } ?>
                                    <input type="hidden" name="username" value="<?php echo $row1["username"] ?>">
                                    <div class="row ">
                                        <div class="col">
                                            <span class="btn-tertiary addAddress" data-dismiss="modal" data-toggle="modal" data-target="#AddAddressModalCart"><i class="fa fa-plus"></i>ADD NEW ADDRESS</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                    <button type="submit" name="SaveAddress" value="Submit" class="btn btn-primary">SAVE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!----  Cart Items  ----->
            <div class="container-fluid" style="padding:0;margin-top:20px;">
                <div class="card">
                    <div class="card-header">
                        <span>CHECKOUT</span>
                    </div>
                    <div class="card-body" style="padding:40px;padding-top:5px;padding-bottom:0">
                        <?php
                        $query6 = "SELECT * FROM cart WHERE username = '" . $_SESSION["username"] . "' ORDER BY mangaln_id";
                        $result6 = mysqli_query($link, $query6);

                        ?>
                        <table id="myCart" class="table table-borderless">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th style="text-align:left">PRODUCT</th>
                                    <th>VOLUME</th>
                                    <th>PRICE</th>
                                    <th>QUANTITY</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $yomi_tokens = 0;
                                $order_total = 0;
                                while ($row6 = mysqli_fetch_array($result6, MYSQLI_BOTH)) {
                                    $query7 = "SELECT * FROM stock WHERE mangaln_id = '" . $row6['mangaln_id'] . "' AND volume = '" . $row6['volume'] . "'";
                                    $result7 = mysqli_query($link, $query7);
                                    while ($row7 = mysqli_fetch_array($result7, MYSQLI_BOTH)) { ?>
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
                                                <p style="margin:0;">×<?php echo $row6['quantity'] ?></p>
                                            </td>
                                            <td style="width:10%">
                                                <p style="margin:0;">RM<?php echo $row6['subtotal'] ?></p>
                                            </td>
                                        </tr>
                                <?php
                                        $yomi_tokens = $yomi_tokens + $row6['quantity'];
                                        $total_yomi = $yomi_tokens * 10;
                                        $order_total = $order_total + $row6['subtotal'];
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col">
                                <span style="float:right;color:#5A2E98;font-weight:500;background-color:#BF95FC;border-radius:5px;padding:10px;margin-top:0;margin-bottom:15px">YOU'LL EARN <?php echo $total_yomi ?> YOMI TOKENS!</span>
                            </div>
                        </div>
                        <div class="card-footer" style="border-top:2px solid #525252">
                            <div class="row">
                                <div class="col">
                                    <p>DISCOUNT:</p>
                                </div>
                                <div class="col-1" style="text-align:right;margin-right:30px">
                                    <p id="discount">RM0</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>ORDER TOTAL:</p>
                                </div>
                                <div class="col-1" style="text-align:right;margin-right:30px">
                                    <p id="order_total">RM<?php echo $order_total ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="placeOrder.php" method="POST">
                <div class="container-fluid" style="padding:0;margin-top:20px;">
                    <div class="card">
                        <div class="card-header">
                            <span>REDEEM YOMI TOKENS</span>
                        </div>
                        <div class="card-body" style="padding:40px;padding-top:10px;padding-bottom:10px">

                            <div class="row">
                                <div class="col" style="padding-bottom:0">
                                    <span id="yomi_tokens" style="float:right;color:#5A2E98;font-weight:500;background-color:#BF95FC;border-radius:5px;padding:10px;margin-top:10px;">YOUR BALANCE: <?php echo $row1['yomi_tokens'] ?></span>
                                </div>
                            </div>
                            <div class="checkmark">
                                <div class="row">
                                    <div class="col">
                                        <input id='hiddenCheck' type='hidden' value='No' name='option'>
                                        <?php if ($row1['yomi_tokens'] >= 10) { ?>
                                            <input type="checkbox" name="option" id="option1" value="discount" onClick="ckChange(this)"> REDEEM ALL YOMI TOKENS AS DISCOUNT
                                        <?php } else { ?>
                                            <input type="checkbox" disabled name="option" id="option1" value="discount" onClick="ckChange(this)"> REDEEM ALL YOMI TOKENS AS DISCOUNT
                                        <?php } ?>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">

                                        <?php if ($row1['yomi_tokens'] >= 10) { ?>
                                            <input type="checkbox" name="option" id="option2" value="donate" onClick="ckChange(this)"> DONATE YOMI TOKENS TO MANGA TRANSLATORS
                                        <?php } else { ?>
                                            <input type="checkbox" disabled name="option" id="option2" value="donate" onClick="ckChange(this)"> DONATE YOMI TOKENS TO MANGA TRANSLATORS
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div style="display:flex;justify-content:left;padding:15px">
                                        <input type='hidden' value='0' name='donate'>
                                        <input type="number" disabled id="donate" name="donate" value="10" min="10" max="<?php echo $row1['yomi_tokens'] ?>" step="10" pattern="[0-9]*" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid" style="padding:0;margin-top:20px;padding-bottom:20px;">
                    <div class="card">
                        <div class="card-body" style="padding:40px;padding-top:10px;padding-bottom:10px">
                            <div class="row">
                                <div class="col" style="padding:10px">
                                    <select name="payment_method" id="payment_method" class="selectpicker show-menu-arrow w-30" title="Payment Method" data-size="3" required>
                                        <option class="options" value="Cash on Delivery">Cash on Delivery</option>
                                        <option class="options" value="Online Banking">Online Banking</option>
                                        <option class="options" value="Debit/Credit Card">Debit/Credit Card</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" style="padding:10px">
                                    <div class="card-text" style="font-size:20px;font-weight:600;">TOTAL PAYMENT:</div>
                                </div>
                                <div class="col-1" style="padding:10px;padding-bottom:0;text-align:right;margin-right:55px">
                                    <p id="total_payment" style="font-size:20px;font-weight:600;text-align:right;">RM<?php echo $order_total ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="hidden" name="username" value="<?php echo $row1['username'] ?>">
                            <?php if (mysqli_num_rows($result4) > 0) { ?>
                                <button type="submit" id="checkout" name="checkout" value="Submit" class="btn btn-primary" style="float:right;margin-top:20px;;padding:10px;width:150px">PLACE ORDER</button>
                            <?php } else { ?>
                                <button type="submit" disabled id="checkout" name="checkout" value="Submit" class="btn btn-primary" style="float:right;margin-top:20px;;padding:10px;width:150px">PLACE ORDER</button>
                            <?php } ?>

                        </div>
                    </div>

                </div>
            </form>
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
                form.addEventListener('submit', () => {
                    if (document.getElementById("option1").checked || document.getElementById("option2").checked) {
                        document.getElementById('hiddenCheck').disabled = true;
                    }
                });
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
                function ckChange(ckType) {
                    var ckName = document.getElementsByName(ckType.name);
                    var checked = document.getElementById(ckType.id);
                    var yomi_tokens = <?php echo $row1['yomi_tokens'] ?>;
                    var p = document.getElementById('yomi_tokens')
                    var order_total = <?php echo $order_total ?>;

                    if (checked.checked) {
                        for (var i = 0; i < ckName.length; i++) {

                            if (!ckName[i].checked) {
                                ckName[i].disabled = true;
                                document.getElementById('discount').innerHTML = "-RM" + yomi_tokens / 10;
                                p.style.textDecoration = 'line-through';
                                document.getElementById('order_total').innerHTML = "RM" + (order_total - (yomi_tokens / 10));
                                document.getElementById('total_payment').innerHTML = "RM" + (order_total - (yomi_tokens / 10));
                                document.getElementById('donate').disabled = true;
                            } else {
                                ckName[i].disabled = false;
                                document.getElementById('discount').innerHTML = "RM0";
                                p.style.textDecoration = 'none';
                                document.getElementById('order_total').innerHTML = "RM" + order_total;
                                document.getElementById('total_payment').innerHTML = "RM" + order_total;
                                document.getElementById('donate').disabled = false;
                            }
                        }
                    } else {
                        for (var i = 0; i < ckName.length; i++) {
                            ckName[i].disabled = false;
                            document.getElementById('donate').disabled = true;
                            document.getElementById("discount").innerHTML = "RM0";
                            p.style.textDecoration = 'none';
                            document.getElementById('order_total').innerHTML = "RM" + order_total;
                            document.getElementById('total_payment').innerHTML = "RM" + order_total;
                        }
                    }
                }
            </script>


            <script>
                $('input[type=number]').inputSpinner();
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('#addfullname,#addphoneNumber,#addstreet,#addtown_city,#addpostcode').on('keyup', function() {
                        var fullname_value = $("#addfullname").val();
                        var phoneNumber_value = $("#addphoneNumber").val();
                        var street_value = $("#addstreet").val();
                        var town_city = $("#addtown_city").val();
                        var postcode_value = $("add#postcode").val();
                        if (!fullname_value.trim().length || !phoneNumber_value.trim().length || !street_value.trim().length || !town_city.trim().length || !postcode_value.trim().length) { //check if the value insert contain value or not
                            $('button.saveAddress').prop('disabled', true);
                        } else {
                            $('button.saveAddress').prop('disabled', false);
                        }
                    });

                });
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('#addfullname2,#addphoneNumber2,#addstreet2,#addtown_city2,#addpostcode2').on('keyup', function() {
                        var fullname_value = $("#addfullname2").val();
                        var phoneNumber_value = $("#addphoneNumber2").val();
                        var street_value = $("#addstreet2").val();
                        var town_city = $("#addtown_city2").val();
                        var postcode_value = $("#addpostcode2").val();
                        if (!fullname_value.trim().length || !phoneNumber_value.trim().length || !street_value.trim().length || !town_city.trim().length || !postcode_value.trim().length) { //check if the value insert contain value or not
                            $('button.saveAddress2').prop('disabled', true);
                        } else {
                            $('button.saveAddress2').prop('disabled', false);
                        }
                    });

                });
            </script>+

            <script type="text/javascript">
                $(document).ready(function() {
                    $('#fullname,#phoneNumber,#street,#town_city,#postcode').on('keyup', function() {
                        var fullname_value = $("#fullname").val();
                        var phoneNumber_value = $("#phoneNumber").val();
                        var street_value = $("#street").val();
                        var town_city = $("#town_city").val();
                        var postcode_value = $("#postcode").val();
                        if (!fullname_value.trim().length || !phoneNumber_value.trim().length || !street_value.trim().length || !town_city.trim().length || !postcode_value.trim().length) { //check if the value insert contain value or not
                            $('button.editAddress').prop('disabled', true);
                        } else {
                            $('button.editAddress').prop('disabled', false);
                        }
                    });

                });
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('.selectpicker').selectpicker();
                    $('.reset').click(function() {
                        $(".selectpicker").val('default').selectpicker("refresh");
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    var spanSubmit = $('.setDefault-tag');

                    spanSubmit.on('click', function() {
                        $(this).closest('form').submit();
                    });
                });
            </script>

            <script type="text/javascript">
                //add to cart button will be disabled if .selectpicker is not selected
                var $submitButton = $('#checkout');
                var $selectors = $('.selectpicker');
                $submitButton.attr('disabled', 'disabled');
                <?php if (mysqli_num_rows($result4) != 0) { ?>
                    $('#payment_method').change(function() {
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
                <?php } ?>
            </script>
        </body>

    </html>

<?php
    }
} else {
    header("Location:login.php");
}
?>