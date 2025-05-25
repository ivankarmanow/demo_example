<?php

require_once "config.php";

$pdo = Config::$pdo;

session_start();
function login(string $login, string $password): string {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM user WHERE login = :login");
    $stmt->bindParam(":login", $login);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($result) {
        if (password_verify($password, $result->password)) {
            $_SESSION["id"] = $result->id;
            $_SESSION["name"] = $result->name;
            $_SESSION["is_admin"] = $result->is_admin;
            header("Location: index.php");
            exit;
        } else {
            return "Неверный пароль";
        }
    } else {
        return "Пользователь с таким логином не найден";
    }
}

function register(string $login, string $name, string $phone, string $email, string $password): bool {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO user (login, name, phone, email, password) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$login, $name, $phone, $email, password_hash($password, PASSWORD_DEFAULT)]);
}

function isLoggedIn(): bool {
    return isset($_SESSION["id"]);
}

function isAdmin(): bool {
    return isset($_SESSION["is_admin"]) and $_SESSION["is_admin"];
}