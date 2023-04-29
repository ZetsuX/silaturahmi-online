<?php
    session_start();

    if (!isset($_SESSION['loggedin'])){
        header('Location: login.php');
        exit;
    }
    
    require '../utils/functions.php';

    if (isset($_POST["isubmit"])) {
        $check = createMsg($_POST, $_FILES);
        if ($check > 0) {
            echo "
                <script>
                    alert('Succesfully created the message!');
                    document.location.href = '../index.php';
                </script>
            ";
        } else if ($check !== 0) {
            echo "
                <script>
                    alert('Failed creating message..');
                    document.location.href = '../index.php';
                </script>
            ";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Message</title>
</head>
<body>
    <a href="../index.php">← Go Back</a>
    <br>

    <h1>Creating New Message</h1>

    <form method="post" enctype="multipart/form-data">
        <ul>
            <input type="hidden" name="muid" id="muid" value=<?= $_SESSION['uid'] ?> />
            <li>
                <label for="mcontent">Message : </label>
                <input type="text" name="mcontent" id="mcontent" required>
            </li>
            <li>
                <label for="mimage">Image : </label><br>
                <input type="file" name="mimage" id="mimage">
            </li>

            <br>
            <button type="submit" name="isubmit">Add Message</button>
        </ul>
    </form>
    
</body>
</html>