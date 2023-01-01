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
        <title> YOMI | My Addresses </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="css/userHomepage.css?V=1" rel="stylesheet">

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
                    <div class="card-header" style="background-color:#181818;border-bottom:2px solid #5A2E98">
                        <p style="margin:0;font-size:20px;font-weight:500;color:#F5F5F5">MY ADDRESS</p>
                    </div>

                    <div class="card-body" style="padding:50px;min-height:300px;">
                        <?php
                        $query2 = "SELECT * FROM addresses WHERE username = '" . $_SESSION["username"] . "' AND mode = 'default'";
                        $result2 = mysqli_query($link, $query2);

                        $query3 = "SELECT * FROM addresses WHERE username = '" . $_SESSION["username"] . "' AND mode != 'default' ORDER BY address_id ASC";
                        $result3 = mysqli_query($link, $query3);

                        if (mysqli_num_rows($result3) == 0 && mysqli_num_rows($result2) == 0) { ?>
                            <div class="noAddress">
                                <p>You dont have any addresses yet.</p>
                            </div>
                            <?php
                        } else {
                            while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
                                if (empty($row2['floor_unit'])) {
                            ?>
                                    <div class="default-address">
                                        <span class="default-tag">DEFAULT</span>
                                        <button class="edit-address" data-toggle="modal" data-target="#EditAddressModal<?php echo $row2['address_id']; ?>">EDIT</button>
                                        <button class="delete-address" data-toggle="modal" data-target="#DeleteAddressModal<?php echo $row2['address_id']; ?>">DELETE</button>
                                        <p><span style="font-weight:600;font-size:21px"><?php echo $row2['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row2['phone_number'] ?></p>
                                        <p><?php echo $row2['street'] ?></p>
                                        <p><?php echo $row2['town_city'] ?>&nbsp,&nbsp<?php echo $row2['postcode'] ?>&nbsp<?php echo $row2['state_region'] ?></p>
                                    </div>

                                <?php } else { ?>
                                    <div class="default-address">
                                        <span class="default-tag">DEFAULT</span>
                                        <button class="edit-address" data-toggle="modal" data-target="#EditAddressModal<?php echo $row2['address_id']; ?>">EDIT</button>
                                        <button class="delete-address" data-toggle="modal" data-target="#DeleteAddressModal<?php echo $row2['address_id']; ?>">DELETE</button>
                                        <p><span style="font-weight:600;font-size:21px"><?php echo $row2['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row2['phone_number'] ?></p>
                                        <p><?php echo $row2['street'] ?>&nbsp,&nbsp<?php echo $row2['floor_unit'] ?></p>
                                        <p><?php echo $row2['town_city'] ?>&nbsp,&nbsp<?php echo $row2['postcode'] ?>&nbsp<?php echo $row2['state_region'] ?></p>
                                    </div>
                                <?php
                                }
                                ?>
                                <!----  Delete Default Address Modal  ----->
                                <div class="modal fade DeleteModal" id="DeleteAddressModal<?php echo $row2['address_id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Delete Address</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="deleteAddress.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <h7> Are you sure you want to delete this address? </h7>
                                                    <input type="hidden" name="id" value="<?php echo $row2["address_id"] ?>">
                                                    <input type="hidden" name="username" value="<?php echo $row1["username"] ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                                    <button type="submit" name="deleteAddress" value="Submit" class="btn btn-primary">DELETE</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                                            <form action="updateAddress.php" method="POST" id="editAddress">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Fullname :</label>
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
                                                    <button type="submit" name="editAddress" value="Submit" class="btn btn-primary editAddress">EDIT</button>
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
                            while ($row3 = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
                                if (empty($row3['floor_unit'])) {
                                ?>
                                    <div class="all-address">
                                        <span class="setDefault-tag" data-toggle="modal" data-target="#setAddressModal<?php echo $row3['address_id']; ?>">SET AS DEFAULT</span>
                                        <button class="edit-address" data-toggle="modal" data-target="#EditAddressModal<?php echo $row3['address_id']; ?>">EDIT</button>
                                        <button class="delete-address" data-toggle="modal" data-target="#DeleteAddressModal<?php echo $row3['address_id']; ?>">DELETE</button>
                                        <p><span style="font-weight:600;font-size:21px"><?php echo $row3['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row3['phone_number'] ?></p>
                                        <p><?php echo $row3['street'] ?></p>
                                        <p><?php echo $row3['town_city'] ?>&nbsp,&nbsp<?php echo $row3['postcode'] ?>&nbsp<?php echo $row3['state_region'] ?></p>
                                    </div>
                                    <!----  Set Default Modal  ----->
                                    <div class="modal fade setAddressModal" id="setAddressModal<?php echo $row3['address_id']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Set Default Address</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="setDefault.php" method="POST">
                                                    <div class="modal-body">
                                                        <h7> Are you sure you want to set this address as default? </h7>
                                                        <input type="hidden" name="username" value="<?php echo $row1['username'] ?>">
                                                        <input type="hidden" name="address_id" value="<?php echo $row3['address_id'] ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="setDefault" value="Submit" class="btn btn-primary">Yes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <!----  Set Default Modal  ----->
                                    <div class="all-address">
                                        <span class="setDefault-tag" data-toggle="modal" data-target="#setAddressModal<?php echo $row3['address_id']; ?>">SET AS DEFAULT</span>
                                        <button class="edit-address" data-toggle="modal" data-target="#EditAddressModal<?php echo $row3['address_id']; ?>">EDIT</button>
                                        <button class="delete-address" data-toggle="modal" data-target="#DeleteAddressModal<?php echo $row3['address_id']; ?>">DELETE</button>
                                        <p><span style="font-weight:600;font-size:21px"><?php echo $row3['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp(+60)&nbsp&nbsp<?php echo $row3['phone_number'] ?></p>
                                        <p><?php echo $row3['street'] ?>&nbsp,&nbsp<?php echo $row3['floor_unit'] ?></p>
                                        <p><?php echo $row3['town_city'] ?>&nbsp,&nbsp<?php echo $row3['postcode'] ?>&nbsp<?php echo $row3['state_region'] ?></p>
                                    </div>
                                    <div class="modal fade setAddressModal" id="setAddressModal<?php echo $row3['address_id']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Set Default Address</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="setDefault.php" method="POST">
                                                    <div class="modal-body">
                                                        <h7> Are you sure you want to set this address as default? </h7>
                                                        <input type="hidden" name="username" value="<?php echo $row1['username'] ?>">
                                                        <input type="hidden" name="address_id" value="<?php echo $row3['address_id'] ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="setDefault" value="Submit" class="btn btn-primary">Yes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <!----  Delete Other Address Modal  ----->
                                <div class="modal fade DeleteModal" id="DeleteAddressModal<?php echo $row3['address_id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Delete Address</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="deleteAddress.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <h7> Are you sure you want to delete this address? </h7>
                                                    <input type="hidden" name="id" value="<?php echo $row3["address_id"] ?>">
                                                    <input type="hidden" name="username" value="<?php echo $row1["username"] ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="deleteAddress" value="Submit" class="btn btn-primary">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Edit Address Modal for Other Address-->
                                <div class="modal fade" id="EditAddressModal<?php echo $row3['address_id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Address</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="updateAddress.php" method="POST" id="editAddress">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Fullname :</label>
                                                                <input type="text" name="fullname" id="fullname" class="form-control" maxlength="255" value="<?php echo $row3['fullname']; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Phone Number :</label>
                                                                <div id="input-wrapper">
                                                                    <label for="text">+60</label>
                                                                    <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" minlength="8" maxlength="11" pattern="[0-9]+" value="<?php echo $row3['phone_number']; ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Street :</label>
                                                                <input type="text" name="street" id="street" class="form-control" maxlength="255" value="<?php echo $row3['street']; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Floor Unit (Optional) :</label>
                                                                <input type="text" name="floor_unit" id="floor_unit" class="form-control" maxlength="255" value="<?php echo $row3['floor_unit']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Town / City :</label>
                                                                <input type="text" name="town_city" id="town_city" class="form-control" maxlength="255" value="<?php echo $row3['town_city']; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Postcode :</label>
                                                                <input type="text" name="postcode" id="postcode" class="form-control" minlength="5" maxlength="5" pattern="[0-9]+" required value="<?php echo $row3['postcode']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <select name="state_region" id="states<?php echo $row3['address_id']; ?>" class="selectpicker show-menu-arrow w-100" data-header="State / Region" title="State / Region" data-size="14" data-live-search="true" data-live-search-placeholder="Search" required>
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
                                                                <input type="hidden" name="address_id" value="<?php echo $row3['address_id']; ?>">
                                                                <input type="hidden" name="username" value="<?php echo $_SESSION["username"] ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <span class="btn btn-secondary reset" id="reset" onClick="resetFields()">RESET</span>
                                                    <button type="submit" name="editAddress" value="Submit" class="btn btn-primary editAddress">EDIT</button>
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
                                        var a = "<?php echo $row3['state_region']; ?>"; //insert array from database


                                        $('#states<?php echo $row3['address_id']; ?>').selectpicker('val', a); //insert array value to selected options
                                        $('.reset').click(function() {
                                            setTimeout(function() {
                                                $('#states<?php echo $row3['address_id']; ?>').selectpicker('val', a);
                                            });
                                        });
                                    });
                                </script>
                        <?php
                            }
                        }
                        ?>
                        <button class="btn-tertiary addAddress" data-toggle="modal" data-target="#AddAddressModal"><i class="fa fa-plus"></i>ADD NEW ADDRESS</button>
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
                                    <form action="addAddress.php" method="POST">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Fullname :</label>
                                                        <input type="text" name="fullname" id="fullname" class="form-control" maxlength="255" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Phone Number :</label>
                                                        <div id="input-wrapper">
                                                            <label for="text">+60</label>
                                                            <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" minlength="8" maxlength="11" pattern="[0-9]+" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Street :</label>
                                                        <input type="text" name="street" id="street" class="form-control" maxlength="255" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Floor Unit (Optional) :</label>
                                                        <input type="text" name="floor_unit" id="floor_unit" class="form-control" maxlength="255">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Town / City :</label>
                                                        <input type="text" name="town_city" id="town_city" class="form-control" maxlength="255" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Postcode :</label>
                                                        <input type="text" name="postcode" id="postcode" class="form-control" minlength="5" maxlength="5" pattern="[0-9]+" required>
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
                                            <button type="submit" name="saveAddress" value="Submit" class="btn btn-primary saveAddress">ADD</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
        
        <script>
            $('form').attr('autocomplete','off'); //turn off autocomplete
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
                $('#fullname,#phoneNumber,#street,#town_city,#postcode').on('keyup', function() {
                    var fullname_value = $("#fullname").val();
                    var phoneNumber_value = $("#phoneNumber").val();
                    var street_value = $("#street").val();
                    var town_city = $("#town_city").val();
                    var postcode_value = $("#postcode").val();
                    if (!fullname_value.trim().length || !phoneNumber_value.trim().length || !street_value.trim().length || !town_city.trim().length || !postcode_value.trim().length) { //check if the value insert contain value or not
                        $('button.saveAddress').prop('disabled', true); //disable button
                        $('button.editAddress').prop('disabled', true);
                    } else {
                        $('button.saveAddress').prop('disabled', false);
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
        </body>

    </html>

<?php
} else {
    header("Location:login.php");
}
?>