var elem = function(){
    return {
        container: $("#bonus"),
        water: $("#water"),
        shark: $("#shark"),
        chests: $("#chests")
    }
};

var settings = function(){
    return {
        chestTiming: 100
    }
};

var bonus = {

    shuffle: function(array) {
        var currentIndex = array.length, temporaryValue, randomIndex;

        // While there remain elements to shuffle...
        while (0 !== currentIndex) {

            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            // And swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

        return array;
    },

    ran: function(low, high){return Math.floor((Math.random() * high) + low);},
    float: {
        up: function($thiselem){
            $thiselem.animate({bottom:'-'+bonus.ran(10, 15)+'px'}, bonus.ran(1000, 1500), function(){
                bonus.float.down($thiselem);
            });
        },
        down: function($thiselem){
            $thiselem.animate({bottom:'0'}, bonus.ran(1000, 1500), function(){
                bonus.float.up($thiselem);
            });
        }
    },

    startFloat: function($thiselem){
        bonus.float.up($thiselem);
    },


    loadChests: function(){

        bonus.chests.count = bonus.chests.length;

        bonus.shuffle(bonus.chests);

        for (var i = 0; i < bonus.chests.count; i++) {
            var chest = bonus.chests[i];
            elem().chests.append('<div data-index= "'+i+'" data-frame="1" style="display:none;" id="chest-'+i+'" class="chest"></div>');
            var index = i;


            bonus.chests[index].elem = $('#chest-'+index);

            bonus.startFloat(bonus.chests[index].elem);

            bonus.chests[index].elem.show().click(function(){
                bonus.chestClick($(this).attr("data-index"));
            });

        }

        elem().chests.show("drop", {direction: "up"}, 1000);

    },


    chestClick: function(num) {
        for (var i = 0; i < bonus.chests.count; i++) {
            bonus.chests[i].elem.unbind("click");
        }
        bonus.chests[num].elem.attr("data-frame", 2);
        setTimeout(function(){
            bonus.chests[num].elem.attr("data-frame", 3);

            setTimeout(function(){
                bonus.chests[num].elem.attr("data-frame", 4);

                setTimeout(function(){
                    bonus.prizeDisplay(num);
                }, settings().chestTiming);

            }, settings().chestTiming);

        }, settings().chestTiming);
    },

    prizeDisplay: function(num){

        if(bonus.chests[num].type=="tokens"){
            alert("Congratulations! You have won: " + bonus.chests[num].int + " tokens.");
        }
        if(bonus.chests[num].type=="xp"){
            alert("Congratulations! You have won: " + bonus.chests[num].int + "xp.");
        }
        if(bonus.chests[num].type=="card"){
            alert("Congratulations! You have won: Card " + bonus.chests[num].int + "");
        }

    },


    load: function(u, c){
        bonus.chests = c;
        bonus.u = atob(u);

        elem().water.show("fade", {direction: "down"}, 1500, function(){bonus.loadChests();});
    },

    init: function(u, c){
        bonus.load(u, c);
    }
};