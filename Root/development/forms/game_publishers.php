<?php include_once("../mysql_con.php");?>
<?php
if(isset($_GET['game_id'])){
    $game = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_games WHERE id = '".mysqli_real_escape_string($con, $_GET['game_id'])."'"));
    $selected = explode(",", $game['publishers']);
}
?>

<label for="publishers">Publishers</label>
<select id="publishers" name="publishers[]" multiple="multiple">
    <?php
    $get_publishers = mysqli_query($con, "SELECT * FROM tbl_gamepublishers ORDER BY id ASC");
    while ($publisher = mysqli_fetch_assoc($get_publishers)) { ?>
        <?php if(!is_null($publisher['logo'])){ ?>
            <option data-img-src="<?php echo $publisher['logo'];?>" data-img-label="<?php echo $publisher['name'];?>" value="<?php echo $publisher['id'];?>" <?php if(in_array($publisher['id'], $selected)){echo "selected";} ?>><?php echo $publisher['name'];?></option>
        <?php } else { ?>
            <option data-img-src="https://placeholdit.imgix.net/~text?txtsize=16&txt=<?php echo $publisher['name'];?>&w=100&h=100" data-img-label="<?php echo $publisher['name'];?>" value="<?php echo $publisher['id'];?>" <?php if(in_array($publisher['id'], $selected)){echo "selected";} ?>><?php echo $publisher['name'];?></option>
        <?php } ?>
    <?php } ?>
    <option id="add-publishers" data-img-src="imgs/games/add-new.png" data-img-label="Add New">Add New</option>
</select>