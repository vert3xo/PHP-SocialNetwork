<?php
require 'includes/conn.inc.php';
require 'includes/check.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vert3xo</title>
</head>
<body>
    <?php
    if (Login::isLoggedIn()) {
        $user_id = DB::query("SELECT user_id FROM login_tokens WHERE token=:token", array("token"=>hash("sha256", $_COOKIE['SESSION'])))[0][0];
        $username = DB::query("SELECT username FROM users WHERE id=:id", array("id"=>$user_id))[0][0];
        echo "Welcome " . $username;
        
    } else {
        echo "Under construction!";
    }
    ?>
</body>
</html>