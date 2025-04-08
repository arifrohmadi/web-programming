<?php
# bmi (body mass index)
$weight = $_GET['weight'] ?? 50; // in kilograms
$height = $_GET['height'] ?? 1.5; // in meters

$bmi = $weight / pow($height,2);
/* 
| **BMI Range**        | **Category**       |
|----------------------|--------------------|
| Less than 18.5       | Underweight        |
| 18.5 – 24.9          | Normal weight      |
| 25 – 29.9            | Overweight         |
| 30 and above         | Obesity            | */

echo "<i>BMI Checker</i><br>";
echo "Your Weight is: $weight (kg)<br>";
echo "Your Height is: $height (m)<br>";
echo "Your BMI is: " . round($bmi, 2) . "<br>";
switch(true) {
    case $bmi < 18.5:
        echo "Category: Underweight";
        break;
    case $bmi >= 18.5 && $bmi < 24.9:
        echo "Category: Normal";
        break;
    case $bmi >= 25 && $bmi < 29.9:
        echo "Category: Overweight";
        break;
    default:
        echo "Category: Obesity";
}
echo "<br>";