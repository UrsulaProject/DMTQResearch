<?php

class ShopConverter {

    function buyFreeProduct ($params) {
        return (object)[
            'guid' => $params[0],
            'productId' => $params[1]
        ];
    }

    function buyProductByQPoint ($params) {
        return (object)[
            'guid' => $params[0],
            'productId' => $params[1],
            'extra' => $params[2]
        ];
    }

    function getPackageInfoByGuid ($params) {
        return (object)[
            'guid' => $params[0]
        ];
    }

    function getProductForUnlock ($params) {
        return (object)[
            'guid' => $params[0],
            'productId' => $params[1]
        ];
    }

    function getOwnItemList ($params) {
        return (object)[
            'guid' => $params[0]
        ];
    }

    function getUnlockedProductList ($params) {
        return (object)[
            'guid' => $params[0]
        ];
    }


    function upgradeInGameItem ($params) {
        return (object)[
            'guid' => $params[0],
            'itemType' => $params[1],
            'itemLevel' => $params[2]
        ];
    }
}