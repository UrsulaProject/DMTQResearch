import requests
import json
import string
import random
import sys
import os
import signal
from urlparse import urlparse
from urllib import urlencode
from Crypto.Hash import MD5
import PyDMTQ
import SimpleHTTPServer
import SocketServer
import datetime
import StringIO
import gzip
from sys import version as python_version
from cgi import parse_header, parse_multipart

if python_version.startswith('3'):
    from urllib.parse import parse_qs
    from http.server import BaseHTTPRequestHandler
else:
    from urlparse import parse_qs
    from BaseHTTPServer import BaseHTTPRequestHandler

class DMTQServerHandler(BaseHTTPRequestHandler):
    #This is MethodID/MethodName Table
    protocol_version = 'HTTP/1.1'
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
                   55:"game.getSongUrl",
                   9:"user.loginV2",
                   0:"service.getInfo"

    }
    def gzipencode(self, content):
        out = StringIO.StringIO()
        f = gzip.GzipFile(fileobj=out, mode='w', compresslevel=5)
        f.write(content)
        f.close()
        return out.getvalue()
    def do_OPTIONS(self):
        print self.headers
        self.send_response(200, "OK")
    def do_HEAD(self):
        print self.headers
        self._set_headers()
    def do_GET(self):
        print self.headers
        self.send_response(200, 'OK')
        self.send_header("Content-type", "application/json")
        self.end_headers()
    def version_string(self):
        return "nginx"
    def do_POST(self):
        print self.headers
        Info= self.rfile.read(int(self.headers.getheader('Content-Length')))
        Info=json.loads(Info)#It's actually a list. Now dispatch requests
        Response=list()
        for Req in Info:
            ID=Req["id"]
            try:
                Handler=getattr(self,DMTQServerHandler.IDMethodTable[ID].replace(".","_"))
                Response.append(Handler(Req))
            except AttributeError:
                print ("Mapping "+str(ID)+" To Local")
                f=open("/Users/Naville/Development/DMTQResearch/APIs/Response/"+str(ID)+".json","r")
                Response.append(json.loads(f.read()))
                f.close()
        self.send_response(200, "ok")
        self.send_header("Content-Type", "application/json")
        self.send_header("Vary", "Accept-Encoding")
        self.send_header("Cache-control", "no-cache, no-store, must-revalidate")
        self.send_header("Pragma", "no-cache")
        self.send_header("Content-Encoding", "gzip")
        self.send_header("Transfer-Encoding", "chunked")
        self.send_header("Connection", "Keep-alive")
        self.end_headers()
        Data=self.gzipencode(json.dumps(Response,sort_keys=True,separators=(',', ':')).replace("/","\/"))
        self.wfile.write("%x\r\n%s\r\n" % (len(Data), Data))
        self.wfile.write("0\r\n\r\n" )
        self.wfile.flush()
    def game_getLineTopRank(self,Req):
        Rep=dict()
        Rep["error"]=None
        Rep["id"]=51
        Rep["result"]=dict()
        Rep["result"]["rank_day"]=str(datetime.datetime.now().strftime("%Y%m%d"))
        RList=list()
        for index in range(1,21):
            RList.append({
                "rank": 1,
                "fluctuation": 0,
                "guid": 140695,
                "score": 56499900,
                "slot_item1": 0,
                "slot_item2": 0,
                "display_name": "Firesynth",
                "profile_img": "http://img.pmangplus.com/members/129815351/profile_img/1491548154176"
            })
        Rep["result"]["ranks"]=RList
        return Rep
    def user_loginV2(self,Req):
        return {
        		"id": 9,
        		"result": {
        			"recom_code": "cBq2Td",
        			"displayName": "Naville",
        			"profileImg": "http://img.pmangplus.com/members/128280949/profile_img",
        			"SECRET_VER": "1",
        			"API_TOKEN": "SOMESUPERFUCKINGLONGTOKESOMESUPERFUCKINGLONGTOKESOMESUPERFUCKIN",
        			"INTRO_SERVER": "http://dmqglb.mb.pmang.com/DMQ/rpc",
        			"SECRET_KEY": "DMQGLBlive5",
        			"guid": "103052"
        		},
        		"error": None
        }
    def game_getUserAsset(self,Req):
        return {
        		"result": {
        			"exp": 40217,
        			"mpoint": 12790999999,
        			"score": 46113156,
        			"slot_item1": 0,
        			"slot_item2": 0,
        			"slot_item3": 90002,
        			"slot_item4": 100001,
        			"in_game_item1": 10,
        			"in_game_item2": 10,
        			"in_game_item3": 10,
        			"lev": 73,
        			"amt_total": "20",
        			"amt_cash": "0",
        			"amt_point": "99999",
        			"amt_mileage": "0"
        		},
        		"error": None,
        		"id": 35
        	}

    def service_getInfo(self,Req):
        return {
        		"result": {
        			"api_url": "http://dmqglb.mb.pmang.com/DMQ/rpc",
        			"service_type": "LIVE",
        			"coupon_yn": "Y"
        		},
        		"error": None,
        		"id": 0
        	}
    def game_getOwnPatternScore(self,Req):
        return {
        		"result": [],
        		"error": None,
        		"id": 35
        	}


if __name__ == '__main__':
    httpd = SocketServer.TCPServer(("127.0.0.1", 8899), DMTQServerHandler)
    httpd.serve_forever()
