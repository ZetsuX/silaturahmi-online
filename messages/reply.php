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
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            font-family: 'Poppins';
        }
    </style>
</head>
<body class="h-screen w-full bg-[#FDFAF0] overflow-hidden">
    <script>
        AOS.init();
    </script>

    <a href="../index.php" class="space-x-1 absolute left-16 top-16 px-4 py-2 z-20 bg-[#FFF4DC] border border-[#99762C] text-[#99762C] rounded-full"><i class="fa-solid fa-chevron-left fa-xs"></i><span>Back</span></a>
    <section class="h-full w-full grid place-items-center">
        <div class="bg-white rounded-2xl shadow-lg flex flex-col min-w-[30rem]">
            <div class="px-6 py-4 bg-[#2A3553] text-white rounded-t-2xl" style="font-family: 'Poppins', sans-serif;">Balas Pesan</div>
            <div class="px-6 py-4 space-y-4">
                <div class="flex items-center gap-x-2 mb-1">
                    <div class="w-8 h-8 border rounded-full">
                        <img src="../img/assets/logo.png" alt="">
                    </div>
                    <p class="font-semibold"><?= $message["name"] ?></p>
                </div>
                <div class="flex flex-col items-start gap-y-2">
                    <?php if ($message['image']) :?>
                        <div class="w-1/3 h-auto max-h-42 flex justify-center border-2 border-slate-300 bg-slate-50 p-2 rounded-lg">
                            <img src="../img/<?= $message["image"] ?>" width="160" height="160"><br>
                        </div>
                    <?php endif; ?>
                    <div class="w-1/2 border rounded-md bg-slate-100 p-2">
                        <p class="text-left m-1"><?= $message["content"] ?></p>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-y-2">
                    <div class="flex items-center justify-start gap-x-2 mb-1">
                        <div class="w-8 h-8 border rounded-full">
                            <img src="../img/assets/logo.png" alt="">
                        </div>
                        <p class="font-semibold"><?= $adm["name"] ?></p>
                    </div>
                    <form method="post" class="flex flex-col w-1/2 gap-y-8">
                        <input type="hidden" name="rid" id="rid" value=<?= $rId ?> />
                        <input type="hidden" name="radm" id="radm" value=<?= $adm["name"] ?> />
                        <div class="space-y-4">
                            <div class="h-[8rem]">
                                <textarea type='text' name="mreply" id="mreply" placeholder="Masukkan balasan..." required
                                    class="border border-slate-200 bg-green-300 px-4 py-2 rounded-2xl w-full h-full placeholder:text-slate-500"></textarea>
                            </div>
                        </div>
                        <button type="submit" name="isubmit" class="w-fit px-6 py-2 text-white bg-[#2A3553] rounded-full self-end">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Get the input and label elements
        const input = document.getElementById("mimage");
        const label = document.getElementById("label");

        input.addEventListener("change", () => {
        if (input.files.length > 0) {
            label.innerText = input.files[0].name;
            label.style.border = '2px solid #2A3553'
            label.style.color = '#2A3553'
        } else {
            label.innerText = "Select Image";
            label.style.borderw = '1px solid'
            label.style.color = '#9ba3af'
        }
});

    </script>
</body>
</html>