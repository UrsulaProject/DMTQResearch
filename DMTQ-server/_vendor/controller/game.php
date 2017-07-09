<?php

class Game {

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
                    'song_count' => $config->MAX_SONG_ID,
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
        global $config;
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("SELECT slot_item1, slot_item2, nickname FROM Member WHERE id = ".$params->guid);
        if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            list($slotItem1, $slotItem2, $nickname) = $queryData;
        } else {
            list($slotItem1, $slotItem2, $nickname) = [0, 0, ' '];
        }
        $handle->close();
        return (object)[
            'result' => [
                'ranks' => [
                    [
                        'rank' => 1,
                        'fluctuation' => 0,
                        'guid' => $params->guid,
                        'score' => $params->guid,
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

    function getOwnAchievementList ($params) {
        return (object)[
            'result' => [
                'own_achievements' => []
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
        global $config;
        $result = [];
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("SELECT DISTINCT(pattern_id) FROM Play WHERE user_id = ".$params->guid);
        while (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            array_push($result, [
                    'guid' => $params->guid,
                    'pattern_id' => $queryData[0],
                    'score' => 9999999,
                    'judgement_name' => 'S',
                    'allcom_yn' => 'Y',
                    'perfect_yn' => 'Y'
            ]);
            list($memberId) = $queryData;
        }
    
        $handle->close();
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
                    ], [
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
                    ], [
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
                    ]],
                    'quest_rewards' => [[
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
        $songList = [];
        for ($i = 1; $i <= $config->MAX_SONG_ID; $i++) {
            array_push($songList, $i);
        }
        return (object)[
            'result' => [
				'song_ids' => $songList
			],
            'error' => NULL
        ];
    }

    function getPatternUrl ($params) {
        global $config;
        return (object)[
            'result' => $config->PATTERN_PATH.ceil($params->patternId / 6).'/'.$params->patternId.($params->earphoneMode === 'e' ? '_EARPHONE' : ''),
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
                'game_token' => md5(time()).substr(md5(time() + 1), -4)
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
        global $config;
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("SELECT slot_item1, slot_item2, slot_item3, slot_item4 FROM Member WHERE id = ".$params->guid);
        if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            list($slotItem1, $slotItem2, $slotItem3, $slotItem4) = $queryData;
        } else {
            list($slotItem1, $slotItem2, $slotItem3, $slotItem4) = [0, 0, 0, 0, 0, 0, 0];
        }
        $handle->close();
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
        global $config;
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("INSERT INTO PLAY (pattern_id, user_id) VALUES (".$params->patternId.", ".$params->guid.")");
        $handle->close();
        return (object)[
            'result' => [
                'is_success' => true,
                'is_first_pattern' => true,
                'is_new_record' => true,
                'judgement_name' => 'S',
                'allcom_yn' => 'Y',
                'perfect_yn' => 'Y',
                'bonus_score' => 99999,
                'lucky_bonus_score' => 99999,
                'score' => 9999999,
                'total_score' => 9999999,
                'exp' => 99999,
                'total_exp' => 99999,
                'mpoint' => 999999,
                'total_mpoint' => 999999,
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
        global $config;
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("UPDATE Member SET slot_item1 = ".(!!$params->slotItem1 ? $params->slotItem1 : 'NULL').", slot_item2 = ".(!!$params->slotItem2 ? $params->slotItem2 : 'NULL').", slot_item3 = ".(!!$params->slotItem3 ? $params->slotItem3 : 'NULL').", slot_item4 = ".(!!$params->slotItem4 ? $params->slotItem4 : 'NULL')." WHERE id = ".$params->guid);
        $handle->close();
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