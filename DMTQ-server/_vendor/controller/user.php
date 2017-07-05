<?php

class user {

    function getConnectUuid ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getUsersByPuid ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function loginV2 ($params) {
        global $config;
        $isRegister = !!getHeader('Secret-Key', '');

        return (object)[
            'result' => [
                'API_TOKEN' => 'O7VuJJOWiOgWTF5zBey8T9LLpmP94LmQATjDjAex5kUS9p0BI9CKksBXej+OX8l4',
                'SECRET_KEY' => $isRegister ? $config->REGISTER_SECRET_KEY : $config->NOT_REGISTER_SECRET_KEY,
                'SECRET_VER' => '1',
                'guid' => '3018783',
                'recom_code' => 'QbCx9Xe',
                'displayName' => '',
                'profileImg' => '',
                'INTRO_SERVER' => $config->API_PATH
            ],
            'error' => false
        ];
    }

    function setNickname ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }
}