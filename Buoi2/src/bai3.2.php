<?php
// khong dung ham
$a = [
    [8, 1, 5, 4, 2],
    [3, 9, -1, 6, 10],
    [-1, 7, 8, 2, 3],
    [5, 2, 4, 1, 8],
    // [11, -2, 4, 1, 8],
];

// a) Tính tổng tất cả các phần tử dương của mảng.
function sumPositive($array) {
    $sumPositive = 0;
    for ($i=0; $i < count($array); $i++) { 
        for ($j=0; $j < count($array[$i]); $j++) { 
            $currentNumber = $array[$i][$j];
            if($currentNumber > 0) {
                $sumPositive += $currentNumber;
            }
        }
    }
    return "Tổng tất cả các phần tử dương của mảng: $sumPositive <br/> <br/>";
}
echo sumPositive($a);
// b) Tính tổng các phần tử A[i][j] trong đó (i + j) chia hết cho 5.
function sumDivisible5($array) {
    $sumDivisible5 = 0;
    for ($i=0; $i < count($array); $i++) { 
        for ($j=0; $j < count($array[$i]); $j++) { 
            $currentNumber = $array[$i][$j];
            if(($i + $j) % 5 == 0){
                $sumDivisible5 += $currentNumber;
            }
        }
    }
    return "Tổng các phần tử A[i][j] trong đó (i + j) chia hết cho 5: $sumDivisible5 <br/> <br/>";
}
echo sumDivisible5($a);
// c) In ra các số nguyên tố theo từng hàng.
function prime($array) {
    $rowIsPrime = [];
    for ($i=0; $i < count($array); $i++) { 
        for ($j=0; $j < count($array[$i]); $j++) { 
            $currentNumber = $array[$i][$j];
            if(isPrime($currentNumber)) {
                $rowIsPrime[$i][] = $currentNumber;
            }
        }
    }
    foreach($rowIsPrime as $key => $value) {
        $key = $key + 1;
        $row = "Hàng $key: ";
        foreach($value as $val) {
            $row .= $val . (count($value) > 1 && $val != end($value) ? ", " : "");
        }
        echo $row . "<br>";
    }
}
echo "In ra các số nguyên tố theo từng hàng <br>";
prime($a);
echo "<br/>";
// d) Sắp xếp tăng dần theo hàng.
function sortByRow($array) {
    for ($i=0; $i < count($array); $i++) { 
        echo "Hàng ". $i + 1 .": " . "Array(" . implode(", ", selectionSort($array[$i])) . ")<br/>";
    }
}
echo "Sắp xếp tăng dần theo hàng <br/>";
sortByRow($a);
echo "<br/>";
// e) Tính tổng các phần tử trên đường chéo chính (i = j) và trên đường biên.
function sumDiagonalLine($array) {
    $sumDiagonalLine = 0;
    for ($i=0; $i < count($array); $i++) { 
        for ($j=0; $j < count($array[$i]); $j++) { 
            $currentNumber = $array[$i][$j];
            if($i == $j){
                $sumDiagonalLine += $currentNumber;
            }
        }
    }
    return "Tổng các phần tử trên đường chéo chính (i = j): $sumDiagonalLine <br/>";
}
echo sumDiagonalLine($a);
function sumBorder($array) {
    $sumBorder = 0;
    for ($i=0; $i < count($array); $i++) { 
        for ($j=0; $j < count($array[$i]); $j++) { 
            $currentNumber = $array[$i][$j];
            if($i == 0 || $i == count($array) - 1 || $j == 0 || $j == count($array[$i]) - 1){
                $sumBorder += $currentNumber;
            }
        }
    }
    return "Tổng các phần tử trên đường biên: $sumBorder <br/> <br/>";
}
echo sumBorder($a);

// f) Tìm phần tử max, phần tử min theo từng hàng, từng cột và toàn bộ ma trận.
function minMaxByRow($array) {
    $minRow = [];
    $maxRow = [];
    for ($i=0; $i < count($array); $i++) { 
        $minRow[$i][] = getMin(...$array[$i]);
        $maxRow[$i][] = getMax(...$array[$i]);
    }
    foreach($minRow as $key => $value){
        $row = $key + 1;
        echo "Min hàng " . $row . ": " . $value[0] ."<br>";
        echo "Max hàng " . $row . ": " . $maxRow[$key][0] ."<br> <br>";
    }
}
echo "Min, Max theo hàng <br>";
minMaxByRow($a);
function minMaxByColumn($array) {
    $minCol = [];
    $maxCol = [];
    for ($i=0; $i < count($array); $i++) { 
        for ($j=0; $j < count($array[$i]); $j++) { 
            $currentNumber = $array[$i][$j];
            if(! isset($minCol[$j])){
                $minCol[$j] = $currentNumber;
            }
            if(! isset($maxCol[$j])){
                $maxCol[$j] = $currentNumber;
            }
            $minCol[$j] = getMin($minCol[$j], $currentNumber);
            $maxCol[$j] = getMax($maxCol[$j], $currentNumber);
        }
    }
    foreach($minCol as $key => $value){
        $row = $key + 1;
        echo "Min cột " . $row . ": " . $value ."<br>";
        echo "Max cột " . $row . ": " . $maxCol[$key] ."<br> <br>";
    }
}
echo "Min, Max theo cột <br>";
minMaxByColumn($a);
function minMaxArray($array) {
    $min = $array[0][0];
    $max = $array[0][0];
    foreach ($array as $value) {
        foreach ($value as $val) {
            $min = getMin($min, $val);
            $max = getMax($max, $val);
        }
    }
    echo "Min: " . $min . "<br/>";
    echo "Max: " . $max . "<br/>";
}
echo "Min, Max toàn bộ ma trận <br>";
minMaxArray($a);

function isPrime($number) {
    if($number < 2) return false;
    for ($i=2; $i <= sqrt($number); $i++) { 
        if($number % $i == 0) return false;
    }
    return true;
}

function getMin(...$values) {
    $minVal = $values[0];

    foreach ($values as $value) {
        if($minVal > $value) {
            $minVal = $value;
        }
    }
    return $minVal;
}

function getMax(...$values) {
    $maxVal = $values[0];

    foreach ($values as $value) {
        if($maxVal < $value) {
            $maxVal = $value;
        }
    }
    return $maxVal;
}

function selectionSort($arr) {
    for ($i=0; $i < count($arr) - 1; $i++) { 
        $min = $i;
        for ($j = $i + 1; $j < count($arr); $j++) { 
            if($arr[$j] < $arr[$min]) {
                $min = $j;
            }
        }
        $update = $arr[$i];
        $arr[$i] = $arr[$min];
        $arr[$min] = $update;
    }
    return $arr;
}
