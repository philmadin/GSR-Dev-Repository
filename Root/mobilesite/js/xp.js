/**
 * Created by Daniel on 23/02/2016.
 */
function randomString() {
    var length = 50;
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
}
var xp_old = [];



    var getUser = function(){
        if (typeof u == 'undefined'){return atob("IA==");}else{
            return atob(u);
        }
    };

    function getXP(){
    $.ajax({
        type: "JSON",
        url: "http://gamesharkreviews.com/api/xp?user="+getUser(),
        async: true,
        cache: false,
        success: function(data) {
            var xp = data;
            $(".currentlevel").text(xp.current_level);
            $(".currentexp").text(xp.current_xp);
            $(".levelexp").text(xp.level_xp);
            if(xp_old.length>0){
                if(xp_old[xp_old.length - 1].current_level!=xp.current_level){
                    $(".expamount").animate({width: "100%"}, 2000, function(){
                        popup("Level Up", "<h3>Congratulations!</h3> You have levelled up and are now level "+xp.current_level);
                        $(".expamount").animate({width: "0%"}, 0, function(){
                            $(".expamount").animate({width: xp.level_percentage + "%"}, 2000);
                        });
                    });

                }
                else{
                    $(".expamount").animate({width: xp.level_percentage + "%"}, 2000);
                }
            }
            else{
                $(".expamount").animate({width: xp.level_percentage + "%"}, 2000);
            }

            xp_old.push(xp);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(textStatus + ": " + errorThrown);
        }
    });
}

function ae8857b082115f203e8a5d23410461f7(xp_amount, item_type, item_id, action_type, description, reciever){
    if (reciever === undefined) {
        reciever="null";
    }

    $.ajax({
        type: "POST",
        url: "../xp.php",
        async: true,
        cache: false,
        data: {
            xp_amount:xp_amount,
            item_type:item_type,
            item_id:item_id,
            action_type:action_type,
            description:description,
            reciever:reciever
        },
        success: function(data) {
            var status = data.split("@##$@");
            if(status[0]=="true") {
                popup("XP Rewarded", status[2]);
                getXP();
            }
            if(status[0]=="false"){
                console.log(data);
            }
            else{
                console.log(data);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(textStatus + ": " + errorThrown);
        }
    });
}


$(function(){
    getXP();
    ae8857b082115f203e8a5d23410461f7(100, "daily_login", null, "login", "<h3>Login Bonus!</h3> You have been rewarded %xp%xp.<br />Login everyday to get more xp!");
});