<?php

//1. Получить сумму всех вторых элементов массива произвольного размера и вложенности.
$array = [1,2,5,5,2,3];

//One example
$sumEvenNumbers = 0;
for ($i = 1; $i <= count($array); $i++) {
    if ($i % 2 === 0 && is_numeric($array[$i-1])) {
        $sumEvenNumbers += $array[$i-1];
    }
}
var_export($sumEvenNumbers);

//Two example
$sumEvenNumbers2 = 0;
foreach ($array as $key => $value){
    if ($key === 0 && $key % 2 === 0 &&  is_numeric($value)) {
        $sumEvenNumbers2 += $value;
    }
}
var_export($sumEvenNumbers);

/*2.*/ $str = "Определить количество символов входящих в произвольную строку, т.е у строки 'afrae' a = 2, e=1, f=1,r=1";

//$str = 'Some text for example';
$result = [];
if(preg_match('/[а-я]+/msi', $str)){
    echo 'Cyrillic not supported';
} else{
    for ($i = 0; $i <= strlen($str); $i++) {
        $key = $str[$i];
        if(!empty($key)){
            if(array_key_exists($key, $result)){
                ++$result[$key];
            } else {
                $result[$key] = 1;
            }
        }
    }
    var_dump($result);
}
