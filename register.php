<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shotcut icon" href="image/yomiLogo3.png" type="image/png">
    <title>YOMI | Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="css/register.css" type="text/css" rel="stylesheet">
    <style>
        .popover-title {
            background-color: #73AD21;
            color: #FFFFFF;
            font-size: 28px;
            text-align: center;
        }
    </style>
</head>

<body>
    <script type="text/javascript">
        function removeSpaces(string) {
            return string.split(' ').join('');
        }
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
        });
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
    <!-- Sign Up Form -->
    <div class="signup-form">
        <form action="registerValidation.php" method="post">
            <div class="form-header">
                <h2>SIGN UP</h2>
                <p>Welcome to YOMI!</p>
            </div>
            <div class="form-group">
                <div class="input-icons">
                    <i class="fa fa-user-circle-o icon"></i>
                    <?php if (isset($username_error)) { ?>
                        <input type="text" class="form-control" name="username" placeholder="Username" onblur="this.value=removeSpaces(this.value)" data-toggle="popover" id="error1" data-content="<?php echo $username_error ?>" data-html="true" pattern=".{5,}" minlength="5" maxlength="12" required>
                    <?php } else { ?>
                        <input type="text" class="form-control" name="username" placeholder="Username" onblur="this.value=removeSpaces(this.value)" data-toggle="popover" data-trigger="hover" data-content="At least 5 characters. <br />  Username must not have spaces." data-html="true" pattern=".{5,}" minlength="5" maxlength="12" required>
                    <?php } ?>
                    <!--<p style="color:#DC143C;font-size:12px;margin-top:5px;">&nbsp Username already been taken!</p>-->
                </div>
            </div>

            <div class="form-group">
                <div class="input-icons">
                    <i class="fa fa-user-circle icon"></i>
                    <?php if (isset($fullname_error)) { ?>
                        <input type="text" class="form-control" name="fullname" placeholder="Full Name" data-toggle="popover" id="error2" data-content="<?php echo $fullname_error ?>" data-html="true" minlength="3" required="required">
                    <?php } else { ?>
                        <input type="text" class="form-control" name="fullname" placeholder="Full Name" data-toggle="popover" data-trigger="hover" data-content="What's your name?" data-html="true" minlength="3" required="required">
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <div class="input-icons">
                    <i class="fa fa-envelope icon"></i>
                    <?php if (isset($email_error)) { ?>
                        <input type="email" class="form-control" name="email" placeholder="Email" onblur="this.value=removeSpaces(this.value)" data-toggle="popover" id="error3" data-content="<?php echo $email_error ?>" data-html="true" required="required">
                    <?php } else { ?>
                        <input type="email" class="form-control" name="email" placeholder="Email" onblur="this.value=removeSpaces(this.value)" data-toggle="popover" data-trigger="hover" data-content="Example: yomi@gmail.com " data-html="true" required="required">
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <div class="input-icons">
                    <i class="fa fa-lock icon"></i>
                    <?php if (isset($password_error)) { ?>
                        <input type="password" class="form-control" name="password" placeholder="Password" pattern=".{6,}" minlength="6" maxlength="12" data-toggle="popover" id="error4" data-content="<?php echo $password_error ?>" data-html="true" required="required">
                        <div class="checkmark">
                            <input type="checkbox" onclick="myFunction2()"> Show Password
                        </div>
                    <?php } else { ?>
                        <input type="password" class="form-control" name="password" id="passwordInput" placeholder="Password" pattern=".{6,}" minlength="6" maxlength="12" data-toggle="popover" data-trigger="hover" data-content="At least 6 characters with  combination <br /> of numbers and characters" data-html="true" required="required">

                </div>
                <div class="checkmark">
                    <input type="checkbox" onclick="myFunction()"> Show Password
                </div>
            <?php } ?>
            </div>
            <div class="form-group">
                <button type="reset" class="btn btn-secondary">RESET</button>
                <button type="submit" class="btn btn-primary">SIGN UP</button>
            </div>
            <div class="text-center small"> Already have an account? <a href="login.php">Login here</a></div>

            <input type="hidden" name="bio" value="Welcome to my profile!">
            <input type="hidden" name="image" value="image/defaultProfile.png">
            <input type="hidden" name="type" value="user">
        </form>
        <script>
            $('form').attr('autocomplete', 'off'); //turn off autocomplete
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
            function myFunction2() {
                var x = document.getElementById("error4");
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
            $('#error2').popover({
                placement: 'right',
                html: true,
                trigger: 'show',
            });

            $('#error2').popover('show')
            $('.popover').addClass('error'); //adding class to popover to change background color
        </script>
        <script>
            $('#error3').popover({
                placement: 'right',
                html: true,
                trigger: 'show',
            });

            $('#error3').popover('show')
            $('.popover').addClass('error'); //adding class to popover to change background color
        </script>
        <script>
            $('#error4').popover({
                placement: 'right',
                html: true,
                trigger: 'show',
            });

            $('#error4').popover('show')
            $('.popover').addClass('error'); //adding class to popover to change background color
        </script>
    </div>

</body>

</html>