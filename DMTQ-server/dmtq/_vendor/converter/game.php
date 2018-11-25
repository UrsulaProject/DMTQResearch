<?php

class GameConverter {

    function checkKakao2Global ($params) {
        return (object)[
            'puid' => $params[0]
        ];
    }

    function checkPmang2Global ($params) {
        return (object)[
            'puid' => $params[0]
        ];
    }

    function checkOld2Global ($params) {
        return (object)[
            'puid' => $params[0]
        ];
    }

    function getAchievementCount ($params) {
          return (object)[
        ];
    }

    function getAdSongList ($params) {
        return (object)[
          'guid' => $params[0]
        ];
    }

    function getAdTicketChecked ($params) {
        return (object)[
          'guid' => $params[0]
        ];
    }


    function getAdTicketRequest ($params) {
        return (object)[
          'guid' => $params[0],
          'songId' => $params[1]
        ];
    }

    function getAdTicketReceived ($params) {
        return (object)[
          'guid' => $params[0],
          'songId' => $params[1]
        ];
    }

    function getAdTicketUsed ($params) {
        return (object)[
          'guid' => $params[0],
          'songId' => $params[1]
        ];
    }

    function getDefaultSetting ($params) {
        return (object)[];
    }

    function getFirstResourceSongList ($params) {
        return (object)[
        ];
    }

    function getGameAssetByPuid ($params) {
        return (object)[
            'puid' => $params[0]
        ];

    }

    function getGameAssetForMigByToken ($params) {
        return (object)[
            'guid' => $params[0],
            'copy' => $params[1]
        ];
    }

    function getGameSettingInfo ($params) {
        return (object)[
            'key' => $params[0]
        ];
    }

    function getLineScoreMyRank ($params) {
        return (object)[
            'guid' => $params[0],
            'songId' => $params[1],
            'line' => $params[2]
        ];
    }

    function getLineScoreRange ($params) {
        return (object)[
            'songId' => $params[0],
            'line' => $params[1],
            'fromRank' => $params[2],
            'range' => $params[3]
        ];
    }

    function getLineScoreRangeWithLevel ($params) {
        return (object)[
            'songId' => $params[0],
            'line' => $params[1],
            'fromRank' => $params[2],
            'range' => $params[3]
        ];
    }

    function getLineTopRankWithLevel ($params) {
        return (object)[
            'unknown' => $params[0],
            'page' => $params[1],
            'pagePerSize' => $params[2],
            'guid' => $params[3][0],
        ];
    }

    function getLineScoreMyRankWithNext ($params) {
        return (object)[
            'guid' => $params[0],
            'unknown1' => $params[1],
            'unknown2' => $params[2]
        ];
    }

    function getPatternUsePointData ($params) {
        return (object)[];
    }

     function getLineScoreMyRankWithLevel ($params) {
        return (object)[
            'guid' => $params[0],
            'unknown1' => $params[1],
            'unknown2' => $params[2]
        ];
    }

    function getOwnAchievementList ($params) {
        return (object)[
           'guid' => $params[0]
        ];
    }

    function getOwnItemList ($params) {
        return (object)[
           'guid' => $params[0]
        ];
    }

    function getOwnPatternScore ($params) {
        return (object)[
          'guid' => $params[0]
        ];
    }

    function getOwnQuestList ($params) {
        return (object)[
          'guid' => $params[0]
        ];
    }

    function getOwnSongList ($params) {
        return (object)[
          'guid' => $params[0]
        ];
    }

    function getPatternUrl ($params) {
        return (object)[
            'guid' => $params[0],
            'patternId' => $params[1],
            'earphoneMode' => $params[2],
            'deviceType' => $params[3]
        ];
    }

    function getPreviewPlayInfo ($params) {
        return (object)[
            'guid' => $params[0],
            'patternId' => $params[1]
        ];
    }

    function getSongList ($params) {
        return (object)[
        ];
    }

    function getSongUrl ($params) {
        return (object)[
            'guid' => $params[0],
            'songId' => $params[1],
            'clientOS' => $params[2],
            'version' => $params[3]
        ];
    }

    function getUserAsset ($params) {
        return (object)[
            'guid' => $params[0]
        ];
    }

    function savePlayResult ($params) {
        return (object)[
            'guid' => $params[0] !== 239238323 ? $params[0] : 221403175,
            'patternId' => $params[1],
            'judgementStat' => $params[2],
            'maxCombo' => $params[3],
            'luckyBonus' => $params[4],
            'effector' => $params[5],
            'ingameItem' => $params[6],
            'gameToken' => $params[7]
        ];
    }

    function savePlayResultFailLog ($params) {
        return (object)[
            'guid' => $params[0],
            'patternId' => $params[1],
            'gameToken' => $params[2],
            'logType' => $params[3]
        ];
    }

    function setSlotItem ($params) {
        return (object)[
            'guid' => $params[0],
            'slotItem1' => $params[1],
            'slotItem2' => $params[2],
            'slotItem3' => $params[3],
            'slotItem4' => $params[4],
        ];
    }
}