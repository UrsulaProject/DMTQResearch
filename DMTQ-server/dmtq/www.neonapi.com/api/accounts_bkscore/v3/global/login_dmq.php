<?php

function getSslPage($url, $headerData, $postData, $isJson = false, $spHeaderData = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    if ($isJson) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $spHeaderData);
    }
    $result = curl_exec($ch);
    //var_dump(curl_strerror(curl_errno($ch)));
    curl_close($ch);
    return $result;
}
function getSHA($ts) {
    $app_secret = 'ODY0NmM0ZjBjZTI5ZTQ2NzFkMTVmOTE2YjU1YzY3MmY';
    return sha1($ts.$app_secret);
}
function getFP($key, $data) {
    return md5($key.$data);
}
function getNCE($length = 32) {
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$device = 'iOS';


$headerData = [];
foreach (getallheaders() as $name => $value) {
    if ($name === 'X-PmangPlus-Platform') {
        $device = $value;
    }
    array_push($headerData, $name.': '.$value);
}
$postData = file_get_contents('php://input');
$loginResult = getSslPage('https://www.neonapi.com/api/accounts/v3/global/login_dmq', $headerData, $postData);
//file_put_contents('header.txt', serialize($headerData));
//file_put_contents('post.txt', serialize($postData));
//file_put_contents('login.txt', $loginResult);
$loginData = json_decode($loginResult);
list($puid) = explode('|', $loginData->value->access_token);
//file_put_contents($loginData->value->member->nickname.'_login.txt', $step3data);


/*
$postData = unserialize(file_get_contents('post.txt'));
$headerData = unserialize(file_get_contents('header.txt'));
$ts = (string)round(microtime(true) * 1000);
for ($i = 0; $i < count($headerData); $i++) {
    if (substr($headerData[$i], 0, 4) === 'fp: ') {
        $headerData[$i] = 'fp: '.getSHA($ts);
    }
    if (substr($headerData[$i], 0, 4) === 'ts: ') {
        $headerData[$i] = 'ts: '.$ts;
    }
    if (substr($headerData[$i], 0, 22) === 'X-PmangPlus-Platform: ') {
        $device = str_replace('X-PmangPlus-Platform: ', '', $headerData[$i]);
    }
}
$loginResult = getSslPage('https://www.neonapi.com/api/accounts/v3/global/login_dmq', $headerData, $postData);
file_put_contents('login.txt', $loginResult);
$loginData = json_decode($loginResult);
*/


/*
$headerData = unserialize(file_get_contents('header.txt'));
for ($i = 0; $i < count($headerData); $i++) {
    if (substr($headerData[$i], 0, 22) === 'X-PmangPlus-Platform: ') {
        $device = str_replace('X-PmangPlus-Platform: ', '', $headerData[$i]);
    }
}
$loginData = json_decode(file_get_contents('login.txt'));
*/


$apiToken = '';
$key = '';
$url = 'https://dmqglb.mb.pmang.com/DMQ/rpc';
$step1postData = '[{"id":3,"method":"user.loginV2","params":["'.$loginData->value->access_token.'"," ","","1.3.5","'.$device.'","'.$loginData->value->member->reg_nation.'"]}]';
$step1secretHeader = [
    'Fp: '.getFP($key, $step1postData), 
    'X-Unity-Version: 5.6.5p2', 
    'Accept: */*', 
    'Nce: '.getNCE(), 
    'Api-Token: '.$apiToken, 
    'Secret-Ver: 1', 
    'Accept-Language: ja-jp', 
    'Accept-Encoding: gzip, deflate', 
    'Content-Type: application/json', 
    'Content-Length: '.strlen($step1postData), 
    'User-Agent: dmtq/1875 CFNetwork/808.1.4 Darwin/16.1.0', 
    'Connection: keep-alive', 
    'Secret-Key: '.$key,
];
$spHeaderData = [
    'Content-Type: application/json',
    'Content-Length: '.strlen($step1postData),
    'Fp: '.getFP($key, $step1postData), 
    'Nce: '.getNCE(), 
    'Api-Token: '.$apiToken,
    'Secret-Key: '.$key
];
$step1data = getSslPage($url, $step1secretHeader, $step1postData, true, $spHeaderData);
//file_put_contents('step1.txt', $step1data);
$step1data = json_decode($step1data);
$apiToken = $step1data[0]->result->API_TOKEN;
$key = $step1data[0]->result->SECRET_KEY;



$step2postData = '[{"id":3,"method":"user.loginV2","params":["'.$loginData->value->access_token.'"," ","","1.3.5","'.$device.'","'.$loginData->value->member->reg_nation.'"]}]';
$step2secretHeader = [
    'Fp: '.getFP($key, $step2postData), 
    'X-Unity-Version: 5.6.5p2', 
    'Accept: */*', 
    'Nce: '.getNCE(), 
    'Api-Token: '.$apiToken, 
    'Secret-Ver: 1', 
    'Accept-Language: ja-jp', 
    'Accept-Encoding: gzip, deflate', 
    'Content-Type: application/json', 
    'Content-Length: '.strlen($step2postData), 
    'User-Agent: dmtq/1875 CFNetwork/808.1.4 Darwin/16.1.0', 
    'Connection: keep-alive', 
    'Secret-Key: '.$key,
];
$spHeaderData = [
    'Content-Type: application/json',
    'Content-Length: '.strlen($step2postData),
    'Fp: '.getFP($key, $step2postData), 
    'Nce: '.getNCE(), 
    'Api-Token: '.$apiToken,
    'Secret-Key: '.$key
];
$step2data = getSslPage($url, $step2secretHeader, $step2postData, true, $spHeaderData);
//file_put_contents('step2.txt', $step2data);
$step2data = json_decode($step2data);
$apiToken = $step2data[0]->result->API_TOKEN;
$key = $step2data[0]->result->SECRET_KEY;
$guid = $step2data[0]->result->guid;
$displayName = $step2data[0]->result->displayName;


$step3postData = '[{"id":30,"method":"game.getOwnPatternScore","params":['.$guid.']}]';
//$step3postData = '[{"id":50,"method":"game.getLineTopRankWithLevel","params":[0,1,1,['.$guid.']]},{"id":37,"method":"game.getAchievementCount","params":[]},{"id":9,"method":"user.getConnectUuid","params":['.$guid.',"'.$device.'"]},{"id":2,"method":"memo.getMemoList","params":['.$guid.',0,50]},{"id":31,"method":"game.getUserAsset","params":['.$guid.']},{"id":34,"method":"game.getOwnSongList","params":['.$guid.']},{"id":19,"method":"shop.getOwnItemList","params":['.$guid.']},{"id":38,"method":"game.getOwnAchievementList","params":['.$guid.']},{"id":40,"method":"game.getOwnQuestList","params":['.$guid.']},{"id":30,"method":"game.getOwnPatternScore","params":['.$guid.']},{"id":23,"method":"shop.getUnlockedProductList","params":['.$guid.']},{"id":48,"method":"game.getFirstResourceSongList","params":[]},{"id":7,"method":"user.getUsersByPuid","params":[["'.$puid.'"],["display_name"]]},{"id":66,"method":"game.getAdSongList","params":['.$guid.']},{"id":67,"method":"game.getAdTicketChecked","params":['.$guid.']},{"id":75,"method":"game.getDefaultSetting","params":[]},{"id":76,"method":"game.getUserFreePass","params":['.$guid.']},{"id":77,"method":"game.getPatternUsePointData","params":[]}]';
$step3secretHeader = [
    'Fp: '.getFP($key, $step3postData), 
    'X-Unity-Version: 5.6.5p2', 
    'Accept: */*', 
    'Nce: '.getNCE(), 
    'Api-Token: '.$apiToken, 
    'Secret-Ver: 1', 
    'Accept-Language: ja-jp', 
    'Accept-Encoding: gzip, deflate', 
    'Content-Type: application/json', 
    'Content-Length: '.strlen($step3postData), 
    'User-Agent: dmtq/1875 CFNetwork/808.1.4 Darwin/16.1.0', 
    'Connection: keep-alive', 
    'Secret-Key: '.$key,
];
$spHeaderData = [
    'Content-Type: application/json',
    'Content-Length: '.strlen($step3postData),
    'Fp: '.getFP($key, $step3postData), 
    'Nce: '.getNCE(), 
    'Api-Token: '.$apiToken,
    'Secret-Key: '.$key
];
$step3data = getSslPage($url, $step3secretHeader, $step3postData, true, $spHeaderData);
//file_put_contents('step3.txt', $step3data);
//file_put_contents($loginData->value->member->member_id.'.txt', $step3data);
file_put_contents($displayName.'.txt', $step3data);
//$step3data = json_decode($step3data);
//$step3data[0]['result'];
http_response_code(500);