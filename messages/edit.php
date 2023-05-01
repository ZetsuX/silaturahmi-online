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
            <div class="px-6 py-4 bg-[#2A3553] text-white rounded-t-2xl" style="font-family: 'Poppins', sans-serif;">Edit Pesan Baru</div>
            <div class="px-6 py-4 space-y-4">
                <div class="flex items-center gap-x-2">
                    <div class="w-8 h-8 border rounded-full">
                        <img src="../img/assets/logo.png" alt="">
                    </div>
                    <!-- <p class="font-semibold"><?= $uname?></p> -->
                </div>
                <form method="post" enctype="multipart/form-data" class="flex flex-col gap-y-8">
                    <input type="hidden" name="eid" id="eid" value="<?= $message["id"] ?>">
                    <input type="hidden" name="oldimg" id="oldimg" value="<?= $message["image"] ?>">
                    <div class="space-y-12">
                        <div class="h-[8rem]">
                            <label for="econtent">Message : </label>
                            <input type="text" name="econtent" id="econtent" value="<?= $message["content"] ?>" required class="border border-slate-200 bg-slate-50 px-4 py-2 rounded-2xl w-full h-full"></input>
                        </div>

                        <div class='space-y-4'>
                            <input type="file" name="eimage" id="eimage" class="px-4 py-2 bg-slate-50 rounded-2xl border text-[#9ba3af] hover:border-[#2A3553]">
                            <img src="../img/<?= $message["image"] ?>" width="100" height="100"><br>
                        </div>
                    </div>

                    <button type="submit" name="esubmit" class="w-fit px-6 py-2 text-white bg-[#2A3553] rounded-full">Edit Message</button>
                </form>
            </div>
        </div>
    </section>

</body>
</html>