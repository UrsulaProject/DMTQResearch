import requests,json,string,random
from urllib import urlencode
from Crypto.Hash import MD5
USERNAME="403799106@qq.com"
PASSWORD="zhs960919"

def CalculateFp(SecretKey,PostData):
	h = MD5.new()
	h.update(bytearray(SecretKey+PostData))
	return h.hexdigest()
def CalculateNce(size=32, chars=string.ascii_lowercase + string.digits):
	return ''.join(random.choice(chars) for _ in range(size))
HTTPHeaders = {"User-Agent":"PmangPlus SDK 1.8 170414 (iPhone OS,9.3.3,iPad5,3,Apple,(null),(null))",
	           "X-PmangPlus-Platform":'iOS',
	           'fp':'7d76eec1ad9f17fd812e118a6cca0e6cfdfa8ea8',
               'locale':"en_US",
	           'ts':'1497336612772',
               'ver':'5'}
Body={'app_id':'576',
'app_key':'c6a0fad2ef3ab45068ba95fdc059e2bf',
'locale':'en_US',
'device_cd':'IPAD',
'app_secret':'ODY0NmM0ZjBjZTI5ZTQ2NzFkMTVmOTE2YjU1YzY3MmY',
'local_cd':'ENG',
'passwd':PASSWORD,
'os_ver':'9.3.3',
'app_ver':'1.0',
'jailbreak_yn':'N',
'email':USERNAME,
'udid':'BAA24753-294C-4529-9B1D-19730245E6A4'}

foo=json.loads(requests.post("https://pmangplus.com/accounts/3/login",params=Body, headers=HTTPHeaders).content)
print foo
access_token=foo['value']['access_token']
NickName=foo['value']['member']['nickname']
ProfileImageURL=foo['value']['member']['profile_img_url']
GUID=foo['value']['extra_infos']['result']['SECRET_KEY']
DMTHTTPHeader={
	                "Api-Token" : "",
	                "Fp" : "71278e4607fbc7d83ca2e82c83490f08",
	                "Nce" : "00f091a0dc0381a8d667b068d2fd515f",
	                "Secret-Key" : "",
	                "Secret-Ver" : "1",
	                "X-Unity-Version" : "5.5.2f1"
}
DMTHTTPBody=[
	{
		"id": 9,
		"method": "user.loginV2",
		"params": [
			access_token,
			NickName,
			ProfileImageURL,
			"1.0.11",
			"iOS"
		]
	}
]
foo2=json.loads(requests.post("https://dmqglb.mb.pmang.com/DMQ/rpc",data=json.dumps(DMTHTTPBody), headers=DMTHTTPHeader).content)
REAL_API_TOKEN=foo2[0]['result']['API_TOKEN']
SECRET_KEY=str(foo2[0]['result']['SECRET_KEY'])
PatternURLBody=[
	{
		"id": 56,
		"method": "game.getPatternUrl",
		"params": [
			GUID,
			3,
			"",
			"P"
		]
	}
]
PatternURLHeader={
	                "Api-Token":str(REAL_API_TOKEN),
	                "Fp":str(CalculateFp(SECRET_KEY,json.dumps(PatternURLBody))),
	                "Nce":str(CalculateNce()),
	                "Secret-Key":SECRET_KEY,
	                "Secret-Ver":"1",
	                "X-Unity-Version":"5.5.2f1"
}
print PatternURLHeader
print requests.post("https://dmqglb.mb.pmang.com/DMQ/rpc",data=json.dumps(PatternURLBody), headers=PatternURLHeader).content