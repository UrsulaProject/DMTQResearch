<?php
function randomCode($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
define('DB_PATH', '../../../../_info/dmtq.db3');
$nowTime = time();
$appId = isset($_POST['app_id']) ? $_POST['app_id'] : '576';
$provider = isset($_POST['provider']) ? $_POST['provider'] : 'GAMECENTER';
$deviceCode = isset($_POST['device_cd']) ? $_POST['device_cd'] : 'IPHONE';
$udid = isset($_POST['udid']) ? $_POST['udid'] : '';
$serverCode = 'KR';


$handle = new SQLite3(DB_PATH);
$query = $handle->query("SELECT id FROM Member WHERE udid = '${udid}'");
if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
    list($memberId) = $queryData;
} else {
    $query = $handle->query("SELECT MAX(id) + 1 FROM Member");
    if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
        list($memberId) = $queryData;
        if (!$memberId) {
            $memberId = 1;
        }
    } else {
        $memberId = 1;
    }
    $handle->query("INSERT INTO Member (id, nickname, udid) VALUES (${memberId}, ' ', '${udid}')");
}
$handle->close();

$tokenList = [$memberId, $appId, $deviceCode, $serverCode, randomCode(40), $nowTime * 1000 + 602];
$data = [
    'value' => [
        'access_token' => join('|', $tokenList),
        'member' => [
            'crt_dt' => $nowTime * 1000,
            'upd_dt' => $nowTime * 1000,
            'status_cd' => 'OK',
            'member_id' => $memberId,
            'nickname' => 'User14069598',
            'profile_img_url' => 'http://img.pmangplus.com/members/199024429/profile_img',
            'feeling' => NULL,
            'adult_auth_yn' => 'N',
            'adult_auth_dt' => NULL,
            'recent_login_dt' => NULL,
            'recent_app_id' => NULL,
            'email' => NULL,
            'anonymous_yn' => 'N',
            'reg_path' => $provider,
            'recent_app_title' => NULL,
            'last_msg_dt' => NULL,
            'new_msg_yn' => NULL,
            'friend_accept_cd' => 'MANUAL',
            'achieve_detail_info_list' => NULL,
            'member_achievement_summary' => NULL,
            'conflict_member_id' => NULL,
            'reg_ip' => '61.93.17.218',
            'reg_nation' => 'HK',
            'is_guest_login' => false,
            'sanction' => false,
            'profile_img_url_raw' => 'http://img.pmangplus.com/members/199024429/profile_img'
        ],
        'conflict_member_id' => NULL,
        'is_guest_login' => false,
        'old_member_id' => NULL
    ],
    'result_code' => '000',
    'result_msg' => 'API_OK'
];
header('Content-Type: application/json');
echo json_encode($data);