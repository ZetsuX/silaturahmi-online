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

    $messagePerPage = 5;
    $currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
    $firstIndex = ($currentPage-1)*$messagePerPage;
    $messageTotal = count(getByQuery("SELECT * FROM messages WHERE user_id = $uId"));
    $pageCount = ceil($messageTotal/$messagePerPage);
    
    $messages = getByQuery("SELECT * FROM messages WHERE user_id = $uId ORDER BY id ASC LIMIT $firstIndex, $messagePerPage");
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
        <div class='absolute w-[30%] right-0 top-12' data-aos="fade-left" data-aos-duration='1000'><img src="img/assets/Vector.png" alt="" class=' scale-50 opacity-80'></div>
        <div class='absolute w-[30%] bottom-1/4' data-aos="fade-right" data-aos-duration='1000'><img src="img/assets/Vector1.png" alt="" class=' scale-50 opacity-80'></div>
        <div class='absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2'><img src="img/assets/bg2.png" alt="" width='500' class='z-[-1] scale-90 blur-sm opacity-30'></div>
        <div class='h-[4.5rem] bg-white shadow-lg w-8/12 mx-auto relative overflow-x-hidden translate-y-12 rounded-full flex items-center justify-between px-4 z-30'>
   
            <div class='absolute marquee w-[1020px] overflow-x-hidden flex gap-x-2 items-center px-4'>
                <div class='uppercase font-medium'>Kami pejabat mengucapkan selamat merayakan hari raya idul fitri 1444 H, mohon maaf lahir dan batin 🙏</div>
            </div>
            <div class='absolute marquee2 w-[1020px] overflow-x-hidden flex gap-x-2 items-center px-4'>
                <div class='uppercase font-medium'>Kami pejabat mengucapkan selamat merayakan hari raya idul fitri 1444 H, mohon maaf lahir dan batin 🙏</div>
            </div>

            <div class='h-full w-fit flex items-center justify-end bg-white rounded-full self-end absolute left-0 px-5'>
            <img src="img/assets/logo.png" width='50px' alt="">
            </div>
            <div class='h-full w-fit flex items-center justify-end bg-white rounded-full self-end absolute right-0 px-5'>
            <a href="logout.php" class='px-5 py-2 cursor-pointer bg-[#31393C] text-[#FDFAF0] rounded-full' style="font-family: 'Poppins', sans-serif;">Log Out</a>
            </div>
        </div>
        
        <div class='min-h-full z-0 absolute w-full -translate-y-14 flex flex-col gap-y-4 justify-center items-center'>
            <h1 class='text-5xl font-bold drop-shadow-xl mb-2'>Silaturahmi Online</h1>
            <?php if ($messages) :?>
            <table border="3" cellpadding="10" cellspacing="3" style="margin-left: auto; margin-right: auto; width: 50%; font-family: 'Poppins', sans-serif;"
                class="rounded-xl overflow-hidden text-center shadow-lg"
            >
                <colgroup>
                    <col span={1} style="max-width: 5%">
                    <col span={1} style="max-width: 20%">
                    <col span={1} style="max-width: 30%">
                    <col span={1} style="max-width: 30%">
                    <col span={1} style="max-width: 10%">
                </colgroup>
                <thead class="bg-[#2A3553] text-[#FDFAF0] p-4 h-[50px]">
                    <tr class="text-center">
                        <th class="font-medium" style="font-family: 'Poppins', sans-serif;">No. </th>
                        <th class="font-medium" style="font-family: 'Poppins', sans-serif;">Gambar</th>
                        <th class="font-medium" style="font-family: 'Poppins', sans-serif;">Pesan</th>
                        <th class="font-medium" style="font-family: 'Poppins', sans-serif;">Balasan</th>
                        <th class="font-medium" style="font-family: 'Poppins', sans-serif;">Aksi</th>
                    </tr>
                </thead>

                <?php $i = $firstIndex+1 ?>
                <tbody class="bg-white text-sm">
                <?php foreach($messages as $m) :?>
                    <tr class="border-b h-[50px]">
                        <td style="font-family: 'Poppins', sans-serif;"><?= $i++ ?></td>
                        <td class="">
                            <?php if ($m['image']) :?>
                            <div class="w-full flex justify-center">
                                <img src="img/<?= $m['image'] ?>" width="45" height="45">
                            </div>
                            <?php else :?>
                                <h4 style="font-family: 'Poppins', sans-serif;">None</h4>
                            <?php endif; ?>
                        </td>
                        <td style="font-family: 'Poppins', sans-serif;" class="text-left max-w-[200px] truncate text-ellipsis overflow-x-hidden"><?= $m['content'] ?></td>
                        <td style="font-family: 'Poppins', sans-serif;" class="text-left max-w-[10%] truncate text-ellipsis overflow-x-hidden">
                            <?php if ($m['reply']) :?>
                                <p><?= $m['reply'] ?></p>
                            <?php else :?>
                                <h4 style="font-family: 'Poppins', sans-serif;" class="text-center">Belum Dibalas</h4>
                            <?php endif; ?>
                        </td>
                        <td style="font-family: 'Poppins', sans-serif;" class="flex items-center justify-center">
                            <a style="font-family: 'Poppins', sans-serif;" class="w-16 py-1 bg-[#FFF4DC] border border-[#99762C] text-[#99762C]" href="messages/edit.php?id=<?= $m["id"] ?>">Ubah</a>
                            <div class=" w-1 h-full bg-slate-400"></div>
                            <a style="font-family: 'Poppins', sans-serif;" class="w-16 py-1 bg-red-500 text-white ml-2" href="messages/delete.php?id=<?= $m["id"] ?>" 
                                onclick="return confirm('Are you sure you want to delete this message?')">
                                    Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class='flex items-center gap-x-2'>
                <?php if ($currentPage > 1) :?>
                    <a 
                        href="?page=<?= $currentPage - 1 ?>">
                            ←
                    </a>
                <?php endif; ?>

                <?php for($i = 1; $i <= $pageCount; $i++) : ?>
                    <a class=" w-8 h-8 rounded-md flex justify-center items-center bg-[#2A3553] bg-opacity-10 border border-[#2A3553] text-[#2A3553] backdrop-blur"
                        href="?page=<?= $i ?>">
                            <?= $i ?> 
                    </a>
                <?php endfor; ?>
                
                <?php if ($currentPage < $pageCount) :?>
                    <a 
                        href="?page=<?= $currentPage + 1 ?>">
                            →
                    </a>
                <?php endif; ?>
            </div>
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