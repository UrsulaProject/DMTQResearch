<?php

class User {

    function getConnectUuid ($params) {
        return (object)[
            'result' => [
                'status' => 'SUCCESS',
                'code' => 200,
                'uuid' => '1cbb551c25',
                'result_msg' => 'OK'
            ],
            'error' => NULL
        ];
    }

    function getUsersByPuid ($params) {
        global $config;
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("SELECT nickname FROM Member WHERE id = ".$params->puid);
        if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            list($nickname) = $queryData;
        } else {
            $nickname = ' ';
        }
        $handle->close();
        return (object)[
            'result' => [
				[
					$params->requestData => $nickname
				]
			],
            'error' => NULL
        ];
    }

    function loginV2 ($params) {
        list($puid, $appId, $deviceCode, $serverCode, $token, $accessTime) = explode('|', $params->accessToken);
        global $config;
        return (object)[
            'result' => [
                'API_TOKEN' => strtoupper(substr(md5($token).md5($accessTime), -58)),
                'SECRET_KEY' => $config->SECRET_KEY,
                'SECRET_VER' => '1',
                'guid' => (string)$puid,
                'recom_code' => 'QbCx9Xe',
                'displayName' => $params->nickName,
                'profileImg' => $params->profileImg,
                'INTRO_SERVER' => $config->API_PATH
            ],
            'error' => NULL
        ];
    }

    function setNickname ($params) {
        global $config;
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("UPDATE Member SET nickname = '".$params->nickName."' WHERE id = '".$params->guid."'");
        $handle->close();
        return (object)[
            'result' => true,
            'error' => NULL
        ];
    }
}