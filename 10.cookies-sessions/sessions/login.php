<?php
session_start();

// Dummy account for demo purposes
$valid_email = "user@gmail.com";
$valid_password = "password123";

// Ambil data dari form
$email = $_POST['email'];
$password = $_POST['password'];

// Validasi login
if ($email === $valid_email && $password === $valid_password) {
    $_SESSION['email'] = $email;
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: index.php?error=Invalid email or password");
    exit();
}
?>
