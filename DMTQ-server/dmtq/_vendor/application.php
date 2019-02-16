<?php

function runApi ($requestId, $method, $params) {
    $controllerName = ucfirst(substr($method, 0, strpos($method, '.')));
    $convertName = $controllerName.'Converter';
    $actionName = substr($method, strpos($method, '.') + 1);
    if (class_exists($controllerName) && method_exists($controllerName, $actionName)) {
        $controller = new $controllerName();
        $convert = new $convertName();
        return $controller->$actionName($convert->$actionName($params));
    } else {
        return (object)[
            'result' => [],
            'error' => NULL
        ];
    }
    return (object)[];

}
function runSystem () {
    //global $config;-----
    header('Content-Type: application/json');
	$request = file_get_contents('php://input');
    $data = json_decode($request, true);
    $result = [];
    if ($data) {
        for ($i = 0; $i < count($data); $i++) {
            $response = runApi($data[$i]['id'], $data[$i]['method'], $data[$i]['params']);
            array_push($result, [
                'result' => $response->result,
                'error' => $response->error,
                'id' => $data[$i]['id']
            ]);
        }
    }
    echo json_encode($result);
}
function getHeader($headerId, $defaultValue) {
    $headerList = apache_request_headers();
    foreach ($headerList as $name => $value) {
        if ($headerId === $name) {
            return $value;
        }
    }
    return $defaultValue;
}