<?php

require_once "component.php";
require_once "config.php";
require_once "auth.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["login"]) || empty($_POST["pwd"])) {
        $error = "Заполните все поля";
    } else {
        $error = login($_POST["login"], $_POST["pwd"]);
    }
}

nav("login");

?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Вход</h3>
                <?php error($error); ?>
                <form method="post">
                    <label for="login" class="form-label">Логин</label>
                    <input type="text" name="login" id="login" class="form-control" required
                           pattern="[-A-Za-z_0-9]{3,}">
                    <label for="pwd" class="form-label mt-3">Пароль</label>
                    <input type="password" name="pwd" id="pwd" class="form-control" required>
                    <button class="btn btn-primary w-100 mt-3">Войти</button>
                    <div class="text-center mt-3">
                        <a href="login.php">Регистрация</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>