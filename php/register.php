<?php

include "database.php";

// Kontrollera om formuläret har skickats
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Hämta data från POST
	$firstname = htmlspecialchars($_POST["firstname"]);
	$lastname = htmlspecialchars($_POST["lastname"]);
	$mail = htmlspecialchars($_POST["email"]);
	$password = htmlspecialchars($_POST["password"]);
	$phone_number = htmlspecialchars($_POST["phone_number"]);

	// Kontrollera att alla fälten är ifyllda
	if (!empty($firstname) && !empty($lastname) && !empty($mail) && !empty($password) && !empty($phone_number)) {

		// String concatenation för att få för och efternamn till ett och samma
		$full_name = $firstname . " " . $lastname;

		// Registrera användaren till databasen 
		$is_customer_added = addCustomerToDatabase($full_name, $mail, $phone_number, $password);

		// Kontrollera om våran använaare blev registrerad korrekt
		if ($is_customer_added) {
			// Skriv ut tackmeddelandet med användarens namn
			echo "<h2>Tack $firstname! Du har nu en registrerad användare! Du kan nu logga in med din mailadress.</h2>";
		} else {
			// Informera om att något gick snett
			echo "<h2>Någonting gick fel när din användare skulle regisreras, försök igen</h2>";
		}

	} else {
		// Meddela att alla fält måste vara ifyllda (Detta är ett edge-case, bör inte tillåtas utav html-forms?)
		echo "<h2>Alla fält måste fyllas i. Försök igen.</h2>";
	}
} else {
	// Meddela att formuläret inte har skickats korrekt
	echo "<h2>Formuläret skickades inte korrekt.</h2>";
}

function addCustomerToDatabase($customer_name, $customer_mail, $customer_phone_number, $password)
{

	$db_instance = establishDatabaseConnection();

	// Förbered våran sql-query
	$add_customer_query = mysqli_prepare($db_instance, "INSERT INTO customers (name, mail, phone_number, password) VALUES (?, ?, ?, ?)");

	// Av säkerhetsskäl så krypterar vi användarens lösenord i databasen
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	// Bind våra parametrar till våran query, ssi indikerar att vi har string, string, integer som data
	mysqli_stmt_bind_param($add_customer_query, "ssss", $customer_name, $customer_mail, $customer_phone_number, $hashed_password);

	// Kör våran query
	mysqli_stmt_execute($add_customer_query);

	// Kontrollera om vi ändrade databasen
	if (mysqli_affected_rows($db_instance) > 0) {

		// Använd resultatet för våran query
		mysqli_use_result($db_instance);

		// Returnera true för att påvisa att vi kunde registrera användaren
		return true;
	}

	// Returnera false för att påvisa att vi inte kunde registrera användaren
	return false;
}
;