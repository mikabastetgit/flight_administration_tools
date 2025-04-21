<?php

    session_start();
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

    
    require("connect.php");

    if (ISSET($_GET['kill_entry']))  {
		$kill_entry = $_GET['kill_entry'];
		$delete_entry = "DELETE FROM `feedback-management` WHERE `feedback_id` = ".$kill_entry;
		echo $delete_entry;
		$db->query($delete_entry);
		header("Location: feedback-management.php");
	}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback-Management</title>
    <link rel="stylesheet" href="navbar.css">
    <style>
        body {
            background: rgb(43, 43, 43);
            font-family: 'TW Cen MT', sans-serif;
            color: white;
        }
        
        .container {
            background: rgb(43, 43, 43);
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            width: 98%;
            max-width: 1600px;
            margin: 20px auto;
            animation: fadeIn 1s forwards;
        }

        /* Eingabefelder */
        input, textarea, select {
            padding: 10px;
            width: calc(100% - 22px);
            margin-bottom: 10px;
            background: rgb(74, 74, 74);
            color: white;
            font-family: 'TW Cen MT', sans-serif;
            font-size: 20px;
            border: none;
            box-shadow: 1px 1px 5px black;
            border-radius: 4px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        input:focus, textarea:focus, select:focus {
            background: rgb(95, 95, 95);
            transform: scale(1.03);
        }

        textarea {
            height: 150px;
            resize: none;
        }

        /* Buttons */
        button {
            padding: 10px;
            background: darkblue;
			color: white;
            font-size: 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-family: 'Tw Cen MT', sans-serif;
            width: 85%;
            transition: background 0.3s ease, transform 0.3s ease;
            font-weight: bold;
        }

        button:hover {
            background: #00163b;
            transform: scale(1.02);
            font-family: 'Tw Cen MT', sans-serif;
        }

        #reset_feedback {
            width: 7%;
			margin-left: 2%;
            background: red;
            font-weight: bold;
            font-family: 'Tw Cen MT', sans-serif;
            font-size: 15px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        #reset_feedback:hover {
            background: darkred;
            transform: scale(1.05);
        }

        /* Animationen */
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Tabelle */
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            margin-top: 10px;
            animation: slideUp 0.5s ease-out;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgb(74, 74, 74);
            opacity: 0;
            animation: fadeIn 1.2s forwards;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            word-break: break-word;
        }

        .delete-btn {
            background: red;
            color: white;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .delete-btn:hover {
            background: darkred;
        }

        /* Floating Counter */
        .floating-counter {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            animation: slideIn 0.8s ease-out;
            text-align: right;
        }

        .floating-counter h3 {
            margin: 0;
            font-size: 18px;
            text-align: center;
        }

        .floating-counter ul {
            list-style-type: none;
            padding: 0;
        }

        .floating-counter li {
            font-size: 16px;
            margin: 5px 0;
        }

        @keyframes slideUp {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideIn {
            0% { transform: translateX(50px); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

    </style>
	<?php
		if (ISSET($_POST['submit'])) {
			$customer_id = $_POST['customer_id'];
			$feedback = $_POST['feedback'];
			$category = $_POST['category'];
			//user-id wird bei Websitenaufruf gezogen

			$save_entry = "INSERT INTO `feedback-management`(`customer_id`, `feedback`, `category`, `user_id`) 
            VALUES ('".$customer_id."','".$feedback."','".$category."','".$user_id."')";
			$db->query($save_entry);
            // Header funktioniert irgendwie nicht, deshalb per js aus php raus. funktioniert stand 23.03.2025
            $page = "feedback-management.php";
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.$page.'";';
            echo '</script>';
			exit();
		}
	?>
</head>
<body>
    <div id="navbar-placeholder"></div>
    <div class="container">
        <h2>Feedback Manager</h2>
        <form action="feedback-management.php" method="POST">
            <input type="text" id="customer_id" name="customer_id" placeholder="Reference ID" maxlength="8">
            <textarea id="feedback" name="feedback" placeholder="Customers Feedback"></textarea>
            <select id="category" name="category">
                <option value="Servicegebühr">Service-Fee</option>
                <option value="Airlineverschulden">Airline debts</option>
                <option value="Support">Support</option>
                <option value="Flex_Datum">Flexible date</option>
                <option value="Umgebungssuche">Area search</option>
                <option value="RyanAir">Airline XY</option>
                <option value="Billigflüge">Low-coster flights</option>
                <option value="Preis">Pricing</option>
                <option value="SC">Schedule Change</option>
            </select>
            <button id="submit" name="submit" type="submit">Send</button>
        </form>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Reference ID</th>
                        <th>Given Feedback</th>
                        <th>Category</th>
                        <th>Creator</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="feedbackTable">
                    <?php
                        $get_all_entries = "SELECT * FROM `feedback-management` JOIN `userdata` ON `feedback-management`.`user_id`=`userdata`.`user_id` ORDER BY `feedback_id` ASC;";
                        $get_all_entries_result = $db->query($get_all_entries);

                        foreach ($get_all_entries_result as $get_all_entries_row) {
                            echo "<tr>";
                                echo "<td>";
                                    echo $get_all_entries_row['customer_id'];
                                echo "</td>";
                                echo "<td>";
                                    echo $get_all_entries_row['feedback'];
                                echo "</td>";
                                echo "<td>";
                                    echo $get_all_entries_row['category'];
                                echo "</td>";
                                echo "<td>";
                                    echo $get_all_entries_row['username'];
                                echo "</td>";
                                echo "<td>";
                                    if ($get_all_entries_row['user_id'] == $user_id || $admin == true) {
                                        echo "<a href='feedback-management.php?kill_entry=".$get_all_entries_row['feedback_id']."'><button>Delete</button></a>";
                                    } else {
                                        echo "No permission!";
                                    }
                                echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
        $count_se = "SELECT COUNT(*) FROM `feedback-management` WHERE `category` = 'Servicegebühr';";
        $count_al = "SELECT COUNT(*) FROM `feedback-management` WHERE `category` = 'Airlineverschulden';";
        $count_support = "SELECT COUNT(*) FROM `feedback-management` WHERE `category` = 'Support';";
        $count_flex = "SELECT COUNT(*) FROM `feedback-management` WHERE `category` = 'Flex_Datum';";
        $count_alt = "SELECT COUNT(*) FROM `feedback-management` WHERE `category` = 'Umgebungssuche';";
        $count_fr = "SELECT COUNT(*) FROM `feedback-management` WHERE `category` = 'RyanAir';";
        $count_lc = "SELECT COUNT(*) FROM `feedback-management` WHERE `category` = 'Billigflüge';";
        $count_pr = "SELECT COUNT(*) FROM `feedback-management` WHERE `category` = 'Preis';";
        $count_sc = "SELECT COUNT(*) FROM `feedback-management` WHERE `category` = 'SC';";
        $count_se_result = $db->query($count_se);
        foreach ($count_se_result as $count_se_row) {
            $amount_se = $count_se_row['COUNT(*)'];
        }
        $count_al_result = $db->query($count_al);
        foreach ($count_al_result as $count_al_row) {
            $amount_al = $count_al_row['COUNT(*)'];
        }
        $count_support_result = $db->query($count_support);
        foreach ($count_support_result as $count_support_row) {
            $amount_support = $count_support_row['COUNT(*)'];
        }
        $count_flex_result = $db->query($count_flex);
        foreach ($count_flex_result as $count_flex_row) {
            $amount_flex = $count_flex_row['COUNT(*)'];
        }
        $count_alt_result = $db->query($count_alt);
        foreach ($count_alt_result as $count_alt_row) {
            $amount_alt = $count_alt_row['COUNT(*)'];
        }
        $count_fr_result = $db->query($count_fr);
        foreach ($count_fr_result as $count_fr_row) {
            $amount_fr = $count_fr_row['COUNT(*)'];
        }
        $count_lc_result = $db->query($count_lc);
        foreach ($count_lc_result as $count_lc_row) {
            $amount_lc = $count_lc_row['COUNT(*)'];
        }
        $count_pr_result = $db->query($count_pr);
        foreach ($count_pr_result as $count_pr_row) {
            $amount_pr = $count_pr_row['COUNT(*)'];
        }
        $count_sc_result = $db->query($count_sc);
        foreach ($count_sc_result as $count_sc_row) {
            $amount_sc = $count_sc_row['COUNT(*)'];
        }
    ?>

    <div class="floating-counter">
        <h3>Beschwerden-Zähler</h3>
        <ul id="categoryCounter">
            <li>Service-fee: <?php echo $amount_se ?></li>
            <li>Airline debts: <?php echo $amount_al ?></li>
            <li>Support: <?php echo $amount_support ?></li>
            <li>Flexible date: <?php echo $amount_flex ?></li>
            <li>Area search: <?php echo $amount_alt ?></li>
            <li>Airline XY: <?php echo $amount_fr ?></li>
            <li>Low-coster flights: <?php echo $amount_lc ?></li>
            <li>Pricing: <?php echo $amount_pr ?></li>
            <li>Schedule Change: <?php echo $amount_sc ?></li>
        </ul>
    </div>
	
	
	    <script>
		document.addEventListener("DOMContentLoaded", function () {
			document.getElementById("navbar-placeholder").innerHTML = `
				<nav class="sidebar">
				<img src="logo.png">
					<ul>
						<li><a href="template-creator.php">Template-Creator</a></li>
						<li><a href="mail-doc.php">Mail-Documentation</a></li>
						<li><a href="tax-getter.php">Tax-Compresser</a></li>
						<li><a href="feedback-management.php">Feedback-Management</a></li>
					</ul>
				</nav>
			`;
		});
	</script>
	<?php
		require("logout.php");
		require("userdata.php");
	?>
	
	
</body>
</html>