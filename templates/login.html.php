<div class="container">
    <div class="con">
    
        <form class="form form-colour-background" action="/login" method="POST">
            <h3>Woodlands University College</h3>
            <p class="secondary-title">Records Management Login</p>
            <input class="in" type="text" name="username" placeholder="Username" value="<?=$user['username'] ?? '' ?>">
            <input class="in" type="password" name="password" placeholder="Password">
            <p class='error'><?=$error ?? ''?></p>

            <!-- <button class="button">Login</button> -->
            <!-- <input id="login-button" class="button" type="submit" name="submit" value="Login"> -->
            <div class="logbutton">
            <!-- <input id="login-button" class="button" type="submit" name="loginsubmit" value="Login"> -->
            <input type="submit" name="loginsubmit" value="Login">
            </div>
        </form>
    </div>
</div>

<script>
    $("#login-button").click(function(event){
        event.preventDefault();

        $('form').fadeOut(500);

    })
</script>