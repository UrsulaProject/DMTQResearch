<?php
header('Content-Type: application/json');
$data = [
    'value' => [],
    'result_code' => '000',
    'result_msg' => 'API_OK'
];
echo json_encode($data);