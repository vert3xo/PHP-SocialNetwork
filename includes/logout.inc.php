<?php
require 'conn.inc.php';
require 'check.inc.php';
if (isset($_POST['logout'])) {
    if (Login::isLoggedIn()) {
        if (isset($_POST['alldevices'])) {
            DB::query("DELETE FROM login_tokens WHERE user_id=:id", array("id"=>Login::isLoggedIn()));
        }  else {
            DB::query("DELETE FROM login_tokens WHERE token=:token", array("token"=>hash("sha256", $_COOKIE['SESSION'])));
        }
        setcookie("SESSION", "1", time() - 3600);
        setcookie("SESSION_", "1", time() - 3600);
        header('Location: ../index.php');
        exit();
    } else {
        header('Location: ../logout.php');
        exit();
    }
} else {
    header('Location: ../logout.php');
    exit();
}