<?php
    session_start();

    if (!isset($_SESSION['loggedin'])){
        header('Location: login.php');
        exit;
    }
    
    require '../utils/functions.php';

    $uId = $_SESSION['uid'];
    $user = getByQuery("SELECT name FROM users WHERE id = $uId");
    $uname = $user[0]['name'];

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
            <div class="px-6 py-4 bg-[#2A3553] text-white rounded-t-2xl" style="font-family: 'Poppins', sans-serif;">Buat Pesan Baru</div>
            <div class="px-6 py-4 space-y-4">
                <div class="flex items-center gap-x-2">
                    <div class="w-8 h-8 border rounded-full">
                        <img src="../img/assets/logo.png" alt="">
                    </div>
                    <p class="font-semibold"><?= $uname?></p>
                </div>
                <form method="post" enctype="multipart/form-data" class="flex flex-col gap-y-8">
                    <input type="hidden" name="muid" id="muid" value=<?= $_SESSION['uid'] ?> />
                    <div class="space-y-4">
                        <div class="h-[8rem]">
                            <textarea type='text' name="mcontent" id="mcontent" placeholder="Masukkan pesan..." required
                                class="border border-slate-200 bg-slate-50 px-4 py-2 rounded-2xl w-full h-full"></textarea>
                        </div>

                        <div>
                            <label id="label" for="mimage" class="px-4 py-2 bg-slate-50 rounded-2xl border text-[#9ba3af] hover:border-[#2A3553]">Select Image</label>
                            <input name='mimage' id="mimage" style="visibility:hidden;" type="file">
                        </div>
                    </div>

                    <button type="submit" name="isubmit" class="w-fit px-6 py-2 text-white bg-[#2A3553] rounded-full">Kirim Pesan</button>
                </form>
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