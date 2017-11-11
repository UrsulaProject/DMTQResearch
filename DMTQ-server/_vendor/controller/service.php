<?php

class Service {

    function getInfo ($params) {
        global $config;
        return (object)[
            'result' => [
                'api_url' => $config->API_PATH,
                'file_server_url' => $config->FILE_DOWNLOAD_PATH,
                'file_manage_ver' => $config->PATCH_ID,
                'service_type' => 'LIVE',
                'coupon_yn' => 'Y',
                'inspection_notice_yn' => 'N',
                'event_url' => $config->EVENT_PATH
            ],
            'error' => NULL
        ];
    }
}