<?php
require 'config/database.php';
session_start(); // Start the session

if (isset($_POST['submit'])) {

    // get form data
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username_email || !$password) {
        $_SESSION['signin'] = !$username_email ? "Username or Email required" : "Password required";
        $_SESSION['signin-data'] = $_POST;
        header('Location: ' . ROOT_URL . 'signin.php');
        die();
    } else {

        // fetch user from database
        $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if (mysqli_num_rows($fetch_user_result) == 1) {
            // convert the record to assoc array
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];

            // compare password with dbpassword
            if (password_verify($password, $db_password)) {
                // set session access control 
                $_SESSION['user-id'] = $user_record['id'];

                // set session if user is admin
                if ($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }

                // log user in
                header('Location: ' . ROOT_URL . 'admin/');
                die();
            } else {
                $_SESSION['signin'] = "Incorrect password";
                $_SESSION['signin-data'] = $_POST;
            }
        } else {
            $_SESSION['signin'] = "User not found";
            $_SESSION['signin-data'] = $_POST;
        }

        // Redirect back to sign-in page with error message
        header('Location: ' . ROOT_URL . 'signin.php');
        die();
    }
} else {
    header('Location: ' . ROOT_URL . 'signin.php');
    die();
}
