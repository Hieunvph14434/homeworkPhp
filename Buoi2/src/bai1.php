<?php
    $array = array_map(function(){
        return rand(1, 10);
    }, range(1, 10));

    // xao tron thu tu phan tu array
    shuffle($array);

    // loai bo cac phan tu giong nhau
    $array = array_unique($array);

    // sap xep theo thu tu tang dan
    asort($array);

    print_r($array);
?>
