<?php

class shop {

    function getOwnItemList ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getUnlockedProductList ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }
}