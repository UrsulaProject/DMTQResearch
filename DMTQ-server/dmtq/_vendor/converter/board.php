<?php

class BoardConverter {

    function getNoticeList ($params) {
        return (object)[
            'code' => $params[0],
            'fromNewsId' => $params[1],
            'limit' => $params[2]
        ];
    }
}