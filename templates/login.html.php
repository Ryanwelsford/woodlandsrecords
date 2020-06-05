<div class="container">
    <div class="con">
        <form class="form" action="#" method="POST">
            <input class="in" type="text" name="username" placeholder="Username">
            <input class="in" type="password" name="password" placeholder="Password">
            <!-- <button class="button">Login</button> -->
            <!-- <input id="login-button" class="button" type="submit" name="submit" value="Login"> -->
            <div class="logbutton">
            <input id="login-button" class="button" type="submit" name="submit" value="Login">
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