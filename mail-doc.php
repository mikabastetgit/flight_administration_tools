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
		echo $kill_entry;
		$delete_entry = "DELETE FROM `mail-doc` WHERE `entry_id` = ".$kill_entry;
		echo $delete_entry;
		$db->query($delete_entry);
		header("Location: mail-doc.php");
	}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail-Documentation</title>
    <link rel="stylesheet" href="navbar.css">
    <style>
		body {
			background: rgb(43, 43, 43);
			font-family: 'TW Cen MT', sans-serif;
			color: white;
			transition: background-color 0.3s ease; /* Für sanfte Übergänge bei Hintergrundfarbe */
		}

		.container {
			background: rgb(65, 65, 65);
			padding: 30px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			border-radius: 8px;
			text-align: center;
			width: 98%;
			max-width: 1600px;
			margin: 20px auto;
			animation: fadeIn 0.5s ease-out; /* Animation für Container beim Laden */
		}

		@keyframes fadeIn {
			0% {
				opacity: 0;
				transform: translateY(20px);
			}
			100% {
				opacity: 1;
				transform: translateY(0);
			}
		}

		input, select, textarea {
			padding: 10px;
			width: calc(100% - 22px);
			margin-bottom: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
			background: rgb(74, 74, 74);
			color: white;
			font-family: 'TW Cen MT', sans-serif;
			font-size: 20px;
			outline: none;
			border: none;
			box-shadow: 1px 1px 5px black;
			transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animation für Fokus und Hover */
		}

		input:focus, select:focus, textarea:focus {
			transform: scale(1.02); /* Vergrößert das Element bei Fokus */
			box-shadow: 0 0 10px rgba(255, 255, 255, 0.6); /* Weißer Schatten bei Fokus */
		}

		button {
			padding: 10px;
			background: blue;
			color: white;
			border: none;
			cursor: pointer;
			border-radius: 4px;
			width: 50%;
			font-size: 20px;
			transition: background-color 0.3s ease; /* Sanfte Übergänge für Button */
			font-family: 'Tw Cen MT', sans-serif;
		}

		button:hover {
			background-color: darkblue; /* Button wird bei Hover dunkler */
		}

		a {
			color: lightblue;
			transition: color 0.3s ease; /* Sanfter Farbwechsel bei Hover */
		}

		a:hover {
			color: #99ccff; /* Bläulicherer Ton bei Hover */
		}

		.table-container {
			max-height: 500px;
			overflow-y: auto;
			margin-top: 10px;
			opacity: 0;
			animation: slideIn 0.5s forwards 0.3s; /* Animation für die Tabelle */
		}

		@keyframes slideIn {
			0% {
				transform: translateY(20px);
				opacity: 0;
			}
			100% {
				transform: translateY(0);
				opacity: 1;
			}
		}

		table {
			width: 100%;
			border-collapse: collapse;
			background: rgb(74, 74, 74);
			animation: fadeInTable 0.5s ease-out; /* Fade-In Animation für die Tabelle */
		}

		@keyframes fadeInTable {
			0% {
				opacity: 0;
			}
			100% {
				opacity: 1;
			}
		}

		th, td {
			border: 1px solid #ddd;
			padding: 8px;
			text-align: left;
			word-break: break-word;
			white-space: normal;
			transition: background-color 0.3s ease; /* Sanfter Übergang bei Tabellenzellen */
		}

		th:hover, td:hover {
			background-color: rgba(255, 255, 255, 0.1); /* Hellt Zellen bei Hover auf */
		}

		.delete-btn {
			background: red;
			color: white;
			border: none;
			cursor: pointer;
			padding: 5px;
			border-radius: 4px;
			transition: transform 0.3s ease, background-color 0.3s ease; /* Animation für Löschbutton */
		}

		.delete-btn:hover {
			background-color: darkred; /* Button wird bei Hover dunkler */
			transform: scale(1.1); /* Button wird bei Hover leicht vergrößert */
		}

		@media (max-width: 800px) {
			td {
				display: block;
				width: 100%;
				box-sizing: border-box;
			}
			tr {
				margin-bottom: 10px;
				display: block;
				border: 1px solid #ddd;
				padding: 10px;
				border-radius: 8px;
				background: #fff;
				animation: fadeInMobile 0.5s ease-out;
			}
			@keyframes fadeInMobile {
				0% {
					opacity: 0;
					transform: translateY(20px);
				}
				100% {
					opacity: 1;
					transform: translateY(0);
				}
			}
		}

    </style>
	<?php
		if (ISSET($_POST['submit'])) {
			$erm_id = $_POST['erm_id'];
			$bookinglink = $_POST['bookinglink'];
			$processingtype = $_POST['processingtype'];
			$processingnotes = $_POST['processingnotes'];
			$time = date("d.m.Y")." um ".date("H:i.s");
			//user-id wird bei Websitenaufruf gezogen

			$save_entry = "INSERT INTO `mail-doc`(`erm_id`, `bookinglink`, `processingtype`, `processingnotes`, `time`, `user_id`) 
			VALUES ('".$erm_id."','".$bookinglink."','".$processingtype."','".$processingnotes."','".$time."','".$user_id."')";
			$db->query($save_entry);

			header("Location: mail-doc.php");
			exit();
		}
	?>
</head>
<body>
  <div id="navbar-placeholder"></div>
    <div class="container">
        <h1>Mail-Documentation</h1>
		<form action="mail-doc.php" method="POST">
			<input type="text" id="erm_id" name="erm_id" autocomplete="off" placeholder="Enter a reference ID" >
			<input type="url" id="bookinglink" name="bookinglink" autocomplete="off" placeholder="Enter booking link">
			<select id="processingtype" name="processingtype">
				<option value="email">E-Mail</option>
				<option value="admin-bearbeitung">EDP-Management</option>
				<option value="inbound">Inbound-Call</option>
				<option value="inbound">Outbound-Call</option>
			</select>
			<textarea id="processingnotes" name="processingnotes" placeholder="Enter processing steps" autocomplete="off" required></textarea>
			<button type="submit" name="submit" id="submit">Save</button>
		</form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Reference ID</th>
                        <th>Bookinglink</th>
                        <th>Processing Type</th>
                        <th>Notes</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="entrylist">
					<?php
						$get_entries = "SELECT * FROM `mail-doc` WHERE `user_id` = ".$user_id;
						$get_entries_result = $db->query($get_entries);
						foreach ($get_entries_result as $get_entries_row) {
							echo "<tr>";
							echo "<td>";
							echo $get_entries_row['erm_id'];
							echo "</td>";
							echo "<td>";
							echo "<a target='_blank' rel='noopener noreferrer' href='".$get_entries_row['bookinglink']."'>Open booking link</a>";
							echo "</td>";
							echo "<td>";
							echo $get_entries_row['processingtype'];
							echo "</td>";
							echo "<td>";
							echo $get_entries_row['processingnotes'];
							echo "</td>";
							echo "<td>";
							echo $get_entries_row['time'];
							echo "</td>";
							echo "<td>";
							echo "<a href='mail-doc.php?kill_entry=".$get_entries_row['entry_id']."'><button>Delete</button></a>";
							echo "</td>";
							echo "</tr>";
						}
					?>
				</tbody>
            </table>
        </div>
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
