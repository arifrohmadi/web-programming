<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "user_login";

//script untuk create password
// $password = md5("test123"); //enkripsi cara 1
// $password = password_hash("user123", PASSWORD_DEFAULT); //enkripsi cara 2
// echo $password;exit();

// Koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil dan sanitasi input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = md5($_POST['password']);

    // Cari user berdasarkan email
    /* $sql = "SELECT * FROM users WHERE email = '$email' and password = '$password'"; // sql injection: ' OR 1=1 limit 1 -- -''
    $result = $conn->query($sql); */

    // query aman dari sql injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password); // 'ss' = 2 string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        echo "Login berhasil. Selamat datang, <b>" . $row['email'] . "</b>";

        /* if (password_verify($password, $row['password'])) { // matching password untuk enkripsi cara 2
            echo "Login berhasil. Selamat datang, <b>" . $row['email'] . "</b>";
        } else {
            echo "Login gagal.";
        } */
    } else {
        echo "Login gagal";
    }
}

$conn->close();
