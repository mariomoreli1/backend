<?php
if (isset($_GET['expression'])) {
    $expr = $_GET['expression'];
} else {
    echo "0";
    exit;
}

if (empty($expr)) {
    echo "0";
    exit;
}

// Замена констант
$expr = str_replace('pi', pi(), $expr);
$expr = str_replace('e', exp(1), $expr);

function factorial($n) {
    if ($n < 0) return NAN;
    if ($n == 0 || $n == 1) return 1;
    return $n * factorial($n - 1);
}

// Функция для вычисления корня любой степени
function root($a, $b) {
    return pow($a, 1/$b);
}

function absolute($n) {
    return abs($n);
}

// Подготавливаем выражение для eval
function prepareExpression($expr) {
    $expr = preg_replace('/-\(/', '-(', $expr);
    $expr = preg_replace('/--/', '+', $expr);
    $expr = preg_replace('/\+-/', '-', $expr);
    $expr = preg_replace('/-\*/', '*-', $expr);
    $expr = preg_replace('/([0-9.]+)\^([0-9.]+)/', 'pow($1,$2)', $expr);
    $expr = preg_replace('/([0-9.]+)\^\(([^)]+)\)/', 'pow($1,$2)', $expr);
    $expr = preg_replace('/root\(([^,]+),([^)]+)\)/', 'root($1,$2)', $expr);
    $expr = preg_replace('/sqrt\(([^)]+)\)/', 'sqrt($1)', $expr);
    $expr = preg_replace('/ln\(([^)]+)\)/', 'log($1)', $expr);
    $expr = preg_replace('/log\(([^)]+)\)/', 'log10($1)', $expr);
    $expr = preg_replace('/fact\(([^)]+)\)/', 'factorial($1)', $expr);
    $expr = preg_replace('/abs\(([^)]+)\)/', 'abs($1)', $expr);
    
    return $expr;
}

try {
    $prepared = prepareExpression($expr);
    $code = '$result = ' . $prepared . ';';
    
    eval($code);
    
    if (isset($result) && is_numeric($result)) {
        $result = round($result, 10);
        if (floor($result) == $result) {
            $result = (int)$result;
        }
        echo $result;
    } else {
        echo "Ошибка";
    }
} catch (ParseError $e) {
    echo "Ошибка синтаксиса";
} catch (Throwable $e) {
    echo "Ошибка";
}
?>