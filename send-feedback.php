<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>in Bearbeitung...</title>
    <meta http-equiv="refresh" content="5;url=template-creator.php">
    <style>
        * {
            margin: 0;
            padding: 0;
            text-align: center;
            font-size: 25px;
            font-family: "Tw Cen MT", sans-serif;
        }

        html, body {
            height: 100%;
            width: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        #wrap {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;    
        }

        #textsample {
            animation-name: slide-in;
            animation-duration: 3s;
            width: 60%;
        }
        
        @keyframes slide-in {
            from {
                margin-top: 200px;
                opacity: 0%;
            }

            to {
                margin-top: 0px;
                opacity: 100%;
            }
        }

    </style>
</head>
<body>
    <div id="wrap">
        <div id="textsample">
            <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $nachricht = $_POST['nachricht'] ?? '';

                    $to = 'mika.b.job@gmail.com';
                    $subject = 'Feedback Verwaltungstool';
                    $headers = "From: kontaktformular@invia.hosting191360.a2e1c.netcup.net\r\n";
                    $headers .= "Reply-To: kontaktformular@invia.hosting191360.a2e1c.netcup.net\r\n";
                    $headers .= "Content-Type: text/plain; charset=UTF-8";

                    if (mail($to, $subject, $nachricht, $headers)) {
                        $message = "Danke für das Feedback!";
                    } else {
                        $message = "Das hat nicht funktioniert. Bitte direkt per Mail an mika.b.job@gmail.com";
                    }
                }
            ?>
            <?php echo "<br>".$message; ?>
        </div>
    </div>
</body>
</html>