<?php 
    $age = $_POST['age'];

    if ($age >= 21){
        echo "You're adult now";
    } else {
        echo "You're still young";
    }
?>