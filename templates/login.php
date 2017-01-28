<div class="container" style="width: 400px;">
    <h2>Login</h2>
    <form action="/" method="post">
        <div class="form-group">
            <label for="usr">Name:</label>
            <input type="text" name="username" class="form-control" id="usr" value=""/>
        </div>
        <div class="form-group">
            <label for="pwd">Passwort:</label>
            <input type="password" name="passwort" class="form-control" id="pwd" value=""/>
        </div>
        <div class="forum-group">
            <input type="checkbox" name="remember-me" value="1" id="remember" />
            <label for="remember">Eingeloggt bleiben?</label>
        </div>
        <button type="submit" class="btn btn-default" id="send">Submit</button>
    </form>
</div>