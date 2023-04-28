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
</head>
<body>
    
    <h1>Registration Page</h1>

    <form method="post">
        <ul>
            <li>
                <label for="rname">Name : </label>
                <input type="text" name="rname" id="rname">
            </li>

            <li>
                <label for="runame">Username : </label>
                <input type="text" name="runame" id="runame">
            </li>

            <li>
                <label for="rpw">Password : </label>
                <input type="password" name="rpw" id="rpw">
            </li>

            <li>
                <label for="rpw2">Confirm Password : </label>
                <input type="password" name="rpw2" id="rpw2">
            </li>
            <br>
            <button type="submit" name="rsubmit">Register</button>
        </ul>
    </form>

</body>
</html>