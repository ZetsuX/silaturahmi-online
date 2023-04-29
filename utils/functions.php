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

    function getByQuery($query) {
        global $dbConn;

        $res = mysqli_query($dbConn, $query);
        $rows = [];

        while ($r = mysqli_fetch_assoc($res)) {
            $rows[] = $r;
        }

        return $rows;
    }

    function uploadFile($file, $allowedExtensions, $maxSize) {
        $fileName = $file["name"];
        $fileSize = $file["size"];
        $fileTmp = $file["tmp_name"];

        $fileExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($fileExtension));

        $allowedEString = implode(", ", $allowedExtensions);
        if ( !in_array($fileExtension, $allowedExtensions) ) {
            echo "
                <script>
                    alert('Please upload a file with extension $allowedEString.');
                </script>
            ";
            return false;
        }

        if ( $fileSize > $maxSize ) {
            echo "
                <script>
                    alert('File size is too large, maximum allowed size is $maxSize byte(s).');
                </script>
            ";
            return false;
        }

        $fileName = str_replace("." . $fileExtension, "", $fileName);
        $fileName = substr($fileName, 0, 75) . uniqid() . '.' . $fileExtension;

        move_uploaded_file($fileTmp, '../img/' . $fileName);
        return $fileName;
    }

    function createMsg($newData, $newFile) {
        global $dbConn;

        $mcontent = htmlspecialchars($newData["mcontent"]);
        $muid = htmlspecialchars($newData["muid"]);

        if ($newFile['mimage']['error'] == 4 || ($newFile['mimage']['size'] == 0 && $newFile['mimage']['error'] == 0)) {
            $query = "INSERT INTO messages (id, content, user_id) VALUES (
                '', '$mcontent', $muid)";
        } else {
            $mimage = uploadFile($newFile["mimage"], ['jpg', 'png', 'jpeg'], 2000000);
            if (!$mimage) {
                return 0;
            }

            $query = "INSERT INTO messages (id, content, user_id, image) VALUES (
                '', '$mcontent', $muid, '$mimage')";
        }

        mysqli_query($dbConn, $query);
        return mysqli_affected_rows($dbConn);
    }

    function editMsg($editedData, $editedFile) {
        global $dbConn;

        $eid = $editedData["eid"];
        $econtent = htmlspecialchars($editedData["econtent"]);
        $oldimage = htmlspecialchars($editedData["oldimg"]);

        if (($editedFile['mimage']['size'] == 0 && $editedFile['mimage']['error'] == 0) || $editedFile['eimage']['error'] === 4) {
            $eimage = $oldimage;
        } else {
            $eimage = uploadFile($editedFile['eimage'], ['jpg', 'png', 'jpeg'], 2000000);
            if (!$eimage) {
                return 0;
            }
        }

        $query = 
            "UPDATE messages SET 
                content = '$econtent',
                image = '$eimage'
            WHERE id = $eid
            ";

        mysqli_query($dbConn, $query);
        return mysqli_affected_rows($dbConn);
    }

    function deleteMsg($dId) {
        global $dbConn;

        $query = "DELETE FROM messages WHERE id = $dId";
        mysqli_query($dbConn, $query);
        return mysqli_affected_rows($dbConn);
    }

    function replyMsg($newData) {
        global $dbConn;

        $rid = $newData["rid"];
        $radm = $newData["radm"];
        $mreply = $newData["mreply"];

        $query = 
            "UPDATE messages SET 
                reply = '$mreply -$radm'
            WHERE id = $rid
            ";

        mysqli_query($dbConn, $query);
        return mysqli_affected_rows($dbConn);
    }
?>