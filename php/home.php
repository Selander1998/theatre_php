<?php
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
    <title>Welcome</title>
</head>

<body>
    <header>
        <h1>
            Välkommen tillbaka, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
        </h1>
    </header>
    <p>Du är nu inloggad</p>
</body>

</html>