var curSocialUser = false;
var curSocialAuth = false;
$(document).ready(function() {

    $('#ajaxpreloader').hide();

    $('#ajaxpreloader')
    .ajaxStart(function(){
        $(this).show();
    }).ajaxStop(function(){
        $(this).hide();
    });

    $("#pressi").ready(function() {
        $.ajax({
            url : "featured_articles.php",
            async : false,
            error : function(err) {
                alert(err);
            },
            success : function(ft_articles) {
                $("#pressi_data").html(ft_articles);

                $(".interaction").each(function() {
                    var interIndex = $(this).attr("id").replace("id","");
                    $("#pagination").append("<a class='pag' id='id" + interIndex + "'></a>");
                    $(".pag#id1").addClass("active");
                    $(".interaction#id1").addClass("islive");
                    $(".interaction:not(.islive)").hide();

                    var headings = $(this).find("h1");

                    if(headings.text().length > 18) {
                        headings.css({"font-size":"400%", "top":"180px"});
                    }
                });

                $(document).mousemove(function (event) {
                    var Xdeg = 0;
                    var Ydeg = 0;
                    Ydeg = (event.pageX * 2) / ($(document).width() / 2);            
                    Xdeg = (event.pageY * 2) / ($(document).height() / 2);
                    $('.ftBG').each(function() {
                        $(this).css('transform', 'translateZ(-100px) perspective(600px) rotateY(' + Ydeg + 'deg) rotateX(' + Xdeg + 'deg)');
                    });
                });
            }
        });

        var loaderMS    = 4000; // IN MILLISECONDS || MUST CHANGE '#pressi #pressi-loader.loading' ANIMATION IN CSS
        var goalWidth   = $("#pressi").find(".left_side").width();
        var currIndex;
        var nextIndex;
        var pressiAction;

        var pressiImage = function() {
            currIndex = $(".islive").attr("id").replace("id","");
            nextIndex = Math.round(parseInt(currIndex) + 1);
            if(currIndex == $(".pag").length) {
                $("#pressi-loader").removeClass("loading");
                $(".interaction").removeClass("islive").fadeOut("fast");
                $(".interaction#id1").addClass("islive").fadeIn("slow");
                $(".pag").removeClass("active");
                $(".pag#id1").addClass("active");
                $("#pressi-loader").addClass("loading");
            } else {
                $("#pressi-loader").removeClass("loading");
                $(".interaction").fadeOut("fast").removeClass("islive");
                $(".interaction#id" + nextIndex).addClass("islive").fadeIn("slow");
                $(".pag").removeClass("active");
                $(".pag#id" + nextIndex).addClass("active");
                $("#pressi-loader").addClass("loading");
            }
        }

        $("#pressi-loader").addClass("loading");

        pressiAction = setInterval(pressiImage,loaderMS);

        $(".pressi-info").on("click", function() {
            if($(this).hasClass("userenabled")) {
                $(this).removeClass("userenabled");
                $(".content_overlay").html("").removeClass("showcontents");
                pressiAction = setInterval(pressiImage,loaderMS);
                $("#pressi-loader").addClass("loading");
            } else {
                clearInterval(pressiAction);
                $("#pressi-loader").removeClass("loading");
                $.ajax({
                    url : "pressi_get_more.php?article_type=" + $(this).attr("data-article-type") + "&article_id=" + $(this).attr("data-article-id") + "&article_user=" + $(this).attr("data-article-user"),
                    async : false,
                    success : function(returnedInfo) {
                        pressiHTML = returnedInfo;
                    }
                });
                $(this).addClass("userenabled");
                var attrs = ".content_overlay[data-article-type=" + $(this).attr("data-article-type") + "][data-article-id=" + $(this).attr("data-article-id") + "][data-article-user=" + $(this).attr("data-article-user") + "]";
                $(attrs).html(pressiHTML).addClass("showcontents");
            }
        });

        $(".pag").on("click", function() {
            $("#pressi-loader").removeClass("loading");
            var getID = parseInt($(this).attr("id").replace("id",""));
            $(".pag").removeClass("active");
            $(this).addClass("active");
            $(".islive").fadeOut("fast").removeClass("islive");
            $(".interaction#id" + getID).addClass("islive").fadeIn("slow");
            clearInterval(pressiAction);
            pressiAction = setInterval(pressiImage,loaderMS);
            $("#pressi-loader").addClass("loading");
            
            $(".pressi-info").each(function() {
                $(".content_overlay").removeClass("showcontents");
                $(this).removeClass("userenabled");
            });
        });
    });

  	$("#owl-demo").owlCarousel({
    	items : 4,
    	navigation : true,
    	navigationText : ["<",">"],
    	responsive : false
	});

	$("#exclusive").owlCarousel({
    	items : 3,
    	navigation : false,
    	responsive : true,
    	autoPlay: true,
    	singleItem: true
	});

  	$(document).on('mousemove', function(e){
	    $('#gooshape').css({
	       "transform" : "skewX(" + e.pageX / 35 + "deg) translate(" + e.pageX * 0.03 + "px,0)"
	    });
	});

    if($('#usermenu').length) {
        var YStart = $('#usermenu').offset().top;

        $(window).scroll(function() {
            var YStop = $(this).scrollTop();

            if (YStop >= YStart)
                $('#usermenu').addClass('fixed');
            else
                $('#usermenu').removeClass('fixed');

            $('#usermenu').width($('#usermenu').parent().width());
        });
    }

    $("#expamount").css({
        "width" : $("#expamount").attr("data-exp-amount") + "%"
    });

    $("input[name='min_rating']").change(function() {
        if($(this).val() == '10') {
            $("#rating_value").text($(this).val());
        } else {
            $("#rating_value").text($(this).val() + ".0");
        }
    });

    function addFish(shark) {
        return $(".about_section-" + shark).before('<div id="' + shark + '_fish" class="fish_swarm"></div>');
    }

    function positionFish(shark) {
        return $("#" + shark + "_fish").css("top" , ($(".about_section-" + shark).offset().top - 100) + "px");
    }

    //setTimeout(addFish("hammerhead"), 0);
    //setTimeout(addFish("thresher"), 0);
    //setTimeout(addFish("greatwhite"), 0);
    //setTimeout(addFish("bigredjelly"), 0);

    //jQuery(window).on("scroll resize load", function() {
        //positionFish("hammerhead");
        //positionFish("thresher");
        //positionFish("greatwhite");
        //positionFish("bigredjelly");
    //});

    $("#login").css("display","block").slideToggle(0);

    $(".live").click(function() {
        $("#login").slideToggle(600);
    });

    var verifyURL = "check_validation.php";

    $("#loginform").validate({
        ignore: [],
        rules: {
            username: {
                required: true,
                remote: verifyURL
            },
            password: {
                required: true
            }
        },
        messages: {
            username: {
                required: "Enter both your username and password.",
                remote: "Please verify your email before signing in."
            },
            password: "Enter both your username and password."
        },
        errorElement: "div",
        errorClass: "loginmessage",
        errorPlacement: function(error, element) {
            error.appendTo('#loginform');
        },
        submitHandler: function(form) {
            var loginurl = "signin.php";
            var logindata = $("#loginform").serialize();

            if(curSocialAuth!=false && curSocialUser!=false){
                logindata = "user="+btoa(JSON.stringify(curSocialUser))+"&auth_type="+curSocialAuth+"&"+logindata;
            }

            $.ajax({
                url : loginurl,
                type : "GET",
                dataType: "html",
                data: logindata,
                async : false,
                success: function(response) {

                    if(response == "fail") {
                        $("<div class='loginmessage'>Either your username or password is incorrect.</div>").appendTo('#loginform');
                    } else {
                        location.reload();
                    }
                },
                beforeSend: function() {
                    if($("#passwordinput").val() == "" || $("#usernameinput").val() == "") {
                        $("<div class='loginmessage'>Enter both your username and password.</div>").appendTo('#loginform');
                        return false;
                    }
                }
            });
        }
    });

    $("#cruncher").click(function() {

        var cruSENDER       = "from=" + $("#dataholder").attr("data-crunch-sender") + "&";
        var cruRECEIVER     = "to=" + $("#dataholder").attr("data-crunch-receiver") + "&";
        var cruMESSAGE      = "message=" + $("#crunch_message").val();

        var cruURL = "crunch.php?" + cruSENDER + cruRECEIVER + cruMESSAGE.replace(/[\*\^\'\!]/g, '');

        $.ajax({
            url : cruURL,
            type : "GET",
            async : false,
            success: function() {
                location.reload();
            },
            beforeSend: function() {
                if($("#crunch_message").val() == "") {
                    $("<div id='errormessage'>Please enter a message.</div>").appendTo('#crunchForm');
                    return false;
                }
            }
        });

    });

    $(".unlive").click(function(e) {

        $.ajax({
            url : "logout.php",
            success: function() {
                location.reload();
            }
        });

    });



    $("#loginform input").each(function(index, el) {
        $(this).focus(function(event) {
            $("#loginmessage").remove();
        });
    });
    

    $(".shark_pic").each(function() {
        if($(this).attr('data-shark-picture') == "default") {
            $(this).css("background-image", "url(imgs/users/default-116x135.jpg)");
        } else {
            $(this).css("background-image", "url(imgs/users/" + $(this).attr('data-shark-picture') + "-116x135.jpg)");
        }
    });

    $(".sharkface").each(function() {
        if($(this).attr('data-shark-picture') == "default") {
            $(this).css("background-image", "url(imgs/users/default-232x270.jpg)");
        } else {
            $(this).css("background-image", "url(imgs/users/" + $(this).attr('data-shark-picture') + "-232x270.jpg)");
        }
    });

    $("#userpp").each(function() {
        if($(this).attr('data-shark-picture') == "default") {
            $(this).css("background-image", "url(imgs/users/default-116x135.jpg)");
        } else {
            $(this).css("background-image", "url(imgs/users/" + $(this).attr('data-shark-picture') + "-116x135.jpg)");
        }
    });

    var profileLovesCONSOLE = $("#profileconsole").text();

    var profileCONSOLE = profileLovesCONSOLE.replace("Loves ","");

    var ARR_xbox = ['Xbox', 'Xbox 360', 'Xbox One'];
    var ARR_play = ['PlayStation', 'PlayStation 2', 'PlayStation Portable', 'PlayStation 3', 'PlayStation Vita', 'PlayStation 4'];
    var ARR_comp = ['Steam', 'PC'];
    var ARR_ntdo = ['Game &amp; Watch', 'Nintendo Entertainment System (NES)', 'Game Boy', 'Super Nintendo Entertainment System (SNES)', 'Nintento 64', 'Nintendo GameCube', 'Game Boy Advance', 'Nintendo DS', 'Wii', 'Nintendo 3DS', 'Wii U'];

    if(jQuery.inArray(profileCONSOLE, ARR_xbox) !== -1) {
        $("#lovesicon").addClass("xbox");
    } else if(jQuery.inArray(profileCONSOLE, ARR_play) !== -1) {
        $("#lovesicon").addClass("play");
    } else if(jQuery.inArray(profileCONSOLE, ARR_comp) !== -1) {
        $("#lovesicon").addClass("comp");
    } else if(jQuery.inArray(profileCONSOLE, ARR_ntdo) !== -1) {
        $("#lovesicon").addClass("ntdo");
    }

});

$(function(){
			$('#bite-help').magnificPopup({
		  items: {
			  src: "<div class='help-popup'><h3>What's this?</h3>GSR's 'Bites' button resembles whether the viewer likes or agrees with the article/video. This function promotes the article/video and gives credit to the author.</div>",
			  type: 'inline'
		  },
		  closeBtnInside: true
		});
	
		$('#disqus-help').magnificPopup({
		  items: {
			  src: "<div class='help-popup'><h3>What's this?</h3>Disqus is a comment section that allows you to post your input on an article, aswell as let the author know your opinion on it. <br /><br />Disqus comment section not showing? Clear both your browser's cache and cookies.<br /> If it's still not showing then visit the <a target='_blank' href='https://help.disqus.com/customer/portal/articles/466227-why-isn-t-the-comment-box-loading-'>Disqus</a> website for more information.</div>",
			  type: 'inline'
		  },
		  closeBtnInside: true
		});
});

function parallaxScroll(){
    var scrolled = $(window).scrollTop();
    $('.parallax').css('top',(0-(scrolled*1.5))+'px');
}
function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}

function changeUrlParam (param, value) {
    var currentURL = window.location.href+'&';
    var change = new RegExp('('+param+')=(.*)&', 'g');
    var newURL = currentURL.replace(change, '$1='+value+'&');

    if (getURLParameter(param) !== null){
        try {
            window.history.replaceState('', '', newURL.slice(0, - 1) );
        } catch (e) {
            console.log(e);
        }
    } else {
        var currURL = window.location.href;
        if (currURL.indexOf("?") !== -1){
            window.history.replaceState('', '', currentURL.slice(0, - 1) + '&' + param + '=' + value);
        } else {
            window.history.replaceState('', '', currentURL.slice(0, - 1) + '?' + param + '=' + value);
        }
    }
}



var dialogNum = 0;
function popup(title, text){
    dialogNum++;
    var dialogDiv = '<div class="dialogDiv" id="dialog-'+dialogNum+'" title="'+title+'"><p class="description">'+text+'</p></div>';
    $("body").append(dialogDiv);

    $( "#dialog-"+dialogNum ).dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        draggable: false,
        show: {
            effect: "puff",
            duration: 300
        },
        hide: {
            effect: "puff",
            duration: 300
        }
    });
    $( "#dialog-"+dialogNum ).parent().css({position:"fixed"}).end().dialog( "open" );
}



























//SOCIAL LOGIN

function authUser(user, auth_type){
    var user_info = JSON.stringify({
        displayName: user.displayName,
        email: user.email,
        emailVerified: user.emailVerified,
        photoURL: user.photoURL,
        isAnonymous: user.isAnonymous,
        uid: user.uid,
        refreshToken: user.refreshToken,
        providerData: user.providerData
    });

    var this_auth_type = auth_type;


    $.post("social_auth.php", {
        user: user_info,
        auth_type: this_auth_type
    }, function(data){

        data = JSON.parse(data);
        user = JSON.parse(data.user);


        if(data.success==true){
            document.location = data.redirect;
        }
        if(data.success==false){
            curSocialUser = user;
            curSocialAuth = auth_type;
            popup("Link Account", "<h4><span class='auth-type'>"+auth_type+"</span> account not linked.</h4>To link it to an existing account on GSR <a class='social-link' href='javascript: socialLink();'>Login Now</a><br /><br />To create a new account on GSR <a class='social-link' href='javascript: socialRegister();'>Click Here</a><br />");
        }


    });

}

function socialLink(){
    var user = curSocialUser;
    var auth_type = curSocialAuth;
    if(auth_type!=false && user!=false){
        $("<div class='loginmessage'>Login to link your <span class='auth-type'>"+auth_type+"</span> account.</div>").appendTo('#loginform');
        $(".ui-dialog-content").dialog("close");
    }
}

function socialRegister(){
    var user = curSocialUser;
    var auth_type = curSocialAuth;
    if(auth_type!=false && user!=false){
        $(".ui-dialog-content").dialog("close");
        var userdata = "user="+btoa(JSON.stringify(user))+"&auth_type="+auth_type;
        document.location = "signup.php?"+userdata;
    }
}

var socialLogin = {
    facebook: function(){
        var provider = new firebase.auth.FacebookAuthProvider();
        provider.addScope('user_birthday');
        provider.addScope('email');
        provider.addScope('public_profile');
        firebase.auth().signInWithPopup(provider).then(function(result) {
            var token = result.credential.accessToken;
            var user = result.user;
            authUser(user, "facebook");
        }).catch(function(error) {
            var errorCode = error.code;
            var errorMessage = error.message;
            var email = error.email;
            var credential = error.credential;
            if (errorCode === 'auth/account-exists-with-different-credential') {
                alert('You have already signed up with a different auth provider for that email.');
            } else {
                console.error(error);
            }
        });
    },
    twitter: function() {
        var provider = new firebase.auth.TwitterAuthProvider();
        firebase.auth().signInWithPopup(provider).then(function(result) {
            var token = result.credential.accessToken;
            var secret = result.credential.secret;
            var user = result.user;
            authUser(user, "twitter");
        }).catch(function(error) {
            var errorCode = error.code;
            var errorMessage = error.message;
            // The email of the user's account used.
            var email = error.email;
            // The firebase.auth.AuthCredential type that was used.
            var credential = error.credential;
            // [START_EXCLUDE]
            if (errorCode === 'auth/account-exists-with-different-credential') {
                alert('You have already signed up with a different auth provider for that email.');
            } else {
                console.error(error);
            }
        });
    },
    google: function(){
        var provider = new firebase.auth.GoogleAuthProvider();
        provider.addScope('https://www.googleapis.com/auth/plus.login');
        provider.addScope('https://www.googleapis.com/auth/userinfo.email');
        provider.addScope('https://www.googleapis.com/auth/userinfo.profile');

        firebase.auth().signInWithPopup(provider).then(function(result) {
            var token = result.credential.accessToken;
            var user = result.user;
            authUser(user, "google");
        }).catch(function(error) {
            var errorCode = error.code;
            var errorMessage = error.message;
            var email = error.email;
            var credential = error.credential;
            if (errorCode === 'auth/account-exists-with-different-credential') {
                alert('You have already signed up with a different auth provider for that email.');
            } else {
                console.error(error);
            }
        });
    }
};

$(function(){

    $(".social_login").click(function(e){
        e.preventDefault();
        var auth_type = $(this).attr("data-auth");


        switch (auth_type) {
            case "facebook":
                socialLogin.facebook();
                break;
            case "twitter":
                socialLogin.twitter();
                break;
            case "google":
                socialLogin.google();
                break;
        }

    });
});
