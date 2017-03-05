<?php include_once("../mysql_con.php");?>
<?php
if(isset($_GET['game_id'])){
    $game = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_games WHERE id = '".mysqli_real_escape_string($con, $_GET['game_id'])."'"));
    $selected = explode(",", $game['characters']);
}
?>
<label for="characters">Characters</label>
<select id="characters" name="characters[]" multiple="multiple">
    <?php
    $get_characters = mysqli_query($con, "SELECT * FROM tbl_characters ORDER BY id ASC");
    while ($character = mysqli_fetch_assoc($get_characters)) { ?>
        <?php if(!is_null($character['image'])){ ?>
            <option data-img-src="<?php echo $character['image'];?>" data-img-label="<?php echo $character['name'];?>" value="<?php echo $character['id'];?>" <?php if(in_array($character['id'], $selected)){echo "selected";} ?>><?php echo $character['name'];?></option>
        <?php } else { ?>
            <option data-img-src="https://placeholdit.imgix.net/~text?txtsize=16&txt=<?php echo $character['name'];?>&w=100&h=100" data-img-label="<?php echo $character['name'];?>" value="<?php echo $character['id'];?>" <?php if(in_array($character['id'], $selected)){echo "selected";} ?>><?php echo $character['name'];?></option>
        <?php } ?>
    <?php } ?>
    <option id="add-characters" data-img-src="imgs/games/add-new.png" data-img-label="Add New">Add New</option>
</select>