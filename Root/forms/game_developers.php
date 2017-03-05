<?php include_once("../mysql_con.php"); ?>
<?php
if(isset($_GET['game_id'])){
    $game = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_games WHERE id = '".mysqli_real_escape_string($con, $_GET['game_id'])."'"));
    $selected = explode(",", $game['developers']);
}
?>

<label for="developers">Developers</label>
<select id="developers" name="developers[]" multiple="multiple">
    <?php
    $get_developers = mysqli_query($con, "SELECT * FROM tbl_gamedevelopers ORDER BY id ASC");
    while ($developer = mysqli_fetch_assoc($get_developers)) { ?>
        <?php if(!is_null($developer['logo'])){ ?>
            <option data-img-src="<?php echo $developer['logo'];?>" data-img-label="<?php echo $developer['name'];?>" value="<?php echo $developer['id'];?>" <?php if(in_array($developer['id'], $selected)){echo "selected";} ?>><?php echo $developer['name'];?></option>
        <?php } else { ?>
            <option data-img-src="https://placeholdit.imgix.net/~text?txtsize=16&txt=<?php echo $developer['name'];?>&w=100&h=100" data-img-label="<?php echo $developer['name'];?>" value="<?php echo $developer['id'];?>" <?php if(in_array($developer['id'], $selected)){echo "selected";} ?>><?php echo $developer['name'];?></option>
        <?php } ?>
    <?php } ?>
    <option id="add-developers" data-img-src="imgs/games/add-new.png" data-img-label="Add New">Add New</option>
</select>