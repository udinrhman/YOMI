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
        <title> YOMI | Product Detail </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="../css/adminProductDetail.css?V=1" rel="stylesheet">
        <style>
            .stock th {
                padding: 20px;
                border-bottom: 2px solid #181818;
            }

            .stock td {
                padding: 20px;
                border-bottom: 2px solid #181818;
            }

            #top3 tr:hover {
                cursor: pointer;
            }

            label {
                color: #8FB2FF;
            }

            .form-control {
                padding: 0;
            }

            .select .dropdown-menu {
                margin-left: 0px;
            }

            .select .options {
                padding-left: 0px;
            }

            .select .form-control {
                padding: 10px;
            }

            button:focus {
                outline: none;
            }
        </style>
    </head>

    <?php
    if (isset($_GET['ID'])) {
        $host = "localhost";
        $userid = "root";
        $password = "";
        $database = "yomi";

        $link = mysqli_connect($host, $userid, $password, $database);
        include '../function/timeAgo.php';
        $ID = mysqli_real_escape_string($link, $_GET['ID']);

        $query1 = "SELECT * FROM user where username = '" . $_SESSION["username"] . "'";
        $result1 = mysqli_query($link, $query1);

        $query = "SELECT * FROM mangaln where mangaln_id = '" . $ID . "'";
        $result = mysqli_query($link, $query);


        while ($row1 = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {

                $time_elapsed = timeAgo($row['mangaln_date']);
    ?>

                <body>
                    <!-- NAVBAR -->
                    <nav class="navbar navbar-expand-md navbar-custom sticky-top">
                        <div class="container-fluid">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item"> <a class="nav-link" href="dashboard.php">DASHBOARD</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="sales.php">SALES</a> </li>
                                <li class="nav-item"> <a style="border-bottom: 2px solid #777AFF" class="nav-link" href="products.php">PRODUCTS</a> </li>
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

                    <div id="result"></div>
                    <!------  Body   ------->
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <div class="col-sm-9 col-sm-offset-3 no-float">
                                <div class="container-fluid" style="padding: 0;">
                                    <div class="details" id="details">
                                        <img src="../upload/<?php echo $row['cover'] ?>" class="background">
                                        <div class="coverBox">
                                            <img src="../upload/<?php echo $row['cover'] ?>" class="cover">
                                            <button class="btn cover imgeditbtn"> CHANGE <br> COVER </button>
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
                                                    echo "&nbsp<button class='btn-primary' style='border:none;min-width:80px;font-size:12px;padding:2px'><a href='search.php?ID=" . $out . "'> " . $out . "</a></button>";       //link based on tags
                                                }
                                                ?>
                                            </span>
                                        </div>

                                        <div style="position:absolute;bottom:30px;right:140px;width:120px">
                                            <button class="btn btn-delete" style="width:120px" data-toggle="modal" data-target="#DeleteProductModal<?php echo $row['mangaln_id']; ?>">DELETE</button>
                                        </div>
                                        <div style="position:absolute;bottom:30px;right:10px;width:120px">
                                            <button class="btn btn-tertiary" data-toggle="modal" data-target="#UpdateProductModal">EDIT DETAILS</button>
                                        </div>
                                    </div>
                                </div>
                                <!----  Delete Product Modal  ----->
                                <div class="modal fade DeleteModal" id="DeleteProductModal<?php echo $row['mangaln_id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Delete Product</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="deleteProductForm" action="deleteProduct.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <h7> Are you sure you want to delete this product? </h7>
                                                    <input type="hidden" name="id" value="<?php echo $row["mangaln_id"] ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <input type="submit" name="deleteProduct" value="Delete" class="btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-----  Change Cover Modal  ------>
                                <div class="modal fade" id="ChangeCoverModal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Change Cover</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="updateCover.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">

                                                    <label style="color:#8FB2FF;font-weight:500;margin-bottom:5px">Image :</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="image" accept="image/*" class="custom-file-input" id="customFile" required>
                                                        <label class="custom-file-label" for="customFile">Choose Image</label>
                                                    </div>
                                                    <input type="hidden" name="mangaln_id" value="<?php echo $row["mangaln_id"] ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-secondary reset">RESET</button>
                                                    <button type="submit" name="saveCover" value="Submit" class="btn btn-primary">UPDATE</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!------  Product Details  ------->
                                <div class="container-fluid" style="padding: 0;">
                                    <div class="card tbig">
                                        <div class="card-body">
                                            <h5 class="card-title">Synopsis</h5>
                                            <p class="card-text"><?php echo nl2br($row['synopsis']); ?></p>
                                            <hr>
                                            <div class="review">
                                                <h5 class="card-title" style="color:#c4cfff;text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.227)">Admin's Review</h5>
                                                <span class="card-text more" style="color:#FFFFFF"><?php echo nl2br($row['admin_review']); ?></span><a class="readmore" style="color:#c4cfff;text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.227)">... read more</a>
                                            </div>
                                            <br>
                                            <span id="last_updated" style="float:right;font-size:13px;color:#AAAAAA">Last updated: <?php echo $time_elapsed; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <!------  Stock  ------->
                                <div class="container-fluid" style="padding: 0;">
                                    <div class="card tbig">
                                        <div class="card-body">
                                            <h5 class="card-title" style="color:#8FB2FF">STOCK</h5>
                                            <table class="stock" style="background-color:#000000;border-radius:5px;width: 100%;">
                                                <tr>
                                                    <th></th>
                                                    <th style="width:10%">Quantity</th>
                                                </tr>

                                                <?php
                                                $queryStock = "SELECT * FROM stock WHERE mangaln_id = '" . $ID . "' ORDER BY stock_id ASC";
                                                $resultStock = mysqli_query($link, $queryStock) or die(mysqli_error($link));
                                                $data   = $resultStock->fetch_all(MYSQLI_ASSOC);

                                                if (mysqli_num_rows($resultStock) == 0) {
                                                ?>
                                                    <tr>
                                                        <td colspan="2" style="text-align:center;">No Volume added for this product.</td>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    foreach ($data as $stock) {
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $stock['volume'];
                                                                if ($stock['stock'] == 0) { ?>
                                                                    &nbsp
                                                                    <div class="stock-tag">
                                                                        OUT OF STOCK
                                                                    </div>
                                                                <?php } ?>
                                                            </td>
                                                            <td style="width:10%;text-align:center;"><?php echo $stock['stock'] ?></td>
                                                        </tr>

                                                <?php }
                                                }
                                                ?>
                                            </table>
                                        </div>
                                        <div class="card-footer stockFooter" style="padding:0">
                                            <form id="addVolumeForm" method="POST">
                                                <input type="hidden" name="mangaln_id" id="mangaln_id" value="<?php echo $ID ?>">
                                                <button class="btn btn-primary" style="float:right;margin-left:-10px;margin-right:20px;margin-bottom:10px;margin-top:10px" type="submit" name="addVolume" id="addVolume">ADD VOLUME</button>
                                            </form>
                                            <?php if (mysqli_num_rows($resultStock) != 0) { ?>
                                                <button class="btn btn-tertiary" style="float:right;margin-right:20px;margin-bottom:10px;margin-top:10px;width:120px" data-toggle="modal" data-target="#EditStockModal">EDIT STOCK</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!----  Edit Stock Quantity Modal  ----->
                                <div class="modal fade" id="EditStockModal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content stockQuantity" style="width:fit-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">EDIT STOCK QUANTITY</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="editStockForm" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <?php if (mysqli_num_rows($resultStock) == 0) { ?>
                                                        No Volume added for this product.
                                                    <?php } ?>
                                                    <table style="border-radius:5px;width:100%;">
                                                        <?php
                                                        $numItems = count($data);
                                                        $s = 0;
                                                        foreach ($data as $stock) {
                                                        ?>
                                                            <tr>
                                                                <td style="padding:0">
                                                                    <?php if (++$s === $numItems) { ?>
                                                                        <span data-toggle="modal" data-target="#DeleteVolumeModal<?php echo $stock['stock_id']; ?>"><i class="fa fa-window-close"></i></span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td></td>
                                                                <td style="padding:0;padding-left:20px;min-width:150px"><?php echo $stock['volume'] ?></td>
                                                                <td style="padding:0">
                                                                    <input type="hidden" name="mangaln_id" id="mangaln_id" value="<?php echo $ID ?>">
                                                                    <input type="number" name="stock[]" id="stock" value="<?php echo $stock['stock'] ?>" min="0" step="1" pattern="[0-9]*" style="width:100px;border-radius:5px;text-align:center" required />
                                                                </td>
                                                            </tr>
                                                            <input type="hidden" name="stock_id[]" id="stock_id" value="<?php echo $stock['stock_id'] ?>">
                                                        <?php }
                                                        ?>
                                                    </table>

                                                </div>
                                                <?php if (mysqli_num_rows($resultStock) != 0) { ?>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                                        <button class="btn btn-primary" type="submit" name="editStock" id="editStock">UPDATE</button>
                                                    </div>
                                                <?php } ?>
                                            </form>
                                            <?php
                                            foreach ($data as $stock) {
                                            ?>
                                                <!--------------------------  Delete Volume Modal -------------------------------->
                                                <div class="modal fade DeleteModal" id="DeleteVolumeModal<?php echo $stock['stock_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Delete Volume</h6>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form id="deleteVolumeForm" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <h7> Are you sure you want to delete this volume? </h7>
                                                                    <input type="hidden" name="stock_id" id="stock_id" value="<?php echo $stock["stock_id"] ?>">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                                                    <button type="submit" name="deleteVolume" value="delete" id="delete" class="btn btn-primary">DELETE</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <!----  Comment Section  ----->
                                <div class="container-fluid" style="padding: 0;">
                                    <div class="card tbig">
                                        <div class="card-body" style="padding-right: 20px;">
                                            <h5 class="card-title">Comment</h5>
                                            <hr>
                                            <div id="commentSection">
                                                <?php
                                                $querycom = "SELECT * FROM comments WHERE mangaln_id = '" . $ID . "' ORDER BY comment_id ASC";
                                                $resultcom = mysqli_query($link, $querycom) or die(mysqli_error($link));
                                                $i = 1; //for reply collapse id (individual collapse)
                                                if (mysqli_num_rows($resultcom) < 1) {
                                                ?>
                                                    <img src="../image/yomiLogo3.png" style="height:60px;width:70px;display:block;margin:3% auto 15px;opacity:0.5;">
                                                    <h6 style="color:#c0c0c0;text-align:center;margin-bottom:2%;"> There are no comments yet. </h6>
                                                    <?php
                                                } else {
                                                    while ($coms = mysqli_fetch_array($resultcom, MYSQLI_BOTH)) { ?>
                                                        <!--------------------------  Delete Comment Modal -------------------------------->
                                                        <div class="modal fade DeleteCommentModal" id="DeleteCommentModal<?php echo $coms['comment_id']; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title">Delete Comment</h6>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form id="deleteCommentForm" method="POST" enctype="multipart/form-data">
                                                                        <div class="modal-body">
                                                                            <h7> Are you sure you want to delete this comment? </h7>
                                                                            <input type="hidden" name="id" value="<?php echo $row["mangaln_id"] ?>">
                                                                            <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $coms["comment_id"] ?>">
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                                                            <button type="submit" name="deleteComment" value="delete" id="delete" class="btn btn-primary">DELETE</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $queryrep = "SELECT * FROM reply where parent = '" . $coms['comment_id'] . "' ORDER BY reply_id ASC";
                                                        $resultrep = mysqli_query($link, $queryrep) or die(mysqli_error($link));

                                                        $queryPRcom = "SELECT user_image FROM user WHERE username = '" . $coms['username'] . "'";
                                                        $resultPRcom = mysqli_query($link, $queryPRcom) or die(mysqli_error($link));

                                                        $queryPRcom = "SELECT * FROM user WHERE username = '" . $coms['username'] . "'";
                                                        $resultPRcom = mysqli_query($link, $queryPRcom) or die(mysqli_error($link));

                                                        while ($PRcom = mysqli_fetch_array($resultPRcom, MYSQLI_BOTH)) {
                                                            $commentAgo = timeAgo($coms['comment_date']);
                                                        ?>

                                                            <!-------------------------------------------------------------------------------->


                                                            <table class="table table-borderless">
                                                                <tr>
                                                                    <table>
                                                                        <td style="padding:10px;vertical-align:top"><a href="dynamicProfile.php?ID=<?php echo $coms['username'] ?>"><img src="../<?php echo $PRcom['user_image'] ?>" class="rounded-circle" width="50" height="50" style="float:left;margin-bottom:10px;object-fit:cover;"></a></td>
                                                                        <td width=100%><span style="font-weight:600;color:#BF95FC;"><a href="dynamicProfile.php?ID=<?php echo $coms['username'] ?>"><?php echo $coms['username']; ?></span></a>&nbsp&nbsp&nbsp<span style="color:#AAAAAA;font-size:12px"><?php echo $commentAgo ?></span>
                                                                            <?php
                                                                            if ($_SESSION["username"] == $coms['username'] || $_SESSION["username"] == 'admin') //if comment belongs to currently logged in user / admin
                                                                            {
                                                                            ?>
                                                                                <button class="btn dlcomment" style="padding-top:0px;" data-toggle="modal" data-target="#DeleteCommentModal<?php echo $coms['comment_id']; ?>">Delete</button>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            <br><span style="display:inline-block;padding-bottom:5px;margin-right:10px;color:#F5F5F5"><?php echo $coms['user_comment']; ?></span>
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
                                                                                        <form id="deleteReplyForm" method="POST" enctype="multipart/form-data">
                                                                                            <div class="modal-body">
                                                                                                <h7> Are you sure you want to delete this comment? </h7>
                                                                                                <input type="hidden" name="id" value="<?php echo $row["mangaln_id"] ?>">
                                                                                                <input type="hidden" name="reply_id" id="comment_id" value="<?php echo $reps["reply_id"] ?>">
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                                                                                <button type="submit" name="deleteReply" value="delete" id="delete" class="btn btn-primary">DELETE</button>
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
                                                                                    <td style="border-left:2px solid #8FB2FF;padding-left:10px;"><a href="dynamicProfile.php?ID=<?php echo $reps['username'] ?>"><img src="../<?php echo $PRrep['user_image'] ?>" class="rounded-circle" width="50" height="50" style="float:left;margin-right:10px;margin-bottom:10px;object-fit:cover;"></a></td>
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
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Update Product Modal -->
                            <div class="modal fade" id="UpdateProductModal" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update Product</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="updateProduct.php" id="updateProduct" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Title :</label>
                                                            <input type="text" name="title" id="title" class="form-control" maxlength="500" value="<?php echo $row['title'] ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Alternative Title :</label>
                                                            <input type="text" name="alternative_title" id="alternative_title" class="form-control" maxlength="500" value="<?php echo $row['alternative_title'] ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Author :</label>
                                                            <input type="text" name="author" id="author" class="form-control" value="<?php echo $row['author'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Total Volume :</label>
                                                            <input type="number" name="total_volume" id="total_volume" class="form-control" value="<?php echo $row['total_volume'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Release Year :</label>
                                                            <input type="text" name="release_year" id="release_year" class="form-control" maxlength="255" value="<?php echo $row['release_year'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Price :</label>
                                                            <input type="number" name="price" id="price" class="form-control" value="<?php echo $row['price'] ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group select">
                                                            <label style="margin-bottom:0">Status :</label>
                                                            <select name="publication" id="publication" class="selectpicker w-100" data-none-selected-text="-- Select --" required>
                                                                <option disabled selected> -- Select -- </option>
                                                                <option class="options" value="Publishing">Publishing</option>
                                                                <option class="options" value="Finished">Finished</option>
                                                                <option class="options" value="Hiatus">Hiatus</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group select">
                                                            <label style="margin-bottom:0">Type :</label>
                                                            <select name="type" id="type" class="selectpicker w-100" data-none-selected-text="-- Select --" required>
                                                                <option disabled selected> -- Select -- </option>
                                                                <option class="options" value="Manga">Manga</option>
                                                                <option class="options" value="Light Novel">Light Novel</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group select">
                                                            <label style="margin-bottom:0">Genre :</label><br>
                                                            <select name="genre[]" id="genre" class="selectpicker w-100" data-live-search="true" data-live-search-placeholder="Search" multiple data-selected-text-format="count > 8" data-none-selected-text="-- Select --" required>
                                                                <option class="options" value="Action">Action</option>
                                                                <option class="options" value="Adventure">Adventure</option>
                                                                <option class="options" value="Comedy">Comedy</option>
                                                                <option class="options" value="Drama">Drama</option>
                                                                <option class="options" value="Fantasy">Fantasy</option>
                                                                <option class="options" value="Horror">Horror</option>
                                                                <option class="options" value="Isekai">Isekai</option>
                                                                <option class="options" value="Mecha">Mecha</option>
                                                                <option class="options" value="Mystery">Mystery</option>
                                                                <option class="options" value="Psychological">Psychological</option>
                                                                <option class="options" value="Romance">Romance</option>
                                                                <option class="options" value="School">School</option>
                                                                <option class="options" value="Sci-fi">Sci-fi</option>
                                                                <option class="options" value="Slice of Life">Slice of Life</option>
                                                                <option class="options" value="Supernatural">Supernatural</option>
                                                                <option class="options" value="Thriller">Thriller</option>
                                                                <option class="options" value="Tragedy">Tragedy</option>
                                                                <option class="options" value="Vampire">Vampire</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Synopsis :</label>
                                                            <textarea name="synopsis" id="synopsis" class="form-control" rows="8" maxlength="2000" required><?php echo $row['synopsis'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Admin's Review :</label>
                                                            <textarea name="admin_review" id="admin_review" class="form-control" rows="8" maxlength="2000" required><?php echo $row['admin_review'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="mangaln_id" value="<?php echo $row["mangaln_id"] ?>">
                                            <div class="modal-footer">
                                                <span class="btn btn-secondary reset" onClick="resetFields()">RESET</span>
                                                <button type="submit" name="updateProduct" value="Submit" class="btn btn-primary addProduct">UPDATE</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!----  Product Suggestion  ----->
                            <div class="col-sm-3">
                                <div class="container" style="position:sticky;margin-top:20px;margin-bottom:20px;">
                                    <table class="table table-borderless" id="top3" style="border-radius:5px">
                                        <th colspan="3" style="text-align:left;font-size:20px;color:#8FB2FF;padding-left:20px">
                                            TOP 3 DONATORS
                                        </th>
                                        <?php
                                        $query2 = "SELECT *, SUM(yomi_tokens) as token_sum FROM donation GROUP BY username ORDER BY token_sum DESC LIMIT 3";
                                        $result2 = mysqli_query($link, $query2);
                                        while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
                                            $query3 = "SELECT * FROM user WHERE username = '$row2[username]'";
                                            $result3 = mysqli_query($link, $query3);
                                            while ($row3 = mysqli_fetch_array($result3, MYSQLI_BOTH)) { ?>
                                                <tr onclick="window.location='dynamicProfile.php?ID=<?php echo $row3['username'] ?>';">
                                                    <td style="padding:10px;padding-left:20px">
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
                                <div class="container" style="position:sticky;margin-top:20px;margin-bottom:20px;height:100%;">
                                    <div class="card tsmall">
                                        <div class="card-body">
                                            <h5 class="card-title">RECENTLY ADDED PRODUCTS</h5>
                                            <div class="boxRow">
                                                <?php
                                                $queryRecent = "SELECT * FROM mangaln WHERE mangaln_id != '" . $ID . "' ORDER BY mangaln_id DESC LIMIT 6 "; //to retrive recent product
                                                $resultRC = mysqli_query($link, $queryRecent) or die(mysqli_error($link));

                                                while ($rowRRC = mysqli_fetch_array($resultRC, MYSQLI_BOTH)) {
                                                ?>

                                                    <div class="boxColumn imagesmall">
                                                        <a href='productDetails.php?ID=<?php echo $rowRRC['mangaln_id'] ?>'>
                                                            <img src="../upload/<?php echo $rowRRC['cover'] ?>">
                                                        </a>
                                                        <a href='productDetails.php?ID=<?php echo $rowRRC['mangaln_id'] ?>'>
                                                            <div class="text-truncate"><?php echo $rowRRC['title'] ?></div>
                                                        </a>
                                                    </div>

                                                <?php
                                                }
                                                ?>
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

                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('.imgeditbtn').on('click', function() {

                                    $('#ChangeCoverModal').modal('show');
                                });
                            });
                        </script>

                        <script type="application/javascript">
                            $('input[type="file"]').change(function(e) {
                                var fileName = e.target.files[0].name;
                                $('.custom-file-label').text(fileName);
                            });
                        </script>

                        <script>
                            $(document).on('submit', '#addVolumeForm', function() {
                                var data = $('#addVolumeForm').serialize() + '&addVolume=addVolume';
                                $.ajax({
                                    url: '/YOMI/admin/addVolume.php',
                                    type: 'post',
                                    data: data,
                                    success: function(response) {
                                        $('#result').text(response);
                                        $("#result").addClass('alert alert-custom')
                                        $("#result").show().delay(500).addClass("in").fadeOut(1000);
                                        $('.stock').load(' .stock');
                                        $('.stockFooter').load(' .stockFooter');
                                        $('.stockQuantity').load(' .stockQuantity');
                                    },
                                    error: function(response) {
                                        alert("Failed")
                                    }
                                });
                                return false;
                            });
                        </script>

                        <script>
                            $(document).on('submit', '#editStockForm', function() {
                                var data = $('#editStockForm').serialize() + '&editStock=editStock';
                                $.ajax({
                                    url: '/YOMI/admin/updateStock.php',
                                    type: 'post',
                                    data: data,
                                    success: function(response) {
                                        $('#result').text(response);
                                        $("#result").addClass('alert alert-custom')
                                        $("#result").show().delay(500).addClass("in").fadeOut(1000);
                                        $('.stock').load(' .stock');
                                        $('.stockQuantity').load(' .stockQuantity');
                                        $('#last_updated').load(' #last_updated');
                                        $('#EditStockModal').modal('hide');
                                        $(".modal-backdrop").remove();
                                    },
                                    error: function(response) {
                                        alert("Failed")
                                    }
                                });
                                return false;
                            });
                        </script>

                        <script type="text/javascript">
                            $(document).ready(function() {
                                var type = "<?php echo $row['type']; ?>";
                                var publication = "<?php echo $row['publication']; ?>";
                                var a = "<?php echo $row['genre']; ?>"; //insert array from database
                                var tag = a.split(",");
                                var strTag = '[';
                                for (i = 0; i < tag.length; i++) {
                                    strTag += '"' + tag[i] + '",';
                                }
                                strTag = strTag.slice(0, -1); //remove last comma
                                strTag += ']';

                                $('.selectpicker').selectpicker('val', JSON.parse(strTag)); //insert array value to selected options
                                $('#type').selectpicker('val', type);
                                $('#publication').selectpicker('val', publication);
                                $('.reset').click(function() {
                                    $('.selectpicker').selectpicker('val', JSON.parse(strTag)); //insert array value to selected options
                                    $('#type').selectpicker('val', type);
                                    $('#publication').selectpicker('val', publication);
                                    $('.custom-file-label').text('Choose Image');
                                });
                            });
                        </script>

                        <script type="text/javascript">
                            function resetFields() { //reset form without [input type=reset]
                                document.getElementById("updateProduct").reset();
                            }
                        </script>

                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#title,#alternative_title,#author,#total_volume,#release_year,#price,#synopsis,#admin_review').on('keyup', function() {
                                    var title = $("#title").val();
                                    var alternative_title = $("#alternative_title").val();
                                    var author = $("#author").val();
                                    var total_volume = $("#total_volume").val();
                                    var release_year = $("#release_year").val();
                                    var price = $("#price").val();
                                    var synopsis = $("#synopsis").val();
                                    var admin_review = $("#admin_review").val();
                                    if (!title.trim().length || !alternative_title.trim().length || !author.trim().length || !total_volume.trim().length || !release_year.trim().length || !price.trim().length || !synopsis.trim().length || !admin_review.trim().length) { //check if the value insert contain value or not
                                        $('button.addProduct').prop('disabled', true); //disable button
                                    } else {
                                        $('button.addProduct').prop('disabled', false);
                                    }
                                });

                            });
                        </script>

                        <script>
                            $(document).on('submit', '#deleteCommentForm', function(e) {
                                e.preventDefault(); //prevent from refreshing
                                var data = $('#deleteCommentForm,#comment_id').serialize() + '&delete=delete';
                                $.ajax({
                                    url: '/YOMI/admin/deleteComment.php',
                                    type: 'post',
                                    data: data,
                                    success: function(response) {
                                        $('.DeleteCommentModal').modal('hide');
                                        $(".modal-backdrop").remove();
                                        $('#commentSection').load(' #commentSection');
                                    },
                                    error: function(response) {
                                        alert("Failed")
                                    }
                                });
                            });
                        </script>

                        <script>
                            $(document).on('submit', '#deleteReplyForm', function(e) {
                                e.preventDefault(); //prevent from refreshing
                                var data = $('#deleteReplyForm,#comment_id').serialize() + '&delete=delete';
                                $.ajax({
                                    url: '/YOMI/admin/deleteReply.php',
                                    type: 'post',
                                    data: data,
                                    success: function(response) {
                                        $('.DeleteCommentModal').modal('hide');
                                        $(".modal-backdrop").remove();
                                        $('#commentSection').load(' #commentSection');
                                    },
                                    error: function(response) {
                                        alert("Failed")
                                    }
                                });
                            });
                        </script>

                        <script>
                            $(document).on('submit', '#deleteVolumeForm', function(e) {
                                e.preventDefault(); //prevent from refreshing
                                var data = $('#deleteVolumeForm,#stock_id').serialize() + '&delete=delete';
                                $.ajax({
                                    url: '/YOMI/admin/deleteVolume.php',
                                    type: 'post',
                                    data: data,
                                    success: function(response) {
                                        $('#result').text(response);
                                        $('.DeleteModal').modal('hide');
                                        $(".modal-backdrop").remove();
                                        $('.stockQuantity').load(' .stockQuantity');
                                        $('.stock').load(' .stock');
                                        $('.stockFooter').load(' .stockFooter');
                                        $('.stockQuantity').load(' .stockQuantity');
                                    },
                                    error: function(response) {
                                        alert("Failed")
                                    }
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