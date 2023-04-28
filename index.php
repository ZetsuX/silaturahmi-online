<?php 
    session_start();

    if (!isset($_SESSION['loggedin'])){
        header('Location: login.php');
        exit;
    }

    require 'utils/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Silaturahmi Online</title>
</head>
<body>
    <h1 style="display: inline-block; position: relative; bottom: 20px;">Silaturahmi Online</h1>

    <a href="logout.php" style="float: right">Log Out</a>
    <br>
</body>
</html>