<?php

// Visa errors, användbart för att exempelvis se problem med SQL eller .env under utveckling
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Hämta relativ path för projekt
require __DIR__ . '/../vendor/autoload.php';

// Använd Dotenv biblioteket "vlucas/phpdotenv"
use Dotenv\Dotenv;

// Funktion för att skapa en databasanslutning
function establishDatabaseConnection()
{

    // Ladda in .env fil och hämta användardata för databasinloggning pga att jag kommer råka skicka med lösenord här annars
    // Dessa kräver OOP-syntax (Object-oriented programming syntax) pga det phpdotenv bibliotek vi använder
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->safeLoad();

    // Skapa en ansluting via våran databasanvändare som vi skapat
    // Använder värden från våran .env fil $via _ENV variabeln
    $db_instance = mysqli_connect($_ENV["DB_IP"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

    // Om vi inte kunde etablera någon anslutning, visa errormeddelandet och stoppa våran execution
    if (mysqli_connect_errno() or !$db_instance) {
        printf("Could not connect to database: %s\n", mysqli_connect_error());
        exit();
    }

    // Returnera instansen vi initierade
    return $db_instance;
}
;

// Funktion för att hämta databasens data för kunder
function getCustomerData($customer_mail)
{

    // Skapa en databasinstans och sätt variabelvärde
    $db_instance = establishDatabaseConnection();

    // Förbered våran sql-query
    if ($customer_fetch_query = mysqli_prepare($db_instance, "SELECT customer_id, name, phone_number FROM customers WHERE mail=?")) {

        // Bind parametern för våran queries mail
        mysqli_stmt_bind_param($customer_fetch_query, "s", $customer_mail);

        // Kör våran query
        mysqli_stmt_execute($customer_fetch_query);

        // Bind våran queries resultat till variablerna result_
        mysqli_stmt_bind_result($customer_fetch_query, $result_id, $result_name, $result_pnumber);

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

    // Sätt våra return-värden till resultatet från våran query
    $customer_data = array(
        "id" => $result_id,
        "name" => $result_name,
        "phone_number" => $result_pnumber
    );

    // Returnera våran array med values
    return $customer_data;

}