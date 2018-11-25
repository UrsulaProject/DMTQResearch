<?php

class Game {

    function getOwnInfo ($params) {
        global $config;
        $result = [];
        $handle = new SQLite3($config->DB_PATH);
		if (!isset($params['userId'])) {
			$params['userId'] = 999999;
		}
		$code = 0x135798642;
		$guid = hexdec(strrev($$params['userId'])) ^ $code;
        $query = $handle->query("SELECT nickname FROM Member WHERE guid = ".$guid." AND puid = ".$guid);
        while (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            $result = [
                'nickname' => $queryData[0]
            ];
        }
    
        $handle->close();
        return $result;
    }

    function getOwnPatternScore ($params) {
        global $config;
        $result = [];
        $handle = new SQLite3($config->DB_PATH);
		if (!isset($params['userId'])) {
			$params['userId'] = 999999;
		}
		$code = 0x135798642;
		$guid = hexdec(strrev($params['userId'])) ^ $code;
        $query = $handle->query("SELECT pattern_id, score, grade, isAllCombo, isPerfectPlay, judgement FROM Play WHERE user_id = ".$guid);
        while (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            $result[$queryData[0]] = [
				'patternId' => $queryData[0],
				'score' => $queryData[1],
				'judgement' => $queryData[2],
				'isFullCombo' => $queryData[3] === 'Y',
				'isExc' => $queryData[4] === 'Y',
				'rate' => $queryData[5]
            ];
        }
    
        $handle->close();
        return $result;
    }

    function getSongList ($params) {
        global $config;
        $songList = json_decode(file_get_contents($config->SONG_LIST));
		$output = [];
		$matching = ['easy', 'normal', 'hard', 'expert'];
		for ($i = 0; $i < count($songList); $i++) {
			$lineList = [];
			for ($j = 0; $j < count($songList[$i]->song_patterns); $j++) {
				$name = ($songList[$i]->song_patterns[$j]->line - 1).'lines';
				if (!isset($lineList[$name])) {
					$lineList[$name] = [];
				}
				$lineList[$name][$matching[$songList[$i]->song_patterns[$j]->signature]] = [
					'patternId' => $songList[$i]->song_patterns[$j]->pattern_id,
					'difficulty' => $songList[$i]->song_patterns[$j]->difficulty,
				];
			}
			array_push($output, [
				'musicId' => $songList[$i]->song_id,
				'fileName' => $songList[$i]->name,
				'musicName' => $songList[$i]->full_name,
				'artistName' => $songList[$i]->artist_name,
				'genre' => $songList[$i]->genre,
				'lineList' => $lineList
			]);
		}
        return $output;
    }

}