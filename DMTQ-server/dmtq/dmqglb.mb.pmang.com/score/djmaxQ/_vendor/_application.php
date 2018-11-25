<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
function runApi ($method) {
    $controllerName = ucfirst(substr($method, 0, strpos($method, '.')));
    $actionName = substr($method, strpos($method, '.') + 1);
    if (class_exists($controllerName) && method_exists($controllerName, $actionName)) {
        $controller = new $controllerName();
        return $controller->$actionName($_POST);
    } else {
        return (object)[
            'result' => [],
            'error' => NULL
        ];
    }
    return (object)[];

}
function runSystem ($method) {
    header('Content-Type: application/json');
    echo json_encode(runApi($method));
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