<?php
include "mysql_con.php";

$user = $_SESSION['username'];

if(!isset($user)) { header("location:index.php"); }

$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");

if(!has_perms("manage-wiki")){
    header("Location: index.php");
}

if(!isset($_GET['game_id'])){
    header("Location: index.php");
}

$game = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_games WHERE id = '".mysqli_real_escape_string($con, $_GET['game_id'])."'"));

$imagedata =  file_get_contents($game['image']);
$base64 = base64_encode($imagedata);

?>

<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, follow, noarchive">

    <title><?php echo $game['title'];?> | Edit Game | GSR</title>

    <meta name="description" content="Submission form to edit a game in GSR's database.">

    <?php include "links.php"; ?>
    <style>
        .add-form {
            position: relative;
            background: #FFF;
            padding: 40px;
            width:auto;
            max-width: 500px;
            margin: 20px auto;
            border:none;
        }

        form{
            width:500px;
            margin:auto;
            margin-top:15px;
            margin-bottom:15px;
            display:block;
            padding:15px;
            text-align:left;
        }

        form label{
            display:block;
            width:100%;
            font-size:18px;
            line-height:30px;
            height:30px;
            font-weight:bold;
            border: solid 1px #e73030;
            text-align:left;
            background-color: #e73030;
            color:white;
            box-shadow: 0 10px 6px -6px #777;
            cursor:pointer;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding-left:20px;
        }

        form input{
            width: 100%;
            display: block;
            padding: 10px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            border: solid 1px #e73030;
            color: black;
            text-align: left;
            font-size: 16px;
            background-color: #fff;
            box-shadow: 0 10px 6px -6px #777;
            margin-bottom: 10px;
        }

        form input[type=checkbox]{
            width: 25px;
            height:25px;
            display: inline-block;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            border: solid 1px #e73030;
            color: #e73030;
            text-align: left;
            font-size: 14px;
            background-color: #fff;
            box-shadow: none;
            margin-bottom: 10px;
        }

        form textarea{
            width: 100%;
            display: block;
            padding: 10px;
            height:200px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            border: solid 1px #e73030;
            color: black;
            text-align: left;
            font-size: 16px;
            background-color: #fff;
            box-shadow: 0 10px 6px -6px #777;
            margin-bottom: 10px;
            font-family:Arial;
        }

        form button{
            box-shadow: 0 10px 6px -6px #777;
            text-align: center;
            font-size: 14px;
            font-family: Arial,Helvetica,sans-serif;
            display: inline-block;
            width: auto;
            padding-left:15px;
            padding-right:15px;
            height: 48px;
            line-height: 48px;
            background-color: #e73030;
            border: none;
            color: #fff;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            cursor: pointer;
        }

        form button:hover{
            background-color:#A22321;
        }

        .ui-datepicker{
            border: solid 1px #e73030;
            box-shadow: 0 10px 6px -6px #777;
        }

        .container {
            box-shadow: 0 10px 6px -6px #777;
            border: solid 1px #e73030;
            width:100%;
            height: 400px;
            overflow-y: scroll;
            overflow-x:hidden;
            background-color:#FFF;
            margin-bottom:20px;
        }

        .container input[type=checkbox]{
            width:30px;
            cursor:pointer;
            transition:0.3s all ease;
        }
        .list-result{
            width:100%;
            display;block;
            height:30px;
            background-color:#FFF;
            color:white;
            cursor:pointer;
            padding:0;
            padding:-bottom:10px;
            border-bottom:solid 1px #e73030;
            transition:0.3s all ease;
        }

        .list-result:hover{
            background-color: #e73030;
        }

        .list-result label{
            transition:0.3s all ease;
            font-size:14px;
            width:400px;
            display:inline-block;
            font-weight:100;
            padding:0;
            color:#000;
            vertical-align:middle;
            border:none;
            background-color:transparent;
            font-family:verdana;
            margin-bottom:10px;
            box-shadow:none;
            cursor:pointer
        }

        .list-result:hover label{
            color:white;
        }

        .error-result{
            margin-left:15px;
            display:inline-block;
            font-size:14px;
        }

        .base64_image{
            display:none;
        }

        .game-cover{
            height:400px;
            width:100%;
            background-size:contain;
            background-position:center;
            background-color:black;
            background-repeat:no-repeat;
        }


    </style>

</head>

<body>

<?php include "header.php"; ?>

<div id="page" class="container_24">

    <article>

        <section id="articlelist">

            <?php include 'dashboard-nav.php';?>

            <div id="db-main">
                <?php include 'dashboard-msg.php';?>
                <br /><br />
                <center>
                    <i style="font-size:18px;">All fields optional except title, you can come back and add or change something later.</i>
                </center>
                <form class="wiki-form" id="add-game" method="post" action="manage-games_get.php?action=addgame" enctype="multipart/form-data">

                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" placeholder="Game title" value="<?php echo $game['title'];?>"/>
                    
                    <label for="storyline">Storyline</label>
                    <textarea id="storyline" name="storyline" placeholder="Storyline"><?php echo $game['storyline'];?></textarea>

                    <label for="about">About</label>
                    <textarea id="about" name="about" placeholder="About the game"><?php echo $game['about'];?></textarea>

                    <div id="characters-load"></div>

                    <label for="release-date">Release Date</label>
                    <input type="text" name="release-date" id="release-date" value="<?php echo $game['release_date'];?>" placeholder="Select date which game was first release" />

                    <label for="website">Website</label>
                    <input type="url" name="website" id="website" placeholder="The game's website URL. " value="<?php echo $game['website'];?>"/>


                    <div id="platforms-load"></div>

                    <label for="genres">Genres <span style="font-size:12px;font-weight:normal;">(tick all the genres the game fits in)</span></label>
                    <div class="container">
                        <?php
                        $cur_genres = explode(",",$game['genres']);
                        $get_genres = mysqli_query($con, "SELECT * FROM tbl_genres ORDER BY genre ASC");
                        while ($genre = mysqli_fetch_assoc($get_genres)) { ?>
                            <div class="list-result">
                                <input type="checkbox" id="genre-<?php echo $genre['id'];?>" name="genres[]" value="<?php echo $genre['id'];?>" <?php if(in_array($genre['id'], $cur_genres)){echo "checked";} ?>/><label for="genre-<?php echo $genre['id'];?>"><?php echo $genre['genre'];?></label><br />
                            </div>
                        <?php } ?>
                    </div>


                    <div id="developers-load"></div>
                    <div id="publishers-load"></div>

                    <label for="levels">Levels</label>
                    <textarea id="levels" name="levels" placeholder="Levels"><?php echo $game['levels'];?></textarea>

                    <label for="missions">Missions</label>
                    <textarea id="missions" name="missions" placeholder="Missions"><?php echo $game['missions'];?></textarea>

                    <label for="weapons">Weapons</label>
                    <textarea id="weapons" name="weapons" placeholder="Weapons"><?php echo $game['weapons'];?></textarea>

                    <label for="cheats">Cheats</label>
                    <textarea id="cheats" name="cheats" placeholder="Cheats"><?php echo $game['cheats'];?></textarea>

                    <br /><br />
                    <button type="submit">Save Game</button><span class="error-result"></span>

                </form>
            </div>
        </section>

    </article>

</div>

<?php include "footer.html"; ?>
<div id="addForms" style="display:none;">

    <form class="add-form" id="new-platforms" enctype="multipart/form-data" method="post">

        <h3>Add Platform</h3><hr />

        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Name of Platform"/>

        <label for="plat-icon">Icon for Platform</label>
        <input type="file" name="icon" id="plat-icon" accept="image/*">
        <textarea class="base64_image" id="base64-platforms" name="base64-platforms" placeholder="Base64 Image encoding" cols="50" rows="15"></textarea>

        <br /><br />
        <button id="submitNewPlatform" type="submit">Add Platform</button><span class="error-result"></span>

    </form>

    <form class="add-form" id="new-publishers" enctype="multipart/form-data" method="post">

        <h3>Add Publisher</h3><hr />

        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Publishers Name"/>

        <label for="pub-website">Publishers Website</label>
        <input type="text" name="website" id="pub-website" placeholder="Website URL"/>

        <label for="pub-logo">Publishers Logo</label>
        <input type="file" name="logo" id="pub-logo" accept="image/*">
        <textarea class="base64_image" id="base64-publishers" name="base64-publishers" placeholder="Base64 Image encoding" cols="50" rows="15"></textarea>

        <br /><br />
        <button id="submitNewPublisher" type="submit">Add Publisher</button><span class="error-result"></span>

    </form>

    <form class="add-form" id="new-developers" enctype="multipart/form-data" method="post">

        <h3>Add Developer</h3><hr />

        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Developers Name"/>

        <label for="dev-website">Developers Website</label>
        <input type="text" name="website" id="dev-website" placeholder="Website URL"/>

        <label for="dev-logo">Developers Logo</label>
        <input type="file" name="logo" id="dev-logo" accept="image/*">
        <textarea class="base64_image" id="base64-developers" name="base64-developers" placeholder="Base64 Image encoding" cols="50" rows="15"></textarea>


        <br /><br />
        <button id="submitNewDeveloper" type="submit">Add Developer</button><span class="error-result"></span>

    </form>

    <form class="add-form" id="new-characters" enctype="multipart/form-data" method="post">

        <h3>Add Character</h3><hr />

        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Characters Name"/>

        <label for="about">About</label>
        <textarea id="about" name="about" placeholder="About the character"></textarea>

        <label for="char-image">Characters Image</label>
        <input type="file" name="image" id="char-image" accept="image/*">
        <textarea class="base64_image" id="base64-characters" name="base64-characters" placeholder="Base64 Image encoding" cols="50" rows="15"></textarea>


        <br /><br />
        <button id="submitNewCharacter" type="submit">Add Character</button><span class="error-result"></span>

    </form>

</div>

<script>

    var imgPickerArray = [
        "characters",
        "platforms",
        "developers",
        "publishers"
    ];

    function scrollToBot(){
        $(".image_picker_selector").each(function(){
            $(this).animate({ scrollTop: $(this).prop("scrollHeight")}, 1000);
        });
    }

    var popupForms = 0;

    function loadAndShow(addType){
        popupForms++;
        $("#"+addType).append('<a class="'+addType+'-'+popupForms+'" href="#new-'+addType+'">Open form</a>');
        $('.'+addType+'-'+popupForms).magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#name',

            // When elemened is focused, some mobile browsers in some cases zoom in
            // It looks not nice, so we disable it:
            callbacks: {
                beforeOpen: function() {
                    if($(window).width() < 700) {
                        this.st.focus = false;
                    } else {
                        this.st.focus = '#name';
                    }
                }
            }
        });
        $('.'+addType+'-'+popupForms).click();
    }

    function loadTypes(){
        $("select").imagepicker({
            hide_select : true,
            show_label  : true
        });

        var i=-1;
        $(".image_picker_selector").each(function(){
            i++;
            $(this).find("li").last().addClass("add-new");
            $(this).find("li").last().attr("data-addtype", imgPickerArray[i]);
            $(this).find("li").last().click(function(e){
                e.preventDefault();
                var addType = $(this).attr("data-addtype");
                $(this).find(".thumbnail").removeClass("selected");
                $("#addPlatform").prop("selected", false);
                $("#addDeveloper").prop("selected", false);
                $("#addPublisher").prop("selected", false);
                $("#addCharacter").prop("selected", false);
                $("select").data('picker').sync_picker_with_select();

                loadAndShow(addType);

            });
        });
    }


    function loadType(x){
        $("#"+x+"-load").load("forms/game_"+x+".php?game_id=<?php echo $game['id'];?>", function(){loadTypes();scrollToBot();});
    }

    $(function() {



        $("input[type=file").each(function(){

            var fileInput = $(this).attr("id");
            var base64Textarea = $(this).parent().find(".base64_image").attr("id");

            var handleFileSelect = function(evt) {
                var files = evt.target.files;
                var file = files[0];

                if (files && file) {
                    var reader = new FileReader();

                    reader.onload = function(readerEvt) {
                        var binaryString = readerEvt.target.result;
                        document.getElementById(base64Textarea).value = btoa(binaryString);
                    };

                    reader.readAsBinaryString(file);
                }
            };

            if (window.File && window.FileReader && window.FileList && window.Blob) {
                document.getElementById(fileInput).addEventListener('change', handleFileSelect, false);
            } else {
                alert('The File APIs are not fully supported in this browser.');
            }
        });

        for (i = 0, len = imgPickerArray.length; i < len; i++) {
            loadType(imgPickerArray[i]);

        }

        var datepicker = $("#release-date");
        datepicker.datepicker();
        datepicker.datepicker( "option", "dateFormat", "yy-mm-dd" );
        datepicker.datepicker( "setDate", "<?php echo $game['release_date'];?>");




        $("#submitNewPlatform").click(function(e){
            var erdiv = $(this).parent().find(".error-result");
            e.preventDefault();
            erdiv.html("Loading...");
            $.post("manage-games_get.php?action=addplatform",
                {
                    name: $("#new-platforms #name").val(),
                    base64: $("#new-platforms #base64-platforms").val()

                },
                function(data, status){
                    erdiv.html("");
                    var result = data.split("@##$^@");
                    if(result[0]=="true"){
                        $.magnificPopup.close();
                        loadType("platforms");
                    }
                    else{
                        var errors = result[1].split(",")[0];
                        erdiv.html("<br />"+errors);
                    }
                });
        });

        $("#submitNewDeveloper").click(function(e){
            var erdiv = $(this).parent().find(".error-result");
            e.preventDefault();
            erdiv.html("Loading...");
            $.post("manage-games_get.php?action=adddeveloper",
                {
                    name: $("#new-developers #name").val(),
                    base64: $("#new-developers #base64-developers").val(),
                    website: $("#new-developers #dev-website").val()

                },
                function(data, status){
                    erdiv.html("");
                    var result = data.split("@##$^@");
                    if(result[0]=="true"){
                        $.magnificPopup.close();
                        loadType("developers");
                    }
                    else{
                        var errors = result[1].split(",")[0];
                        erdiv.html("<br />"+errors);
                    }
                });
        });

        $("#submitNewPublisher").click(function(e){
            var erdiv = $(this).parent().find(".error-result");
            e.preventDefault();
            erdiv.html("Loading...");
            $.post("manage-games_get.php?action=addpublisher",
                {
                    name: $("#new-publishers #name").val(),
                    base64: $("#new-publishers #base64-publishers").val(),
                    website: $("#new-publishers #pub-website").val()

                },
                function(data, status){
                    erdiv.html("");
                    var result = data.split("@##$^@");
                    if(result[0]=="true"){
                        $.magnificPopup.close();
                        loadType("publishers");
                    }
                    else{
                        var errors = result[1].split(",")[0];
                        erdiv.html("<br />"+errors);
                    }
                });
        });

        $("#submitNewCharacter").click(function(e){
            var erdiv = $(this).parent().find(".error-result");
            e.preventDefault();
            erdiv.html("Loading...");
            $.post("manage-games_get.php?action=addcharacter",
                {
                    name: $("#new-characters #name").val(),
                    base64: $("#new-characters #base64-characters").val(),
                    about: $("#new-characters #about").val(),


                },
                function(data, status){
                    erdiv.html("");
                    var result = data.split("@##$^@");
                    if(result[0]=="true"){
                        $.magnificPopup.close();
                        loadType("characters");
                    }
                    else{
                        var errors = result[1].split(",")[0];
                        erdiv.html("<br />"+errors);
                    }
                });
        });



        $("#add-game").on("submit", function(e) {
            var erdiv = $(this).parent().find(".error-result");
            e.preventDefault();
            erdiv.html("Loading...");

            $.ajax({
                url: "manage-games_get.php?action=addgame&id=<?php echo $game['id'];?>",
                type: "post",
                data: $(this).serialize(),
                success: function(data) {
                    var result = data.split("@##$^@");
                    if(result[0]=="true"){
                        document.location="manage-games.php?game=saved";
                    }
                    else{
                        var errors = result[1].split(",")[0];
                        erdiv.html("<br />"+errors);
                    }
                }
            });
        });

    });

</script>
</body>
</html>