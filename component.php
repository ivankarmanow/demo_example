<?php

require_once "auth.php";

function isActive(string $link, string $active): string
{
    if ($link === $active) {
        return "active";
    } else {
        return "";
    }
}

function nav(string $active)
{
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
              crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <title>Главная</title>
        <style>

            .card-anim {
                transition: transform 0.4s ease-in-out, box-shadow 0.4s;
            }

            .card-anim:hover {
                transform: translateY(-10px);
                box-shadow: var(--bs-secondary-bg) 10px 10px 8px;
            }

            html, body {
                height: 100%;
            }

            body {
                display: flex;
                flex-direction: column;
            }

            footer {
                flex-shrink: 0;
            }
        </style>
    </head>
    <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <div class="container">
            <a href="index.php" class="navbar-brand">Грузоперевозки.ру</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nvb"
                    aria-controls="nvb" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse justify-content-end" id="nvb">
                <div class="navbar-nav">
                    <a class="nav-link <?= isActive("index", $active) ?>" href="index.php">Главная</a>
                    <?php if (isLoggedIn()): ?>
                        <a class="nav-link <?= isActive("requests", $active) ?>" href="requests.php">Мои заявки</a>
                        <a class="nav-link <?= isActive("add", $active) ?>" href="add.php">Создать заявку</a>
                        <a class="nav-link" href="logout.php">Выйти</a>
                    <?php else: ?>
                        <a href="login.php" class="nav-link <?= isActive("login", $active) ?>">Вход</a>
                        <a href="reg.php" class="nav-link <?= isActive("reg", $active) ?>">Регистрация</a>
                    <?php endif; ?>
                    <?php if (isAdmin()): ?>
                        <a href="admin.php" class="nav-link <?= isActive("admin", $active) ?>">Админ-панель</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
    <?php
}

function footer()
{
    ?>
    </div>
    <footer class="bg-dark text-white mt-auto" style="height: 150px;">
        <div class="container h-100 align-content-center">
                <div class="text-center fs-4 mb-3">&copy; Грузоперевозки.ру <?= date('Y') ?></div>
                <div class="row text-center link-opacity-75 link-offset-3 link-underline link-underline-opacity-0">
                    <div class="col">
                        <a href="index.php" class="link-light link-opacity-100-hover link-underline-opacity-75-hover">Главная</a>
                    </div>
                    <div class="col">
                        <a href="requests.php" class="link-light link-opacity-100-hover link-underline-opacity-75-hover">Заявки</a>
                    </div>
                    <div class="col">
                        <a href="add.php" class="link-light link-opacity-100-hover link-underline-opacity-75-hover">Новая заявка</a>
                    </div>
                </div>
            </div>
    </footer>
    </body>
    </html>
    <?php
}

function error(string $error)
{
    if ($error) {
        ?>
        <div class="alert alert-danger alert-dismissible">
            <div><?= htmlspecialchars($error) ?></div>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php
    }
}

function success(string $success)
{
    if ($success) {
        ?>
        <div class="alert alert-success alert-dismissible">
            <div><?= htmlspecialchars($success) ?></div>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php
    }
}