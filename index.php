<?php

//1. Получить сумму всех вторых элементов массива произвольного размера и вложенности.
$arr = [1,2,5,4,[6,5,2,3],5,2,3,[6,5,2,3]];
$sum = 0;
array_walk_recursive(
    $arr,
    static function ($value, $key) use (&$sum) {
        if (is_numeric($value) && !($key % 2 === 0)) {
            $sum += $value;
        }
    }
);
var_export($sum);

/*2.*/ $str = "Определить количество символов входящих в произвольную строку, т.е у строки 'afrae' a = 2, e=1, f=1,r=1";
$arr = mb_str_split($str, 1, 'UTF-8');
$result = [];
foreach ($arr as $value){
    if(array_key_exists($value, $result)){
        ++$result[$value];
    } else {
        $result[$value] = 1;
    }
}
var_export($result);
