<div id="db-chat">
<span id="chat-title">Staff Chat</span>
<div id="chat-list">

</div>
<div id="chat-container">
<form id="chat-form" method="post" action="dashboard-chat-set.php">
<input id="chat-input" autocomplete="off" type="text" placeholder="Enter your message..."/>
</form>
</div>
</div>
<?php if(has_perms("chat-commands")){ ?>
    <style>
        .chat-commands-ul li{
            margin-bottom:15px;
        }
    </style>
<button onclick='popup("Dashboard Commands", "<ul class=\"chat-commands-ul\"> <li>changelog>{desc}>{version}>{comingsoon}</li> <li>announce>{announcement}</li> <li>xp>{add|remove}>{amount}>{username}</li> </ul>");'>Dashboard Commands</button>
<?php } ?>

    <!--PLACEHOLDER BOX-->

<script>var loggedUser = '<?php echo strtoupper($user); ?>';</script>
<script src="js/dashboard-chat.js" type="text/javascript"></script>