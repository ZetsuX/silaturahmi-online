<?php
    require 'utils/functions.php';

    if (isset($_POST['rsubmit'])) {
        $check = registerUser($_POST);
        if ($check > 0) {
            echo "
                <script>
                    alert('Succesfully registered as a new user!');
                    window.location = 'login.php';
                </script>
            ";
        } else if ($check !== 0) {
            echo "
                <script>
                    alert('Failed registering new user..');
                </script>
            ";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Page</title>

    <style>
        label {
            display: block;
        }
    </style>
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
                        <h1 class='text-3xl font-secondary text-center font-bold'>Registration</h1>

                        <form method="post">
                            <ul class='space-y-4'>
                                <li class='flex flex-col'>
                                    <label for="rname" class='text-lg font-medium'>Name</label>
                                    <input type="text" name="rname" id="rname" placeholder="Enter your name" class='w-full border-2 rounded-lg p-2 bg-gray-200 text-black focus:bg-gray-100'>
                                </li>
                                <li>
                                    <label for="runame" class='text-lg font-medium'>Username</label>
                                    <input type="text" name="runame" id="runame" placeholder="Enter your username" class='w-full border-2 rounded-lg p-2 bg-gray-200 text-black focus:bg-gray-100'>
                                </li>

                                <li>
                                    <label for="rpw" class='text-lg font-medium'>Password</label>
                                    <input type="password" name="rpw" id="rpw" placeholder="Enter your password" class='w-full border-2 rounded-lg p-2 bg-gray-200 text-black focus:bg-gray-100'>
                                </li>

                                <li>
                                    <label for="rpw2" class='text-lg font-medium'>Confirm Password </label>
                                    <input type="password" name="rpw2" id="rpw2" placeholder="Confirm your password" class='w-full border-2 rounded-lg p-2 bg-gray-200 text-black focus:bg-gray-100'>
                                </li>
                                
                            </ul>
                            <div class='pt-10 space-y-4'>
                                <button type="submit" name="rsubmit" class='p-2 w-full bg-[#ffbe58] rounded-2xl text-xl font-semibold hover:bg-[#d2973a]'>Register</button>
                                <h3 class='text-center'>Already have an account? <a class='underline text-blue-700' href='login.php'>Log in</a></h3>
                            </div>
                        </form>
                    </div>
                </div>
                <div class='absolute top-0 left-10 translate-x-[100%] opacity-90 w-[30%] scale-50'>
                    <img src="img/assets/Vector.png" alt="" width='500px' class='' data-aos="fade-left" data-aos-duration='1000'>
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