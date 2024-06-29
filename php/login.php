<?php

// Inititera en ny session
session_start();

// Inkludera filen database.php för att få tillgång till dess funktioner
include "database.php";

// Kontrollera om formuläret har skickats
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Hämta data från POST
    $mail = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    // Kontrollera att alla fälten är ifyllda
    if (!empty($mail) && !empty($password)) {

        // Validera inloggning
        $is_valid = validateLoginCredentials($mail, $password);

        // Om våran inloggning är godkänd
        if ($is_valid) {
            // Hämta resten utav kundens data
            $customer_data = getCustomerData($mail);

            // Sätt kundens data till sessionsvariabler
            $_SESSION['user_id'] = $customer_data["id"];
            $_SESSION['user_name'] = $customer_data['name'];
            $_SESSION['user_phone_number'] = $customer_data['phone_number'];

            // Redirecta till home.php
            header("Location: home.php");

            // Avlsuta filens execution
            exit;
        }
    } else {
        // Meddela att alla fält måste vara ifyllda (Detta är ett edge-case, bör inte tillåtas utav html-forms?)
        echo "<h2>Alla fält måste fyllas i. Försök igen.</h2>";
    }
} else {
    // Meddela att formuläret inte har skickats korrekt
    echo "<h2>Formuläret skickades inte korrekt.</h2>";
}

// Funktion för att validera ett inloggningsförsök
function validateLoginCredentials($mail, $password)
{
    // Skapa en databasinstans och sätt variabelvärde
    $db_instance = establishDatabaseConnection();

    // Förbered våran sql-query
    if ($customer_fetch_query = mysqli_prepare($db_instance, "SELECT customer_id, password FROM customers WHERE mail=?")) {

        // Bind parametern för våran queries mail
        mysqli_stmt_bind_param($customer_fetch_query, "s", $mail);

        // Kör våran query
        mysqli_stmt_execute($customer_fetch_query);

        // Bind våran queries resultat till variablerna result_
        mysqli_stmt_bind_result($customer_fetch_query, $result_id, $result_hashed_password);

        // Under tiden vi väntar på svar från databasen, låt programmet pausas
        while (mysqli_stmt_fetch($customer_fetch_query)) {
            sleep(0);
        }

        // Stäng processen för våran query
        mysqli_stmt_close($customer_fetch_query);
    }
    ;

    // Stäng anslutning till databasen
    mysqli_close($db_instance);

    // Om vi inte hittar ett id som resultat, så finns ingen användare registrerad 
    if (!$result_id) {
        // Informera om icke existerande användare
        echo "<h2>Kontot du försökte logga in med existerar inte</h2>";
        return false;
    }

    // Om vårat lösenord inte stämmer överrens våran email
    if (!password_verify($password, $result_hashed_password)) {
        // informera om att lösenordet inte stämmer
        echo "<h2>Lösenordet du angivit är felaktikt, försök igen</h2>";
        return false;
    }

    return true;
}