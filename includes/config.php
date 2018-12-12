<?php

ob_start();

date_default_timezone_set('Africa/Johannesburg');

try {
    $con = new PDO('mysql:host=localhost;dbname=youtube_clone_db', 'root', '');
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}