<?php

class GameController {

    function checkKakao2Global ($params) {
        return (object)[
            'result' => false,
            'error' => NULL
        ];
    }

    function checkPmang2Global ($params) {
         return (object)[
            'result' => false,
            'error' => NULL
        ];
    }

    function checkOld2Global ($params) {
        return (object)[
            'result' => false,
            'error' => NULL
        ];
    }

    function getAchievementCount ($params) {
          return (object)[
            'result' => [
                'total_achievement_count' => 999,
                'total_achievement_point_sum' => 99999
            ],
            'error' => NULL
        ];
    }

    function getAdSongList ($params) {
        return (object)[
            'result' => [
                'status' => 200,
                'message' => 'Ad song list',
                'info' => [
                    'songList' => []
                ]
            ],
            'error' => NULL
        ];
    }

    function getAdTicketChecked ($params) {
        return (object)[
            'result' => [
                'status' => 200,
                'message' => 'Check Ad ticket info',
                'info' => [
                    'ticket' => [
                        'guid' => $params->guid,
                        'song_id' => 0,
                        'has_ticket' => 'N',
                        'reg_date' => '20170101000000'
                    ]
                ]
            ],
            'error' => NULL
        ];
    }

    function getAdTicketRequest ($params) {
        return (object)[
            'result' => [
                'status' => 200,
                'message' => 'I am watching ad movie',
                'info' => [
                    'has_ticket' => true,
                    'state' => 'S'
                ]
            ],
            'error' => NULL
        ];
    }

    function getAdTicketReceived ($params) {
        return (object)[
            'result' => [
                'status' => 200,
                'message' => 'I got a ticket to play',
                'info' => [
                    'has_ticket' => true,
                    'state' => 'Y'
                ]
            ],
            'error' => NULL
        ];
    }

    function getAdTicketUsed ($params) {
        return (object)[
            'result' => [
                'status' => 200,
                'message' => 'I used to play',
                'info' => [
                    'ticket' => [
                        'use_ticket' => true,
                        'state' => 'N'
                    ]
                ]
            ],
            'error' => NULL
        ];
    }

    function getDefaultSetting ($params) {
        global $config;
        return (object)[
            'result' => [
                'defaultKeyValue' => [
                    [
                        'key' => '1',
                        'value' => '1'
                    ],
                    [
                        'key' => 'gamesuggest_popup',
                        'value' => $config->GAME_SUGGEST_POPUP
                    ],
                    [
                        'key' => 'howtoplay_page1',
                        'value' => $config->HOW_TO_PLAY_PAGE1
                    ],
                    [
                        'key' => 'howtoplay_page2',
                        'value' => $config->HOW_TO_PLAY_PAGE2
                    ],
                    [
                        'key' => 'howtoplay_popup',
                        'value' => $config->HOW_TO_PLAY_POPUP
                    ],
                    [
                        'key' => 'tstop_url',
                        'value' => $config->TSTOP_URL
                    ],
                    [
                        'key' => 'twc_url',
                        'value' => $config->TWC_URL
                    ],
                ]
            ],
            'error' => NULL
        ];
    }

    function getFirstResourceSongList ($params) {
        global $config;
        return (object)[
            'result' => [
                'first_resource_songs' => [
                    [
                        'song_id' => 1,
                        'name' => 'oblivion'
                    ]
                ]
            ],
            'error' => NULL
        ];
    }

    function getGameAssetByPuid ($params) {
        global $config;
        $songList = json_decode(file_get_contents($config->SONG_LIST));
        $maxSongId = 1;
        for ($i = 0; $i < count($songList); $i++) {
            if ($songList[$i]->song_id > $maxSongId) {
                $maxSongId = $songList[$i]->song_id;
            }
        }
        return (object)[
            'result' => [
                'status' => 'SUCCESS',
                'code' => 200,
                'myAssetInfo' => [
                    'puid' => (string)$params->puid,
                    'guid' => (int)$params->puid,
                    'exp' => 99999,
                    'mpoint' => 999999,
                    'score' => 9999999,
                    'lev' => 99,
                    'amt_total' => 999999,
                    'amt_cash' => 999999,
                    'amt_point' => 999999,
                    'song_count' => $maxSongId,
                    'migrated_yn' => 'Y'
                ]
            ],
            'error' => NULL
        ];

    }

    function getGameAssetForMigByToken ($params) {
        return (object)[
            'result' => NULL,
            'error' => [
                'code' => 'SVC.05001',
                'message' => 'Error (Invalid pmangplus(member_id) user id)'
            ]
        ];
    }

    function getGameSettingInfo ($params) {
        global $config;
        return (object)[
            'result' => [
                'status' => 200,
                'code' => 200,
                'message' => 'FOUND THE KEY',
                'info' => [
                    'key' => 'HARDEXPERT_ALERT_LEVEL',
                    'value' => 4
                ]
            ],
            'error' => NULL
        ];
    }

    function getLineScoreMyRank ($params) {
        return (object)[
            'result' => [
                'rank' => 0
            ],
            'error' => NULL
        ];
    }

    function getLineScoreRange ($params) {
        return (object)[
            'result' => [
                'scores' => []
            ],
            'error' => NULL
        ];
    }

    function getLineScoreRangeWithLevel ($params) {
        return (object)[
            'result' => [
                'scores' => []
            ],
            'error' => NULL
        ];
    }

    function getLineTopRankWithLevel ($params) {
		list($slotItem1, $slotItem2, $slotItem3, $slotItem4, $nickname) = UserModel::slotItemWithNickname($params);
        return (object)[
            'result' => [
                'ranks' => [
                    [
                        'rank' => 1,
                        'fluctuation' => 0,
                        'guid' => $params->guid,
                        'score' => 0,
                        'slot_item1' => $slotItem1,
                        'slot_item2' => $slotItem2,
                        'lev' => 99,
                        'display_name' => $nickname,
                        'profile_img' => ''
                    ]
                ],
                'rank_day' => '20170707'
            ],
            'error' => NULL
        ];
    }

    function getLineScoreMyRankWithNext ($params) {
        return (object)[
            'result' => [
                'scores' => []
            ],
            'error' => NULL
        ];
    }

    function getPatternUsePointData ($params) {
        return (object)[
            'result' => [  
                'getPatternUsePointData' => [
                    [  
                        'pattern_id' => 868,
                        'song_id' => 17,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 869,
                        'song_id' => 17,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 870,
                        'song_id' => 17,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 874,
                        'song_id' => 107,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 875,
                        'song_id' => 107,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 876,
                        'song_id' => 107,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 877,
                        'song_id' => 114,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 878,
                        'song_id' => 114,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 879,
                        'song_id' => 114,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1126,
                        'song_id' => 5,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1127,
                        'song_id' => 5,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1128,
                        'song_id' => 5,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1129,
                        'song_id' => 26,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1130,
                        'song_id' => 26,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1131,
                        'song_id' => 26,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1132,
                        'song_id' => 36,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1133,
                        'song_id' => 36,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1134,
                        'song_id' => 36,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1135,
                        'song_id' => 71,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1136,
                        'song_id' => 71,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1137,
                        'song_id' => 71,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1138,
                        'song_id' => 72,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1139,
                        'song_id' => 72,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1140,
                        'song_id' => 72,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1141,
                        'song_id' => 73,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1142,
                        'song_id' => 73,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1143,
                        'song_id' => 73,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1147,
                        'song_id' => 133,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1148,
                        'song_id' => 133,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1149,
                        'song_id' => 133,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1150,
                        'song_id' => 145,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1151,
                        'song_id' => 145,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1152,
                        'song_id' => 145,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1153,
                        'song_id' => 146,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1154,
                        'song_id' => 146,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1155,
                        'song_id' => 146,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1156,
                        'song_id' => 1,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1157,
                        'song_id' => 1,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1158,
                        'song_id' => 1,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1159,
                        'song_id' => 27,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1160,
                        'song_id' => 27,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1161,
                        'song_id' => 27,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1162,
                        'song_id' => 31,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1163,
                        'song_id' => 31,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1164,
                        'song_id' => 31,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1165,
                        'song_id' => 34,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1166,
                        'song_id' => 34,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1167,
                        'song_id' => 34,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1168,
                        'song_id' => 49,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1169,
                        'song_id' => 49,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1170,
                        'song_id' => 49,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1171,
                        'song_id' => 52,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1172,
                        'song_id' => 52,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1173,
                        'song_id' => 52,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1174,
                        'song_id' => 54,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1175,
                        'song_id' => 54,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1176,
                        'song_id' => 54,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1177,
                        'song_id' => 63,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1178,
                        'song_id' => 63,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1179,
                        'song_id' => 63,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1180,
                        'song_id' => 77,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1181,
                        'song_id' => 77,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1182,
                        'song_id' => 77,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1183,
                        'song_id' => 100,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1184,
                        'song_id' => 100,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1185,
                        'song_id' => 100,
                        'point_type' => 1,
                        'point_value' => 500
                    ],
                    [  
                        'pattern_id' => 1186,
                        'song_id' => 142,
                        'point_type' => 1,
                        'point_value' => 200
                    ],
                    [  
                        'pattern_id' => 1187,
                        'song_id' => 142,
                        'point_type' => 1,
                        'point_value' => 350
                    ],
                    [  
                        'pattern_id' => 1188,
                        'song_id' => 142,
                        'point_type' => 1,
                        'point_value' => 500
                    ]
                ]
            ],
            'error' => NULL
        ];
    }

    function getLineScoreMyRankWithLevel ($params) {
        return (object)[
            'result' => [
                'scores' => []
            ],
            'error' => NULL
        ];
    }

    function getOwnAchievementList ($params) {
        return (object)[
            'result' => [
                'own_achievements' => [
                    // [
                    //     'achievement_id' => 22,
                    //     'reg_date' => '20170806174416'
                    // ]
                ]
            ],
            'error' => NULL
        ];
    }

    function getOwnItemList ($params) {
        return (object)[
            'result' => [],
            'error' => NULL
        ];
    }

    function getOwnPatternScore ($params) {
		$result = PlayModel::recordList($params);
        return (object)[
            'result' => $result,
            'error' => NULL
        ];
    }

    function getOwnQuestList ($params) {
        return (object)[
            'result' => [
                'period_quest' => [
                    'quest_order' => 1,
                    'quest_id' => 148,
                    'quest_type' => 'E',
                    'quest_name' => 'REBOOT! 20주차 퀘스트',
                    'description' => '매주 업데이트되는 퀘스트에 도전하세요!',
                    'start_date' => '20170702000000',
                    'end_date' => '20170708235959',
                    'quest_complete_yn' => 'N',
                    'own_quest_missions' => [
                        [
                            'quest_mission_id' => 357,
                            'quest_mission_complete_yn' => 'N',
                            'play_count' => 0,
                            'song_id' => 0,
                            'play_special' => '',
                            'condition_random_song_yn' => 'N',
                            'condition_song_id' => 0,
                            'condition_signature' => 1,
                            'condition_line' => 0,
                            'condition_difficulty' => 0,
                            'condition_type' => 'CLEAR',
                            'condition_value' => 1,
                            'condition_count' => 6,
                            'condition_special' => '',
                            'description' => '조건 1 : NORMAL 패턴 6회 클리어'
                        ],
                        [
                            'quest_mission_id' => 358,
                            'quest_mission_complete_yn' => 'N',
                            'play_count' => 0,
                            'song_id' => 0,
                            'play_special' => '',
                            'condition_random_song_yn' => 'N',
                            'condition_song_id' => 0,
                            'condition_signature' => 2,
                            'condition_line' => 0,
                            'condition_difficulty' => 0,
                            'condition_type' => 'CLEAR',
                            'condition_value' => 1,
                            'condition_count' => 8,
                            'condition_special' => '',
                            'description' => '조건 2 : HARD 패턴 8회 클리어'
                        ],
                        [
                            'quest_mission_id' => 359,
                            'quest_mission_complete_yn' => 'N',
                            'play_count' => 1,
                            'song_id' => 0,
                            'play_special' => '',
                            'condition_random_song_yn' => 'N',
                            'condition_song_id' => 0,
                            'condition_signature' => 3,
                            'condition_line' => 0,
                            'condition_difficulty' => 0,
                            'condition_type' => 'CLEAR',
                            'condition_value' => 1,
                            'condition_count' => 10,
                            'condition_special' => '',
                            'description' => '조건 3 : EXPERT 패턴 10회 클리어',
                            'is_updated' => true
                        ]
                    ],
                    'quest_rewards' => [
                        [
                            'quest_reward_id' => 148,
                            'quest_id' => 148,
                            'reward_type' => 'MP',
                            'reward_value' => 2000
                        ]
                    ],
                    'is_updated' => true
                ],
                'repeat_quest' => [
                    'quest_order' => 10,
                    'quest_id' => 3,
                    'quest_type' => 'P',
                    'quest_name' => '이펙터의 이해',
                    'description' => '패턴을 고르고 나면, 이펙터를 고를 수 있어요.\r\n\r\n노트가 사라지거나, 방향이 바뀌는 등 재미있는 기능을 선보입니다.',
                    'quest_complete_yn' => 'N',
                    'own_quest_missions' => [
                        [
                            'quest_mission_id' => 5,
                            'quest_mission_complete_yn' => 'N',
                            'play_count' => 0,
                            'song_id' => 0,
                            'play_special' => '',
                            'condition_random_song_yn' => 'N',
                            'condition_song_id' => 0,
                            'condition_signature' => 0,
                            'condition_line' => 0,
                            'condition_difficulty' => 0,
                            'condition_type' => 'EFFECTOR',
                            'condition_value' => 1,
                            'condition_count' => 1,
                            'condition_special' => 'all,no,no no,all,no no,no,all',
                            'description' => '이펙터를 장착한 상태에서 클리어 1회'
                        ]
                    ],
                    'quest_rewards' => [
                        [
                            'quest_reward_id' => 3,
                            'quest_id' => 3,
                            'reward_type' => 'CA',
                            'reward_value' => 10
                        ]
                    ]
                ],
                'level_quest' => NULL
            ],
            'error' => NULL
        ];
    }

    function getOwnSongList ($params) {
        global $config;
        $songList = json_decode(file_get_contents($config->SONG_LIST));
        $maxSongId = 1;
        for ($i = 0; $i < count($songList); $i++) {
            if ($songList[$i]->song_id > $maxSongId) {
                $maxSongId = $songList[$i]->song_id;
            }
        }
        $outputSongList = [];
        for ($i = 1; $i <= $maxSongId; $i++) {
            array_push($outputSongList, $i);
        }
        return (object)[
            'result' => [
                'song_ids' => $outputSongList
            ],
            'error' => NULL
        ];
    }

    function getPatternUrl ($params) {
        global $config;
        return (object)[
            'result' => $config->PATTERN_PATH.$params->patternId.($params->earphoneMode === 'e' ? '_EARPHONE' : ''),
            'error' => NULL
        ];
    }

    function getPreviewPlayInfo ($params) {
        return (object)[
            'result' => [
                'note_count' => 3,
                'slot_item_effect' => [
                    'slot_item1' => NULL,
                    'slot_item2' => NULL,
                    'slot_item3' => [
                        'item_id' => '90008',
                        'effect_type' => 'N',
                        'effect_point' => 1,
                        'effect_count' => 1,
                        'effect_special' => ''
                    ]
                ],
                'in_game_item' => [
                    'in_game_item1' => [
                        'item_type' => 'FP',
                        'item_level' => 10,
                        'product_id' => 70020,
                        'item_effects' => [
                            [
                                'item_id' => 70020,
                                'effect_type' => 'F',
                                'effect_point' => 5,
                                'effect_count' => 3,
                                'effect_special' => ''
                            ]
                        ]
                    ],
                    'in_game_item2' => [
                        'item_type' => 'GR',
                        'item_level' => 10,
                        'product_id' => 70030,
                        'item_effects' => [
                            [
                                'item_id' => 70030,
                                'effect_type' => 'G',
                                'effect_point' => 100,
                                'effect_count' => 1,
                                'effect_special' => ''
                            ]
                        ]
                    ],
                    'in_game_item3' => [
                        'item_type' => 'AB',
                        'item_level' => 10,
                        'product_id' => 70010,
                        'item_effects' => [
                            [
                                'item_id' => 70010,
                                'effect_type' => 'A',
                                'effect_point' => 12,
                                'effect_count' => 10,
                                'effect_special' => 'JUDGEMENT_MAX100'
                            ]
                        ]
                    ]
                ],
                'game_token' => md5(time()).substr(md5(time() + 1), -4),
				'freepass' => false
            ],
            'error' => NULL
        ];
    }

    function getSongList ($params) {
        global $config;
        $songList = json_decode(file_get_contents($config->SONG_LIST));
        return (object)[
            'result' => [
                'songs' => $songList
            ],
            'error' => NULL
        ];
    }

    function getSongUrl ($params) {
        global $config;
        $fpk = $config->SONG_PATH.$params->songId.'/'.$params->songId.'.fpk';
        $webm = $config->SONG_PATH.$params->songId.'/'.$params->songId.'.webm';
        return (object)[
            'result' => [
                'pmang' => [$fpk, $webm],
                'amazon' => [$fpk, $webm]
            ],
            'error' => NULL
        ];
    }

    function getUserAsset ($params) {
		list($slotItem1, $slotItem2, $slotItem3, $slotItem4, $nickname) = UserModel::slotItemWithNickname($params);
        return (object)[
            'result' => [
                'exp' => 0,
                'mpoint' => 999999,
                'score' => 9999999,
                'slot_item1' => $slotItem1,
                'slot_item2' => $slotItem2,
                'slot_item3' => $slotItem3,
                'slot_item4' => $slotItem4,
                'in_game_item1' => 10,
                'in_game_item2' => 10,
                'in_game_item3' => 10,
                'lev' => 99,
                'amt_total' => '999999',
                'amt_cash' => '999999',
                'amt_point' => '999999',
                'amt_mileage' => '999999'
            ],
            'error' => NULL
        ];
    }

    function savePlayResult ($params) {
        $score = 0;
        $allComboScore = $params->judgementStat[1] === 0 ? 15000 : 0;
        $perfectPlayScore = $params->judgementStat[1] === 0 && $params->judgementStat[2] === 0 && $params->judgementStat[3] === 0 && $params->judgementStat[4] === 0 && $params->judgementStat[5] === 0 && $params->judgementStat[6] === 0 && $params->judgementStat[7] === 0 && $params->judgementStat[8] === 0 && $params->judgementStat[9] === 0 && $params->judgementStat[10] === 0  && $params->judgementStat[11] === 0 ? 30000 : 0;
        //$luckyScore = $params->luckyBonus * 300;
        $luckyScore = 0;
        $score += $params->judgementStat[2];
        $score += $params->judgementStat[3] * 20;
        $score += $params->judgementStat[4] * 40;
        $score += $params->judgementStat[5] * 60;
        $score += $params->judgementStat[6] * 80;
        $score += $params->judgementStat[7] * 100;
        $score += $params->judgementStat[8] * 120;
        $score += $params->judgementStat[9] * 140;
        $score += $params->judgementStat[10] * 160;
        $score += $params->judgementStat[11] * 180;
        $score += $params->judgementStat[12] * 200;
        $totalScore = $score + $allComboScore + $perfectPlayScore + $luckyScore;
        $grade = 'F';
        $maxPoint = ($params->judgementStat[1] + $params->judgementStat[2] + $params->judgementStat[3] + $params->judgementStat[4] + $params->judgementStat[5] + $params->judgementStat[6] + $params->judgementStat[7] + $params->judgementStat[8] + $params->judgementStat[9] + $params->judgementStat[10] + $params->judgementStat[11] + $params->judgementStat[12]) * 100;
        $nowPoint = ($score - $params->judgementStat[2]) / 2 + $params->judgementStat[2];
        $realPointRatio = (int)floor($nowPoint / $maxPoint * 1000);
        $pointRatio = $realPointRatio / 10;
        if ($pointRatio >= 98) {
            $grade = 'S';
        } else if ($pointRatio >= 90) {
            $grade = 'A';
        } else if ($pointRatio >= 80) {
            $grade = 'B';
        } else if ($pointRatio >= 70) {
            $grade = 'C';
        } else if ($pointRatio >= 60) {
            $grade = 'D';
        } else if ($pointRatio >= 50) {
            $grade = 'E';
        }
		list($lastScore) = PlayModel::recordScore($params);
        if ($lastScore === NULL) {
			PlayModel::insertRecord($totalScore, $realPointRatio, $grade, $params);
        } else {
			PlayModel::updateRecord($totalScore, $realPointRatio, $grade, $params);
		}
        return (object)[
            'result' => [
                'is_success' => true,
                'is_first_pattern' => $lastScore === NULL,
                'is_new_record' => $lastScore === NULL || $totalScore > $lastScore,
                'judgement_name' => $grade,
                'allcom_yn' => ($params->judgementStat[1] === 0 ? 'Y': 'N'),
                'perfect_yn' => ($params->judgementStat[1] === 0 && $params->judgementStat[2] === 0 && $params->judgementStat[3] === 0 && $params->judgementStat[4] === 0 && $params->judgementStat[5] === 0 && $params->judgementStat[6] === 0 && $params->judgementStat[7] === 0 && $params->judgementStat[8] === 0 && $params->judgementStat[9] === 0 && $params->judgementStat[10] === 0  && $params->judgementStat[11] === 0 ? 'Y': 'N'),
                'bonus_score' => $allComboScore + $perfectPlayScore,
                'lucky_bonus_score' => $luckyScore,
                'score' => $totalScore,
                'total_score' => $totalScore,
                'exp' => 10,
                'total_exp' => 10,
                'mpoint' => 150,
                'total_mpoint' => 150,
                'lev' => 99,
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
            ],
            'error' => NULL
        ];
    }

    function savePlayResultFailLog ($params) {
        return (object)[
            'result' => [
                'status' => true
            ],
            'error' => NULL
        ];
    }

    function setSlotItem ($params) {
		UserModel::updateSlotItem($params);
        return (object)[
            'result' => [
                'slot_item1' => $params->slotItem1,
                'slot_item2' => $params->slotItem2,
                'slot_item3' => $params->slotItem3,
                'slot_item4' => $params->slotItem4,
            ],
            'error' => NULL
        ];
    }
}