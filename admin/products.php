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
        <title> YOMI | Products </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="../css/admin.css?V=3" rel="stylesheet">

        <style>
            p {
                margin: 0;
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

            tr:hover {
                background-color: #181818;
            }

            input[type='number']::-webkit-inner-spin-button,
            input[type='number']::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
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

            <div class="container-fluid" style="padding:0;padding-top:20px;padding-bottom:20px;">
                <div class="card" style="background-color:#000000">
                    <div class="card-body" style="padding:0px">
                        <div class="card-header" style="background-color:#181818;border-bottom:2px solid #777AFF">
                            <p style="margin:0">PRODUCTS</p>
                        </div>
                        <div class="row" style="padding-left:10px;">
                            <div class="col">
                                <div style="display:flex">
                                    <form id="all_form" method="POST">
                                        <input type="hidden" id="type" name="type" value="All">
                                        <button class="btn btn-primary" style="margin-top:10px;width:135px" type="submit" name="all" id="all">ALL</button>
                                    </form>
                                    <form id="manga_form" method="POST">
                                        <input type="hidden" id="type" name="type" value="Manga">
                                        <button class="btn unselected" style="margin-top:10px;width:135px" type="submit" name="manga" id="manga">MANGA</button>
                                    </form>
                                    <form id="ln_form" method="POST">
                                        <input type="hidden" id="type" name="type" value="Light Novel">
                                        <button class="btn unselected" style="margin-top:10px;width:135px" type="submit" name="ln" id="ln">LIGHT NOVEL</button>
                                    </form>
                                    <form id="stock_form" method="POST">
                                        <input type="hidden" id="type" name="type" value="Stock">
                                        <button class="btn unselected" style="margin-top:10px;width:135px" type="submit" name="stock" id="stock">OUT OF STOCK</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-primary" style="float:right;margin-top:10px;width:150px" data-toggle="modal" data-target="#AddProductModal">ADD PRODUCT</button>
                            </div>
                        </div>
                        <div id="filter">
                            <?php
                            $queryProduct = "SELECT * FROM mangaln ORDER BY mangaln_id DESC";
                            $resultProduct = mysqli_query($link, $queryProduct);
                            $count = mysqli_num_rows($resultProduct);
                            ?>
                            <h4 style="margin-left:15px;margin-top:20px;margin-bottom:0;font-weight:600">ALL</h4>
                            <p class="card-text" style="color:#c0c0c0;float:left;margin-left:15px;"><?php echo $count ?> results for <strong>ALL</strong> products</p><br><br>
                            <table style="background-color:#000000">
                                <?php
                                if (mysqli_num_rows($resultProduct) != 0) {
                                    while ($product = mysqli_fetch_array($resultProduct, MYSQLI_BOTH)) {
                                ?>

                                        <tr>
                                            <td style="width:100px;padding:15px;">
                                                <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                                    <div class="container" style="width:100%;height:100%;">
                                                        <div class="cover"><img width="100px" height="150px" src="../upload/<?php echo $product['cover'] ?>" /></div>
                                                        <?php
                                                        $queryStock = "SELECT * FROM stock WHERE mangaln_id = '" . $product['mangaln_id'] . "'";
                                                        $resultStock = mysqli_query($link, $queryStock);
                                                        if (mysqli_num_rows($resultStock) == 0) { ?>
                                                            <!-- if no volume or all volume out of stock -->
                                                            <div class="status">
                                                                <p style="font-size:12px">NO STOCK</p>
                                                            </div>
                                                            <?php
                                                        }
                                                        while ($stock = mysqli_fetch_array($resultStock, MYSQLI_BOTH)) {

                                                            if ($stock['stock'] < 1) { ?>
                                                                <!-- if no volume or all volume out of stock -->
                                                                <div class="status">
                                                                    <p style="font-size:12px">NEED RESTOCK</p>
                                                                </div>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </div>
                                                </a>
                                            </td>

                                            <td style="text-align:left">
                                                <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                                    <p style="font-size:30px;font-weight:600;margin-top:-10px;"><?php echo $product['title'] ?></p>
                                                    <p><?php echo $product['alternative_title'] ?></p>
                                                    <p>Author: <?php echo $product['author'] ?></p>
                                                    <p>Type: <?php echo $product['type'] ?></p>
                                                    <span style="color:#F5F5F5">Genre:
                                                        <?php
                                                        $mark = explode(",", $product['genre']); //remove "," from Genre table in database
                                                        foreach ($mark as $out) {
                                                            echo "&nbsp<button class='btn-primary' style='margin-top:5px;border:none'><a style='color:#F5F5F5;' href='search.php?ID=" . $out . "'> " . $out . "</a></button>";       //link based on tags
                                                        }
                                                        ?>
                                                    </span>
                                                </a>
                                            </td>
                                            <td style="width:5%;vertical-align:top;padding-top:20px;position:relative">
                                                <span data-toggle="modal" data-target="#DeleteProductModal<?php echo $product['mangaln_id']; ?>"><i class="fa fa-window-close"></i></span>
                                                <a href="productDetails.php?ID=<?php echo $product['mangaln_id'] ?>">
                                                    <button class="btn btn-tertiary" style="position:absolute;bottom:0%;right:0%;margin-bottom:20px">VIEW DETAILS</button>
                                                </a>
                                            </td>
                                        </tr>

                                        <!----  Delete Product Modal  ----->
                                        <div class="modal fade DeleteModal" id="DeleteProductModal<?php echo $product['mangaln_id']; ?>">
                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Delete Product</h6>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <h7> Are you sure you want to delete this product?</h7>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                                        <input type="submit" value="DELETE" name="deleteProduct" id="<?php echo $product["mangaln_id"]; ?>" class="btn btn-primary deleteMangaln">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="no-result">
                                        <img src="../image/yomiLogo3.png">
                                    </div>
                                    <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">No Products Yet.</h5>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    <!-- Add Product Modal -->
                    <div class="modal fade" id="AddProductModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Product</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="addProduct.php" id="addProduct" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <label style="margin-bottom:10px;color:#8FB2FF;font-weight:500;">Image :</label>
                                                <div class="custom-file">
                                                    <input type="file" name="image" accept="image/*" class="custom-file-input" id="customFile" required>
                                                    <label class="custom-file-label" for="customFile">Choose Image</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Title :</label>
                                                    <input type="text" name="title" id="title" class="form-control" maxlength="500" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Alternative Title :</label>
                                                    <input type="text" name="alternative_title" id="alternative_title" class="form-control" maxlength="500" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Author :</label>
                                                    <input type="text" name="author" id="author" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Total Volume :</label>
                                                    <input type="number" name="total_volume" id="total_volume" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Release Year :</label>
                                                    <input type="text" name="release_year" id="release_year" class="form-control" maxlength="255" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Price :</label>
                                                    <input type="number" name="price" id="price" class="form-control" required>
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
                                                    <textarea name="synopsis" id="synopsis" class="form-control" rows="5" maxlength="2000" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Admin's Review :</label>
                                                    <textarea name="admin_review" id="admin_review" class="form-control" rows="5" maxlength="2000" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="username" value="<?php echo $_SESSION["username"] ?>">
                                    <div class="modal-footer">
                                        <span class="btn btn-secondary reset" onClick="resetFields()">RESET</span>
                                        <button type="submit" name="addProduct" value="Submit" class="btn btn-primary addProduct">ADD</button>
                                    </div>
                                </form>
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

            <script>
                $(document).on('submit', '#all_form', function() {
                    var data = $('#all_form').serialize() + '&all=all';
                    $.ajax({
                        url: '/YOMI/admin/filterProduct.php',
                        type: 'post',
                        data: data,
                        success: function(response) {
                            $('#type').text('');
                            $("#filter").html(response);
                            $("#all").removeClass('btn unselected').addClass('btn btn-primary');
                            $("#manga").removeClass('btn btn-primary').addClass('btn unselected');
                            $("#ln").removeClass('btn btn-primary').addClass('btn unselected');
                            $("#stock").removeClass('btn btn-primary').addClass('btn unselected');
                        },
                        error: function(response) {
                            alert("Failed")
                        }
                    });
                    return false;
                });
            </script>
            <script>
                $(document).on('submit', '#manga_form', function() {
                    var data = $('#manga_form').serialize() + '&manga=manga';
                    $.ajax({
                        url: '/YOMI/admin/filterProduct.php',
                        type: 'post',
                        data: data,
                        success: function(response) {
                            $('#type').text('');
                            $("#filter").html(response);
                            $("#manga").removeClass('btn unselected').addClass('btn btn-primary');
                            $("#ln").removeClass('btn btn-primary').addClass('btn unselected');
                            $("#stock").removeClass('btn btn-primary').addClass('btn unselected');
                            $("#all").removeClass('btn btn-primary').addClass('btn unselected');
                        },
                        error: function(response) {
                            alert("Failed")
                        }
                    });
                    return false;
                });
            </script>
            <script>
                $(document).on('submit', '#ln_form', function() {
                    var data = $('#ln_form').serialize() + '&ln=ln';
                    $.ajax({
                        url: '/YOMI/admin/filterProduct.php',
                        type: 'post',
                        data: data,
                        success: function(response) {
                            $('#type').text('');
                            $("#filter").html(response);
                            $("#ln").removeClass('btn unselected').addClass('btn btn-primary');
                            $("#manga").removeClass('btn btn-primary').addClass('btn unselected');
                            $("#stock").removeClass('btn btn-primary').addClass('btn unselected');
                            $("#all").removeClass('btn btn-primary').addClass('btn unselected');
                        },
                        error: function(response) {
                            alert("Failed")
                        }
                    });
                    return false;
                });
            </script>
            <script>
                $(document).on('submit', '#stock_form', function() {
                    var data = $('#stock_form').serialize() + '&stock=stock';
                    $.ajax({
                        url: '/YOMI/admin/filterProduct.php',
                        type: 'post',
                        data: data,
                        success: function(response) {
                            $('#type').text('');
                            $("#filter").html(response);
                            $("#stock").removeClass('btn unselected').addClass('btn btn-primary');
                            $("#manga").removeClass('btn btn-primary').addClass('btn unselected');
                            $("#ln").removeClass('btn btn-primary').addClass('btn unselected');
                            $("#all").removeClass('btn btn-primary').addClass('btn unselected');
                        },
                        error: function(response) {
                            alert("Failed")
                        }
                    });
                    return false;
                });
            </script>
            <script>
                $(document).on('click', '.deleteMangaln', function(e) {
                    e.preventDefault(); //prevent from refreshing
                    var id = $(this).attr("id");
                    $.ajax({
                        url: '/YOMI/admin/deleteProduct.php',
                        type: 'post',
                        data: ({
                            id: id
                        }),
                        success: function(response) {
                            $('.DeleteModal').modal('hide');
                            $(".modal-backdrop").remove();
                            $(document).ajaxStop(function() {
                                window.location.reload();
                            });
                        },
                        error: function(response) {
                            alert("Failed");
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

            <script type="text/javascript">
                function resetFields() { //reset form without [input type=reset]
                    document.getElementById("addProduct").reset();
                }
            </script>
        <?php    }
        ?>
        </body>

    </html>

<?php
} else {
    header("Location:login.php");
}
?>