<?php

$apiList = [
    'service.getInfo',

    'game.checkKakao2Global',
    'game.checkPmang2Global',
    'game.checkOld2Global',
    'game.getAchievementCount',
    'game.getFirstResourceSongList',
    'game.getGameAssetByPuid',
    'game.getGameAssetForMigByToken',
    'game.getLineScoreRange',
    'game.getLineScoreRangeWithLevel',
    'game.getLineTopRankWithLevel',
    'game.getOwnAchievementList',
    'game.getOwnItemList',
    'game.getOwnPatternScore',
    'game.getOwnQuestList',
    'game.getOwnSongList',
    'game.getPatternUrl',
    'game.getPreviewPlayInfo',
    'game.getSongUrl',
    'game.getUserAsset',
    'game.savePlayResult',

    'user.getConnectUuid',
    'user.getUsersByPuid',
    'user.loginV2',
    'user.setNickname',

    'shop.getOwnItemList',
    'shop.getUnlockedProductList',

    'memo.getMemoList',

    'board.getNoticeList'
];
function runApi ($requestId, $method, $params) {
    $controllerName = substr($method, 0, strpos($method, '.'));
    $actionName = substr($method, strpos($method, '.') + 1);
    if (class_exists($controllerName) && method_exists($controllerName, $actionName)) {
        $controller = new $controllerName();
        return $controller->$actionName($params);
    }
    return (object)[];

}
function runSystem () {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
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