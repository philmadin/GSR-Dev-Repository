<?php $name = base64_encode("Daniel");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shark Bonus</title>
    <link href="https://code.jquery.com/ui/1.12.0-rc.2/themes/smoothness/jquery-ui.css" type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0-rc.2/jquery-ui.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="js/script.js"></script>
    <style>
        html, body{
            display:block;
            padding:0;
            margin:0;
            background-color:transparent;
        }
        #bonus{
            position:fixed;
            left:0;
            top:0;
            display:block;
            width:100%;
            height:100%;
            background:transparent;
        }


        #bonus #shark{

        }

        #bonus #shark.frame-1{
            
        }
    </style>
</head>

<body>
    <div id="bonus">
        <div id="shark"></div>
    </div>
</body>
<script>

    $(function(){
        bonus.init('<?php echo $name;?>', [
            {type: "tokens", int: 100},
            {type: "tokens", int: 200},
            {type: "xp", int: 500},
            {type: "xp", int: 1000},
            {type: "card", int: 1},
            {type: "card", int: 2},
            {type: "card", int: 3}
        ]);
    });

</script>
</html>