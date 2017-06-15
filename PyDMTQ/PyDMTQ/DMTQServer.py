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
    def BuildJSONString(self,InputList):
        '''
        DMTQ is using its very own stupid error-prone JSON Parser.
        We have to built our own serializer to strictly follow its format
        '''
    	SubStringList=list()
    	for item in InputList:
            SS="{\"result\":"+json.dumps(item["result"],separators=(',', ':'))+",\"error\":"+json.dumps(item["error"],separators=(',', ':'))+",\"id\":"+str(item["id"])+"}"
            SubStringList.append(SS)
    	return ("["+",".join(SubStringList)+"]").replace("/","\/")
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
        Data=None
        Info= self.rfile.read(int(self.headers.getheader('Content-Length')))
        Info=json.loads(Info)#It's actually a list. Now dispatch requests
        Response=list()
        ReqIDs=list()
        for Req in Info:
            ID=Req["id"]
            ReqIDs.append(ID)
            try:
                Handler=getattr(self,DMTQServerHandler.IDMethodTable[ID].replace(".","_"))
                Response.append(Handler(Req["params"],self.headers))
            except AttributeError:
                print ("Mapping "+str(ID)+" To Local")
                f=open("/Users/Naville/Development/DMTQResearch/APIs/Response/"+str(ID)+".json","r")
                Response.append(json.loads(f.read()))
                f.close()
        '''
        if 0 in ReqIDs:
            f=open("/Users/Naville/Development/DMTQResearch/APIs/Response/0.json","r")
            Data=self.gzipencode(f.read())
            f.close()
        '''
        self.send_response(200, "ok")
        self.send_header("Content-Type", "application/json")
        self.send_header("Vary", "Accept-Encoding")
        self.send_header("Cache-control", "no-cache, no-store, must-revalidate")
        self.send_header("Pragma", "no-cache")
        self.send_header("Content-Encoding", "gzip")
        self.send_header("Transfer-Encoding", "chunked")
        self.send_header("Connection", "Keep-alive")
        self.end_headers()
        Data=self.gzipencode(self.BuildJSONString(Response))
        self.wfile.write("%x\r\n%s\r\n" % (len(Data), Data))
        self.wfile.write("0\r\n\r\n" )
        self.wfile.flush()
    def service_getInfo(self,Params,Headers):
        return {'id': 0, 'result': {'service_type': 'LIVE', 'api_url': 'https://dmqglb.mb.pmang.com/DMQ/rpc', 'coupon_yn': 'Y'}, 'error': None}
    def shop_getOwnItemList(self,Params,Headers):
        return {"result":[{"item_id":90001,"own_count":1,"repeat_count":999,"using_yn":"Y","reg_date":"20141113010808","end_date":""},{"item_id":90002,"own_count":1,"repeat_count":899,"using_yn":"Y","reg_date":"20141231151858","end_date":""},{"item_id":90003,"own_count":1,"repeat_count":999,"using_yn":"Y","reg_date":"20160228031209","end_date":""},{"item_id":90005,"own_count":1,"repeat_count":8,"using_yn":"Y","reg_date":"20141112213302","end_date":""},{"item_id":90006,"own_count":1,"repeat_count":14,"using_yn":"Y","reg_date":"20141113011210","end_date":""},{"item_id":90008,"own_count":1,"repeat_count":10,"using_yn":"Y","reg_date":"20150118121938","end_date":""},{"item_id":90009,"own_count":1,"repeat_count":10,"using_yn":"Y","reg_date":"20151007221159","end_date":""},{"item_id":100001,"own_count":1,"repeat_count":0,"using_yn":"N","reg_date":"20140801010031","end_date":""}],"error":None,"id":24}
    def game_getUserAsset(self,Params,Headers):
        return {"result":{"lev":73,"amt_total":"20","score":46113156,"in_game_item1":100,"amt_mileage":"0","mpoint":99999,"amt_cash":"0","exp":40217,"slot_item1":0,"slot_item2":0,"slot_item3":90002,"slot_item4":100001,"amt_point":"9999","in_game_item3":100,"in_game_item2":100},"error":None,"id":35}
    '''
    def game_getResourceList(self,Params,Headers):
        return {
            "id":33,
            "error":None,
            "result":self.server.PyDMTQ.game_getResourceList(Params[0],Params[1])
        }
    def user_loginV2(self,Params,Headers):
        return self.server.PyDMTQ.LoginInfo
    '''

if __name__ == '__main__':
    httpd = SocketServer.TCPServer(("127.0.0.1", 8899), DMTQServerHandler)
    #httpd.PyDMTQ=PyDMTQ.PyDMTQ("403799106@qq.com","zhs960919")
    #httpd.PyDMTQ.user_loginV2()
    httpd.serve_forever()
