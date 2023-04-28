<?php 
    include("config.php");

    function registerUser($newUser) {
        global $dbConn;

        $rname = mysqli_real_escape_string($dbConn, $newUser["rname"]);
        $runame = strtolower(stripslashes($newUser["runame"]));
        $rpass = mysqli_real_escape_string($dbConn, $newUser["rpw"]);
        $rconfirmpass = mysqli_real_escape_string($dbConn, $newUser["rpw2"]);

        if (strlen($runame) > 50) {
            echo "
                <script>
                    alert('The username is too long, maximum allowed character is 100.');
                </script>
            ";
            return 0;
        }

        $checkUser = mysqli_query($dbConn, "SELECT username FROM users WHERE username = '$runame'");
        if (mysqli_fetch_assoc($checkUser)) {
            echo "
                <script>
                    alert('The username is already registered, please choose another username to register with.');
                </script>
            ";
            return 0;
        }

        if ($rpass !== $rconfirmpass) {
            echo "
                <script>
                    alert('The password and the confirmation password are different.');
                </script>
            ";
            return 0;
        }

        $rpass = password_hash($rpass, PASSWORD_DEFAULT);

        if (strlen($rpass) > 300) {
            echo "
                <script>
                    alert('The password is too long, please shorten it.');
                </script>
            ";
            return 0;
        }

        $query = 
            "INSERT INTO users (id, name, username, password) VALUES (
                '', '$rname', '$runame', '$rpass')";

        mysqli_query($dbConn, $query);
        return mysqli_affected_rows($dbConn);
    }
?>