<?php

    if(!ISSET($_SESSION['user_id'])) {
        header("Location: index.php");
    } else {
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        $admin = $_SESSION['admin'];
        if (ISSET($admin)) {
            if ($admin) {
                $admin = true;
            } else {
                $admin = false;
            }
        } else {
            $admin = false;
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Userdata-Bar</title>
    <style>
        .info-bar {
            position: fixed;
            top: 0;
            right: 0;
            color: white;
            padding: 0 10px;
            border-radius: 0 0 0 10px;
            text-align: right;
            background-color: black;
        }
    </style>
</head>
<body>
    <div class="info-bar">
        <p>Nutzername: <span id="username"><?php echo $username; ?> | </span>
        Nutzer-ID: <span id="userid"><?php echo $user_id; ?> | </span>
        <?php 
            if (!$admin) {
                echo "Admin: <span id='admin'>Nein</span></p>";
            } else if($admin) {
                echo "Admin: <span id='admin'>Ja</span></p>";
            }
        ?>
    </div>
</body>
</html>