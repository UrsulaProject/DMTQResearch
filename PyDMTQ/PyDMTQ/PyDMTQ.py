import requests
import json
import string
import random
import sys
import os
from urlparse import urlparse
from urllib import urlencode
from Crypto.Hash import MD5


class PyDMTQ(object):
    #This is MethodID/MethodName Table
    IDMethodTable={56:"game.getPatternUrl",
                   69:"game.getFirstResourceSongList",
                   28:"shop.getUnlockedProductList",
                   34:"game.getOwnPatternScore",
                   14:"user.getOwnRecomInfo",
                   49:"game.getOwnQuestList",
                   46:"game.getOwnAchievementList",
                   24:"shop.getOwnItemList",
                   41:"game.getOwnSongList",
                   35:"game.getUserAsset",
                   10:"user.updateInfo",
                   6:"memo.getMemoList",
                   2:"board.getNoticeList",
                   51:"game.getLineTopRank",
                   33:"game.getResourceList",
                   39:"game.getSongList",
                   55:"game.getSongUrl"

    }
    #Functions are named as MethodName.replace(".","_") for dynamic method dispatching
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

        return json.loads(self.APIPost(56,[self.guid,PatternId,EM,DeviceType]).content)[0]["result"]
    def game_getSongList(self):
        return json.loads(self.APIPost(39,[]).content)[0]["result"]
    def game_getResourceList(self,version,ClientOS):
        return json.loads(self.APIPost(33,[version,ClientOS]).content)[0]["result"]
    def game_getUserAsset(self):
        return json.loads(self.APIPost(35,[self.guid]).content)[0]["result"]
    def game_getSongUrl(self,SongID,ClientOS,Version):
        '''
            ClientOS: IOS or ANDROID
            Version: 1.0.0
        '''
        return json.loads(self.APIPost(55,[self.guid,SongID,ClientOS,Version]).content)[0]["result"]
    def saveAllPatterns(self,RootPath=os.path.join(os.path.dirname(os.path.abspath(__file__)),"Patterns")):
        if not os.path.exists(RootPath):
            os.makedirs(RootPath)
        for item in self.game_getSongList()["songs"]:
            SongID=item["song_id"]
            for P in item["song_patterns"]:
                PID=P["pattern_id"]
                ContainerPath=os.path.join(RootPath,str(SongID))
                if not os.path.exists(ContainerPath):
                    os.makedirs(ContainerPath)
                PFPath=os.path.join(ContainerPath,str(PID))
                PEMFPath=os.path.join(ContainerPath,str(PID)+"_EARPHONE")
                if os.path.exists(PFPath)==False:
                    PF=open(PFPath,"w")
                    Pattern=requests.get(self.game_getPatternUrl(PID,EarphoneMode=False)).content
                    PF.write(Pattern)
                    PF.close()
                if os.path.exists(PEMFPath)==False:
                    PatternEM=requests.get(self.game_getPatternUrl(PID)).content
                    PEMF=open(PEMFPath,"w")
                    PEMF.write(PatternEM)
                    PEMF.close()
    def saveAllSongData(self,RootPath=os.path.dirname(os.path.abspath(__file__))):
        if not os.path.exists(RootPath):
            os.makedirs(RootPath)
        SongInfoDict=dict()
        for SongInfo in self.game_getSongList()["songs"]:
            SongID=SongInfo["song_id"]
            print ("Fetching SongURL of:"+str(SongID))
            URLList=list()
            URLList.extend(self.game_getSongUrl(SongID,"ANDROID","1.0.0")["amazon"])
            URLList.extend(self.game_getSongUrl(SongID,"IOS","1.0.0")["pmang"])
            for url in URLList:
                print ("Saving :"+url)
                SavePath=RootPath+urlparse(url).path
                if os.path.exists(SavePath)==False:
                    if not os.path.exists(os.path.dirname(os.path.abspath(SavePath))):
                        os.makedirs(os.path.dirname(os.path.abspath(SavePath)))
                        Data=requests.get(url)
                        f=open(SavePath,"w")
                        f.write(Data)
                        f.close


if __name__ == '__main__':
    x=PyDMTQ("403799106@qq.com","zhs960919")
    print x.game_getUserAsset()
