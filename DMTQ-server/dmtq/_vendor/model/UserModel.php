<?php

class UserModel {

    static public function slotItemWithNickname ($params) {
        $stmt = connectDB()->prepare("SELECT slot_item1, slot_item2, slot_item3, slot_item4, nickname FROM Member WHERE guid=:guid");
		$stmt->bindValue('guid', $params->guid);
		$query = $stmt->execute();
        if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            return $queryData;
        }
        return [0, 0, 0, 0, ' '];
    }
    static public function restoreCode ($params) {
        $stmt = connectDB()->prepare("SELECT code FROM Member WHERE guid=:guid");
		$stmt->bindValue('guid', $params->guid);
		$query = $stmt->execute();
		$error = NULL;
		$result = NULL;
        if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            list($code) = $queryData;
			return $code;
        }
		return false;
    }
    static public function nickname ($params) {
        $stmt = connectDB()->prepare("SELECT nickname FROM Member WHERE puid=:puid");
		$stmt->bindValue('puid', $params->puid);
		$query = $stmt->execute();
        if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
            list($nickname) = $queryData;
			return $nickname;
        }
		return ' ';
    }
    static public function guidByCode ($params) {
        $stmt = connectDB()->prepare("SELECT guid FROM Member WHERE code=:code");
		$stmt->bindValue('code', $params->code);
		$query = $stmt->execute();
		if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
			list($guid) = $queryData;
			return $guid;
		}
		return false;
    }
    static public function guidByPuid ($puid) {
        $stmt = connectDB()->prepare("SELECT guid FROM Member WHERE puid=:puid");
		$stmt->bindValue('puid', $puid);
		$query = $stmt->execute();
		if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
			list($guid) = $queryData;
			return $guid;
		}
		return false;
    }
    static public function updateSlotItem ($params) {
        $stmt = connectDB()->prepare("UPDATE Member SET slot_item1=:slot_item1, slot_item2=:slot_item2, slot_item3=:slot_item3, slot_item4=:slot_item4  WHERE guid=:guid");
		$stmt->bindValue('slot_item1', (!!$params->slotItem1 ? $params->slotItem1 : NULL));
		$stmt->bindValue('slot_item2', (!!$params->slotItem2 ? $params->slotItem2 : NULL));
		$stmt->bindValue('slot_item3', (!!$params->slotItem3 ? $params->slotItem3 : NULL));
		$stmt->bindValue('slot_item4', (!!$params->slotItem4 ? $params->slotItem4 : NULL));
		$stmt->bindValue('guid', $params->guid);
		$query = $stmt->execute();
    }
    static public function updateNickname ($params) {
        $stmt = connectDB()->prepare("UPDATE Member SET nickname=:nickname WHERE guid=:guid");
		$stmt->bindValue('nickname', $params->nickName);
		$stmt->bindValue('guid', $params->guid);
		$query = $stmt->execute();
    }
    static public function updateGuid ($newGuid, $params) {
		$stmt = connectDB()->prepare("UPDATE Member SET guid = :newGuid WHERE guid=:guid");
		$stmt->bindValue('newGuid', $newGuid);
		$stmt->bindValue('guid', $params->guid);
		$query = $stmt->execute();
    }
    static public function nextUserId ($params) {
		$query = connectDB()->query("SELECT MAX(id) + 1 FROM Member");
		if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
			list($memberId) = $queryData;
			if (!$memberId) {
				$memberId = 1;
			}
		} else {
			$memberId = 1;
		}
		return $memberId;
    }
    static public function newUserByPuid ($memberId, $puid) {
		$stmt = connectDB()->prepare("INSERT INTO Member (id, nickname, guid, puid, code) VALUES (:id, :nickname, :guid, :puid, :code)");
		$stmt->bindValue('id', $memberId);
		$stmt->bindValue('nickname', 'NewUser');
		$stmt->bindValue('guid', $puid);
		$stmt->bindValue('puid', $puid);
		$stmt->bindValue('code', substr(md5('CODE_'.$memberId), -10));
		$query = $stmt->execute();
    }
}