<?php
$mathExample = "27 - X = 17";

$data = explode(' ', $mathExample);

$firstName = $data[0];   
$action = $data[1];      
$secondName = $data[2];  
$equal = $data[3];       
$answerNum = $data[4];   

if ($firstName == "X") {
    $knownNum = $secondName;
    $xPlace = "X стоит первым числом";
    if ($action == "-") {
        $xValue = $answerNum + $knownNum;
    }
} else {
    $knownNum = $firstName;
    $xPlace = "X стоит вторым числом";
    if ($action == "-") {
        $xValue = $knownNum - $answerNum;
    }
}

echo "1. Оператор: " . $action . " (вычитание)\n";
echo "2. Расположение X: " . $xPlace . "\n\n";
echo "3. Решение:\n";
echo "   " . $knownNum . " - X = " . $answerNum . "\n";
echo "   " . $knownNum . " - " . $answerNum . " = X\n";
echo "   X = " . $xValue . "\n\n";
echo "4. Проверка: " . $knownNum . " - " . $xValue . " = " . ($knownNum - $xValue) . "\n\n";
echo "ОТВЕТ: X = " . $xValue . "\n";
?>