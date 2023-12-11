<?php
// dung ham
$a = [
    [8, 1, 5, 4, 2],
    [3, 9, -1, 6, 10],
    [-1, 7, 8, 2, 3],
    [5, 2, 4, 1, 8],
    // [11, -2, 4, 1, 8],
];

$sumPositive = 0;
$sumDivisible5 = 0; 
$rowIsPrime = [];
$sumDiagonalLine = 0;
$sumBorder = 0;
$rowMin = [];
$rowMax = [];
$colMin = [];
$colMax = [];
$min = $a[0][0];
$max = $a[0][0];

for ($i=0; $i < count($a); $i++) { 
    for ($j=0; $j < count($a[$i]); $j++) { 
        $currentNumber = $a[$i][$j];
        if($currentNumber > 0){
            $sumPositive += $currentNumber;
        }
        if(($i + $j) % 5 == 0){
            $sumDivisible5 += $currentNumber;
        }
        if(isPrime($currentNumber)) {
            $rowIsPrime[$i][] = $currentNumber;
        }
        if($i == $j) {
            $sumDiagonalLine += $currentNumber;
        }
        if($i == 0 || $i == count($a) - 1 || $j == 0 || $j == count($a[$i]) - 1) {
            $sumBorder += $currentNumber;
        }
        
        if (!isset($colMin[$j])) {
            $colMin[$j] = $currentNumber;
        }
        if (!isset($colMax[$j])) {
            $colMax[$j] = $currentNumber;
        }

        // Cap nhat gia tri min max cho column
        $colMin[$j] = min($colMin[$j], $currentNumber);
        $colMax[$j] = max($colMax[$j], $currentNumber);

        $min = min($min, $currentNumber);
        $max = max($max, $currentNumber);
    }
    $rowMin[$i][] = min($a[$i]);
    $rowMax[$i][] = max($a[$i]);
}

// a) Tính tổng tất cả các phần tử dương của mảng.
echo "Tổng tất cả các phần tử dương của mảng: $sumPositive <br/> <br/>";
// b) Tính tổng các phần tử A[i][j] trong đó (i + j) chia hết cho 5.
echo "Tổng các phần tử A[i][j] trong đó (i + j) chia hết cho 5: $sumDivisible5 <br/> <br/>";
// c) In ra các số nguyên tố theo từng hàng.
echo "In ra các số nguyên tố theo từng hàng <br>";
foreach($rowIsPrime as $key => $value) {
    $key = $key + 1;
    $row = "Hàng $key: ";
    foreach($value as $val) {
        $row .= $val . (count($value) > 1 && $val != end($value) ? ", " : "");
    }
    echo $row . "<br>";
}
echo "<br/>";
// d) Sắp xếp tăng dần theo hàng.
echo "Sắp xếp tăng dần theo hàng <br/>";
for ($i=0; $i < count($a); $i++) { 
    asort($a[$i]);
    echo "Hàng ". $i + 1 .": " . "Array(" . implode(", ", $a[$i]) . ")<br/>";
}
echo "<br/>";
// e) Tính tổng các phần tử trên đường chéo chính (i = j) và trên đường biên.
echo "Tổng các phần tử trên đường chéo chính (i = j): $sumDiagonalLine <br/>";
echo "Tổng các phần tử trên đường biên: $sumBorder <br/> <br/>";

// f) Tìm phần tử max, phần tử min theo từng hàng, từng cột và toàn bộ ma trận.
echo "Min, Max theo hàng <br>";
foreach($rowMin as $key => $value){
    $row = $key + 1;
    echo "Min hàng " . $row . ": " . $value[0] ."<br>";
    echo "Max hàng " . $row . ": " . $rowMax[$key][0] ."<br> <br>";
}
echo "Min, Max theo cột <br>";
foreach($colMin as $key => $value){
    $row = $key + 1;
    echo "Min cột " . $row . ": " . $value ."<br>";
    echo "Max cột " . $row . ": " . $colMax[$key] ."<br> <br>";
}
echo "Min, Max toàn bộ ma trận <br>";
echo "Min: " . $min . "<br/>";
echo "Max: " . $max . "<br/>";

function isPrime($number) {
    if($number < 2) return false;
    for ($i=2; $i <= sqrt($number); $i++) { 
        if($number % $i == 0) return false;
    }
    return true;
}
