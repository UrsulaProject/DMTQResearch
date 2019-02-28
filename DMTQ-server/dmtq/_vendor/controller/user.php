<?php

class User {

    function getConnectUuid ($params) {
        global $config;
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("SELECT code FROM Member WHERE guid = ".$params->guid);
		$error = NULL;
		$result = NULL;
        if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            list($code) = $queryData;
			$result = [
                'status' => 'SUCCESS',
                'code' => 200,
                'uuid' => $code,
                'result_msg' => 'OK'
            ];
        } else {
			$error = [
				'code' => 'SVC.05001',
				'message' => 'Error (Invalid pmangplus(member_id) user id)'
			];
        }
        $handle->close();
        return (object)[
            'result' => $result,
            'error' => $error
        ];
    }

    function getUsersByPuid ($params) {
        global $config;
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("SELECT nickname FROM Member WHERE guid = ".$params->puid);
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
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("SELECT guid FROM Member WHERE puid = '".$puid."'");
        if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            list($guid) = $queryData;
        } else {
			//return (object)[
			//	'result' => []
			//];
            $query = $handle->query("SELECT MAX(id) + 1 FROM Member");
            if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
                list($memberId) = $queryData;
                if (!$memberId) {
                    $memberId = 1;
                }
            } else {
                $memberId = 1;
            }
			$guid = $puid;
            $handle->query("INSERT INTO Member (id, nickname, guid, puid, code) VALUES (".$memberId.", ' ', '".$puid."', '".$puid."', '".substr(md5('CODE_'.$memberId), -10)."')");
        }
        $handle->close();
        return (object)[
            'result' => [
                'API_TOKEN' => strtoupper(substr(md5($token).md5($accessTime), -58)),
                'SECRET_KEY' => $config->SECRET_KEY,
                'SECRET_VER' => '1',
                'guid' => (string)$guid,
                'recom_code' => 'AAAAAA',
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
        $query = $handle->query("UPDATE Member SET nickname = '".$params->nickName."' WHERE guid = '".$params->guid."'");
        $handle->close();
        return (object)[
            'result' => true,
            'error' => NULL
        ];
    }
	
    function setConnectUuid ($params) {
        global $config;
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("SELECT guid FROM Member WHERE code = '".$params->code."'");
		$error = NULL;
		$result = NULL;
        if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            list($newGuid) = $queryData;
			$query = $handle->query("UPDATE Member SET guid = '".$newGuid."' WHERE guid = '".$params->guid."'");
			$handle->close();
			$result = [
                'status' => 'SUCCESS',
                'code' => 200,
                'result_msg' => 'OK'
            ];
        } else {
			$error = [
				'code' => 'SVC.05001',
				'message' => 'Error (Invalid pmangplus(member_id) user id)'
			];
        }
        $handle->close();
        return (object)[
            'result' => $result,
            'error' => $error
        ];
    }
}