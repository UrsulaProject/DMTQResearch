<?php

class ServiceConverter {

    function getInfo ($params) {
        return (object)[
            'version' => $params[0],
            'os' => $params[1]
        ];
    }
}