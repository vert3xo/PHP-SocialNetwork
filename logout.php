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
    <title>Log out</title>
</head>
<body>
<?php
if (Login::isLoggedIn()) {
    echo '<h1>Do you really want to log out?</h1>
    <form action="includes/logout.inc.php" method="post">
        <p><input type="checkbox" name="alldevices"> Log out of all devices</p>
        <input type="submit" name="logout" value="Log out">
    </form>';
} else {
    header('Location: index.php');
}
?>
    
</body>
</html>