<?php 
    session_start();

    if (!isset($_SESSION['loggedin'])){
        header('Location: login.php');
        exit;
    }

    if ($_SESSION['urole'] != 'admin') {
        header('Location: index.php');
        exit;
    }

    require 'utils/functions.php';

    $repliedPerPage = 10;
    $currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
    $firstIndex = ($currentPage-1)*$repliedPerPage;
    $repliedTotal = count(getByQuery("SELECT * FROM messages WHERE reply IS NOT NULL"));
    $pageCount = ceil($repliedTotal/$repliedPerPage);

    $replieds = getByQuery("SELECT * FROM messages WHERE reply IS NOT NULL ORDER BY id ASC LIMIT $firstIndex, $repliedPerPage");

    $unreplieds = getByQuery("SELECT m.id, m.content, m.image, u.name FROM messages m INNER JOIN users u ON (m.user_id = u.id) WHERE m.reply IS NULL ORDER BY m.id ASC LIMIT 10;");
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

    <div style="text-align: center; align-items: center;">
        <?php if ($unreplieds) :?>
            <table border="1" cellpadding="10" cellspacing="0" style="margin-left: auto; margin-right: auto;">
                <tr>
                    <th>No. </th>
                    <th>Image</th>
                    <th>Message</th>
                    <th>Sender</th>
                    <th>Action</th>
                </tr>

                <?php $i = 1 ?>
                <?php foreach($unreplieds as $u) :?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td>
                            <?php if ($u['image']) :?>
                                <img src="img/<?= $u['image'] ?>" width="50" height="50">
                            <?php else :?>
                                <h4>None</h4>
                            <?php endif; ?>
                        </td>
                        <td><?= $u['content'] ?></td>
                        <td>
                            <h4><?= $u['name'] ?></h4>
                        </td>
                        <td>
                            <a href="messages/reply.php?id=<?= $u["id"] ?>">Reply</a>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else :?>
            <h2>There is no unreplied message available currently..</h2>
        <?php endif; ?>
    </div>
</body>
</html>