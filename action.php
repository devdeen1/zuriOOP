<?php

require 'classes/Dbh.php';
require 'classes/UserAuth.php';
require 'classes/Route.php';

// Using a switch condition for each form action or button
// switch condition start
switch (true) {
    case isset($_POST['register']):
//extracting the values from the register form
        $fullname = $_POST['fullnames'];
        $email = $_POST['email'];
        $country = $_POST['country'];
        $gender = $_POST['gender'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
// calling the class and method responsible for registering user
        $route = new formController($fullname, $email, $country, $gender, $password, $confirmPassword);
        $route->handleForm();
        break;

//extracting the values from the login form
    case isset($_POST['login']):
        $email = $_POST['email'];
        $password = $_POST['password'];
// calling the class and method responsible for login
        $route = new LoginController($email, $password);
        $route->handleLogin();
        break;

//extracting the values from the reset password form
    case isset($_POST["reset"]):
        $email = $_POST['email'];
        $password = $_POST['password'];
// calling the class and method responsible for resetting password
        $route = new ResetPasswordController($email, $password);
        $route->resetPassword($email, $password);
        break;

//extracting the id from the anchor tag in the delete button
    case isset($_GET["deleteid"]):
        $id = $_GET['deleteid'];
        $_SESSION['id'] = $id;
// calling the class and method responsible for deleting a user
        $route = new deleteController();
        $route->handleDelete();
        break;

    // if this button to fetch all user pressed
    case isset($_POST["all"]):
// call the class and method responsible for fetching all users
        $route = new getAllController();
        $route->handleGetAll();
        break;

// if this button for logout is pressed
    case isset($_POST["logout"]):
// call the class and method responsible for deleting that user
        $route = new LogoutController();
        $route->handleLogout();
        break;
}

