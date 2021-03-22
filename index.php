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

//\array_search();//ускоренная обработка

abstract class A
{
    public static $var = 'yeah';

    abstract function test(int $i): int;
}

class B extends A
{
    function test(int $i): int
    {
        return 1;
    }

    function func(string $var)
    {
        return $var . $var;
    }
}

class C extends A
{
    function test(int $i): int
    {
        return 2;
    }

    private function str0($test): string
    {
        return $test . $test;
    }

    final function str($test): string
    {
        return $test . $test;
    }
}

final class E extends C
{
    function func(string $var): int
    {
        return $var . $var;
    }

    public function str0($test): string
    {
        return $test . $test . $test;
    }
}

class D
{
    function test(A $obj): int
    {
        return $obj->test(5);
    }

    function print(): void
    {
        A::$var = 1111;
        var_dump(A::$var);
    }
}

$objB = new B;
$objC = new C;
$objD = new D;
$objE = new E;

//    var_dump($objD->test($objB));
//    var_dump($objD->test($objC));
//    var_dump($objE->str0('test'));

$objD->print();

//5.1 Создать абстрактный класс "животные"
abstract class Animals
{
    abstract function amountFood(int $weight): ?float;
}
//5.2 Создать наследников от животных - хищники, травоядные
class Predators extends Animals
{
    const EAT_COEFFICIENT = 1.5;

    function amountFood(int $weight): float
    {
       return self::EAT_COEFFICIENT * $weight;
    }
}

class Herbivores extends Animals
{
    const EAT_COEFFICIENT = 2;

    function amountFood(int $weight): float
    {
        return self::EAT_COEFFICIENT * $weight;
    }
}

$objPredators = new Predators();
var_dump($objPredators->amountFood(100));
$objPredators = new Herbivores();
var_dump($objPredators->amountFood(300));

//5.2 Создать абстрактный класс "Транспортные средства"
abstract class Transport
{
    /**
     * @var int in american cent
     */
    protected int $costByMile;

    public function __construct($costByMile)
    {
        $this->costByMile = $costByMile;
    }
    /**
     * @param int $weight
     * @param int $distance
     * @return int
     */
    abstract function transportationCosts(int $weight, int $distance): int;
    /**
     * @param int $costInCents
     * @return numeric
     */
    public function convertCostToDollars(int $costInCents): int
    {
        return $costInCents/100;
    }
}
//5.4 Создать наследников от транспортных средств - лодки, легковые авто, грузовики
//5.5 Создать реализации для всех наследников первого уровня
class Boats extends Transport
{
    private $cranePrice;

    function __construct($costByMile, $cranePrice) {
        parent::__construct($costByMile);
        $this->cranePrice = $cranePrice;
    }

    function transportationCosts(int $weight, int $distance): int
    {
        return $this->costByMile * $weight * $distance * $this->cranePrice;
    }
}

class PassengerCars extends Transport
{
    function __construct($costByMile) {
        parent::__construct($costByMile);
    }

    function transportationCosts(int $weight, int $distance): int
    {
        return $this->costByMile * $weight * $distance;
    }
}

class Trucks extends Transport
{
    private $containerPrice;

    function __construct($costByMile, $containerPrice) {
        parent::__construct($costByMile);
        $this->containerPrice = $containerPrice;
    }

    function transportationCosts(int $weight, int $distance): int
    {
        return $this->costByMile * $weight * $distance * $this->containerPrice;
    }
}

$objBoats = new Boats(30, 10000);
$cost = $objBoats->transportationCosts(2000, 450);
var_dump($objBoats->convertCostToDollars($cost));

//5.6 Создать хелпер работающий с массивами
class ArrayHelper
{
    public static function sumSecondNumbers(array $arr)
    {
        $sum = 0;
        array_walk_recursive(
            $arr,
            static function ($value, $key) use (&$sum) {
                if (is_numeric($value) && !($key % 2 === 0)) {
                    $sum += $value;
                }
            }
        );
        return $sum;
    }
}

var_export(ArrayHelper::sumSecondNumbers([1,2,5,4,[6,5,2,3],5,2,3,[6,5,2,3]]));

//5.7 Создать хелпер работающий со строками
class StringHelper
{
    public static function getFileNameWithoutFormat(string $str)
    {
        $arr = mb_str_split($str, 1, 'UTF-8');
        $result = [];
        foreach ($arr as $value){
            if(array_key_exists($value, $result)){
                ++$result[$value];
            } else {
                $result[$value] = 1;
            }
        }
        return $result;
    }
}

var_export(StringHelper::getFileNameWithoutFormat('суммы входящих символов/sum entry chars'));

class StringHelper
{
    public static function camelCaseToSeparateWords(string $str): string
    {
        return implode(' ', preg_split('/(?=[A-Z])/',$str));
    }
}
class Transport
{
    public function getTypeDescription(string $methodName, string $type): string
    {
        return static::class ." have {$type} ". StringHelper::camelCaseToSeparateWords($methodName);
    }
}
interface WheelFormula
{
    public function wheelParams(int $wheelCount, int $wheelDriveCount): array;
}
interface BodyType
{
    const TYPE_PICK_UP = 'pick_up';
    const TYPE_CLOSE = 'close';

    public function bodyType(string $type): string;
}
interface EngineType
{
    const TYPE_DIESEL = 'diesel';
    const TYPE_ELECTRIC = 'electric';

    public function engineType(string $type): string;
}
interface TransmissionType
{
    const TYPE_AUTOMATIC = 'automatic';
    const TYPE_MANUAL = 'automatic';
    const TYPE_LEVER = 'lever';

    public function transmissionType(string $type): string;
}
trait Power
{
    public function calcEnginePower(string $engineType, int $engineCapacity = null)
    {
        //TODO кажется я не правильно задал типы данных, не пойму как считать со стрингой
    }
}

class Tractor extends Transport implements WheelFormula, BodyType, EngineType, TransmissionType
{
    use Power;

    public function wheelParams(int $wheelCount, int $wheelDriveCount): array
    {
        return [
            'wheel_count' => $wheelCount,
            'wheel_drive' => $wheelDriveCount,
        ];
    }

    public function bodyType(string $type): string
    {
        return $this->getTypeDescription(__FUNCTION__, $type);
    }

    public function engineType(string $type): string
    {
        return $this->getTypeDescription(__FUNCTION__, $type);
    }

    public function transmissionType(string $type): string
    {
        return $this->getTypeDescription(__FUNCTION__, $type);
    }
}

class Panzer extends Transport implements BodyType, EngineType, TransmissionType
{
    use Power;

    public function bodyType(string $type): string
    {
        return $this->getTypeDescription(__FUNCTION__, $type);
    }

    public function engineType(string $type): string
    {
        return $this->getTypeDescription(__FUNCTION__, $type);
    }

    public function transmissionType(string $type): string
    {
        return $this->getTypeDescription(__FUNCTION__, $type);
    }
}

class Bike extends Transport implements WheelFormula, TransmissionType
{
    public function wheelParams(int $wheelCount, int $wheelDriveCount): array
    {
        return [
            'wheel_count' => $wheelCount,
            'wheel_drive' => $wheelDriveCount
        ];
    }

    public function transmissionType(string $type): string
    {
        return $this->getTypeDescription(__FUNCTION__, $type);
    }
}

class Tesla extends Transport implements WheelFormula, BodyType, EngineType, TransmissionType
{
    use Power;

    public function wheelParams(int $wheelCount, int $wheelDriveCount): array
    {
        return [
            'wheel_count' => $wheelCount,
            'wheel_drive' => $wheelDriveCount,
        ];
    }

    public function bodyType(string $type): string
    {
        return $this->getTypeDescription(__FUNCTION__, $type);
    }

    public function engineType(string $type): string
    {
        return $this->getTypeDescription(__FUNCTION__, $type);
    }

    public function transmissionType(string $type): string
    {
        return $this->getTypeDescription(__FUNCTION__, $type);
    }
}

$objTractor = new Tractor();
var_export($objTractor->transmissionType(TransmissionType::TYPE_MANUAL));
var_export($objTractor->bodyType(BodyType::TYPE_CLOSE));
var_export($objTractor->engineType(EngineType::TYPE_DIESEL));
var_export($objTractor->wheelParams(4, 2));

$objPanzer = new Panzer();
var_export($objPanzer->transmissionType(TransmissionType::TYPE_LEVER));
var_export($objPanzer->bodyType(BodyType::TYPE_CLOSE));
var_export($objPanzer->engineType(EngineType::TYPE_DIESEL));

$objBike = new Bike();
var_export($objBike->transmissionType(TransmissionType::TYPE_LEVER));
var_export($objBike->wheelParams(2, 1));

$objTesla = new Tesla();
var_export($objTesla->transmissionType(TransmissionType::TYPE_AUTOMATIC));
var_export($objTesla->bodyType(BodyType::TYPE_PICK_UP));
var_export($objTesla->engineType(EngineType::TYPE_ELECTRIC));
var_export($objTesla->wheelParams(4, 2));