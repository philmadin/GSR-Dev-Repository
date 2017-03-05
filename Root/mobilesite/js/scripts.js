var curSocialUser = false;
var curSocialAuth = false;

$(function(){
    $(window).resize(function(){resize();});
    resize();
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
});

function resize(){
    var wh = $(window).height()-70;
    $("html, body, #page").height(wh);
}

var dialogNum = 0;
function popup(title, text){
    dialogNum++;
    var dialogDiv = '<div class="modal fade" id="customModal_'+dialogNum+'" role="dialog"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title">'+title+'</h4> </div> <div class="modal-body"> '+text+' </div> <div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> </div> </div> </div> </div>';
    $("body").append(dialogDiv);

    $("#customModal_"+dialogNum).modal();
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
        $('.modal').modal('hide');
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


