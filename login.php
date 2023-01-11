<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shotcut icon" href="image/yomiLogo3.png" type="image/png">
    <title>YOMI | Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="css/login.css" type="text/css" rel="stylesheet">
</head>

<body>
    <script type="text/javascript">
        function removeSpaces(string) {
            return string.split(' ').join('');
        }
    </script>

    <!-- Navigation Bar -->

    <nav class="navbar navbar-expand-md navbar-custom sticky-top">
        <div class="container-fluid">
            <!-- LOGO -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"> <a class="nav-link" href="homepage.php">HOME</a> </li>
                <li class="nav-item"> <a class="nav-link" href="mangaln.php">MANGA & LN</a> </li>
                <li class="nav-item"> <a class="nav-link" href="genre.php">GENRE</a> </li>
                <li class="nav-item"> <a class="nav-link" href="news.php">NEWS</a> </li>
                <li class="nav-item"> <a class="nav-link" href="donate.php">DONATE</a> </li>
            </ul>
            <form action="GuestSearch.php" method="POST" class="form-inline my-2 my-lg-0">
                <div class="searchNav">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="search" class="form-control enter" placeholder="Search" name="Search" style="min-height: 38px;">
                </div>
            </form>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"> <a class="nav-link" href="login.php">LOGIN </a> </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Form -->

    <div class="login-form">
        <form action="loginValidation.php" method="post">
            <div class="form-header">
                <h2>LOGIN</h2>
                <p>Welcome to YOMI!</p>
            </div>
            <div class="form-group">
                <div class="input-icons">
                    <br>
                    <i class="fa fa-user-circle-o icon"></i>
                    <?php if (isset($username_error)) { ?>
                        <input type="text" class="form-control" name="username" placeholder="Username" data-toggle="popover" id="error1" data-content="<?php echo $username_error ?>" data-html="true" maxlength="25" required>
                    <?php } else if (isset($password_error)) { ?>
                        <input type="text" class="form-control" name="username" placeholder="Username" data-toggle="popover" id="error1" data-content="<?php echo $password_error ?>" data-html="true" maxlength="25" required>
                    <?php } else { ?>
                        <input type="text" class="form-control" name="username" placeholder="Username" maxlength="25" required="required">
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <div class="input-icons">
                    <i class="fa fa-lock icon"></i>
                    <input type="password" class="form-control" name="password" id="passwordInput" placeholder="Password" maxlength="25" required="required">
                </div>
                <div class="checkmark">
                    <input type="checkbox" onclick="myFunction()"> Show Password
                </div>
            </div>
            <div class="form-group">
                <button type="reset" class="btn btn-secondary">RESET</button>
                <button type="submit" class="btn btn-primary">LOGIN</button>
            </div>
            <div class="text-center small"> Don't have an account? <a href="register.php">Register here</a></div>
        </form>
        <script>
            $('form').attr('autocomplete','off'); //turn off autocomplete
        </script>
        <script>
            function myFunction() {
                var x = document.getElementById("passwordInput");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
        </script>
        <script>
            $('#error1').popover({
                placement: 'right',
                html: true,
                trigger: 'show',
            });

            $('#error1').popover('show')
            $('.popover').addClass('error'); //adding class to popover to change background color
        </script>
        <script>
            $('#passwordInput').popover({
                placement: 'right',
                html: true,
                trigger: 'show',
            });

            $('#passwordInput').popover('show')
            $('.popover').addClass('error'); //adding class to popover to change background color
        </script>
    </div>
</body>

</html>