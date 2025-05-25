<?php

require_once 'config.php';
require_once 'component.php';
require_once 'auth.php';

if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

nav("admin");

$pdo = Config::$pdo;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_st = $_POST["new_st"];
    $req_id = $_POST["req_id"];
    $stmt = $pdo->prepare("UPDATE request SET status = ? WHERE id = ?");
    $stmt->execute([$new_st, $req_id]);
}

$status = htmlspecialchars($_GET["status"] ?? "");
if (!in_array($status, array("new", "confirm", "cancel", "progress"))) {
    $status = "";
}
$sql = "SELECT r.id, r.datetime, r.feedback, r.type, r.status, r.created_at, u.name as username FROM request as r JOIN user as u ON r.user_id = u.id";
if ($status) {
    $sql .= " WHERE status = '$status'";
}
$stmt = $pdo->prepare($sql);
$stmt->execute();
$requests = $stmt->fetchAll();

?>

<h2 class="mb-4">Заявки пользователей</h2>
<div class="row mb-4">
    <div class="col">
        <div class="btn-group-vertical">
            <a href="admin.php" class="btn btn-outline-primary <?= $status == "" ? "active" : "" ?>">Все</a>
            <a href="admin.php?status=new"
               class="btn btn-outline-primary <?= $status == "new" ? "active" : "" ?>">Новые</a>
            <a href="admin.php?status=progress"
               class="btn btn-outline-primary <?= $status == "progress" ? "active" : "" ?>">В работе</a>
            <a href="admin.php?status=confirm"
               class="btn btn-outline-primary <?= $status == "confirm" ? "active" : "" ?>">Подтверждённые</a>
            <a href="admin.php?status=cancel"
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
        foreach ($requests as $request) {
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
                    <div class="card-header">
                        <p class="card-text">Пользователь: <span class="badge bg-info"><?= $request->username ?></span>
                        </p>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Дата
                            доставки: <?= date("d/m/y H:i:s", strtotime($request->datetime)) ?></p>
                        <p class="card-text">Тип груза: <?= $request->type ?></p>
                        <p class="card-text">Создана: <?= date("d/m/y H:i:s", strtotime($request->created_at)) ?></p>
                        <?php if ($request->feedback) { ?>
                            <p class="card-text">Отзыв: <?= $request->feedback ?></p>
                        <?php } ?>
                        <p class="card-text"><small class="text-muted">Статус: </small><span
                                    class="badge bg-<?= $color ?>"><?= $st ?></span></p>
                    </div>
                    <div class="card-footer">
                        <form method="post" action="admin.php?status=<?= $_GET['status'] ?? "" ?>">
                            <input type="hidden" name="req_id" value="<?= $request->id ?>">
                            <select name="new_st" id="new_st" class="form-select">
                                <option value="new">Новая</option>
                                <option value="progress">В работе</option>
                                <option value="confirm">Выполнена</option>
                                <option value="cancel">Отклонена</option>
                            </select>
                            <button class="btn btn-primary mt-2">Обновить статус</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php }
    } ?>
</div>

<?php footer(); ?>

