<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbedaan PHP Procedural vs OOP</title>
</head>
<body>
    <?php
    # Procedural
    // Perintah satu-satu, campur aduk
    $nama = "Budi";
    echo "Halo " . $nama;

    echo "<br>";
    $nama2 = "Ani";
    echo "Halo " . $nama2;
    // Nulis hal yang sama berulang-ulang... capek!

    # OOP
    // Buku panduan = CLASS
    class Robot {
        public $nama;  // isian nama robot

        // Cara membuat robot baru
        public function __construct($nama) {
            $this->nama = $nama;
        }

        // Kemampuan robot
        public function sapa() {
            echo "Halo! Saya robot " . $this->nama . "!";
        }
    }

    // Cetak robot dari buku panduan = OBJECT
    $robot1 = new Robot("Budi");
    $robot2 = new Robot("Ani");

    echo "<br>";
    $robot1->sapa(); // Halo! Saya robot Budi!
    echo "<br>";
    $robot2->sapa(); // Halo! Saya robot Ani!

    ?>
</body>
</html>