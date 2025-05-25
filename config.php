<?php

class Config {
    static PDO $pdo;
}

Config::$pdo = new PDO('mysql:host=localhost;dbname=pod3', 'root', 'root');
Config::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
Config::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
