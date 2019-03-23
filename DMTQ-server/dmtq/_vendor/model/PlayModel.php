<?php

class PlayModel {

    static public function recordList ($params) {
        $result = [];
        $stmt = connectDB()->prepare("SELECT pattern_id, score, grade, isAllCombo, isPerfectPlay, judgement FROM PLAY WHERE user_id=:user_id");
		$stmt->bindValue('user_id', $params->guid);
		$query = $stmt->execute();
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
        }
		return $result;
    }
	static public function recordScore ($params) {
        $stmt = connectDB()->prepare("SELECT score FROM PLAY WHERE pattern_id=:pattern_id AND user_id=:user_id");
		$stmt->bindValue('pattern_id', $params->patternId);
		$stmt->bindValue('user_id', $params->guid);
		$query = $stmt->execute();
        if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            return $queryData;
        }
		return [NULL];
	}
	static public function insertRecord ($totalScore, $realPointRatio, $grade, $params) {
		$stmt = connectDB()->prepare("INSERT INTO PLAY (pattern_id, user_id, score, grade, isAllCombo, isPerfectPlay, judgement) VALUES (:pattern_id, :user_id, :score, :grade, :isAllCombo, :isPerfectPlay, :judgement)");
		$stmt->bindValue('pattern_id', $params->patternId);
		$stmt->bindValue('user_id', $params->guid);
		$stmt->bindValue('score', $totalScore);
		$stmt->bindValue('grade', $grade);
		$stmt->bindValue('isAllCombo', ($params->judgementStat[1] === 0 ? 'Y': 'N'));
		$stmt->bindValue('isPerfectPlay', ($params->judgementStat[1] === 0 && $params->judgementStat[2] === 0 && $params->judgementStat[3] === 0 && $params->judgementStat[4] === 0 && $params->judgementStat[5] === 0 && $params->judgementStat[6] === 0 && $params->judgementStat[7] === 0 && $params->judgementStat[8] === 0 && $params->judgementStat[9] === 0 && $params->judgementStat[10] === 0  && $params->judgementStat[11] === 0 ? 'Y': 'N'));
		$stmt->bindValue('judgement', $realPointRatio);
		$query = $stmt->execute();
	}
	static public function updateRecord ($totalScore, $realPointRatio, $grade, $params) {
		$stmt = connectDB()->prepare("UPDATE PLAY SET score = CASE WHEN :score > score THEN :score ELSE score END, judgement = CASE WHEN :judgement > judgement THEN :judgement ELSE judgement END, grade = CASE WHEN :judgement > judgement THEN :grade ELSE grade END, isAllCombo = CASE WHEN isAllCombo = 'N' THEN :isAllCombo ELSE isAllCombo END, isPerfectPlay = CASE WHEN isPerfectPlay = 'N' THEN :isPerfectPlay ELSE isPerfectPlay END WHERE pattern_id=:pattern_id AND user_id=:user_id");
		$stmt->bindValue('score', $totalScore);
		$stmt->bindValue('judgement', $realPointRatio);
		$stmt->bindValue('grade', $grade);
		$stmt->bindValue('isAllCombo', ($params->judgementStat[1] === 0 ? 'Y': 'N'));
		$stmt->bindValue('isPerfectPlay', ($params->judgementStat[1] === 0 && $params->judgementStat[2] === 0 && $params->judgementStat[3] === 0 && $params->judgementStat[4] === 0 && $params->judgementStat[5] === 0 && $params->judgementStat[6] === 0 && $params->judgementStat[7] === 0 && $params->judgementStat[8] === 0 && $params->judgementStat[9] === 0 && $params->judgementStat[10] === 0  && $params->judgementStat[11] === 0 ? 'Y': 'N'));
		$stmt->bindValue('pattern_id', $params->patternId);
		$stmt->bindValue('user_id', $params->guid);
		$query = $stmt->execute();
	}
}