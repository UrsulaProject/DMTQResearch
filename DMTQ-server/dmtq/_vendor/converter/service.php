<?php

class ServiceConverter {

    function getInfo ($params) {
        return (object)[
            'version' => $params[0],
            'clientOS' => $params[1]
        ];
    }
}