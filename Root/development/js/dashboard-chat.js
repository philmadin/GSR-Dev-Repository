// request permission on page load
document.addEventListener('DOMContentLoaded', function () {
    if (Notification.permission !== "granted")
        Notification.requestPermission();
});

function notifyMe(title, body) {
    if (!Notification) {
        alert('Desktop notifications not available in your browser. Try Chromium.');
        return;
    }

    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        var notification = new Notification(title, {
            icon: 'http://gamesharkreviews.com/imgs/gsr_raw_logo2.jpg',
            body: body
        });

        notification.onclick = function () {
            
        };
		
		setTimeout(function() { notification.close() }, 10000);

    }

}


function stripslashes(str) {
    return (str + '').replace(/\\(.?)/g, function(s, n1) {
        switch (n1) {
            case '\\':
                return '\\';
            case '0':
                return '\u0000';
            case '':
                return '';
            default:
                return n1;
        }
    });
}
var msgNotif;
soundManager.setup({
    debugMode: false,
    onready: function() {
        msgNotif = soundManager.createSound({
            id: 'msgNotfif',
            url: '../sounds/dashboard-chat-notif.mp3'
        });
    },
    ontimeout: function() {}
});
var old_timestamp = null;
var waiting;
var getmessages;

function waitForMsg(firstLoad) {
    getmessages = $.ajax({
        type: "GET",
        url: "dashboard-chat-get.php",
        async: true,
        cache: false,
        success: function(data) {
            $("#chat-list").html("");
            var msg_array = eval('(' + data + ')');
            for (i = 0; i < msg_array.length; i++) {
                var chat_msg = '<span style="color:#E73030;">[' + msg_array[i].time + '] <b>' + msg_array[i].name + '</b></span>: ' + stripslashes(msg_array[i].message) + '<br />';
                $("#chat-list").append(chat_msg);
            }
            var new_timestamp = msg_array[msg_array.length - 1].timestamp;
            if (old_timestamp != new_timestamp && old_timestamp != null) {
                if (msg_array[msg_array.length - 1].user != loggedUser) {
                    msgNotif.play();
                    notifyMe(msg_array[msg_array.length - 1].name, stripslashes(msg_array[msg_array.length - 1].message));

                }
                $("#chat-list").animate({
                    scrollTop: $('#chat-list').prop("scrollHeight")
                }, "slow");
            }
            if (firstLoad == true) {
                $("#chat-list").animate({
                    scrollTop: $('#chat-list').prop("scrollHeight")
                }, 0);
            }
            old_timestamp = new_timestamp;
            waiting = setTimeout('waitForMsg()', 60000);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus != "abort") {
                console.log(textStatus + ": " + errorThrown);
                waiting = setTimeout('waitForMsg()', 3000);
            }
        }
    });
}
$(document).ready(function() {
    waitForMsg(true);
});
$(function() {
    $("#chat-form").submit(function(e) {
        e.preventDefault();
        clearTimeout(waiting);
        getmessages.abort();
        var msg_str = $("#chat-input").val();
        var input = $("#chat-input");
        var s  = '>';
        var split = input.val().split(s);
        var c = split[0];
        var v1 = split[1];
        var v2 = split[2];
        var v3 = split[3];
        var v4 = split[4];
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1;
        var year = currentDate.getFullYear();
        var date = day+'/'+month+'/'+year;

//vars end

        if(c+s=='changelog'+s)
        {
            if(v3!="1"){v3="0";}
            $.ajax({
                type: "POST",
                url: "changelog-set.php",
                async: true,
                cache: false,
                data: {
                    description: v1,
                    version: v2,
                    comingsoon: v3,
                    dateof: date

                },
                success: function(data) {
                    alert(data);
                    input.val("");
                    waitForMsg();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus + ": " + errorThrown);
                }
            });
            return false;
        }

        if(c+s=='announce'+s)
        {
            $.ajax({
                type: "POST",
                url: "staff-announcement.php",
                async: true,
                cache: false,
                data: {
                    dashboard_chat: true,
                    announcement: v1
                },
                success: function(data) {
                    alert(data);
                    input.val("");
                    waitForMsg();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus + ": " + errorThrown);
                }
            });
            return false;
        }

        if(c+s=='xp'+s)
        {
            if (v1 === undefined) {
                return false;
            }
            if (v2 === undefined) {
                return false;
            }
            if (v3 === undefined) {
                return false;
            }

            if(v1=="add"){
                v2 = parseInt(v2);
                ae8857b082115f203e8a5d23410461f7(v2, "StaffCommand", randomString(), "staff_add", "<h3>XP Given!</h3> %giver% gave %reciever% %xp%xp", v3);
                input.val("");
                return false;
            }
            if(v1=="remove"){
                v2 = parseInt("-"+v2);
                ae8857b082115f203e8a5d23410461f7(v2, "StaffCommand", randomString(), "staff_remove", "<h3>XP Removed!</h3> %giver% removed %xp%xp from %reciever%", v3);
                input.val("");
                return false;
            }
            else {
                return false;
            }
        }

        if(c+s=='command'+s)
        {
            eval(v1);
            input.val("");
            return false;
        }

        if(c==''){return false;}
        else {
            $("#chat-list").append('<span style="opacity:0.5;">Sending...</span><br />');
            $("#chat-list").animate({
                scrollTop: $('#chat-list').prop("scrollHeight")
            }, 0);
            $.ajax({
                type: "POST",
                url: "dashboard-chat-set.php",
                async: true,
                cache: false,
                data: {
                    msg_str: msg_str
                },
                success: function(data) {
                    waitForMsg();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus + ": " + errorThrown);
                }
            });
        }
        $("#chat-input").val("");
    });
});