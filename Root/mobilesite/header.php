<div id="topmenu">
    <a href="index.php" id="gsrlogo"></a>
    <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-recalc="false" data-target=".navmenu" data-canvas=".canvas">
        <span class="fa fa-bars fa-3x"></span>
    </button>



    <?php
    if(!isset($sessionlogin) || !isset($cookielogin)) {
        include 'loginform.php';
    }
    else{
        include 'usermenu.php';
    }
    ?>

</div>

<?php

if(!isset($sessionlogin) || !isset($cookielogin)) {

} else { ?>
    
    <div id="userexpbar">
        <div id="expamount" class="expamount" style="width:0;"><span id="expvalue"><span id="currentexp" class="currentexp">0</span>/<span id="levelexp" class="levelexp">0</span></span></div>

    </div>
<?php } ?>

