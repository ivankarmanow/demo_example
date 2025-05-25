<?php

require_once "component.php";
require_once "config.php";
require_once "auth.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST["login"] ?? "");
    $password = $_POST["password"] ?? "";
    if (empty($_POST["login"]) || empty($_POST["password"]) || empty($_POST["conf"]) || empty($_POST["email"]) || empty($_POST["name"]) || empty($_POST["phone"])) {
        $error = "Заполните все поля";
    } else if ($_POST["password"] != $_POST["conf"]) {
        $error = "Пароли не совпадают";
    } else if (strlen($_POST["password"]) < 6) {
        $error = "Пароль должен быть длиннее 6 символов";
    } else if (strlen(strtolower($login)) < 3) {
        $error = "Логин должен быть длиннее 3 символов";
    } else {
        try {
            $res = register($_POST["login"], $_POST["name"], $_POST["phone"], $_POST["email"], $_POST["password"]);
            if (!$res) {
                $error = "Ошибка при создании пользователя";
            } else {
                login($login, $password);
            }
        } catch (PDOException $e) {
            $error = "Пользователь с таким логином уже существует";
        }
    }
}

nav("reg");

?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Регистрация</h3>
                <?php error($error); ?>
                <form method="post">
                    <label for="login" class="form-label mt-3">Имя</label>
                    <input type="text" name="name" id="name" class="form-control" required pattern="^[А-Яа-я]+ [А-Яа-я]+$">
                    <label for="login" class="form-label mt-3">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <label for="login" class="form-label mt-3">Номер телефона</label>
                    <input type="tel" name="phone" id="phone" value="+7 (" class="form-control" required>
                    <label for="login" class="form-label mt-3">Логин</label>
                    <input type="text" name="login" id="login" class="form-control" required pattern="^[-A-Za-z]{3,}$">
                    <label for="pwd" class="form-label mt-3">Пароль</label>
                    <input type="password" name="password" id="password" class="form-control" required minlength="6">
                    <label for="pwd" class="form-label mt-3">Пароль</label>
                    <input type="password" name="conf" id="conf" class="form-control" required minlength="6">
                    <button class="btn btn-primary w-100 mt-3">Зарегистрироваться</button>
                    <div class="text-center mt-3">
                        <a href="login.php">Вход</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(() => {
        function formatN(value) {
            let numbers = value.replace(/\D/g, '');
            numbers = numbers.substring(1);

            let formatted = '+7 (';
            if (numbers.length > 0) {
                formatted += numbers.substring(0, 3);
            }
            if (numbers.length >= 4) {
                formatted += ')-' + numbers.substring(3, 6);
            }
            if (numbers.length >= 7) {
                formatted += '-' + numbers.substring(6, 8);
            }
            if (numbers.length >= 9) {
                formatted += '-' + numbers.substring(8, 10);
            }
            return formatted
        }
        ph = $("#phone");
        ph.on("input", () => {
            let inp = ph.val();
            let formatted = formatN(inp);
            ph.val(formatted);
        })
    })
</script>

<?php footer(); ?>