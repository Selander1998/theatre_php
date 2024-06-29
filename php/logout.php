<?php

// Kontrollera så att vi har sessionsdata
if (!isset($_SESSION['user_id'])) {

    // Återställ data för session
    session_destroy();
}

// Redirecta användaren tillbaka till förstasidan
header("Location: ../html/index.html");
exit;