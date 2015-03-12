<?php

echo "<table cellspacing='0' width='500px' border = '1px' bordercolor='black'>";
$ctn = 0;
for ($i = 1; $i <= 9; $i++) {
    $ctn++;
    echo "<tr>";
    if ($i <= 3) {
        $odd = "white";
        $even = "blue";
    } elseif ($i > 3 && $i <= 6) {
        $odd = "white";
        $even = "black";
    } elseif ($i > 6 && $i <= 9) {
        $odd = "green";
        $even = "black";
    }

    for ($j = 1; $j <= 9; $j++) {

        if (($i + $j) % 2 === 1) {
            echo "<td style='text-align: center;' height='50px' bgcolor='$even'>$ctn";
        } else {
            echo "<td style='text-align: center;' height='50px' bgcolor='$odd'>$ctn";
        }
    }
    echo "</tr>";
}


echo "</table><br><br>";



