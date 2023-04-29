<?php 
    session_start();

    if (!isset($_SESSION['loggedin'])){
        header('Location: login.php');
        exit;
    }

    if ($_SESSION['urole'] == 'admin') {
        header('Location: admin.php');
        exit;
    }

    require 'utils/functions.php';

    $uId = $_SESSION["uid"];
    $messages = getByQuery("SELECT * FROM messages WHERE user_id = $uId ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Silaturahmi Online</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
</head>
<body class='h-screen w-full overflow-hidden relative'>
    <script>
        AOS.init();
    </script>
    <section class='bg-[#FDFAF0] h-full w-full overflow-hidden text-[#31393C]'>
        <div class='absolute w-[30%] right-0 top-12' data-aos="fade-left" data-aos-duration='1000'><img src="assets/Vector.png" alt="" class=' scale-50 opacity-80'></div>
        <div class='absolute w-[30%] bottom-1/4' data-aos="fade-right" data-aos-duration='1000'><img src="assets/Vector1.png" alt="" class=' scale-50 opacity-80'></div>
        <div class='absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2'><img src="assets/bg2.png" alt="" width='500' class='z-[-1] scale-90 blur-sm opacity-30'></div>
        <div class='h-[4.5rem] bg-white shadow-lg w-8/12 mx-auto relative overflow-x-hidden translate-y-12 rounded-full flex items-center justify-between px-4 z-30'>
   
            <div class='absolute marquee w-[1020px] overflow-x-hidden flex gap-x-2 items-center px-4'>
                <div class='uppercase font-medium'>Kami pejabat mengucapkan selamat merayakan hari raya idul fitri 1444 H, mohon maaf lahir dan batin 🙏</div>
            </div>
            <div class='absolute marquee2 w-[1020px] overflow-x-hidden flex gap-x-2 items-center px-4'>
                <div class='uppercase font-medium'>Kami pejabat mengucapkan selamat merayakan hari raya idul fitri 1444 H, mohon maaf lahir dan batin 🙏</div>
            </div>

            <div class='h-full w-fit flex items-center justify-end bg-white rounded-full self-end absolute left-0 px-5'>
            <img src="assets/logo.png" width='50px' alt="">
            </div>
            <div class='h-full w-fit flex items-center justify-end bg-white rounded-full self-end absolute right-0 px-5'>
            <a href="logout.php" class='px-5 py-2 cursor-pointer bg-[#31393C] text-[#FDFAF0] rounded-full' style="font-family: 'Poppins', sans-serif;">Log Out</a>
            </div>
        </div>
        
        <div class='min-h-full z-0 absolute w-full -translate-y-14 flex flex-col gap-y-4 justify-center items-center'>
            <h1 class='text-5xl font-bold drop-shadow-lg'>Silaturahmi Online</h1>
            <?php if ($messages) :?>
            <table border="1" cellpadding="10" cellspacing="0" style="margin-left: auto; margin-right: auto;">
                <tr>
                    <th>No. </th>
                    <th>Image</th>
                    <th>Message</th>
                    <th>Reply</th>
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
                            <?php if ($m['reply']) :?>
                                <p><?= $m['reply'] ?></p>
                            <?php else :?>
                                <h4>Not replied yet</h4>
                            <?php endif; ?>
                        </td>
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
            <h2 class='font-medium text-lg text-center' style="font-family: 'Poppins', sans-serif;">Kamu belum membuat pesan apapun, ayo buat sekarang!</h2>
        <?php endif; ?>
            <a class='px-8 py-2 font-semibold uppercase text-white' href="messages/create.php" style="background: linear-gradient(143.45deg, #F79824 11.17%, #FDCA40 120.47%);
border-radius: 8px 100px; font-family: 'Poppins', sans-serif;">buat pesan</a>
        </div>
    </section>
    
    
    <br>
    <!-- <div style="text-align: center; align-items: center;">
        
        </div> -->
</body>
</html>