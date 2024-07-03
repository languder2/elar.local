<?php if(!empty($header)) echo $header;?>
    <form name="authForm" action="/admin" method="post" class="w-25 mx-auto" style="margin-top: 30vh;">
        <h3 class="text-center">Авторизация</h3>
        <?php if(!empty($ErrorMessage)):?>
            <div class="alert alert-danger text-center mt-3" role="alert">
                <?=$ErrorMessage?>
            </div>
        <?php endif;?>
        <label for="inputLogin" class="form-label mt-1">Login</label>
        <input type="text" id="inputLogin" class="form-control" name="authForm[login]" value="<?=$form['login']??""?>">
        <label for="inputPassword" class="form-label mt-1">Password</label>
        <input type="password" id="inputPassword" class="form-control" name="authForm[password]">
        <div class="text-center">
            <input type="submit" name="authForm[enter]" class="btn btn-primary mt-3 w-50" value="Войти">
        </div>
    </form>
<?php if(!empty($footer)) echo $footer;?>
