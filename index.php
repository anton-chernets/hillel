<?php
/* Домашнее задание 3 */
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

/**
 * Example from Lesson
 * @param array $arr
 * @return mixed
 */
function recSum(array $arr)
{
    $i = 0;
    $sum = 1;
    foreach ($arr as $key => $value){
        if(is_array($value)) {
            $sum += recSum($value);
        }
        if(
            2 == $i
            && (is_integer($value)||is_double($value))
        ) {
            $sum = $value;
        }
        $i++;
    }
    return $sum;
}
echo recSum($arr);

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


/* Классное занятие 4 */
function boo(...$test)
{
    //
}
boo('string', 1, 5, [1,2,3]);
function boo2()
{
    function boo3()
    {
        //
    }
}
boo2();
boo3();


//    $closure ('hello');// не в области видимости клажура
$testString = ' World!';
$closure = function ($test) use($testString)
{
    echo $test . $testString;

};
$closure ('hello');
$testString (' World!2');// не в области видимости клажура
$closure ('hello');


function testStatic(int $a = 1)
{
    static $var;// хранит значение после вызова функции (обычно перетирается после вызова функции)
    $var = $var + $a;
    echo $var;
}
testStatic();
testStatic();
testStatic();
testStatic();

// 1. создать функцию - фабрику вызова функций пользователя через безымянную функцию
$str = 'test arg';
$fabric = function ($func) use ($str)
{
    echo $func($str);
};

function method1()
{
    echo "method1 без аргумента <br />\n";
}

function method2($arg)
{
    echo 'method2 аргумент - '. $arg ."<br />\n";
}

function method3($arg)
{
    echo 'method3 аргумент - '. $arg ."<br />\n";
}

$fabric('method1');
$fabric('method2');
$fabric('method3');

// 2. создать функцию обеспечивающую запись в csv файл
function writeToCSV(array $arr)
{
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="sample.csv"');

    $fp = fopen('php://output', 'wb');
    foreach ($arr as $line) {
        $val = explode(",", $line);
        fputcsv($fp, $val);
    }
    fclose($fp);
}
$arr = array(
    'test , string, for, homework',
    'another row',
);
writeToCSV($arr);

// 3. создать функцию обеспечивающую чтение из csv файла
function readFromCSV($filename)
{
    $handle = fopen($filename, "r");
    while (($data = fgetcsv($handle)) !== FALSE) {
        var_dump($data);
    }
}
readFromCSV('sample.csv');
