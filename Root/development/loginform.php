<article id="login" class="container_24">
    <section class="grid_16 grid_0">
        <form class="redonwhite inputform">
            <h2>SIGN UP</h2>
            <p class="form_message">
                Not a member? Click the button below to sign up with <span>Game Shark Reviews</span>.
            </p>
            <p class="form_message" style="text-align:center;">
                <a class="button" id="signup_button" href="signup.php">SIGN UP</a>
                <button data-auth="facebook" class="social_login"><span class="smalltext">SIGN UP W/</span> <i class="fa fa-facebook" aria-hidden="true"></i></button>
                <button data-auth="twitter" class="social_login"><span class="smalltext">SIGN UP W/</span> <i class="fa fa-twitter" aria-hidden="true"></i></button>
                <button data-auth="google" class="social_login"><span class="smalltext">SIGN UP W/</span> <i class="fa fa-google-plus" aria-hidden="true"></i></button>
            </p>
        </form>
    </section>
    <section class="grid_8 grid_0">
        <form name="loginform" class="whiteonred inputform" id="loginform">
            <h2>LOGIN</h2>
            <p>
                <input id="usernameinput" name="username" type="text" placeholder="Username" required /><br>
                <label for="username"><a href="forgot.php?type=user">Forgot Username</a></label>
            </p>
            <p>
                <input id="passwordinput" name="password" type="password" placeholder="Password" required /><br>
                <label for="password"><a href="forgot.php?type=pass">Forgot Password</a></label>
            </p>
			<p>
                <input id="staylogged" name="staylogged" style="width:14px;height:14px;" type="checkbox"/><label for="staylogged">Remember me?</label>
            </p>
            <p>
                <button name="login" type="submit" id="loginbutton" style="display:inline-block;width:100px;cursor:pointer;">LOGIN</button>
                <button data-auth="facebook" class="social_login"><i class="fa fa-facebook" aria-hidden="true"></i></button>
                <button data-auth="twitter" class="social_login"><i class="fa fa-twitter" aria-hidden="true"></i></button>
                <button data-auth="google" class="social_login"><i class="fa fa-google-plus" aria-hidden="true"></i></button>
            </p>
            
            <p style="margin-top:-10px;" class="form_message">
                By signing in you agree with the <a target="_blank" href="User-Policy.php">GSR User Policy</a> and the <a target="_blank" href="Terms-And-Conditions.php">GSR Terms and Conditions</a>
            </p>
        </form>
    </section>
</article>
<style>
    .social_login{
        color:white;
    }
</style>