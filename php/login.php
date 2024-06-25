<?php

include "database.php";

// Kontrollera om formuläret har skickats
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Hämta data från POST
    $mail = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    // Kontrollera att alla fälten är ifyllda
    if (!empty($mail) && !empty($password)) {

        $is_valid = validateLoginCredentials($mail, $password);

        if ($is_valid) {
            $customer_data = getCustomerData($mail);

            echo "<h2>Välkommen tillbaka " . $customer_data["name"] . "</h2>";
        }
    } else {
        // Meddela att alla fält måste vara ifyllda (Detta är ett edge-case, bör inte tillåtas utav html-forms?)
        echo "<h2>Alla fält måste fyllas i. Försök igen.</h2>";
    }
} else {
    // Meddela att formuläret inte har skickats korrekt
    echo "<h2>Formuläret skickades inte korrekt.</h2>";
}

function validateLoginCredentials($mail, $password)
{
    // Skapa en databasinstans och sätt variabelvärde
    $db_instance = establishDatabaseConnection();

    // Förbered våran sql-query
    if ($customer_fetch_query = mysqli_prepare($db_instance, "SELECT customer_id FROM customers WHERE mail=? AND password=?")) {

        mysqli_stmt_bind_param($customer_fetch_query, "ss", $mail, $password);

        mysqli_stmt_execute($customer_fetch_query);

        mysqli_stmt_bind_result($customer_fetch_query, $result_id);

        while (mysqli_stmt_fetch($customer_fetch_query)) {
            sleep(0);
        }

        mysqli_stmt_close($customer_fetch_query);
    }
    ;

    mysqli_close($db_instance);

    if (!$result_id) {
        echo "<h2>Kontot du försökte logga in med existerar inte alternativt så har du angett felaktiva inloggningsuppgifter.</h2>";
        return false;
    }

    return true;
}