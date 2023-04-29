<?php
    session_start();

    if (!isset($_SESSION['loggedin'])){
        header('Location: login.php');
        exit;
    }

    require '../utils/functions.php';

    $eId = $_GET["id"];
    $message = getByQuery("SELECT * FROM messages WHERE id = $eId")[0];

    if ($message["user_id"] != $_SESSION["uid"]) {
        header('Location: index.php');
        exit;
    }

    if (isset($_POST["esubmit"])) {
        $check = editMsg($_POST, $_FILES);
        if ($check > 0) {
            echo "
                <script>
                    alert('Succesfully edited the message!');
                    document.location.href = '../index.php';
                </script>
            ";
        } else if ($check !== 0) {
            echo "
                <script>
                    alert('Failed to edit the message..');
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
    <title>Edit Message</title>
</head>
<body>
    <a href="../index.php">← Go Back</a>
    <br>

    <h1>Editing a Message</h1>

    <form method="post" enctype="multipart/form-data">
        <ul>
            <input type="hidden" name="eid" id="eid" value="<?= $message["id"] ?>">
            <input type="hidden" name="oldimg" id="oldimg" value="<?= $message["image"] ?>">
            <li>
                <label for="econtent">Message : </label>
                <input type="text" name="econtent" id="econtent" value="<?= $message["content"] ?>" required>
            </li>
            <li>
                <label for="eimage">Image : </label><br>
                <img src="../img/<?= $message["image"] ?>" width="100" height="100"><br>
                <input type="file" name="eimage" id="eimage">
            </li>

            <br>
            <button type="submit" name="esubmit">Edit Message</button>
        </ul>
    </form>
    
</body>
</html>