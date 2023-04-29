<?php
    session_start();

    if (!isset($_SESSION['loggedin'])){
        header('Location: login.php');
        exit;
    }

    if ($_SESSION['urole'] != 'admin'){
        header('Location: index.php');
        exit;
    }

    require '../utils/functions.php';

    $rId = $_GET["id"];
    $message = getByQuery("SELECT m.content, m.image, u.name FROM messages m INNER JOIN users u ON (m.user_id = u.id) WHERE m.id = $rId")[0];

    $aId = $_SESSION['uid'];
    $adm = getByQuery("SELECT name FROM users WHERE id = $aId")[0];

    if (isset($_POST["isubmit"])) {
        $check = replyMsg($_POST);
        if ($check > 0) {
            echo "
                <script>
                    alert('Succesfully replied the message!');
                    document.location.href = '../index.php';
                </script>
            ";
        } else if ($check !== 0) {
            echo "
                <script>
                    alert('Failed replying message..');
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
    <title>Reply Message</title>
</head>
<body>
    <a href="../index.php">← Go Back</a>
    <br>

    <h1>Replying To Message</h1>

    <?php if ($message['image']) :?>
        <img src="../img/<?= $message["image"] ?>" width="500" height="500"><br>
    <?php endif; ?>

    <h3>Message: </h3>
    <p><?= $message["content"] ?></p>
    <h4>By: <?= $message["name"] ?></h4>
    <br>

    <form method="post">
        <input type="hidden" name="rid" id="rid" value=<?= $rId ?> />
        <input type="hidden" name="radm" id="radm" value=<?= $adm["name"] ?> />
        <label for="mreply">Reply : </label>
        <input type="text" name="mreply" id="mreply" required>
        <button type="submit" name="isubmit">Send Reply</button>
    </form>
    
</body>
</html>