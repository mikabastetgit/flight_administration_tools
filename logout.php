<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        * {
        }
        .logout-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 160px;
            background: none;
            border: none;
            cursor: pointer;
            text-align: center;
            transition: 1s background-color;
        }
        .logout-btn img {
            width: 50px;
            transition: 0.25s transform;
        }
        .logout-btn img:hover {
            transform: scale(1.2);
            transition: 0.25s transform;
        }
    </style>

    <?php

        if (ISSET($_GET['kill_section'])) {
            session_start();
            session_unset();
            session_destroy();
            header("Location: index.php");
            exit();
        }

    ?>
</head>
<body>
    <div class="logout-btn" onclick="kill_section()">
        <a href="logout.php?kill_section=true"><img src="logout.png" alt="Logout"></a>
    </div>
</body>
</html>