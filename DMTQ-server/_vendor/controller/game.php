<?php

class game {

    function checkKakao2Global ($params) {
        return (object)[
            'result' => false,
            'error' => false
        ];
    }

    function checkPmang2Global ($params) {
         return (object)[
            'result' => false,
            'error' => false
        ];
    }

    function checkOld2Global ($params) {
        return (object)[
            'result' => false,
            'error' => false
        ];
    }

    function getAchievementCount ($params) {
          return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getFirstResourceSongList ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getGameAssetByPuid ($params) {
        return (object)[
            'result' => [
                'status' => 'SUCCESS',
                'code' => 200,
                'myAssetInfo' => [
                    'puid' => $params[0],
                    'guid' => 3018783,
                    'exp' => 0,
                    'mpoint' => 0,
                    'score' => 0,
                    'lev' => 11,
                    'amt_total' => 0,
                    'amt_cash' => 0,
                    'amt_point' => 0,
                    'song_count' => 1,
                    'migrated_yn' => 'N'
                ]
            ],
            'error' => false
        ];

    }

    function getGameAssetForMigByToken ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getLineScoreRange ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getLineScoreRangeWithLevel ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getLineTopRankWithLevel ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getOwnAchievementList ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getOwnItemList ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getOwnPatternScore ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getOwnQuestList ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getOwnSongList ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getPatternUrl ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getPreviewPlayInfo ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getSongUrl ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function getUserAsset ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }

    function savePlayResult ($params) {
        return (object)[
            'result' => [],
            'error' => false
        ];
    }
}