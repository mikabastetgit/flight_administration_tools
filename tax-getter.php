
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

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax-Compressor</title>
    <link rel="stylesheet" href="navbar.css">
    <style>
        body {
            font-family: 'TW Cen MT', sans-serif;
			background: rgb(43, 43, 43);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
			color: white;
        }
        .container {
            width: 90%;
            max-width: 600px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0px 20px rgba(0, 0, 0, 1);
			background: rgb(50, 50, 50);
        }
        textarea {
            width: 90%;
            height: 150px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
			resize: none;
			background: rgb(74, 74, 74);
			outline: none;
			border: none;
			box-shadow: 1px 1px 5px black;
			color: white;
            font-family: 'TW Cen MT', sans-serif;
			font-size: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007BFF;
            color: #ffffff;
            border: none;
            border-radius: 4px;
        }
        button:hover {
            background-color: #0056b3;
        }
        pre {
			background: rgb(74, 74, 74);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: auto;
			color: white;
			outline: none;
			border: none;
			box-shadow: 1px 1px 5px black;
        }
    </style>
</head>
<body>
  <div id="navbar-placeholder"></div>
    <div class="container">
        <h1>Tax-Compressor</h1>
        <p>Insert the original cost breakdown to obtain the adjusted list of tax values:</p>
        <textarea id="input" placeholder="Copy-paste here..."></textarea>
        <button onclick="formatTaxes()">Start formatting</button>
        <h2>Adjusted list:</h2>
        <pre id="output">Waiting for input...</pre>
    </div>

    <script>
        function formatTaxes() {
            // Eingabe aus dem Textbereich holen
            const input = document.getElementById('input').value;

            // Regulärer Ausdruck zur Extraktion der Steuerwerte und -arten
            const regex = /\d+\.\d{2}[A-Z0-9]{1,2}/g;

            // Passende Werte finden
            const matches = input.match(regex);

            // Ergebnis anzeigen oder Fehlermeldung
            const output = document.getElementById('output');
            if (matches) {
                output.textContent = matches.join('\n');
            } else {
                output.textContent = "Keine gültigen Steuerwerte gefunden.";
            }
        }
    </script>
	
  
    <script>
		document.addEventListener("DOMContentLoaded", function () {
			document.getElementById("navbar-placeholder").innerHTML = `
				<nav class="sidebar">
				<img src="logo.png">
					<ul>
						<li><a href="template-creator.php">Template-Creator</a></li>
						<li><a href="mail-doc.php">Mail-Documentation</a></li>
						<li><a href="tax-getter.php">Tax-Compressor</a></li>
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
