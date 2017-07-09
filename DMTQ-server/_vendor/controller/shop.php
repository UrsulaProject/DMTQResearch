<?php

class Shop {

    function buyFreeProduct ($params) {
        return (object)[
            'result' => true,
            'error' => NULL
        ];
    }

    function buyProductByQPoint ($params) {
        return (object)[
            'result' => [
                'status' => true,
                'product_id' => $params->productId,
                'message' => 'SUCCESS'
            ],
            'error' => NULL
        ];
    }

    function getProductForUnlock ($params) {
        return (object)[
            'result' => [
                'product_id' => 80002,
                'platform_product_id' => 909,
                'store_product_id' => 'com.neowizInternet.game.dmtq.unlock2',
                'product_type' => 'I',
                'cost_game_point' => 0,
                'cost_game_cash' => 7,
                'item_id' => 80002,
                'item_name' => '레벨 언락 2',
                'img_url_1' => '',
                'img_url_2' => '',
                'summary' => '레벨 언락 2',
                'description' => '',
                'repeat_count' => 0,
                'item_type' => 'L',
                'limit_minute' => 0,
                'status' => 'N',
                'buy_level' => 0,
                'buy_limit_count' => 0,
                'buy_limit_type' => '',
                'reg_date' => '20130704152633',
                'sale_start_date' => '',
                'sale_end_date' => '',
                'display_order' => 0
            ],
            'error' => NULL
        ];
    }

    function getOwnItemList ($params) {
        global $config;
        $list = [];
        for ($i = 0; $i < count($config->PRODUCT_LIST); $i++) {
            array_push($list, [
                    'item_id' => $config->PRODUCT_LIST[$i],
                    'own_count' => 99,
                    'repeat_count' => 999,
                    'using_yn' => 'Y',
                    'reg_date' => '20170709025007',
                    'end_date' => ''
            ]);
        }
        return (object)[
            'result' => $list,
            'error' => NULL
        ];
    }

    function getUnlockedProductList ($params) {
        return (object)[
            'result' => [],
            'error' => NULL
        ];
    }

    function upgradeInGameItem ($params) {
        //$params->itemType = ['FP', 'GR', 'AB'];
        //max itemLevel is 10
        return (object)[
            'is_success' => true,
            'new_achievements' => [],
            'own_quests' => [
                'complete' => [
                    'period_quest' => NULL,
                    'level_quest' => NULL,
                    'repeat_quest' => NULL
                ],
                'going' => [
                    'period_quest' => NULL,
                    'level_quest' => NULL,
                    'repeat_quest' => NULL
                ]
            ]
        ];
    }
}