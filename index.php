<?php

//1. Получить сумму всех вторых элементов массива произвольного размера и вложенности.
$array = [1,2,5,5,2,3];

//One example
$sumEvenNumbers = 0;
for ($i = 1; $i <= count($array); $i++) {
    if ($i % 2 === 0) {
        $sumEvenNumbers += $array[$i-1];
    }
}
var_export($sumEvenNumbers);

//Two example
$sumEvenNumbers2 = 0;
foreach ($array as $key => $value){
    if ($key === 0 && $key % 2 === 0) {
        $sumEvenNumbers2 += $value;
    }
}
var_export($sumEvenNumbers);
