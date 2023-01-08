<?php
$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

if (isset($_POST['keyword'])) {

    $keyword = $_POST['keyword'];
    if (!empty($keyword)) { //if keyword is inserted
        $query = "SELECT order_num FROM orders WHERE (order_num LIKE '%" . $keyword . "%' OR title LIKE '%" . $keyword . "%' OR alternative_title LIKE '%" . $keyword . "%') ORDER BY order_date DESC"; //have to add FULLTEXT index in sql - ALTER TABLE table_name ADD FULLTEXT index_name(column1, column2)
        $result = mysqli_query($link, $query);
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $query2 = "SELECT * FROM orders WHERE order_num = '" . $row['order_num'] . "' ORDER BY order_date DESC"; //have to add FULLTEXT index in sql - ALTER TABLE table_name ADD FULLTEXT index_name(column1, column2)
            $result2 = mysqli_query($link, $query2);

            $query3 = "SELECT order_num FROM orders WHERE order_num = '" . $row['order_num'] . "' ORDER BY order_date DESC";
            $result3 = mysqli_query($link, $query3);
?>
            <table id="myOrders" class="table table-borderless">
                <?php
                if (mysqli_num_rows($result2) == 0) {
                ?>
                    <div class="no-result">
                        <img src="../image/yomiLogo3.png">
                    </div>
                    <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">No Result</h5>
                <?php
                } ?>
                <tbody>
                    <?php
                    $currentDate = false;
                    $order_total = 0;
                    $x = 1;
                    $i = 0;
                    while ($nextrow = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
                        $nextrows[] = $nextrow[$i];
                    }

                    while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
                        $queryUser = "SELECT * FROM user WHERE username = '$row2[username]' ";
                        $resultUser = mysqli_query($link, $queryUser);
                        $queryAddress = "SELECT * FROM addresses WHERE address_id = '$row2[address_id]'";
                        $resultAddress = mysqli_query($link, $queryAddress);
                        while ($rowUser = mysqli_fetch_array($resultUser, MYSQLI_BOTH)) {
                            while ($rowAddress = mysqli_fetch_array($resultAddress, MYSQLI_BOTH)) {
                                if ($row2['order_date'] != $currentDate) {
                    ?>
                                    <tr style="background-color:#000000;">
                                        <td colspan="5"></td>
                                    </tr>
                                    <tr style="background-color:#777AFF">
                                        <th colspan="2" class="order_num" style="text-align:left;">
                                            <img src="../<?php echo $rowUser['user_image'] ?>" class="rounded-circle" width="37" height="37" style="margin-top:2px;object-fit:cover;">
                                            &nbsp&nbsp&nbsp<?php echo $row2['username'] ?>&nbsp&nbsp&nbsp | &nbsp&nbsp&nbsp
                                            ORDER ID:&nbsp&nbsp<span style="color:#AAC4FF">#<?php echo $row2['order_num'] ?></span>
                                        </th>
                                        <th colspan="3" style="text-align:right;padding-top:20px"><?php echo strtoupper(date("j M Y h:i A", strtotime($row2['order_date']))) ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align:left;">Delivery Address</th>
                                    </tr>
                                    <tr style="border-bottom:2px solid #3b3b3b">
                                        <td colspan="5" style="text-align:left">
                                            <span style="font-weight:600;font-size:20px"><?php echo $rowAddress['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp(+60) <?php echo $rowAddress['phone_number'] ?> <br>
                                            <?php echo $rowAddress['street'] ?>, <?php echo $rowAddress['floor_unit'] ?> <br>
                                            <?php echo $rowAddress['town_city'] ?>, <?php echo $rowAddress['postcode'] ?> <?php echo $rowAddress['state_region'] ?>
                                        </td>
                                    </tr>
                                    <tr style="background-color:#1a1a1a">
                                        <th style="text-align:left;">PRODUCT</th>
                                        <th>VOLUME</th>
                                        <th>PRICE</th>
                                        <th>QUANTITY</th>
                                    </tr>

                                <?php
                                    $currentDate = $row2['order_date'];
                                }
                                ?>
                                <tr style='cursor: pointer;' onclick="window.location='productDetails.php?ID=<?php echo $row2['mangaln_id'] ?>';">
                                    <td class="title" style="width:68%;text-align:left;">
                                        <p style="font-size:20px;font-weight:600;margin-bottom:0;"><?php echo $row2['title'] ?></p>
                                        <p><?php echo $row2['alternative_title'] ?></p>
                                        <span style="display:none"><?php echo $row2['order_num'] ?></span>
                                        <!------ to let the fucntion know that this is a different id ------------>
                                    </td>
                                    <td style="width:10%">
                                        <p style="margin:0;"><?php echo $row2['volume'] ?></p>
                                    </td>
                                    <td style="width:10%">
                                        <p style="margin:0;">RM<?php echo $row2['price'] ?></p>
                                    </td>
                                    <td style="width:10%">
                                        <p style="margin:0;">×<?php echo $row2['quantity'] ?></p>
                                    </td>
                                </tr>
                                <?php
                                $order_total = $order_total + $row2['subtotal'];
                                $total_payment = $order_total - $row2['discount'];
                                if (!empty($nextrows[$x])) {
                                    if ($row2['order_num'] != $nextrows[$x]) { ?>
                                        <tr style="border-top:1px solid #3b3b3b;font-weight:500">
                                            <td colspan="2" style="text-align:right;padding:0;padding-top:20px;">Order Total:</td>
                                            <td colspan="2" style="text-align:right;padding:0;padding-top:20px;padding-right:3%">RM<?php echo $order_total ?></td>
                                        </tr>
                                        <tr style="font-weight:500">
                                            <td colspan="2" style="text-align:right;padding:0">Discount:</td>
                                            <td colspan="2" style="text-align:right;padding:0;padding-right:3%">-RM<?php echo $row2['discount'] ?></td>
                                        </tr>
                                        <tr style="font-weight:500">
                                            <td colspan="2" style="text-align:right;padding:0">Total Payment:</td>
                                            <td colspan="2" style="text-align:right;padding:0;padding-right:3%">RM<?php echo $total_payment ?></td>
                                        </tr>
                                        <tr style="font-weight:500">
                                            <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;">Payment Method:</td>
                                            <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;padding-right:3%"><?php echo $row2['payment_method'] ?></td>
                                        </tr>
                                    <?php
                                        $order_total = 0;
                                    }
                                }
                                if (empty($nextrows[$x])) { ?>
                                    <tr style="border-top:1px solid #3b3b3b;font-weight:500">
                                        <td colspan="2" style="text-align:right;padding:0;padding-top:20px;">Order Total:</td>
                                        <td colspan="2" style="text-align:right;padding:0;padding-top:20px;padding-right:3%">RM<?php echo $order_total ?></td>
                                    </tr>
                                    <tr style="font-weight:500">
                                        <td colspan="2" style="text-align:right;padding:0">Discount:</td>
                                        <td colspan="2" style="text-align:right;padding:0;padding-right:3%">-RM<?php echo $row2['discount'] ?></td>
                                    </tr>
                                    <tr style="font-weight:500">
                                        <td colspan="2" style="text-align:right;padding:0">Total Payment:</td>
                                        <td colspan="2" style="text-align:right;padding:0;padding-right:3%">RM<?php echo $total_payment ?></td>
                                    </tr>
                                    <tr style="font-weight:500">
                                        <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;">Payment Method:</td>
                                        <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;padding-right:3%"><?php echo $row2['payment_method'] ?></td>
                                    </tr>
                <?php
                                    $order_total = 0;
                                }
                                $x = $x + 1;
                            }
                        }
                    }
                }
                ?>
                </tbody>
            </table>
        <?php
    } else { //if no keyword inserted
        $query2 = "SELECT * FROM orders ORDER BY order_date DESC"; //have to add FULLTEXT index in sql - ALTER TABLE table_name ADD FULLTEXT index_name(column1, column2)
        $result2 = mysqli_query($link, $query2);

        $query3 = "SELECT order_num FROM orders ORDER BY order_date DESC";
        $result3 = mysqli_query($link, $query3);
        ?>
            <table id="myOrders" class="table table-borderless">
                <?php
                if (mysqli_num_rows($result2) == 0) {
                ?>
                    <div class="no-result">
                        <img src="../image/yomiLogo3.png">
                    </div>
                    <h5 style="color:#c0c0c0;text-align:center;margin-bottom: 17%;">You Haven't Ordered Anything Yet</h5>
                <?php
                } ?>
                <tbody>
                    <?php
                    $currentDate = false;
                    $order_total = 0;
                    $x = 1;
                    $i = 0;
                    while ($nextrow = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
                        $nextrows[] = $nextrow[$i];
                    }

                    while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
                        $queryUser = "SELECT * FROM user WHERE username = '$row2[username]' ";
                        $resultUser = mysqli_query($link, $queryUser);
                        $queryAddress = "SELECT * FROM addresses WHERE address_id = '$row2[address_id]'";
                        $resultAddress = mysqli_query($link, $queryAddress);
                        while ($rowUser = mysqli_fetch_array($resultUser, MYSQLI_BOTH)) {
                            while ($rowAddress = mysqli_fetch_array($resultAddress, MYSQLI_BOTH)) {
                                if ($row2['order_date'] != $currentDate) {
                    ?>
                                    <tr style="background-color:#000000;">
                                        <td colspan="5"></td>
                                    </tr>
                                    <tr style="background-color:#777AFF">
                                        <th colspan="2" class="order_num" style="text-align:left;">
                                            <img src="../<?php echo $rowUser['user_image'] ?>" class="rounded-circle" width="37" height="37" style="margin-top:2px;object-fit:cover;">
                                            &nbsp&nbsp&nbsp<?php echo $row2['username'] ?>&nbsp&nbsp&nbsp | &nbsp&nbsp&nbsp
                                            ORDER ID:&nbsp&nbsp<span style="color:#AAC4FF">#<?php echo $row2['order_num'] ?></span>
                                        </th>
                                        <th colspan="3" style="text-align:right;padding-top:20px"><?php echo strtoupper(date("j M Y h:i A", strtotime($row2['order_date']))) ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align:left;">Delivery Address</th>
                                    </tr>
                                    <tr style="border-bottom:2px solid #3b3b3b">
                                        <td colspan="5" style="text-align:left">
                                            <span style="font-weight:600;font-size:20px"><?php echo $rowAddress['fullname'] ?></span>&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp(+60) <?php echo $rowAddress['phone_number'] ?> <br>
                                            <?php echo $rowAddress['street'] ?>, <?php echo $rowAddress['floor_unit'] ?> <br>
                                            <?php echo $rowAddress['town_city'] ?>, <?php echo $rowAddress['postcode'] ?> <?php echo $rowAddress['state_region'] ?>
                                        </td>
                                    </tr>
                                    <tr style="background-color:#1a1a1a">
                                        <th style="text-align:left;">PRODUCT</th>
                                        <th>VOLUME</th>
                                        <th>PRICE</th>
                                        <th>QUANTITY</th>
                                    </tr>

                                <?php
                                    $currentDate = $row2['order_date'];
                                }
                                ?>
                                <tr>
                                    <td class="title" style="width:68%;text-align:left;">
                                        <p style="font-size:20px;font-weight:600;margin-bottom:0;"><?php echo $row2['title'] ?></p>
                                        <p><?php echo $row2['alternative_title'] ?></p>
                                        <span style="display:none"><?php echo $row2['order_num'] ?></span>
                                        <!------ to let the fucntion know that this is a different id ------------>
                                    </td>
                                    <td style="width:10%">
                                        <p style="margin:0;"><?php echo $row2['volume'] ?></p>
                                    </td>
                                    <td style="width:10%">
                                        <p style="margin:0;">RM<?php echo $row2['price'] ?></p>
                                    </td>
                                    <td style="width:10%">
                                        <p style="margin:0;">×<?php echo $row2['quantity'] ?></p>
                                    </td>
                                </tr>
                                <?php
                                $order_total = $order_total + $row2['subtotal'];
                                $total_payment = $order_total - $row2['discount'];
                                if (!empty($nextrows[$x])) {
                                    if ($row2['order_num'] != $nextrows[$x]) { ?>
                                        <tr style="border-top:1px solid #3b3b3b;font-weight:500">
                                            <td colspan="2" style="text-align:right;padding:0;padding-top:20px;">Order Total:</td>
                                            <td colspan="2" style="text-align:right;padding:0;padding-top:20px;padding-right:3%">RM<?php echo $order_total ?></td>
                                        </tr>
                                        <tr style="font-weight:500">
                                            <td colspan="2" style="text-align:right;padding:0">Discount:</td>
                                            <td colspan="2" style="text-align:right;padding:0;padding-right:3%">-RM<?php echo $row2['discount'] ?></td>
                                        </tr>
                                        <tr style="font-weight:500">
                                            <td colspan="2" style="text-align:right;padding:0">Total Payment:</td>
                                            <td colspan="2" style="text-align:right;padding:0;padding-right:3%">RM<?php echo $total_payment ?></td>
                                        </tr>
                                        <tr style="font-weight:500">
                                            <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;">Payment Method:</td>
                                            <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;padding-right:3%"><?php echo $row2['payment_method'] ?></td>
                                        </tr>
                                    <?php
                                        $order_total = 0;
                                    }
                                }
                                if (empty($nextrows[$x])) { ?>
                                    <tr style="border-top:1px solid #3b3b3b;font-weight:500">
                                        <td colspan="2" style="text-align:right;padding:0;padding-top:20px;">Order Total:</td>
                                        <td colspan="2" style="text-align:right;padding:0;padding-top:20px;padding-right:3%">RM<?php echo $order_total ?></td>
                                    </tr>
                                    <tr style="font-weight:500">
                                        <td colspan="2" style="text-align:right;padding:0">Discount:</td>
                                        <td colspan="2" style="text-align:right;padding:0;padding-right:3%">-RM<?php echo $row2['discount'] ?></td>
                                    </tr>
                                    <tr style="font-weight:500">
                                        <td colspan="2" style="text-align:right;padding:0">Total Payment:</td>
                                        <td colspan="2" style="text-align:right;padding:0;padding-right:3%">RM<?php echo $total_payment ?></td>
                                    </tr>
                                    <tr style="font-weight:500">
                                        <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;">Payment Method:</td>
                                        <td colspan="2" style="text-align:right;padding:0;padding-bottom:20px;padding-right:3%"><?php echo $row2['payment_method'] ?></td>
                                    </tr>
                    <?php
                                    $order_total = 0;
                                }
                                $x = $x + 1;
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
    <?php }
} else {
    echo 'error';
}
