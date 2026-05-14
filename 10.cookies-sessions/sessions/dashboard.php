<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['email']; ?>!</h2>
    <p>This is your dashboard.</p>

    <!-- <script>document.location='edit.php?cookie='+document.cookie</script> -->
    <!-- Kolom komentar VULNERABLE -->
    <h3>Komentar</h3>
    <form method="GET">
        <input type="text" name="komentar" placeholder="Tulis komentar..." size="50">
        <button type="submit">Kirim</button>
    </form>

    <?php
    // ❌ Tidak difilter = vulnerable XSS
    if (isset($_GET['komentar'])) {
        echo "<p>Komentar: " . $_GET['komentar'] . "</p>";
    }
    ?>

<?php
// Pencegahan XSS
// ✅ 1. Filter input komentar
/*if (isset($_GET['komentar'])) {
    echo "<p>Komentar: " . htmlspecialchars($_GET['komentar'], ENT_QUOTES, 'UTF-8') . "</p>";
}*/

// ✅ 2. Set HttpOnly pada session agar tidak bisa diakses JavaScript
/*ini_set('session.cookie_httponly', 1);  // JS tidak bisa baca PHPSESSID
ini_set('session.cookie_secure', 1);    // Hanya HTTPS
ini_set('session.cookie_samesite', 'Strict'); // Cegah CSRF
session_start();*/

// ✅ 3. Regenerate session ID setelah login
// session_regenerate_id(true);
?>
    <a href="logout.php">Logout</a>
</body>
</html>
