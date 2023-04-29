<?php
    session_start();

    if (!isset($_SESSION['loggedin'])){
        header('Location: login.php');
        exit;
    }

    require '../utils/functions.php';

    $dId = $_GET['id'];
    $message = getByQuery("SELECT * FROM messages WHERE id = $dId")[0];

    if ($message["user_id"] != $_SESSION["uid"]) {
        header('Location: index.php');
        exit;
    }

    if (deleteMsg($dId) > 0) {
        echo "
            <script>
                alert('Succesfully deleted the message!');
                document.location.href = '../index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Failed deleting the message..');
                document.location.href = '../index.php';
            </script>
        ";
    }

?>