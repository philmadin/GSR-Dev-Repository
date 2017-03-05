<?php

        $umQRYA = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '" . $_SESSION['username'] . "' LIMIT 1");
        $umQRYB = 0;

        if(mysqli_num_rows($umQRYA) < 1) {
            $usermenuQRY = $umQRYB;
        } else {
            $usermenuQRY = $umQRYA;
        }

        while ($UQRY = mysqli_fetch_assoc($usermenuQRY)) {
            $ur_username = $UQRY['username'];
            $ur_firstname = $UQRY['firstname'];
            $ur_lastname = $UQRY['lastname'];
            $ur_picture = $UQRY['picture'];
            $ur_cotype = $UQRY['cotype'];
            $ur_level = $UQRY['level'];

            $ur_fullname = $ur_firstname . " " . $ur_lastname;
            if ($ur_picture == NULL || $ur_picture == "" || empty($ur_picture)) {
                $ur_image = "default";
            } else {
                $ur_image = $ur_picture;
            }

        }
?>

<script>var u = "<?php echo base64_encode($ur_username);?>";</script>

<li class="dropdown" id="user-nav">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="fa fa-user fa-3x"></span>
    </a>
    <ul class="dropdown-menu" style="color:black;">
        <li>
            <div class="navbar-login">
                <div class="row">
                    <div class="col-lg-4 text-center">
                        <img src="http://gamesharkreviews.com/imgs/users/<?php echo $ur_image."-232x270.jpg"; ?>" style="max-height:100px;margin:auto;" class="img-thumbnail" />
                    </div>
                    <div class="col-lg-8">
                        <p class="text-left"><strong><?php echo $ur_fullname;?></strong></p>
                        <p class="text-left small">LEVEL: <span id="currentlevel" class="currentlevel"><?php echo $ur_level; ?></span></p>
                        <p class="text-left">
                            <a href="settings.php" class="btn btn-primary btn-block btn-sm">Profile Settings</a>

                            <?php if(has_perms("dashboard")) { ?>
                                <a href="dashboard.php" class="btn btn-info btn-block btn-sm">Dashboard</a>
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div>
        </li>
        <li class="divider"></li>
        <li>
            <div class="navbar-login navbar-login-session">
                <div class="row">
                    <div class="col-lg-12">
                        <p>
                            <a href="logout.php" class="btn btn-danger btn-block">Logout</a>
                        </p>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>