<?php
// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include library files 
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Create an instance; Pass `true` to enable exceptions 
$mail = new PHPMailer;

// Server settings 
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;    //Enable verbose debug output 
$mail->isSMTP();                            // Set mailer to use SMTP 
$mail->Host = 'smtp.office365.com';           // Specify main and backup SMTP servers 
$mail->SMTPAuth = true;                     // Enable SMTP authentication 
$mail->Username = 'sw01080776@student.uniten.edu.my';       // SMTP username 
$mail->Password = 'esq165';         // SMTP password 
$mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 587;                          // TCP port to connect to 
$mail->CharSet = 'UTF-8';

?>

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
        <title> YOMI | Thank You! </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.0/js/all.js" data-auto-replace-svg="nest"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" />
        <link href="css/userHomepage.css?V=3" rel="stylesheet">
    </head>
    <?php
    $host = "localhost";
    $userid = "root";
    $pass = "";
    $database = "yomi";

    $link = mysqli_connect($host, $userid, $pass, $database);

    $query1 = "SELECT * FROM user WHERE username = '" . $_SESSION["username"] . "'";
    $result1 = mysqli_query($link, $query1);

    $query2 = "SELECT * FROM mangaln";
    $result2 = mysqli_query($link, $query2);

    $countCart = "SELECT count(*) as total FROM cart WHERE username = '" . $_SESSION["username"] . "'";
    $resultCart = mysqli_query($link, $countCart);
    $data = mysqli_fetch_assoc($resultCart);

    while ($row1 = mysqli_fetch_array($result1, MYSQLI_BOTH)) {
    ?>

        <body>
            <?php
            if (isset($_POST['checkout']) && $_POST['checkout'] == "Submit") {
                $option = $_POST['option'];
                $payment_method = $_POST['payment_method'];
                $donate = $_POST['donate'];
                $username = $_POST['username'];
                if ($option == 'discount') {
                    $discount = $row1['yomi_tokens'] / 10;
                } else {
                    $discount = 0;
                }
                $balance = $row1['yomi_tokens'] - $donate;
                $total_quantity = 0;
                $order_num = strtoupper(substr(md5(uniqid(rand(), true)), 0, 12));
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $order_date = date('d-m-Y H:i:s');

                $addressDefault = "SELECT * FROM addresses WHERE username = '$username' AND mode = 'default'";
                $default = mysqli_query($link, $addressDefault);
                $rowDefault = mysqli_fetch_array($default, MYSQLI_BOTH);

                $addressSelected = "SELECT * FROM addresses WHERE username = '$username' AND mode = 'selected'";
                $selected = mysqli_query($link, $addressSelected);
                $rowSelected = mysqli_fetch_array($selected, MYSQLI_BOTH);
                if (mysqli_num_rows($selected) > 0) {
                    $address = $rowSelected['address_id'];
                } else {
                    $address = $rowDefault['address_id'];
                }

                $query3 = "SELECT * FROM cart WHERE username = '$username'";
                $result3 = mysqli_query($link, $query3);
                if ($option == 'No') {
                    while ($row = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
                        $query4 = "INSERT INTO orders (order_num, mangaln_id, cover, title, alternative_title, volume, price, quantity, subtotal, discount, payment_method, order_date, address_id, username) 
                        VALUES ('" . $order_num . "','" . $row['mangaln_id'] . "','" . $row['cover'] . "','" . addslashes($row['title']) . "','" . addslashes($row['alternative_title']) . "','" . $row['volume'] . "','" . $row['price'] . "','" . $row['quantity'] . "','" . $row['subtotal'] . "','0','" . $payment_method . "',CURRENT_TIMESTAMP, '" . $address . "','" . $row['username'] . "')";
                        $result4 = mysqli_query($link, $query4);
                        $total_quantity = $total_quantity + $row['quantity'];

                        $queryDeleteStock = "UPDATE stock SET stock = stock - '".$row['quantity']."' WHERE volume = '".$row['volume']."' AND mangaln_id = '" . $row['mangaln_id'] . "'";
                        $resultDeleteStock = mysqli_query($link, $queryDeleteStock);
                    }
                    $earn = $row1['yomi_tokens'] + ($total_quantity * 10);
                    if ($result4) {
                        $query5 = "UPDATE user SET yomi_tokens = '$earn' WHERE username = '$username' ";
                        $result5 = mysqli_query($link, $query5);

                        $query6 = "DELETE FROM cart WHERE username='$username'";
                        $result6 = mysqli_query($link, $query6);
                    }
                }
                if ($option == 'discount') {
                    while ($row = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
                        $query4 = "INSERT INTO orders (order_num, mangaln_id, cover, title, alternative_title, volume, price, quantity, subtotal, discount, payment_method, order_date, address_id, username) 
                        VALUES ('" . $order_num . "','" . $row['mangaln_id'] . "','" . $row['cover'] . "','" . addslashes($row['title']) . "','" . addslashes($row['alternative_title']) . "','" . $row['volume'] . "','" . $row['price'] . "','" . $row['quantity'] . "','" . $row['subtotal'] . "','" . $discount . "','" . $payment_method . "',CURRENT_TIMESTAMP, '" . $address . "','" . $row['username'] . "')";
                        $result4 = mysqli_query($link, $query4);
                        $total_quantity = $total_quantity + $row['quantity'];

                        $queryDeleteStock = "UPDATE stock SET stock = stock - '".$row['quantity']."' WHERE volume = '".$row['volume']."' AND mangaln_id = '" . $row['mangaln_id'] . "'";
                        $resultDeleteStock = mysqli_query($link, $queryDeleteStock);
                    }
                    if ($result4) {
                        $earn = $total_quantity * 10;
                        $query5 = "UPDATE user SET yomi_tokens = '$earn' WHERE username = '$username' ";
                        $result5 = mysqli_query($link, $query5);

                        $query6 = "DELETE FROM cart WHERE username='$username'";
                        $result6 = mysqli_query($link, $query6);
                    }
                }
                if ($option == 'donate') {
                    while ($row = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
                        $query4 = "INSERT INTO orders (order_num, mangaln_id, cover, title, alternative_title, volume, price, quantity, subtotal, discount, payment_method, order_date, address_id, username) 
                        VALUES ('" . $order_num . "','" . $row['mangaln_id'] . "','" . $row['cover'] . "','" . addslashes($row['title']) . "','" . addslashes($row['alternative_title']) . "','" . $row['volume'] . "','" . $row['price'] . "','" . $row['quantity'] . "','" . $row['subtotal'] . "','0','" . $payment_method . "',CURRENT_TIMESTAMP, '" . $address . "','" . $row['username'] . "')";
                        $result4 = mysqli_query($link, $query4);
                        $total_quantity = $total_quantity + $row['quantity'];

                        $queryDeleteStock = "UPDATE stock SET stock = stock - '".$row['quantity']."' WHERE volume = '".$row['volume']."' AND mangaln_id = '" . $row['mangaln_id'] . "'";
                        $resultDeleteStock = mysqli_query($link, $queryDeleteStock);
                    }
                    if ($result4) {
                        $earn = $total_quantity * 10;
                        $newBalance = $balance + $earn;
                        $query5 = "UPDATE user SET yomi_tokens = '$newBalance' WHERE username = '$username' ";
                        $result5 = mysqli_query($link, $query5);

                        $query6 = "INSERT INTO donation (username, yomi_tokens) VALUES ('" . $username . "','" . $donate . "')";
                        $result6 = mysqli_query($link, $query6);

                        $query7 = "DELETE FROM cart WHERE username='$username'";
                        $result7 = mysqli_query($link, $query7);
                    }
                }
            }

            if ($result4) {
                // Sender info 
                $mail->setFrom('sw01080776@student.uniten.edu.my', 'YOMI');

                // Add a recipient 
                $mail->addAddress($row1['user_email']);

                //$mail->addCC('cc@example.com'); 
                //$mail->addBCC('bcc@example.com'); 

                // Set email format to HTML 
                $mail->isHTML(true);

                // Mail subject 
                $mail->Subject = 'YOMI - Payment confirmation for order #' . $order_num . '';

                // Mail body content 
                $bodyContent =
                    '
                <body style="color: #F5F5F5;background-color:#000000;padding-top:2%;padding-bottom:2%;padding-left:20%;padding-right:20%;">
                    <p>Hello ' . $username . ', <br> Your payment for order <span style="color:#BF95FC">#' . $order_num . '</span> has been confirmed!</p>
                    <table style="width:100%;padding:20px;background-color:#181818;border-radius:5px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;"> 
                        <tr>
                            <td style="font-weight:600">ORDER DETAILS</td>
                        </tr>
                        <tr>
                            <td style="width:15%">
                            Order Number:
                            </td>
                            <td style="color:#BF95FC;">
                            #' . $order_num . '
                            </td>
                        </tr>
                        <tr>
                            <td style="width:15%">
                            Order Date:
                            </td>
                            <td>
                            ' . $order_date . '
                            </td>
                        </tr>
                    </table>

                    <table style="width:100%;padding:20px;background-color:#181818;border-radius:0px;text-align:center">
                        <tr>
                            <th> </th>
                            <th style="text-align:left;padding-left:10px">PRODUCT ORDERED</th>
                            <th>VOLUME</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>SUBTOTAL</th>
                        </tr>';
                $queryOrder = "SELECT * FROM orders WHERE order_num = '$order_num' AND username = '$username'";
                $resultOrder = mysqli_query($link, $queryOrder);
                $x = 0;
                $order_total = 0;
                while ($row = mysqli_fetch_array($resultOrder, MYSQLI_BOTH)) {
                    $mail->AddEmbeddedImage('upload/' . $row['cover'] . '', 'cover' . $x . '');
                    $bodyContent .= '
                        <tr>
                            <td>
                                <img style="object-fit: cover;height: auto;width: 100px;margin-bottom: 10px;"src="cid:cover' . $x . '"/>
                            </td>
                            <td style="width:45%;text-align:left;padding-left:10px">
                                <p style="font-size:30px;font-weight:600;margin:0;">' . $row['title'] . '</p>
                                <p style="margin:0;">' . $row['alternative_title'] . '</p>
                            </td>
                            <td style="width:10%">
                                <p style="margin:0;">' . $row['volume'] . '</p>
                            </td>
                            <td style="width:10%">
                                <p style="margin:0;">RM' . $row['price'] . '</p>
                            </td>
                            <td style="width:10%">
                                <p style="margin:0;">×' . $row['quantity'] . '</p>
                            </td>
                            <td style="width:10%">
                                <p style="margin:0;">RM' . $row['subtotal'] . '</p>
                            </td>
                        </tr>';
                    $x = $x + 1;
                    $order_total = $order_total + $row['subtotal'];
                    $total_payment = $order_total - $discount;
                }
                $bodyContent .= '
                    </table>

                    <table style="width:100%;padding:20px;background-color:#181818;border-radius:0px;">
                        <tr>
                            <td style="text-align:right;">
                                Order Total:
                            </td>
                            <td style="width:15%;text-align:right;padding-right:20px">
                                RM' . $order_total . '
                            </td>
                        </tr>        
                        <tr>
                            <td style="text-align:right;">
                                Discount:
                            </td>
                            <td style="width:15%;text-align:right;padding-right:20px">
                                -RM' . $discount . '
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right;">
                                Total Payment:
                            </td>
                            <td style="width:15%;text-align:right;padding-right:20px">
                                RM' . $total_payment . ' 
                            </td>
                        </tr>
                    </table>

                    <table style="width:100%;padding:20px;background-color:#181818;border-radius:0px;border-top:2px solid #3b3b3b">
                        <tr>
                            <td style="font-weight:600;">DELIVERY DETAILS</td>
                        </tr>';
                $queryAddress = "SELECT * FROM addresses WHERE address_id = '$address' AND username = '$username'";
                $resultAddress = mysqli_query($link, $queryAddress);
                while ($rowAddress = mysqli_fetch_array($resultAddress, MYSQLI_BOTH)) {
                $bodyContent .= '
                        <tr>
                            <td style="width:15%">
                                Recipient Name:</td>
                            <td>
                                ' . $rowAddress['fullname'] . '
                            </td>
                        </tr>
                        <tr>
                            <td style="width:15%">
                                Phone Number:</td>
                            <td>
                                +60' . $rowAddress['phone_number'] . '
                            </td>
                        </tr>
                        <tr>
                            <td style="width:15%;vertical-align:top">
                                Shipping Address:
                            </td>
                            <td>
                                ' . $rowAddress['street'] . ', ' . $rowAddress['floor_unit'] . '<br>
                                ' . $rowAddress['town_city'] . ', ' . $rowAddress['postcode'] . ' ' . $rowAddress['state_region'] . '
                            </td>
                        </tr>';
                }
                $bodyContent .= '
                    </table>

                    <table style="width:100%;padding:20px;background-color:#181818;border-radius:5px;border-top-left-radius:0px;border-top-right-radius:0px;border-top:2px solid #3b3b3b">
                        <tr>
                            <td style="font-weight:600;">PAYMENT DETAILS</td>
                        </tr>
                        <tr>
                            <td style="width:15%">
                                Payment Method:
                            </td>
                            <td>
                                ' . $payment_method . '
                            </td>
                        </tr>
                        <tr>
                            <td style="width:15%">
                                Payment Date:
                            </td>
                            <td>
                                ' . $order_date . '
                            </td>
                        </tr>
                        <tr>
                            <td style="width:15%">
                                Amount Paid:
                            </td>
                            <td>
                                RM' . $total_payment . '
                            </td>
                        </tr>
                    </table>

                </body>
                ';
                $mail->Body    = $bodyContent;

                // Send email 
                if (!$mail->send()) {
                    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                } else { ?>
                    <div style="padding-top:15%;display:flex;justify-content:center;">
                        <div class="card" style="width:400px;height:450px;border:1px solid #000000;">
                            <div class="card-header" style="text-align:center;background-color:#000000;">
                                <span style="color:#BF95FC;font-weight:600;font-size:30px;">THANK YOU</span>
                            </div>
                            <div class="card-body" style="text-align:center;">
                                <div class="row" style="display:flex;justify-content:center;">
                                    <div style="color:#5A2E98;font-size:60px;"><i class="fa fa-check" aria-hidden="true"></i></div>
                                </div>
                                <div class="row" style="padding:20px;display:flex;justify-content:center;">
                                    <span style="color:#BF95FC;font-size:23px;font-weight:500;">YOUR ORDER HAS BEEN RECEIVED</span>
                                </div>
                                <div class="row" style="padding:20px;">
                                    <span>Thank you for your purchase. Your order number is <span style="font-weight:bold;color:#BF95FC">#<?php echo $order_num ?></span>.</span>
                                </div>
                                <div class="row" style="padding:20px;">
                                    <a href="userHomepage.php" style="width:100%"><button class="btn btn-primary" style="width:100%">CONTINUE SHOPPING</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>


            <?php } else {
                die('Could not insert: ' . mysqli_error($link));
            }
            ?>


        <?php
    }
        ?>
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

        </body>

    </html>

<?php
} else {
    header("Location:login.php");
}
?>