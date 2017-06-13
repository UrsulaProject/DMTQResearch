整个dmtq的登陆第一步是Pmang

# 登陆
这步协议非常简单
向 `https://pmangplus.com/accounts/3/login` POST包
HTTP头部:
```
	                "User-Agent" = "PmangPlus SDK 1.8 170414 (iPhone OS,9.3.3,iPad5,3,Apple,(null),(null))";
	                "X-PmangPlus-Platform" = iOS;
	                fp = 7d76eec1ad9f17fd812e118a6cca0e6cfdfa8ea8;
	                locale = "en_US";
	                ts = 1497336612772;
	                ver = 5;
```
其中fp和ts的作用未知
HTTP正文:
```
app_id=576
app_key=c6a0fad2ef3ab45068ba95fdc059e2bf
locale=en_US
device_cd=IPAD
app_secret=ODY0NmM0ZjBjZTI5ZTQ2NzFkMTVmOTE2YjU1YzY3MmY
local_cd=ENG
passwd=密码
os_ver=9.3.3
app_ver=1.0
jailbreak_yn=N
email=邮箱
udid=BAA24753-294C-4529-9B1D-19730245E6A4
```

注意所有的参数都为文本类型

附带的PmangLogin.py执行后获得
'''

{
	"value": {
		"access_token": "128280949|576|IPAD|KR|b26a4a3b04271c509d335aa778dac397aa25d4d6|1497336613173",
		"member": {
			"crt_dt": 1401168657000,
			"upd_dt": 1497337470000,
			"status_cd": "OK",
			"member_id": 128280949,
			"nickname": "Naville",
			"profile_img_url": "http://img.pmangplus.com/members/128280949/profile_img",
			"feeling": null,
			"adult_auth_yn": "N",
			"adult_auth_dt": null,
			"recent_login_dt": 1401168656000,
			"recent_app_id": 576,
			"email": "403799106@qq.com",
			"anonymous_yn": "N",
			"reg_path": null,
			"recent_app_title": null,
			"last_msg_dt": null,
			"new_msg_yn": null,
			"friend_accept_cd": "MANUAL",
			"achieve_detail_info_list": null,
			"member_achievement_summary": null,
			"options": null,
			"contact_require_phone_auth": false,
			"contact_require_import": false,
			"contact_friend_mapping": false,
			"contact_require_phone_auth_confirm": false,
			"contact": null,
			"pmang_usn": "93884104",
			"ci": null,
			"cert_source": null,
			"sns_user_srl": null,
			"sanction": false,
			"profile_img_url_raw": "http://img.pmangplus.com/members/128280949/profile_img"
		},
		"require_adult_auth": false,
		"expire_adult_auth": false,
		"extra_infos": {
			"result": {
				"API_TOKEN": "NcUeOUhw3R1mibbZ44ZpGjOOipJYA3jw2zhGIy3fWzM0rQgLh/ZI4hNzbQnFB5oW",
				"SECRET_KEY": "DMQGLBlive1",
				"SECRET_VER": "1",
				"guid": "103052",
				"recom_code": "cBq2Td",
				"displayName": "Naville",
				"profileImg": "http://img.pmangplus.com/members/128280949/profile_img",
				"INTRO_SERVER": "https://dmqglb.mb.pmang.com/DMQ/rpc"
			}
		},
		"sns_infos": {},
		"changed_register": false,
		"apps": null,
		"emoticons": {
			"urlPrefix": "http://file.pmangplus.com/pmangplus/app/emoticons/v2/",
			"start": 0,
			"ext": "png",
			"end": 40,
			"version": 2
		},
		"current_version": null,
		"transaction_infos": {},
		"current_app_title": "DJMAX Technika Q (Global)",
		"current_app_publisher": "GMS",
		"current_app_extern_login": "PMANG",
		"contact_require_phone_auth": false,
		"contact_require_import": false,
		"contact_friend_mapping": false,
		"contact_require_phone_auth_confirm": false,
		"contact": null,
		"person_cert": {
			"reg_yn": "N",
			"reg_next_yn": "N",
			"remain_day": 0,
			"ci_yn": "N",
			"gray_yn": "N"
		},
		"extern_unregister": false,
		"require_profile_update": false,
		"newbie": false,
		"changed_profile": null
	},
	"result_code": "000",
	"result_msg": "API_OK"
}

'''

从中可以提取出API_TOKEN和access_token
