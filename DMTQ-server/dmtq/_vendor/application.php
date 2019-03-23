<?php
include_once('config.php');
$global = (object)[];
DEFINE('BASE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
$casePath = BASE_PATH.'{{SEARCH}}'.DIRECTORY_SEPARATOR.'{{CLASS_NAME}}.php';
spl_autoload_register(function ($className) {
    global $casePath;
    $path = str_replace('{{CLASS_NAME}}', $className, $casePath);
    $searchList = ['controller', 'model', 'converter'];
    for ($i = 0; $i < count($searchList); $i++) {
        if (file_exists(str_replace('{{SEARCH}}', $searchList[$i], $path))) {
            include_once(str_replace('{{SEARCH}}', $searchList[$i], $path));
        }
    }
});
register_shutdown_function(function () {
    global $global;
    if (isset($global->db)) {
		$global->db->close();
        $global->db = NULL;
        unset($global->db);
    }
});
function connectDB() {
    global $config, $global;
    if (!isset($global->db)) {
        $global->db = new SQLite3($config->DB_PATH);
    }
    return $global->db;
}
function runApi ($requestId, $method, $params) {
    $controllerName = ucfirst(substr($method, 0, strpos($method, '.')));
    $convertName = $controllerName.'Converter';
	$controllerName .= 'Controller';
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