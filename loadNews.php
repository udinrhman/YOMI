<?php
include 'function/timeAgo.php';
$host = "localhost";
$userid = "root";
$pass = "";
$database = "yomi";

$link = mysqli_connect($host, $userid, $pass, $database);

$queryNews = "SELECT * FROM news WHERE news_date < '".$_POST['id']."' ORDER BY news_date DESC LIMIT 4";
$resultNews = mysqli_query($link, $queryNews);
$queryAdmin = "SELECT * FROM user WHERE username = 'admin'";
$resultAdmin = mysqli_query($link, $queryAdmin);
$admin = mysqli_fetch_assoc($resultAdmin);
$output = "";

while ($news = mysqli_fetch_array($resultNews, MYSQLI_BOTH)) {
    $time_elapsed = timeAgo($news['news_date']);
    $output .= '
    <tr style="border:1px solid #3B3B3B">

    <td style="vertical-align:top;">
        <img src=' . $admin['user_image'] . ' class="rounded-circle" width="37" height="37" style="margin:10px;margin-top:5px;object-fit:cover;">
    </td>
    <td>
        <table width="100%">
            <tr>
                <td style="padding-top:0!important;padding-bottom:10px;padding-right:20px;">
                    <span style="font-weight:600;font-size:15px;color:#BF95FC">' . $admin['user_fullname'] . '</span><span style="font-size:12px;color:#AAAAAA">&nbsp&nbsp·&nbsp&nbsp'.$time_elapsed.'</span>
                    <p style="text-align:justify;font-size:15px;margin:0">' . nl2br($news['description']) . '</p>
                </td>
            </tr>';

    if (!empty($news['news_image'])) {  //if have image
        $output .= '
                <tr>
                    <td style="padding-bottom:10px;padding-top:0!important">';

        list($width, $height) = getimagesize($_SERVER['DOCUMENT_ROOT'] . "/YOMI/upload/$news[news_image]");

        if ($width > $height) { //if landscape 
            $output .= '
                            <img src="upload/' . $news['news_image'] . '" style="width:500px;height:auto;object-fit:cover;border-radius:5px">';
        } else { //if potrait 
            $output .= '
                            <img src="upload/' . $news['news_image'] . '" style="width:300px;height:auto;object-fit:cover;border-radius:5px">';
        }
        $output .= '                    
                    </td>

                </tr>';
    }
    $output .= '
        </table>
    </td>
    </tr>';
    $id = $news['news_date'];
}
if (mysqli_num_rows($resultNews) > 1) {
$output .= '
            <tr id="remove_row">
                <td colspan="2"><button id="view_more" data-id="'.$id.'">VIEW MORE</button></td>
            </tr>
    ';
}
echo $output;
