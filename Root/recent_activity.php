<?php

    include "mysql_con.php";

    include "timecal.php";

    $crunchUSER = $_GET['user'];
    $crunchOFFS = $_GET['offset'];

    $crunchQRY = mysqli_query($con, "SELECT * FROM tbl_crunchbox WHERE receiver = '" . $crunchUSER . "' ORDER BY id DESC LIMIT " . $crunchOFFS . ",5");

    while ($crunchROW = mysqli_fetch_assoc($crunchQRY)) {
        $cru_from       = $crunchROW['sender'];
        $cru_message    = $crunchROW['message'];
        $cru_since      = strtotime($crunchROW['since']);

        $cruIMGQRY = mysqli_query($con, "SELECT picture FROM tbl_accounts WHERE username = '$cru_from'");
        $cru_picture = mysqli_fetch_assoc($cruIMGQRY)['picture'];

        if($cru_picture == NULL || $cru_picture == "" || empty($cru_picture)) {
            $cru_image = "default";
        } else {
            $cru_image = $cru_picture;
        }

        $cru_date = humanTiming($cru_since) . " ago";
?>

        <li>
            <div id="crunchypic" class="shark_pic" data-shark-picture="<?php echo $cru_image; ?>"></div>
            <p><a href="profile.php?profilename=<?php echo $cru_from; ?>"><?php echo $cru_from; ?></a> <?php echo $cru_message; ?></p>
            <span><?php echo $cru_date; ?></span>
        </li>

<?php
    }

    $crunchNUM = mysqli_num_rows($crunchQRY);

    if($crunchNUM == 0) {
?>
        <li class="dead"><span>No one has crunched at <?php echo $crunchUSER; ?></span></li>
<?php
    }

    echo "<p id='crunchOFFSET'>" . $crunchOFFS . "</p>";
?>