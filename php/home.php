<?php

// Inititera en ny session
session_start();

// Dubbelkolla så att användaren är inloggaed innan vi fortsätter
// Om användaren inte har all data tillgänglig så skickar vi tillbaka den till inloggningssidan
if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/index.html"); // Redirect to the login page if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Ladda in font-awesome biblioteket för att få tillgång till ikoner -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <title>Välkommen tillbaka</title>
</head>

<body>
    <header>

        <style>
            /* Placera element för våran användare */
            .user-info-box {
                position: absolute;
                top: 10px;
                right: 10px;
                background-color: #f0f0f0;
                padding: 10px 20px;
                border-radius: 5px;
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
                font-size: 14px;
                display: flex;
                align-items: center;
            }

            /* Se till att vårat namn inte sitter ihop med utloggningsknappen */
            .logout-form {
                margin-left: 10px;
            }

            /* Styling för untloggningsknappen */
            .logout-button {
                background-color: #ff4c4c;
                color: white;
                border: none;
                border-radius: 5px;
                padding: 5px 10px;
                cursor: pointer;
                display: flex;
                align-items: center;
            }

            /* Se till att texten "logga ut" inte sitter ihop med ikonen */
            .logout-button i {
                margin-right: 5px;
            }
        </style>

        <div class="user-info-box">
            <!-- Visa vilken användare som är inloggad -->
            <span>Inloggad som <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>

            <!-- Skapa post-funktion för utloggnign -->
            <form action="../php/logout.php" method="post" class="logout-form">
                <!-- Skapa knapp för utloggning -->

                <button type="submit" class="logout-button">
                    <!-- Placera utloggningsikon och utloggningtext -->
                    <i class="fas fa-sign-out-alt"></i> Logga ut
                </button>

            </form>
        </div>
    </header>
</body>

</html>