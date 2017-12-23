<?php
$data = [
    'value' => [],
    'result_code' => '000',
    'result_msg' => 'API_OK'
];
header('Content-Type: application/json');
echo json_encode($data);