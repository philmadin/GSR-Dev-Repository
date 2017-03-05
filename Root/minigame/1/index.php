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
        #bonus #water{
            background-image:url(images/ocean-floor-background.png);
            background-position:center;
            background-size:cover;
            background-repeat:no-repeat;
            position:fixed;
            left:0;
            top:0;
            display:none;
            width:100%;
            height:100%;
            z-index:3;
        }

        #bonus #water:after{
            content: "";
            background-image:url(images/water-overlay.gif);
            background-size:300px;
            width:100%;
            height:100%;
            position:fixed;
            z-index:4;
            top:0;
            left:0;
            opacity:0.15;
        }

        #chests{
            position:fixed;
            z-index:5;
            display:none;
            width:100%;
            text-align:center;
            bottom:15px;
        }



        .chest{
            width:64px;
            height:64px;
            background-repeat:no-repeat;
            background-image:url(http://www.gdunlimited.net/forums/uploads/1251003750/gallery_10621_57_19583.png);
            background-size:768px 512px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            background-color:transparent;
            display:inline-block;
            margin:15px;
            cursor:pointer;
            background-position-x:0px; /*LEFT*/
            position:relative;
        }

        .chest[data-frame="1"]{
            background-position-y:-256px; /*TOP*/
        }

        .chest[data-frame="2"]{
            background-position-y:-320px; /*TOP*/
        }

        .chest[data-frame="3"]{
            background-position-y:-384px; /*TOP*/
        }

        .chest[data-frame="4"]{
            background-position-y:-448px; /*TOP*/
        }
    </style>
</head>

<body>
    <div id="bonus">
        <div id="water"></div>
        <div id="shark"></div>
        <div id="chests"></div>
        <div id="prize"></div>
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