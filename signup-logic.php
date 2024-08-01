<?php

require 'config/database.php';

// Start the session


// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// get signup form data if signup button is clicked
if(isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // Debugging - print input values
    echo "First Name: $firstname<br>";
    echo "Last Name: $lastname<br>";
    echo "Username: $username<br>";
    echo "Email: $email<br>";
    echo "Create Password: $createpassword<br>";
    echo "Confirm Password: $confirmpassword<br>";

    // validate inputs
    if(!$firstname) {
        $_SESSION['signup'] = "Please enter your First Name"; 
    } elseif (!$lastname) {
        $_SESSION['signup'] = "Please enter your Last Name"; 
    } elseif (!$username) {
        $_SESSION['signup'] = "Please enter your Username"; 
    } elseif (!$email) {
        $_SESSION['signup'] = "Please enter a valid Email"; 
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = "The password should be 8+ characters"; 
    } elseif (!$avatar['name']) {
        $_SESSION['signup'] = "Please add your Avatar"; 
    } else {
        // check if passwords don't match
        if($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "Passwords do not match";
            // Debugging - print password mismatch
            echo "Passwords do not match: $createpassword vs $confirmpassword<br>";
        } else {
            // hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
            // Debugging - print hashed password
            echo "Hashed Password: $hashed_password<br>";

            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' ";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result)>0 ){
                $_SESSION['signup'] = "Username or Email already exist";
            } else {
                // work on avatar
                // rename avatar
                $time = time(); // make each name unique using current time.
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;

                // make sure the file is actually an image

                $allowed_files = ['png','jpg','jpeg'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);
                if(in_array($extention, $allowed_files)) {
                    // make sure its not larger than 1mg
                    if($avatar['size'] < 1000000) {
                        // upload the avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);

                    } else {
                        $_SESSION['signup'] = 'File size is too big, it should be less than 1mb'; 
                    }

                } else {
                    $_SESSION['signup'] = "file should be png, jpg or jpeg";
                }
            }
        }
    }

    // Debugging - print session message if set
    if(isset($_SESSION['signup'])) {
        echo $_SESSION['signup'];
    }

    ///////////////////////////
   if (isset($_SESSION['signup']) ) {


    $_SESSION['signup-data'] = $_POST;

    header('location: ' . ROOT_URL . 'signup.php');
     die(); 
    }else {
        // insert new user into users 
        $insert_user_query = "INSERT INTO users SET firstname='$firstname', lastname= '$lastname', username= '$username', email='$email', password='$hashed_password', avatar='$avatar_name',is_admin=0";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        // redirect to login page with success message
        if (!mysqli_errno($connection)) {
            $_SESSION['signup-success'] = "Registration successful. Please Log in";
            header('location:' . ROOT_URL . 'signin.php');
            die();
        }
    }

} else {
    //if button is not clicked bounce back to signup
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
?>
