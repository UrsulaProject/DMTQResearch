接下来开始DMTQ本身的登陆过程。dmtq所有的API Endpoint都为`https://dmqglb.mb.pmang.com/DMQ/rpc`
需要操作都需要计算Nce和Fp并存放在请求头部
Fp:

```
MD5.ToHexString(MD5.GenHash(SecretKey + postData));;
```

Nce为随机32位hex表示的字符串

参数结构为一个列表里包含一系列对应请求的字符串，每次请求可包含多个API调用。如下文为一个只请求一次user.loginV2的登陆
向这里POST JSON:
```
[{"id":9,"method":"user.loginV2","params":[刚才的ACCESS_TOKEN,"Naville","http://img.pmangplus.com/members/128280949/profile_img","1.0.11","iOS"]}]
```
HTTP Header:
```
	                "Api-Token" = "";
	                Fp = 71278e4607fbc7d83ca2e82c83490f08;
	                Nce = 00f091a0dc0381a8d667b068d2fd515f;
	                "Secret-Key" = "";
	                "Secret-Ver" = 1;
	                "X-Unity-Version" = "5.5.2f1";
```
即可获得:
其中SECRET_KEY guid API_TOKEN 都很重要
```
[
	{
		"result": {
			"API_TOKEN": "这是你的APIToken",
			"SECRET_KEY": "DMQGLBlive7",
			"SECRET_VER": "1",
			"guid": "103052",
			"recom_code": "cBq2Td",
			"displayName": "Naville",
			"profileImg": "http://img.pmangplus.com/members/128280949/profile_img",
			"INTRO_SERVER": "https://dmqglb.mb.pmang.com/DMQ/rpc"
		},
		"error": null,
		"id": 9
	}
]
```
# 谱面下载
BODY

```
[{"id":56,"method":"game.getPatternUrl","params":[103052,3,"","P"]}]
```

Header

```
	                "Api-Token" = "vT8CQRNT6ecFI3bkk5cdJIzDCNvh6KNAXHc7+snDsOL01CCu+UmSe6lPBVEQtZ8U";
	                "Content-Length" = 68;
	                "Content-Type" = "application/json";
	                Fp = 98b853f6c672dfe2481c20928ef286cf;
	                Nce = c1cc42a9008ce609dd13c8e33fa1b033;
	                "Secret-Key" = DMQGLBlive4;
	                "Secret-Ver" = 1;
	                "X-Unity-Version" = "5.5.2f1";

```
