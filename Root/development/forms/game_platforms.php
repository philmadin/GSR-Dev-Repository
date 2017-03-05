<?php include_once("../mysql_con.php");?>
<?php
if(isset($_GET['game_id'])){
    $game = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_games WHERE id = '".mysqli_real_escape_string($con, $_GET['game_id'])."'"));
    $selected = explode(",", $game['platforms']);
}
?>
<label for="platforms">Available Platforms</label>
<select id="platforms" name="platforms[]" multiple="multiple">
    <?php
    $get_platforms = mysqli_query($con, "SELECT * FROM tbl_platforms ORDER BY id ASC");
    while ($platform = mysqli_fetch_assoc($get_platforms)) { ?>
        <?php if(!is_null($platform['icon'])){ ?>
            <option data-img-src="<?php echo $platform['icon'];?>" data-img-label="<?php echo $platform['name'];?>" value="<?php echo $platform['id'];?>" <?php if(in_array($platform['id'], $selected)){echo "selected";} ?>><?php echo $platform['name'];?></option>
        <?php } else { ?>
            <option data-img-src="https://placeholdit.imgix.net/~text?txtsize=16&txt=<?php echo $platform['name'];?>&w=100&h=100" data-img-label="<?php echo $platform['name'];?>" value="<?php echo $platform['id'];?>" <?php if(in_array($platform['id'], $selected)){echo "selected";} ?>><?php echo $platform['name'];?></option>
        <?php } ?>
    <?php } ?>
    <option id="add-platforms" data-img-src="imgs/games/add-new.png" data-img-label="Add New">Add New</option>
</select>