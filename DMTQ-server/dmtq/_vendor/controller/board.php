<?php

class Board {

    function getNoticeList ($params) {
        return (object)[
            'result' => [[
                'news_id' => 4,
                'link_url' => 'http:\/\/m.pmang.com',
                'image_url' => 'http:\/\/dmqglb.dqmdl.pmang.com\/dmqglb\/viewImg\/news\/banner_musicpack_28.png',
                'content' => '20028',
                'news_type' => 'N'
            ], [
                'news_id' => 3,
                'link_url' => 'http:\/\/m.pmang.com',
                'image_url' => 'http:\/\/dmqglb.dqmdl.pmang.com\/dmqglb\/viewImg\/news\/banner_liar.png',
                'content' => '104',
                'news_type' => 'N'
            ], [
                'news_id' => 2,
                'link_url' => 'http:\/\/m.pmang.com',
                'image_url' => 'http:\/\/dmqglb.mdl.pmang.com\/dmqglb\/viewImg\/news\/phone2.png',
                'content' => '52',
                'news_type' => 'N'
            ], [
                'news_id' => 1,
                'link_url' => 'http:\/\/m.pmang.com',
                'image_url' => 'http:\/\/dmqglb.mdl.pmang.com\/dmqglb\/viewImg\/news\/phone1.png',
                'content' => '54',
                'news_type' => 'N'
            ]],
            'error' => NULL
        ];
    }
}