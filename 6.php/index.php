<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php echo "My first PHP script!";
    echo "<br>";

    # comment
    // ini single line comment
    # ini juga single line comment
    /* ini multi 
    line comment */

    # variables
    $name = "John";
    $status = "University Student";
    $colors = array('red', 'green', 'blue', 'yellow', 'pink');
    echo "Hi my name is $name, I'm currently a $status. My favorite color is $colors[1]";
    echo "<br><br>";

    // pricing
    $quantity = 1000;
    $origPrice = 100;
    $currPrice = 75;
    $diffPrice = $currPrice - $origPrice;
    $diffPricePercent = (($currPrice - $origPrice) * 100) / $origPrice;

    echo "<b>Pricing</b><br>";
    echo "Quantity: $quantity <br>
    Cost Price: $origPrice <br>
    Current Price: $currPrice <br>
    Absolute change in price: $diffPrice <br>
    Percent change in price: $diffPricePercent<br>";
    ?>

    <p><b>Conditional</b></p>
    <form action="age.php" method="post">
        <label for="age">Enter your age:</label><input type="text" name="age" size="2">
    </form>

    <i>Greeting</i><br>
    <?php
    $t = date("H");

    if ($t < 10) {
        echo "Have a good morning";
    } else if ($t < 20) {
        echo "Have a good day";
    } else {
        echo "Have a good night";
    }

    echo "<br>";
    $a = 15;
    $b = $a % 2 == 0 ? "even number" : "odd number";
    print($b);
    ?>

    <p><i>Special Menu</i><br>
        <?php
        $day = @$_GET['day'];

        switch ($day) {
            case 1:
                $special = 'chicken noodle';
                break;
            case 2:
                $special = 'fried rice';
                break;
            case 3:
                $special = 'corn soup';
                break;
            case 4:
            case 5:
            case 6:
                $special = 'fried chicken';
                break;
            default:
                $special = 'spinach';
                break;
        }

        echo "Today's menu is $special";
        echo "</p>";
        include 'bmi.php';
        echo "<br>";
        ?>

        <b>Loop</b><br>
        <?php
        # while loop
        $i = 1;
        while ($i < 6) {
            echo $i;
            $i++;
        }
        echo "<br>";

        # for loop
        for ($i = 1; $i < 6; $i++) {
            echo $i;
        }
        echo "<br>";

        # do while
        $j = 1;
        do {
            echo $j;
            $j++;
        } while ($j < 6);
        echo "<br>";

        #foreach loop
        $angka = array(1, 2, 3, 4, 5, 6);
        print "<pre>";
        print_r($angka);
        print "</pre>";

        foreach ($angka as $a) {
            echo "$a";
        }
        echo "<br><br>";
        ?>

        <b>File</b><br>
        <?php
        // Set file to read
        $file = 'item.txt';
        // Open file
        $f = fopen($file, 'r') or die('Could not open file!');
        // Read file contents
        $data = fread($f, filesize($file)) or die('Could not read file!');
        // Close file
        fclose($f);
        // Print file contents
        echo $data;
        echo "<br><br>";
        ?>

        <b>Function</b><br>

        <?php
        changeCase("Hello John", "L");
        changeCase("I like learning php programming", "U");

        function changeCase($str, $flag)
        {
            /* check the flag variable and branch the code */
            switch ($flag) {
                case 'U':
                    print strtoupper($str) . "<br />";
                    break;
                case 'L':
                    print strtolower($str) . "<br />";
                    break;
                default:
                    print $str . "<br />";
                    break;
            }
        }
        ?>

</body>

</html>