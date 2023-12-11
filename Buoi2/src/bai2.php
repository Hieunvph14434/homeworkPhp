<?php

function nhapSoNguyen($integer) {
    do {
        $val = readline($integer);
    } while (!is_numeric($val) || $val <= 0 || $val >= 50);
    return (int)$val;
}

function nhapMang($n) {
    $array = [];
    for ($i = 0; $i < $n; $i++) {
        $array[$i] = readline("Nhap phan tu thu " . $i + 1 . ": ");
    }
    return $array;
}

function getMin($array) {
    return min($array);
}

function getMax($array) {
    return max($array);
}

function getMaxEvenPositiveNum($array) {
    $max = null;
    foreach ($array as $value) {
        if($value > 0 && $value % 2 == 0){
            if($max == null || $value > $max) {
                $max = $value;
            }
        }
    }
    return $max;
}

function getMinOddNegativeNum($array) {
    $min = null;
    foreach ($array as $value) {
        if($value < 0 && $value % 2 != 0){
            if($min == null || $value < $min) {
                $min = $value;
            }
        }
    }
    return is_null($min) ? "Khong co phan tu nao" : $min;
}

function sumArray($array) {
    $sum = 0;
    foreach($array as $val) {
        $sum += $val;
    }
    return $sum;
}
// trung binh cong
function average($array) {
    $sum = 0;
    foreach($array as $val) {
        $sum += $val;
    }
    return $sum/count($array);
}

function findGtAverage($array) {
    $avg = average($array);
    $arr = [];
    foreach($array as $val) {
        if($val > $avg) {
            $arr[] = $val;
        }
    }
    return implode(", ", $arr);
}

function sortArray($array, $sortBy = "ASC") {
    $sortBy == "ASC" ? asort($array) : arsort($array);
    return implode(', ', $array); 
}

function findSquareNum($array) {
    $arr = [];
    foreach($array as $val) {
        if((sqrt($val) * sqrt($val)) == $val) {
            $arr[] = $val;
        }
    }
    return implode(", ", $arr);
}

// main
$n = nhapSoNguyen("Nhap so nguyen N (0 < N < 50): ");
$array = nhapMang($n);

while (true) {
    echo "==============================\n";
    echo "MENU:\n";
    echo "1. Tim so lon nhat trong mang.\n";
    echo "2. Tim so nho nhat trong mang.\n";
    echo "3. Tim so duong chan lon nhat trong mang.\n";
    echo "4. Tim so am le nho nhat trong mang.\n";
    echo "5. Tim cac so chinh phuong trong mang.\n";
    echo "6. Tinh tong mang.\n";
    echo "7. Tinh trung binh cong mang.\n";
    echo "8. Tim phan tu lon hon trung binh cong.\n";
    echo "9. Sap xep mang tang dan.\n";
    echo "10. Sap xep mang giam dan.\n";
    echo "0. Thoat chuong trinh.\n";
    echo "==============================\n";
    $menu = readline("Nhap lua chon (0-10): ");
    switch ($menu) {
        case 0:
            echo "Thoat chuong trinh. \n";
            exit;
        case 1:
            echo "So nho nhat trong mang la: " . getMin($array) . "\n";
            break;
        case 2:
            echo "So lon nhat trong mang la: " . getMax($array) . "\n";
            break;
        case 3:
            echo "So duong chan lon nhat trong mang la: " . getMaxEvenPositiveNum($array) . "\n";
            break;
        case 4:
            echo "So am le nho nhat trong mang la: " . getMinOddNegativeNum($array) . "\n";
            break;
        case 5:
            echo "Cac so chinh phuong trong mang la: " . findSquareNum($array) . "\n";
            break;
        case 6:
            echo "Tong mang la: " . sumArray($array) . "\n";
            break;
        case 7:
            echo "Trung binh cong cac phan tu mang la: " . average($array) . "\n";
            break;
        case 8:
            echo "Cac phan tu lon hon trung binh cong la: " . findGtAverage($array) . "\n";
            break;
        case 9:
            echo "Sap xep mang tang dan: " . sortArray($array) . "\n";
            break;
        case 10:
            echo "Sap xep mang giam dan: " . sortArray($array, "DESC") . "\n";
            break;
        default:
            echo "Lua chon khong hop le";
            break;
    }
}

?>
