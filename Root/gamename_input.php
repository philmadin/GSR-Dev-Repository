<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 26/04/2016
 * Time: 6:20 PM
 */

    $games_ar = array();
    $get_games =  mysqli_query($con, "SELECT title,id FROM tbl_games");
    while ($game = mysqli_fetch_assoc($get_games)) {array_push($games_ar, $game);}
?>
<script type="text/javascript">
    var games = <?php echo json_encode($games_ar, JSON_PRETTY_PRINT) ?>;
</script>


<input name="gamename" class="valid" id="gamename" type="text" value="" placeholder="Enter the name of the game here..." required="" autocomplete="off" aria-required="true" aria-invalid="false">

<input id="gameid" style="display:none;" name="gameid"/>

<script>
    var options = {
        data: games,

        getValue: "title",
        theme: "plate-dark",

        list: {
            onSelectItemEvent: function() {
                var value = $("#gamename").getSelectedItemData().id;
                $("#gameid").val(value).trigger("change");
            },
            maxNumberOfElements: 10,
            match: {
                enabled: true
            }
        }
    };

    $("#gamename").easyAutocomplete(options);
</script>