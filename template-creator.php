
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
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Template-Creator</title>
    <link rel="stylesheet" href="navbar.css">
  <style>
    body {
        background: rgb(43, 43, 43);
        color: white;
	      font-family: 'TW Cen MT', sans-serif;
    }
    h1 {
      margin-left: 20px;
    }
    textarea {
		margin-left: 20px;
      width: 90%;
      height: 500px;
      padding: 10px;
      border: 1px solid #ccc; 
      border-radius: 5px;
      resize: none;
      color: white;
      background: rgb(74, 74, 74);
      font-size: 20px;
      outline: none;
      border: none;
      box-shadow: 1px 1px 5px black;
      font-family: 'TW Cen MT', sans-serif;
    }
    button {
      display: inline;
	    width: 15%;
      padding: 10px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      margin-top: 10px;
      cursor: pointer;
	    margin-left: 20px;
    }
    button:hover {
      background-color: #0056b3;
    }
    .checkbox-container {
      margin-top: 20px;
	  font-size: 20px;
	  margin-left: 20px;
    }
    .checkbox-container label {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div id="navbar-placeholder"></div>   
  <h1>Template-Creator</h1>
  <textarea id="textArea"></textarea>
  <br>
  <button id="copyButton">Copy all</button>
  <button id="resetButton">Reset</button>
  <div class="checkbox-container">
    <label><input type="checkbox" class="text-block" data-text="Thank you for contacting us.&#10;A confirmation of your identity is required to manage your booking with Airline XY.&#10;&#10;Please follow the link below to complete the verification process:&#10;https://www.airline.xy/verify-identity&#10;Your booking details:&#10;Booking code:&#10;First name:&#10;Surname:&#10;&#10;As soon as the verification process is complete, you can view all booking details and make changes."> Airline Verification</label>
    <label><input type="checkbox" class="text-block" data-text="Thank you for contacting us.&#10;To manage your booking with Airline XY, you need to log in to the website.&#10;&#10;Please follow the link below to complete the registration:&#10;https://www.airline.xy/my-booking&#10;Your booking details:&#10;Booking code:&#10;E-mail address:&#10;&#10;Now you can link your booking to a Airline XY account and make changes."> Airline Log-In</label>
    <label><input type="checkbox" class="text-block" data-text="Thank you for contacting us regarding your booking cancellation.&#10;&#10;We would like to inform you that it may take up to six weeks to process your refund.&#10;As soon as we receive the refund from the airline, we will automatically transfer the amount to the original means of payment used."> Cancel (before confirmation of airline)</label>
    <label><input type="checkbox" class="text-block" data-text="Thank you for contacting us regarding your booking cancellation.&#10;&#10;We would like to inform you that the cancellation of your booking has already been confirmed by the airline.&#10;It can take up to six weeks to process the refund.&#10;&#10;As soon as we receive the refund from the airline, we will automatically transfer the amount to the original means of payment used."> Cancel (after confirmation of airline)</label>
  </div>
  <script>
    const textArea = document.getElementById('textArea');
    const copyButton = document.getElementById('copyButton');
    const resetButton = document.getElementById('resetButton');
    const checkboxes = document.querySelectorAll('.text-block');

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', () => {
        let combinedText = '';
        checkboxes.forEach(cb => {
          if (cb.checked) {
            combinedText += cb.dataset.text;
          }
        });
        textArea.value = combinedText;
      });
    });

    copyButton.addEventListener('click', () => {
      textArea.select();
      document.execCommand('copy');
      alert('Text kopiert!');
    });

    resetButton.addEventListener('click', () => {
      checkboxes.forEach(cb => cb.checked = false);
      textArea.value = '';
    });
  </script>
  
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
