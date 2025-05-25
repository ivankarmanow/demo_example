<?php

require_once 'config.php';
require_once 'component.php';
require_once 'auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$pdo = Config::$pdo;
nav("requests");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback = $_POST["feedback"] ?? "";
    $req_id = $_POST["req_id"] ?? "";
    if (!empty($feedback) and !empty($req_id)) {
        $stmt = $pdo->prepare("UPDATE request SET feedback = ? WHERE id = ?");
        $stmt->execute([$feedback, $req_id]);
    }
}

$status = htmlspecialchars($_GET["status"] ?? "");
if (!in_array($status, array("new", "confirm", "cancel", "progress"))) {
    $status = "";
}

$sql = "SELECT * FROM request WHERE user_id = ?";
if ($status) {
    $sql .= " AND status = '$status'";
}
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION["id"]]);
$requests = $stmt->fetchAll();
?>

<h2 class="mb-4">Ваши заявки</h2>
<div class="row mb-4">
    <div class="col">
        <div class="btn-group-vertical">
            <a href="requests.php" class="btn btn-outline-primary <?= $status == "" ? "active" : "" ?>">Все</a>
            <a href="requests.php?status=new"
               class="btn btn-outline-primary <?= $status == "new" ? "active" : "" ?>">Новые</a>
            <a href="requests.php?status=progress"
               class="btn btn-outline-primary <?= $status == "progress" ? "active" : "" ?>">В работе</a>
            <a href="requests.php?status=confirm"
               class="btn btn-outline-primary <?= $status == "confirm" ? "active" : "" ?>">Подтверждённые</a>
            <a href="requests.php?status=cancel"
               class="btn btn-outline-primary <?= $status == "cancel" ? "active" : "" ?>">Отклонённые</a>
        </div>
    </div>
</div>
<div class="row">
    <?php if (empty($requests)) { ?>
        <div class="col">
            <div class="alert alert-info"><?= $status == "" ? "У вас пока нет заявок" : "У вас пока нет заявок с таким статусом" ?></div>
        </div>
    <?php } else {
    foreach ($requests

    as $request) {
    $status = $request->status;
    if ($status == "new") {
        $color = "primary";
        $st = "Новая";
    } elseif ($status == "confirm") {
        $color = "success";
        $st = "Принята";
    } elseif ($status == "progress") {
        $color = "warning";
        $st = "В работе";
    } elseif ($status == "cancel") {
        $color = "danger";
        $st = "Отклонена";
    }
    ?>
    <div class="col-md-4 mb-3">
        <div class="card card-anim bg-opacity-10 bg-<?= $color ?>">
            <div class="card-body">
                <p class="card-text">Дата доставки: <?= date("d/m/y H:i:s", strtotime($request->datetime)) ?></p>
                <p class="card-text">Тип груза: <?= $request->type ?></p>
                <p class="card-text">Создана: <?= date("d/m/y H:i:s", strtotime($request->created_at)) ?></p>
                <p class="card-text"><small class="text-muted">Статус: </small><span
                            class="badge bg-<?= $color ?>"><?= $st ?></span></p>
            </div>
            <?php if ($request->feedback) { ?>
                <div class="card-footer">
                    <p class="card-text">Ваш отзыв: <?= $request->feedback ?></p>
                </div>
            <?php } elseif ($status == "confirm") { ?>
                <div class="card-footer">
                    <form method="post">
                        <input type="hidden" name="req_id" id="req_id" value="<?= $request->id ?>">
                        <label class="form-label">Оставьте отзыв</label>
                        <textarea name="feedback" id="feedback" cols="30" rows="5"
                                  class="form-control" required style="resize: vertical"> </textarea>
                        <button class="btn btn-primary mt-2">Оставить отзыв</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php }
} ?>
</div>

<?php footer(); ?>

