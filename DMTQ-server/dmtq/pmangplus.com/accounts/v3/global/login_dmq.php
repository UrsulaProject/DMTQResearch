<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdef';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//$postData = unserialize(file_get_contents('post.txt'));
$postData = file_get_contents('php://input');
$data = explode('&', $postData);
$postData = [];
for ($i = 0; $i < count($data); $i++) {
    list($name, $value) = explode('=', $data[$i]);
    $postData[$name] = $value;
}
$handle = new SQLite3('C:\WebRoot\dmtq\_info\dmtq.db3');
$query = $handle->query("SELECT puid FROM Member WHERE udid = '".$postData['udid']."'");
if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
    list($puid) = $queryData;
} else {
    $query = $handle->query("SELECT MAX(id) + 1 FROM Member");
    if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
        list($puid) = $queryData;
        if (!$puid) {
            $puid = 1;
        }
    } else {
        $puid = 1;
    }
    $handle->query("INSERT INTO Member (id, nickname, guid, puid, udid) VALUES (".$puid.", ' ', '".$puid."', '".$puid."', '".$postData['udid']."')");
}
$handle->close();
echo '{"value":{"access_token":"'.$puid.'|576|IPHONE|KR|'.generateRandomString(40).'|'.time().'000","member":{"crt_dt":'.time().'000,"upd_dt":'.time().'000,"status_cd":"OK","member_id":'.$puid.',"nickname":"NewUser","profile_img_url":"","feeling":null,"adult_auth_yn":"N","adult_auth_dt":null,"recent_login_dt":'.time().'000,"recent_app_id":null,"email":null,"anonymous_yn":"N","reg_path":"GAMECENTER","recent_app_title":null,"last_msg_dt":null,"new_msg_yn":null,"friend_accept_cd":"MANUAL","achieve_detail_info_list":null,"member_achievement_summary":null,"conflict_member_id":null,"reg_ip":"130.245.192.14","reg_nation":"US","is_guest_login":true,"provider_display_name":"","pushgroup":null,"locale":null,"sanction":false,"profile_img_url_raw":"http://img.pmangplus.com/members/245568744/profile_img"},"conflict_member_id":null,"is_guest_login":true,"old_member_id":null,"jailbreak_yn":"N","unreg_status":"NO","callTime":0},"result_code":"000","result_msg":"API_OK"}';