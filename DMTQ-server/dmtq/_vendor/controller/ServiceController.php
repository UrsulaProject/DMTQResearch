<?php

class ServiceController {

    function getInfo ($params) {
        global $config;
        return (object)[
            'result' => [
                'api_url' => $config->API_PATH,
                'file_server_url' => $config->FILE_DOWNLOAD_PATH,
                'file_manage_ver' => $params->version === '1.0.17' ? $config->OLD_PATCH_ID : $config->PATCH_ID,
                'service_type' => 'LIVE',
                'coupon_yn' => 'Y',
                'terms_yn' => 'Y',
                'pp_live_status' => 'Y',
                'inspection_notice_yn' => 'N',
                // 'inspection_notice' => [
                //     'inspection_notice_id' => '1002',
                //     'start_date' => '20171220100000',
                //     'end_date' => '20171220145959',
                //     'popup_start_date' => '20171220100000',
                //     'popup_end_date' => '20171220145959',
                //     'description' => "1220\uc810\uac80",
                //     'reg_date' => '20171109102617'
                // ]
                'event_url' => $config->EVENT_PATH
            ],
            'error' => NULL
        ];
    }
}