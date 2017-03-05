<?php

$time_array = array(
array("christmas", "20/12", "31/12"),
array("april fools", "1/4", "1/4")
);

$holiday = array();

function timecheck($get_from, $get_to)
{
	$from_ar = explode("/",$get_from);
    $from = date("Y")."-".$from_ar[1]."-".$from_ar[0];
	$from_date = strtotime($from);

	$to_ar = explode("/",$get_to);
    $to = date("Y")."-".$to_ar[1]."-".$to_ar[0];
	$to_date = strtotime($to);

	$now = time();
	return (($now >= $from_date) && ($now <= $to_date));
}


foreach($time_array as $time_ar){
	if(timecheck($time_ar[1], $time_ar[2])){
		array_push($holiday, $time_ar[0]);
	}
}

$randNum = mt_rand(0,5);

?>

<?php //CHRISTMAS ?>

<?php if(in_array("christmas", $holiday)){?>
<script src="js/jquery.snow.min.1.0.js"></script>
<script>
$(document).ready( function(){
    $.fn.snow();
    ae8857b082115f203e8a5d23410461f7(500, "event", "christmas", "holiday", "<h3>Merry Christmas!</h3> You have been rewarded %xp%xp<br /> as a bonus for signing in on Christmas Day.");
});
</script>
<?php } ?>

<?php //CHRISTMAS ?>

<?php //APRIL FOOLS ?>

<?php if(in_array("april fools", $holiday)){?>
    <? if (!isset($_COOKIE['april fools'])){ ?>

        <script>
            $(document).ready( function() {
                popup("ERROR: 19208", "<h3>That's Unfortunate!</h3> Unfortunately your accounts level has been reset back to 1 due to a system error.<br />");
                setTimeout(function(){ae8857b082115f203e8a5d23410461f7(100, "event", "april_fools", "holiday", "<h3>April Fools!</h3> You have been rewarded %xp%xp<br /> as a bonus for signing in on April Fools Day.");}, 10000);
            });
        </script>

        <?
        setcookie('april fools', true,  time()+86400); // 1 day
        ?>

    <? } ?>

<?php } ?>

<?php //APRIL FOOLS ?>


<?php if(has_perms("holiday-test")){ ?>
   
<?php } ?>