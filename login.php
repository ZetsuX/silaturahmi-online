<?php
    session_start();
    require 'utils/functions.php';

    if (isset($_COOKIE['log1']) && isset($_COOKIE['log2'])){
        $cid = $_COOKIE['log1'];
        $chash = $_COOKIE['log2'];

        $checkUser = mysqli_query($dbConn, "SELECT username FROM users WHERE id = $cid");
        $cuser = mysqli_fetch_assoc($checkUser);

        if ($chash === hash('haval160,5', $cuser["username"])) {
            $_SESSION['loggedin'] = true;
        }
    }

    if (isset($_SESSION['loggedin'])){
        header('Location: index.php');
        exit;
    }

    if (isset($_POST['lsubmit'])) {
        
        $uname = $_POST['luname'];
        $pass = $_POST['lpw'];

        $checkUser = mysqli_query($dbConn, "SELECT * FROM users WHERE username = '$uname'");

        if (mysqli_num_rows($checkUser) == 1) {
            $user = mysqli_fetch_assoc($checkUser);
            if (password_verify($pass, $user["password"])) {
                $_SESSION["loggedin"] = true;
                $_SESSION["uid"] = $user["id"];
                $_SESSION["urole"] = $user["role"];

                if (isset($_POST["rmb"])) {
                    setcookie("log1", $user["id"], time() + 1800);
                    setcookie("log2", hash('haval160,5', $user["username"]), time() + 1800);
                }

                header("Location: index.php");
                exit;
            }
        }

        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <script>
        AOS.init();
    </script>
    <main class="w-screen h-screen flex justify-center items-center">
        <section class='w-4/5 h-4/5 flex justify-center rounded-3xl overflow-hidden shadow-xl'>
            <div class='w-full flex items-center justify-between relative bg-[#fefaf0]'>
                <div class='w-full m-4 flex justify-center'>
                    <div class="space-y-8 p-4 w-4/5">
                        <h1 class='text-3xl font-secondary text-center font-bold'>Log in</h1>
                        <?php if (isset($error)) : ?>
                            <p style="color: red; font-family: Arial, Helvetica, sans-serif;">Username / Password is incorrect.</p>
                        <?php endif; ?>
                
                        <form method="post">
                            <ul class='space-y-4'>
                                <li class='flex flex-col'>
                                    <label for="luname" class='text-lg font-medium'>Username</label>
                                    <input type="text" name="luname" id="luname" placeholder="Enter your username" class='w-full border-2 rounded-lg p-2 bg-gray-200 text-black focus:bg-gray-100'>
                                </li>
                    
                                <li class='flex flex-col'>
                                    <label style="padding: 0px 1.5px;" for="lpw" class='text-lg font-medium'>Password</label>
                                    <input type="password" name="lpw" id="lpw" placeholder="Enter your password" class='w-full border-2 rounded-lg p-2 bg-gray-200 text-black focus:bg-gray-100'>
                                </li>
                                <div>
                                    <input type="checkbox" name="rmb" id="rmb">
                                    <label for="rmb">Remember Me </label>
                                </div>
                                
                            </ul>
                            <div class='pt-10 space-y-4'>
                                <button type="submit" name="lsubmit" class='p-2 w-full bg-[#ffbe58] rounded-2xl text-xl font-semibold hover:bg-[#d2973a]'>Log in</button>
                                <h3 class='text-center'>Dont have an account? <a class='underline text-blue-700' href='register.php'>Sign Up</a></h3>
                            </div>
                        </form>
                    </div>
                </div>
                <div class='absolute top-0 left-20 translate-x-3/4 translate-y-1/6 opacity-90 w-[30%] scale-[60%]'>
                    <img src="img/assets/Vector.png" alt="" width='700px' class='' data-aos="fade-left" data-aos-duration='1000'>
                </div>
                <div class='absolute bottom-0 left-0 -translate-x-1/3 translate-y-1/6 opacity-90 w-[30%] scale-50' '>
                    <img src="img/assets/Vector1.png" alt="" width='500px' class='' data-aos="fade-right" data-aos-duration='1000'>
                </div>
                <div class="w-full h-full bg-[url('img/assets/bg-login4.jpg')] bg-cover z-10"></div>
            </div>
        </section>        
    </main>

</body>
</html>