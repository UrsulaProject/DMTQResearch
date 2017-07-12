整个dmtq的登陆第一步是Pmang

# 登陆


这步协议非常简单
向 `https://pmangplus.com/accounts/v3/global/login_dmq` POST包
HTTP头部:
```
	                "User-Agent" = "PmangPlus SDK 1.8 170414 (iPhone OS,9.3.3,iPad5,3,Apple,(null),(null))";
	                "X-PmangPlus-Platform" = iOS;
	                fp =  e30a26e6a6641b83631da5d039f4c62d5056c68b
	                locale = "en_US";
	                ts = 1499617513536;
	                ver = 5;
```
其中~~fp和ts的作用未知~~
ts为unix时间戳
fp为SHA1(UNIX时间戳+appSecret)
HTTP正文:
```
"privacy_yn=Y",
"app_id=576",
"ad_yn=Y",
"provider=",
"ad_night_yn=N",
"app_key=c6a0fad2ef3ab45068ba95fdc059e2bf",
"mob_svc_yn=Y",
"old_udid=062552A0-2C67-49F4-8CD7-649A325A7AD1-576",
"locale=en_US",
"device_cd=IPAD",
"app_secret=ODY0NmM0ZjBjZTI5ZTQ2NzFkMTVmOTE2YjU1YzY3MmY",
"local_cd=ENG",
"os_ver=9.3.3",
"app_ver=1.0",
"jailbreak_yn=N",
"udid=062552A0-2C67-49F4-8CD7-649A325A7AD1"
```

GameCenter登录还有如下两条
```
provider = GAMECENTER;
"provider_user_srl" = "G:1467614854";
```

注意所有的参数都为文本类型
应答
'''
{
	"result_code": "000",
	"value": {
		"access_token": "199131751|576|IPAD|KR|e4cdab493a8f4ea2e4ba7073716d0194cfe6dc00|1499622121157",
		"member": {
			"member_achievement_summary": null,
			"sanction": false,
			"new_msg_yn": null,
			"recent_app_title": null,
			"last_msg_dt": null,
			"friend_accept_cd": "MANUAL",
			"conflict_member_id": null,
			"achieve_detail_info_list": null,
			"is_guest_login": true,
			"crt_dt": 1499622121000,
			"recent_login_dt": null,
			"email": null,
			"adult_auth_yn": "N",
			"profile_img_url": "http://img.pmangplus.com/members/199131751/profile_img",
			"adult_auth_dt": null,
			"nickname": "User34353858",
			"profile_img_url_raw": "http://img.pmangplus.com/members/199131751/profile_img",
			"anonymous_yn": "Y",
			"reg_path": null,
			"status_cd": "OK",
			"recent_app_id": null,
			"reg_ip": "223.167.141.254",
			"upd_dt": 1499622121000,
			"reg_nation": "CN",
			"member_id": 199131751,
			"feeling": null
		},
		"conflict_member_id": null,
		"is_guest_login": true,
		"old_member_id": null
	},
	"result_msg": "API_OK"
}

'''

从中可以提取出API_TOKEN和access_token
