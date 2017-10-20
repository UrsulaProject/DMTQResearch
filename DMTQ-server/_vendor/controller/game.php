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
        $query = $handle->query("SELECT pattern_id, score, grade, isAllCombo, isPerfectPlay, judgement FROM PLAY WHERE user_id = ".$params->guid);
        while (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            array_push($result, [
                    'guid' => $params->guid,
                    'pattern_id' => $queryData[0],
                    'score' => $queryData[1],
                    'judgement_name' => $queryData[2],
                    'allcom_yn' => $queryData[3],
                    'perfect_yn' => $queryData[4],
                    'judgement' => $queryData[5] / 10
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
        $score = 0;
        $allComboScore = $params->judgementStat[1] === 0 ? 7000 : 0;
        $perfectPlayScore = $params->judgementStat[1] === 0 && $params->judgementStat[2] === 0 && $params->judgementStat[3] === 0 && $params->judgementStat[4] === 0 && $params->judgementStat[5] === 0 && $params->judgementStat[6] === 0 && $params->judgementStat[7] === 0 && $params->judgementStat[8] === 0 && $params->judgementStat[9] === 0 && $params->judgementStat[10] === 0  && $params->judgementStat[11] === 0 ? 8000 : 0;
        $luckyScore = $params->luckyBonus * 300;
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
        global $config;
        $handle = new SQLite3($config->DB_PATH);
        $query = $handle->query("SELECT score, grade, judgement FROM PLAY WHERE pattern_id = ".$params->patternId." AND user_id = ".$params->guid);
        if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            list($lastScore) = $queryData;
        } else {
            list($lastScore) = [NULL];
        }
        if ($lastScore === NULL) {
            $query = $handle->query("INSERT INTO PLAY (pattern_id, user_id, score, grade, isAllCombo, isPerfectPlay, judgement) VALUES (".$params->patternId.", ".$params->guid.", ".$totalScore.", '".$grade."', '".($params->judgementStat[1] === 0 ? 'Y': 'N')."', '".($params->judgementStat[1] === 0 && $params->judgementStat[2] === 0 && $params->judgementStat[3] === 0 && $params->judgementStat[4] === 0 && $params->judgementStat[5] === 0 && $params->judgementStat[6] === 0 && $params->judgementStat[7] === 0 && $params->judgementStat[8] === 0 && $params->judgementStat[9] === 0 && $params->judgementStat[10] === 0  && $params->judgementStat[11] === 0 ? 'Y': 'N')."', ".$realPointRatio.")");
        } else {
            $query = $handle->query("UPDATE PLAY SET score = CASE WHEN ".$totalScore." > score THEN ".$totalScore." ELSE score END, judgement = CASE WHEN ".$realPointRatio." > judgement THEN ".$realPointRatio." ELSE judgement END, grade = CASE WHEN ".$realPointRatio." > judgement THEN '".$grade."' ELSE grade END, isAllCombo = CASE WHEN isAllCombo = 'N' THEN '".($params->judgementStat[1] === 0 ? 'Y': 'N')."' ELSE isAllCombo END, isPerfectPlay = CASE WHEN isPerfectPlay = 'N' THEN '".($params->judgementStat[1] === 0 && $params->judgementStat[2] === 0 && $params->judgementStat[3] === 0 && $params->judgementStat[4] === 0 && $params->judgementStat[5] === 0 && $params->judgementStat[6] === 0 && $params->judgementStat[7] === 0 && $params->judgementStat[8] === 0 && $params->judgementStat[9] === 0 && $params->judgementStat[10] === 0  && $params->judgementStat[11] === 0 ? 'Y': 'N')."' ELSE isPerfectPlay END WHERE pattern_id = ".$params->patternId." AND user_id = ".$params->guid);
        }
        $handle->close();
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