import requests
import json
import string
import random
from urllib import urlencode
from Crypto.Hash import MD5


class PyDMTQ(object):
    #This is MethodID/MethodName Table
    IDMethodTable={56:"game.getPatternUrl"

    }
    #Functions are named as MethodName.replace(".","") for dynamic method dispatching
    def __init__(self, email, password):
        #PMang Login
        HTTPHeaders = {"User-Agent": "PmangPlus SDK 1.8 170414 (iPhone OS,9.3.3,iPad5,3,Apple,(null),(null))",
                       "X-PmangPlus-Platform": 'iOS',
                       'fp': '7d76eec1ad9f17fd812e118a6cca0e6cfdfa8ea8',
                       'locale': "en_US",
                       'ts': '1497336612772',
                       'ver': '5'}
        Body = {'app_id': '576',
                'app_key': 'c6a0fad2ef3ab45068ba95fdc059e2bf',
                'locale': 'en_US',
                'device_cd': 'IPAD',
                'app_secret': 'ODY0NmM0ZjBjZTI5ZTQ2NzFkMTVmOTE2YjU1YzY3MmY',
                'local_cd': 'ENG',
                'passwd': password,
                'os_ver': '9.3.3',
                'app_ver': '1.0',
                'jailbreak_yn': 'N',
                'email': email,
                'udid': 'BAA24753-294C-4529-9B1D-19730245E6A4'}
        foo=json.loads(requests.post("https://pmangplus.com/accounts/3/login",params=Body, headers=HTTPHeaders).content)
        self.access_token=foo['value']['access_token']
        self.nickname=foo['value']['member']['nickname']
        self.profileimageurl=foo['value']['member']['profile_img_url']
        self.guid=foo['value']['extra_infos']['result']['guid']
        self.secretkey=foo['value']['extra_infos']['result']['SECRET_KEY']
        self.secretkeyver=foo['value']['extra_infos']['result']['SECRET_VER']#This is temporary.
        #Now perform actual DMTQ Login
        DMTHTTPBody=[
        	{
        		"id": 9,
        		"method": "user.loginV2",
        		"params": [
        			self.access_token,
        			self.nickname,
        			self.profileimageurl,
        			"1.0.11",
        			"iOS"
        		]
        	}
        ]
        DMTHTTPBody=json.dumps(DMTHTTPBody)
        DMTHTTPHeader={
        	                "Api-Token" : "",
        	                "Fp" : self.CalculateFp(DMTHTTPBody),
        	                "Nce" : self.CalculateNce(),
        	                "Secret-Key" : "",
        	                "Secret-Ver" : "1",
        	                "X-Unity-Version" : "5.5.2f1"
        }
        foo2=json.loads(requests.post("https://dmqglb.mb.pmang.com/DMQ/rpc",data=DMTHTTPBody, headers=DMTHTTPHeader).content)
        self.apitoken=foo2[0]['result']['API_TOKEN']
        self.secretkey=str(foo2[0]['result']['SECRET_KEY'])
        self.secretkeyver=str(foo2[0]['result']['SECRET_VER'])
        self.guid=str(foo2[0]['result']['guid'])
        print("Logged in with API Token:"+self.apitoken)
    def CalculateFp(self, PostData):
        h = MD5.new()
        h.update(bytearray(str(self.secretkey + PostData)))
        return h.hexdigest()
    def APIPost(self,id,Params):
        HTTPBody=[
        	{
        		"id": id,
        		"method": PyDMTQ.IDMethodTable[id],
        		"params": Params
        	}
        ]
        HTTPBody=json.dumps(HTTPBody)
        HTTPHeader={
        	                "Api-Token" :self.apitoken,
        	                "Fp" : self.CalculateFp(HTTPBody),
        	                "Nce" : self.CalculateNce(),
        	                "Secret-Key" : self.secretkey,
        	                "Secret-Ver" : self.secretkeyver,
        	                "X-Unity-Version" : "5.5.2f1"
        }
        return requests.post("https://dmqglb.mb.pmang.com/DMQ/rpc",data=HTTPBody, headers=HTTPHeader)
    def CalculateNce(self, size=32, chars=string.ascii_lowercase + string.digits):
        return ''.join(random.choice(chars) for _ in range(size))
    def game_getPatternUrl(self,PatternId,EarphoneMode=True,DeviceType="P"):
        EM=""
        if EarphoneMode==True:
            EM="e"

        return self.APIPost(56,[self.guid,PatternId,EM,DeviceType]).content


if __name__ == '__main__':
    x=PyDMTQ("403799106@qq.com","zhs960919")
    print x.game_getPatternUrl(3)
