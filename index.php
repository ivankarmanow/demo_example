<?php

require_once "config.php";
require_once "component.php";
require_once "auth.php";

nav("index");

?>
<h1 class="mb-4">Приветствуем на сайте компании Грузоперевозки.ру!</h1>
<?php if (isLoggedIn()) : ?>
    <div class="btn-group">
        <a href="requests.php" class="btn btn-primary">Мои заявки</a>
        <a href="add.php" class="btn btn-outline-primary">Создать заявку</a>
    </div>
<?php else: ?>
    <div class="btn-group">
        <a href="login.php" class="btn btn-primary">Войти</a>
        <a href="reg.php" class="btn btn-outline-primary">Зарегистрироваться</a>
    </div>
<?php endif;
footer();
?>
