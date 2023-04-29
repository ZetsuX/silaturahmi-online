<?php 
    session_start();

    if (!isset($_SESSION['loggedin'])){
        header('Location: login.php');
        exit;
    }

    require 'utils/functions.php';

    $messages = getMsgsByQuery("SELECT * FROM messages ORDER BY id ASC");
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

    <a href="messages/create.php" style="display: inline-block">Create Message</a>

    <div style="text-align: center; align-items: center;">
        <?php if ($messages) :?>
            <table border="1" cellpadding="10" cellspacing="0" style="margin-left: auto; margin-right: auto;">
                <tr>
                    <th>No. </th>
                    <th>Image</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>

                <?php $i = 1 ?>
                <?php foreach($messages as $m) :?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td>
                            <?php if ($m['image']) :?>
                                <img src="img/<?= $m['image'] ?>" width="50" height="50">
                            <?php else :?>
                                <h4>None</h4>
                            <?php endif; ?>
                        </td>
                        <td><?= $m['content'] ?></td>
                        <td>
                            <a href="messages/edit.php?id=<?= $m["id"] ?>">Edit</a> |
                            <a href="messages/delete.php?id=<?= $m["id"] ?>" 
                                onclick="return confirm('Are you sure you want to delete this message?')">
                                    Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else :?>
            <h2>You haven't created any message yet! Go create one.</h2>
        <?php endif; ?>
    </div>
</body>
</html>