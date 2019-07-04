<?php

if (isset($_POST['register'])) {
    require 'conn.inc.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    if (DB::query("SELECT username FROM users WHERE username=:username", array("username"=>$username))) {
        header('Location: ../register.php?error=user_taken');
        exit();
    }

    if ($email) {
        if (DB::query("SELECT email from users WHERE email=:email", array("email"=>$email))) {
            header('Location: ../register.php?error=email_taken');
            exit();
        }
    }

    if (strlen($username) < 3 && strlen($username) > 32) {
        echo "Username must be between 3 and 32 characters long!";
        exit();
    }

    if (!preg_match('/[a-zA-Z0-9]+/', $username)) {
        echo "Username may only contain letters and numbers!";
        exit();
    }

    if (strlen($password) < 6 && strlen($password) > 64) {
        echo "Password must be between 6 and 64 characters long!";
        exit();
    }

    if ($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email!";
            exit();
        }
    }
    
    if ($email) {
        DB::query("INSERT INTO users(username, password, email) VALUES(:username, :password, :email)", array("username"=>$username, "password"=>password_hash($password, PASSWORD_DEFAULT), "email"=>$email));
    } else {
        DB::query("INSERT INTO users(username, password) VALUES(:username, :password)", array("username"=>$username, "password"=>password_hash($password, PASSWORD_DEFAULT)));
    }
    echo "Success!";
    exit();
} else {
    header('Location: ../register.php?created=true');
    exit();
}