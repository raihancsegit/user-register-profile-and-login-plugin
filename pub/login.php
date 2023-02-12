<div class="login-form">
    <h2>Login Form</h2>
    <form action="<?php echo get_the_permalink();?>" method="post">
        Username: <input type="text" name="username" />
        Password: <input type="password" name="pass" />
        <input type="submit" name="user_login" value="Login" />
    </form>
</div>