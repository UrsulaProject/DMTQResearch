<?php

class UserController {

    function getConnectUuid ($params) {
		$code = UserModel::restoreCode($params);
		$error = NULL;
		$result = NULL;
        if ($code) {
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
        return (object)[
            'result' => $result,
            'error' => $error
        ];
    }

    function getUsersByPuid ($params) {
		$nickname = UserModel::nickname($params);
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
		global $config;
        list($puid, $appId, $deviceCode, $serverCode, $token, $accessTime) = explode('|', $params->accessToken);
		$guid = UserModel::guidByPuid($puid);
        if (!$guid) {
			$memberId = UserModel::nextUserId();
			$guid = $puid;
			UserModel::newUserByPuid($memberId, $puid);
        }
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
		UserModel::updateNickname($params);
        return (object)[
            'result' => true,
            'error' => NULL
        ];
    }
	
    function setConnectUuid ($params) {
		$guid = UserModel::guidByCode($params);
        if ($guid) {
            UserModel::updateGuid($guid, $params);
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
        return (object)[
            'result' => $result,
            'error' => $error
        ];
    }
}