# Theatre Account Registration and Login System

This project is a simple account registration and login system for a theatre (cinema) website. Users can register with their name, email, phone number, and password. Once registered, they can log in to access a welcome page displaying their name. The system uses PHP for backend processing and MySQL for database management.

## Contributing

This is a school project, any contributions will not be applied. This is purely meant to function as a showcase of the codebase.

## Features

- **User Registration**: Users can register with their first name, last name, email, phone number, and password.
- **User Login**: Registered users can log in with their email and password.
- **Session Management**: User sessions are managed to ensure secure access to protected pages.
- **Welcome Page**: After logging in, users are greeted with a welcome page displaying their name.

## Prerequisites

- PHP (created with version 8.1.2)
- MySQL (created with version 5.7)
- Web server (created with VSCode PHP server extension)
- Composer (for dependancies)

## Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/Selander1998/theatre_php.git
   cd theatre_php
   ```

2. **Database Setup**

   - Create a new MySQL database:

     ```sql
     CREATE DATABASE theatre;
     ```

   - Create the `customers` table:

     ```sql
     CREATE TABLE customers (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(255) NOT NULL,
         mail VARCHAR(255) NOT NULL,
         phone_number VARCHAR(255) NOT NULL,
         password VARCHAR(255) NOT NULL
     );
     ```

3. **Configure Database Connection**

   - Create a .env file and fill in required parameters from .env.example:

     ```
     DB_IP=your_database_ip
     DB_USER=your_database_user_name
     DB_PASSWORD=your_database_user_password
     DB_NAME=your_database_name
     ```

## Usage

1. **Register a New Account**

   - Navigate to the registration page.
   - Fill in the form with your first name, last name, email, phone number, and password.
   - Click the "Register" button.

2. **Log In**

   - Navigate to the login page.
   - Enter your email and password.
   - Click the "Login" button.
   - Upon successful login, you will be redirected to the welcome page displaying your name.

## Security Considerations

- **Prepared Statements**: SQL queries use prepared statements to prevent SQL injection attacks.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## TODO

- Name display header on login
- Implement PHP session management
