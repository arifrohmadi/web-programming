<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // Kelas untuk koneksi database
    class Database
    {
        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "UniversityDB";
        public $conn;

        public function __construct()
        {
            // Buat koneksi
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

            // Cek koneksi
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

        // Fungsi menutup koneksi
        public function close()
        {
            $this->conn->close();
        }
    }

    // Kelas untuk operasi Students
    class Student
    {
        private $db;

        public function __construct($db)
        {
            $this->db = $db;
        }

        // Fungsi untuk mengambil semua data student
        public function getAllStudents()
        {
            $sql = "SELECT student_id, name, age, major FROM Students";
            $result = $this->db->conn->query($sql);

            $students = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $students[] = $row;
                }
            }
            return $students;
        }
    }

    // --- Main program ---

    // Buat objek database
    $db = new Database();

    // Buat objek Student
    $student = new Student($db);

    // Ambil data students
    $students = $student->getAllStudents();

    // Tampilkan data di HTML
    if (!empty($students)) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Major</th></tr>";

        foreach ($students as $s) {
            echo "<tr>";
            echo "<td>" . $s["student_id"] . "</td>";
            echo "<td>" . $s["name"] . "</td>";
            echo "<td>" . $s["age"] . "</td>";
            echo "<td>" . $s["major"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No students found.";
    }

    // Tutup koneksi
    $db->close();
    ?>

</body>

</html>