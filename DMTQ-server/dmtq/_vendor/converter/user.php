<?php

class UserConverter {

    function getConnectUuid ($params) {
        return (object)[
            'guid' => $params[0],
            'os' => $params[1]
        ];
    }

    function getUsersByPuid ($params) {
        return (object)[
            'puid' => $params[0][0],
            'requestData' => $params[1][0]
        ];
    }

    function loginV2 ($params) {
        return (object)[
            'accessToken' => $params[0],
            'nickName' => $params[1],
            'profileImg' => $params[2],
            'version' => $params[3],
            'area' => $params[5],
            'os' => $params[4]
        ];
    }

    function setNickname ($params) {
        return (object)[
            'guid' => $params[0],
            'nickName' => $params[1]
        ];
    }
	
    function setConnectUuid ($params) {
        return (object)[
            'guid' => $params[0],
			'code' => $params[1],
            'os' => $params[2]
        ];
    }
}