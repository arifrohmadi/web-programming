<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // Database credentials
    $servername = "localhost";  // atau 127.0.0.1
    $username = "root";         // default Laragon user
    $password = "";             // default Laragon password kosong
    $dbname = "UniversityDB";   // nama database yang sudah kita buat

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query untuk mengambil data dari tabel Students
    $sql = "SELECT student_id, name, age, major FROM Students";
    $result = $conn->query($sql);

    // Tampilkan data jika ada hasil
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Major</th></tr>";

        // output data setiap baris
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["student_id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["age"] . "</td>";
            echo "<td>" . $row["major"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "0 results";
    }

    // Tutup koneksi
    $conn->close();
    ?>

</body>

</html>