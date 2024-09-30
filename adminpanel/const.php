<?php

include '../conn.php';


$data = [
    [
        'name' => 'NCR',
        'value' => 645.00
    ],
    [
        'name' => 'CAR',
        'value' => 430.00
    ],
    [
        'name' => 'I',
        'value' => 435.00
    ],
    [
        'name' => 'II',
        'value' => 450.00
    ],
    [
        'name' => 'III',
        'value' => 500.00
    ],
    [
        'name' => 'III Aurora',
        'value' => 449.00
    ],
    [
        'name' => 'IV-A EMA',
        'value' => 560.00
    ],
    [
        'name' => 'IV-A CC',
        'value' => 540.00
    ],
    [
        'name' => 'IV-A 1CM',
        'value' => 540.00
    ],
    [
        'name' => 'IV-A 1CM',
        'value' => 520.00
    ],
    [
        'name' => 'IV-A 2CM3CM',
        'value' => 450.00
    ],
    [
        'name' => 'IV-A 4CM5CM6CM',
        'value' => 450.00
    ],
    [
        'name' => 'IV-B',
        'value' => 400.00
    ],
    [
        'name' => 'V',
        'value' => 400.00
    ],
    [
        'name' => 'VI',
        'value' => 480.00
    ],
    [
        'name' => 'VII A',
        'value' => 501.00
    ],
    [
        'name' => 'VII B',
        'value' => 463.00
    ],
    [
        'name' => 'VII C',
        'value' => 453.00
    ],
    [
        'name' => 'VIII',
        'value' => 405.00
    ],
    [
        'name' => 'IX',
        'value' => 400.00
    ],
    [
        'name' => 'X 1',
        'value' => 438.00
    ],
    [
        'name' => 'X 2',
        'value' => 423.00
    ],
    [
        'name' => 'XI',
        'value' => 481.00
    ],
    [
        'name' => 'XII',
        'value' => 403.00
    ],
    [
        'name' => 'XIII',
        'value' => 400.00
    ],
    [
        'name' => 'BARMM',
        'value' => 400.00
    ]
];

// echo count($arr);
// print_r($arr);
$newArr = [];
foreach ($data as $key => $val) {
    $name = $val['name'];
    $value = $val['value'];
    $stmt = $conn->prepare("insert into region (region, rate) values ('$name', '$value')");
    $stmt->execute() ? $newArr['res'] = true : $newArr['res'] = false;
}
// for ($i = 0; $i < count($data) - 1; $i++) {
//     $name = $arr[$i]['name'];
//     $value = $arr[$i]['value'];
//     array_push($newArr, ['1' => $name, '2' => $value]);
//     // $stmt = $conn->prepare("insert into region (region, rate) values ('$name', '$value')");
//     // $stmt->execute() ? $newArr['res'] = true : $newArr['res'] = false;

// }
print_r($newArr);
