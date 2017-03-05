<link href="css/bootstrap.theme.paper.css" rel="stylesheet" type="text/css" />
<link href="css/jasny-bootstrap.css" type="text/css" rel="stylesheet" />
<link href="css/jquery-ui.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">


<link href="css/layout.css" type="text/css" rel="stylesheet" />


<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/jasny-bootstrap.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/additional-methods.min.js"></script>



<script src="js/scripts.js" type="text/javascript"></script>
<script src="js/xp.js" type="text/javascript"></script>

<meta name="google-site-verification" content="we7T70hH2vPCVRx2nmZNBJZvnpag7gWvAyVuA5hRnok" />


<meta property="fb:pages" content="1610060492568280" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
    $alt_url = str_replace("http://m.", "http://", "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
?>
<link rel="canonical" href="<?php echo $alt_url;?>">

<?php
function date_compare($a, $b)
{
    $t1 = strtotime($b['createdate']);
    $t2 = strtotime($a['createdate']);
    return $t1 - $t2;
}
?>

<script src="https://www.gstatic.com/firebasejs/live/3.0/firebase.js"></script>
<script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyCisVanHgsN5KfFifEtPaYtvkXJdJ06VEs",
        authDomain: "gsr-login-32a72.firebaseapp.com",
        databaseURL: "https://gsr-login-32a72.firebaseio.com",
        storageBucket: "gsr-login-32a72.appspot.com",
    };
    firebase.initializeApp(config);
</script>
