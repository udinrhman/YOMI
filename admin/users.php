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
        <title> YOMI | Users </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="../css/admin.css?V=1" rel="stylesheet">

        <style>
            .hover tr:hover {
                background-color: #000000;
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

            <div class="container-fluid" style="padding:0;padding-top:20px;padding-bottom:20px;">
                <div class="card" style="background-color:#000000">
                    <div class="card-header" style="background-color:#181818;border-bottom:2px solid #777AFF">
                        <p style="margin:0">LIST OF USERS</p>
                    </div>
                    <div class="card-body" style="padding:0px;background-color:#181818">
                        <?php
                        $queryUser = "SELECT * FROM user WHERE username != 'admin' ORDER BY register_date DESC";
                        $resultUser = mysqli_query($link, $queryUser);

                        if (mysqli_num_rows($resultUser) == 0) { ?>
                            <div class="no-result">
                                <img src="../image/yomiLogo3.png">
                            </div>
                            <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">No Users Registered Yet!</h5>
                        <?php
                        } else {
                        ?>
                            <div style="padding:10px;padding-top:30px">
                                <table style="text-align:left" class="userList">
                                    <thead style="background-color:#777AFF">
                                        <th style="width:15%;padding-left:10px">
                                            USERNAME
                                        </th>
                                        <th>
                                            NAME
                                        </th>
                                        <th>
                                            E-MAIL
                                        </th>
                                        <th style="width:15%">
                                            JOINED
                                        </th>
                                        <th style="width:2%">

                                        </th>
                                    </thead>
                                    <tbody class="hover">
                                        <?php
                                        while ($user = mysqli_fetch_array($resultUser, MYSQLI_BOTH)) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <a href="dynamicProfile.php?ID=<?php echo $user['username'] ?>">
                                                        <img src="../<?php echo $user['user_image'] ?>" class="rounded-circle" width="37" height="37" style="margin:10px;object-fit:cover;">
                                                        <span style="padding-top:15px"><?php echo $user['username'] ?></span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo $user['user_fullname'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $user['user_email'] ?>
                                                </td>
                                                <td>
                                                    <?php echo strtoupper(date("j F Y", strtotime($user['register_date']))) ?>
                                                </td>
                                                <td>
                                                    <span data-toggle="modal" data-target="#DeleteUserModal<?php echo $user['username']; ?>"><i class="fa fa-window-close"></i></span>
                                                </td>
                                            </tr>
                                            <!----  Delete User Modal  ----->
                                            <div class="modal fade DeleteModal" id="DeleteUserModal<?php echo $user['username']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">Delete User</h6>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form id="deleteUserForm" action="deleteUser.php" method="POST" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <h7> Are you sure you want to delete this user? </h7>
                                                                <input type="hidden" name="username" value="<?php echo $user["username"] ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                                                <button class="btn btn-primary" type="submit" name="delete" id="delete">DELETE</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        }
                        ?>
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
                $(document).on('submit', '#deleteUserForm', function() {
                    var data = $('#deleteUserForm').serialize() + '&delete=delete';
                    $.ajax({
                        url: '/YOMI/admin/deleteUser.php',
                        type: 'post',
                        data: data,
                        success: function(response) {
                            $('.userList').load(' .userList');
                            $('.DeleteModal').modal('hide');
                            $(".modal-backdrop").remove();
                        },
                        error: function(response) {
                            alert("Failed")
                        }
                    });
                    return false;
                });
            </script>
        <?php    }
        ?>
        </body>

    </html>

<?php
} else {
    header("Location:../login.php");
}
?>