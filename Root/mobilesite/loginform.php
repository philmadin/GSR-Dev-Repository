<li class="dropdown" id="user-nav">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size:14px;">
        Login
        <span class="fa fa-caret-down"></span>
    </a>
    <ul class="dropdown-menu" style="color:black;">
        <li>
            <div class="navbar-login">
                <div class="row">
                    <div class="col-lg-12">
                        <form name="loginform" class="inputform" role="form" id="loginform">
                            <div class="form-group">
                                <input id="usernameinput" class="form-control" name="username" type="text" placeholder="Username" required />
                                <label for="username"><a href="forgot.php?type=user">Forgot Username</a></label>
                            </div>
                            <div class="form-group">
                                <input id="passwordinput" class="form-control" name="password" type="password" placeholder="Password" required />
                                <label for="password"><a href="forgot.php?type=pass">Forgot Password</a></label>
                            </div>
                            <div class="checkbox">
                                <label><input id="staylogged" name="staylogged" style="width:14px;height:14px;" type="checkbox"/> Remember me</label>
                            </div>
                            <button name="login" class="btn btn-default" type="submit" id="loginbutton">LOGIN</button>
                            <p style="margin-top:15px;" class="form_message">
                                By signing in you agree with the <a target="_blank" href="User-Policy.php">GSR User Policy</a> and the <a target="_blank" href="Terms-And-Conditions.php">GSR Terms and Conditions</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </li>
        <li class="divider"></li>
        <li>
            <div class="navbar-login navbar-login-session">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="text-center">
                            <button data-auth="facebook" class="social_login btn btn-primary"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></button>
                            <button data-auth="twitter" class="social_login btn btn-info"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></button>
                            <button data-auth="google" class="social_login btn btn-warning"><i class="fa fa-google-plus fa-2x" aria-hidden="true"></i></button>
                        </p>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>

<style>
    .social_login[data-auth="facebook"]{
        background-color:rgb(59, 89, 152);
    }

    .social_login[data-auth="twitter"]{
        background-color:rgb(0, 172, 237);
    }

    .social_login[data-auth="google"]{
        background-color:rgb(221, 75, 57);
    }




    .social_login[data-auth="facebook"]:hover, .social_login[data-auth="facebook"]:active, .social_login[data-auth="facebook"]:focus{
        background:rgba(59, 89, 152, .7) !important;
    }

    .social_login[data-auth="twitter"]:hover, .social_login[data-auth="twitter"]:active, .social_login[data-auth="twitter"]:focus{
        background:rgba(0, 172, 237, .7) !important;
    }

    .social_login[data-auth="google"]:hover, .social_login[data-auth="google"]:active, .social_login[data-auth="google"]:focus{
       background:rgba(221, 75, 57, .7) !important;
    }
</style>