<?php
    session_start();
    session_unset();
    session_destroy();

?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inviia CCP | Log-In</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tw Cen MT', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        .login-container {
            color: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            background: rgb(43, 43, 43);
            animation: fadeIn 1s ease-in-out;
            width: 50%;
        }
        .login-container img {
            width: 100px;
            margin-bottom: 1rem;
            animation: slideIn 1s ease-in-out;
        }
        .login-container h2 {
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .input-group {
            margin-bottom: 1rem;
            text-align: left;
        }
        .input-group label {
            display: block;
            font-weight: 400;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: 0.3s;
        }
        .input-group input:focus {
            border-color: #764ba2;
            outline: none;
        }
        #submit {
            background: #764ba2;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.3s;
        }
        #submit:hover {
            background: #5a3c8c;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
        <?php

            require('connect.php');

            if (ISSET($_POST['submit'])) {
                $username = $_POST['username'];
                // Get Userdata with username
                $search_userdata = "SELECT * FROM `userdata` WHERE `username` = '".$username."'";
                $search_userdata_result = $db->query($search_userdata);
                if ($search_userdata_result->num_rows > 0) {
                    $username_okay = true;
                    foreach ($search_userdata_result as $search_userdata_row) {
                        $user_id = $search_userdata_row['user_id'];
                        $hashed_password = $search_userdata_row['password'];
                        $admin = $search_userdata_row['admin'];
                    }
    
                    if (password_verify($_POST['password'], $hashed_password)) {
                        $password_okay = true;
                        session_start();
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['username'] = $username;
                        $_SESSION['admin'] = $admin;
                        header("Location: template-creator.php");
                        exit();
                    } else {
                        $password_okay = false;
                    }
                } else {
                    $username_okay = false;
                }
            }
        ?>
</head>
<body>
    <div class="login-container">
        <img src="logo.png" alt="Logo">
        <h2>Log-In</h2>
        <?php
            if (ISSET($password_okay)) {
                if ($password_okay == false) {
                    echo "<h3 id='error_msg'>>>> Das Passwort ist falsch <<<</h3>";
                }
            }
            if (ISSET($username_okay)) {
                if ($username_okay == false) {
                    echo "<h3 id='error_msg'>>>> Der Nutzername existiert nicht <<< </h3>";
                }
            }
        ?>
        <form action="index.php" method="POST">
            <div class="input-group">
                <label for="username">Nutzername</label>
                <input type="text" id="username" name="username" autocomplete="off" required>
            </div>
            <div class="input-group">
                <label for="password">Passwort</label>
                <input type="password" id="password" name="password" autocomplete="off" required>
            </div>
            <button type="submit" id="submit" name="submit">Anmelden</button>
        </form>
    </div>
</body>
</html>
