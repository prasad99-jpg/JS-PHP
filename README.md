# JS-PHP
# Futuristic Login and Registration System

## Project Overview

This project is a web-based Login and Registration System developed using HTML, CSS, JavaScript, PHP, and MySQL. The main objective of the project is to provide a secure and user-friendly authentication system with a modern futuristic user interface. The system allows users to register, log in, and manage authentication securely.

The project demonstrates the integration of frontend and backend technologies to create a complete web application. It also includes database connectivity, form validation, password handling, and email functionality using PHPMailer.

## Features

* User Registration System
* User Login Authentication
* Secure Password Storage
* Responsive User Interface
* Modern Futuristic Design
* Form Validation using JavaScript
* PHP Backend Integration
* MySQL Database Connectivity
* Email Verification using PHPMailer
* Error Handling and Validation
* Session Management
* Logout Functionality

## Technologies Used

### Frontend

* HTML5
* CSS3
* JavaScript

### Backend

* PHP

### Database

* MySQL

### Additional Tools

* PHPMailer
* XAMPP Server
* Visual Studio Code

## Project Structure

```
project-folder/
│
├── index.php
├── login.php
├── register.php
├── logout.php
├── database.php
├── style.css
├── script.js
├── assets/
├── images/
├── PHPMailer/
└── README.md
```

## System Requirements

* XAMPP/WAMP/LAMP Server
* PHP 7.0 or higher
* MySQL Database
* Web Browser

## Installation Steps

1. Install XAMPP or any local server.
2. Copy the project folder into the `htdocs` directory.
3. Start Apache and MySQL from XAMPP Control Panel.
4. Open phpMyAdmin.
5. Create a new database.
6. Import the SQL file into the database.
7. Update database credentials in the PHP configuration file.
8. Open the browser and run the project using:

```
http://localhost/project-folder
```

## Working of the Project

### User Registration

* The user enters details such as username, email, and password.
* JavaScript validates the input fields.
* PHP processes the form data.
* User information is stored securely in the MySQL database.
* PHPMailer sends verification or confirmation emails.

### User Login

* The user enters login credentials.
* PHP checks the database for matching records.
* Sessions are created after successful authentication.
* The user gains access to the system.

### Logout

* The session is destroyed.
* The user is redirected to the login page.

## Security Features

* Password Encryption
* Session Handling
* Input Validation
* SQL Injection Prevention
* Error Handling

## Advantages

* Simple and user-friendly interface
* Secure authentication system
* Responsive design
* Easy to maintain and modify
* Real-world web development implementation

## Limitations

* Requires internet browser support
* Basic authentication features only
* Requires server setup for deployment

## Future Enhancements

* Two-factor authentication
* Password reset via email
* User profile management
* Admin dashboard
* Dark and Light theme support
* Database encryption
* Cloud deployment

## Team Members and Responsibilities

### Prasad

* Backend integration and project coordination

### Vivek

* CSS design and styling

### Yash

* HTML structure and webpage layout

### Ziyan

* JavaScript functionality and validation

### Jivi

* Database management and testing

## Conclusion

This project provides a complete authentication system using modern web technologies. It helps in understanding frontend-backend integration, database connectivity, user authentication, and web application security. The futuristic interface improves the user experience while maintaining functionality and security.
