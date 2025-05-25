<?php

require_once "config.php";
require_once "component.php";
require_once "auth.php";

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dt = $_POST["dt"] ?? "";
    $type = $_POST["type"] ?? "";
    if (empty($dt) or empty($type)) {
        $error = "Заполните все поля";
    } else {
        $pdo = Config::$pdo;
        $stmt = $pdo->prepare("INSERT INTO request (user_id, datetime, type) VALUES (?, ?, ?)");
        if ($stmt->execute([$_SESSION["id"], $dt, $type])) {
            $success = "Заявка отправлена!";
        } else {
            $error = "Ошибка при добавлении заявки";
        }
    }
}

nav("add");

?>
    <script>
        function onUpdate() {
            if (document.getElementById("type").value == "Мусор") {
                document.getElementById("al1").style.display = "block";
            } else {
                document.getElementById("al1").style.display = "none";
            }
        }
    </script>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Создать заявку на перевозку груза</h3>
                <?php error($error); ?>
                <?php success($success); ?>
                <form method="post">
                    <label for="dt" class="form-label mt-3">Дата доставки</label>
                    <input type="datetime-local" name="dt" id="dt" required class="form-control">
                    <label for="type" class="form-label mt-3">Тип груза</label>
                    <select name="type" id="type" class="form-select" oninput="onUpdate()">
                        <option value="Мебель">Мебель</option>
                        <option value="Мусор">Мусор</option>
                        <option value="Другое">Другое</option>
                    </select>
                    <div class="alert alert-info mt-3" style="display: none" id="al1">
                        При выборе типа груза Мусор стоимость будет увеличена в связи с необходимостью утилизации
                    </div>
                    <button class="btn btn-primary mt-3">Создать</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php footer(); ?>