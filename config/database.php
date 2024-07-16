<?php

require 'config/constants.php';

// connection to db 
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}
