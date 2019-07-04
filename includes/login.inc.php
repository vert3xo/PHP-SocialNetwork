<?php
if (isset($_POST['login'])) {
    require 'conn.inc.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!DB::query("SELECT username FROM users WHERE username=:username", array("username"=>$username))) {
        header('Location: ../login.php?error=invalid_credentials');
        exit();
    } else if (DB::query("SELECT username FROM users WHERE username=:username", array("username"=>$username))) {
        if (!password_verify($password, DB::query("SELECT password FROM users WHERE username=:username", array("username"=>$username))[0][0])) {
            header('Location: ../login.php?error=invalid_credentials');
            exit();
        } else if (password_verify($password, DB::query("SELECT password FROM users WHERE username=:username", array("username"=>$username))[0][0])) {
            $cstrong = true;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            $user_id = DB::query("SELECT id FROM users WHERE username=:username", array("username"=>$username))[0][0];
            DB::query("INSERT INTO login_tokens(token, user_id) VALUES(:token, :user_id)", array("token"=>hash('sha256', $token), "user_id"=>$user_id));
            setcookie("SESSION", $token, time() + 60 * 60 * 5, '/', null, null, true);
            setcookie("SESSION_", '1', time() + 60 * 60 * 4, '/', null, null, true);
            header('Location: ../index.php');
            exit();
        }
    } else {
        header('Location: ../login.php?error=error');
        exit();
    }
} else {
    header('Location: ../login.php');
    exit();
}