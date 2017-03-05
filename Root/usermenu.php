<div id="usermenu">
    <div class="container_24">

        <?php

        $umQRYA = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '" . $_SESSION['username'] . "' LIMIT 1");
        $umQRYB = mysqli_query($con, "SELECT * FROM tbl_companies WHERE username = '" . $_SESSION['username'] . "' LIMIT 1");

        if(mysqli_num_rows($umQRYA) < 1) {
            $usermenuQRY = $umQRYB;
        } else {
            $usermenuQRY = $umQRYA;
        }

        while ($UQRY = mysqli_fetch_assoc($usermenuQRY)) {
            $ur_username    = $UQRY['username'];
            $ur_firstname   = $UQRY['firstname'];
            $ur_lastname    = $UQRY['lastname'];
            $ur_picture     = $UQRY['picture'];
            $ur_cotype      = $UQRY['cotype'];
            $ur_level      = $UQRY['level'];

            $ur_fullname    = $ur_firstname . " " . $ur_lastname;

            $ur_position    = $posa . " " . $posb;

            if($ur_picture == NULL || $ur_picture == "" || empty($ur_picture)) {
                $ur_image = "default";
            } else {
                $ur_image = $ur_picture;
            }


        ?>

        <div class="grid_3" id="userpp" data-shark-picture="<?php echo $ur_image;?>"></div>

        <div class="grid_2" id="userlvl">LVL<span id="currentlevel" class="currentlevel"><?php echo $ur_level; ?></span></div>
        <div class="grid_4" id="usernam"><a href="profile.php?profilename=<?php echo $ur_username; ?>"><?php echo $ur_username; ?></a></div>
        <ul id="usernav">
            <!--<li><a href="messages.php">MESSAGES</a></li>-->
            <!--<li><a href="#">CLAN HUB</a></li>-->
            <li><a href="settings.php">SETTINGS</a></li>
			<?php if(has_perms("dashboard")) { ?>
                <li><a href="dashboard.php">STAFF DASHBOARD</a></li>
            <?php } ?>
        </ul>


            <div class="grid_8" id="userexp">
            <span id="exptitle">EXP:</span>
            <div id="userexpbar">
                <div id="expamount" class="expamount" style="width:0;"></div>
                <span id="expvalue"><span id="currentexp" class="currentexp">0</span>/<span id="levelexp" class="levelexp">0</span></span>
            </div>
        </div>


        <?php } ?>
    </div>
</div>