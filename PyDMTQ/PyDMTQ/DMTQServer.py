import requests
import json
import string
import random
import sys
import os
from urlparse import urlparse
from urllib import urlencode
from Crypto.Hash import MD5
import PyDMTQ
import SimpleHTTPServer
import SocketServer
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
                   9:"user.loginV2"

    }
    def do_OPTIONS(self):
        self.send_response(200, "ok")
        self.send_header('Access-Control-Allow-Origin', '*')
        self.send_header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
        self.send_header("Access-Control-Allow-Headers", "X-Requested-With")
        self.send_response(200, "ok")
    def do_HEAD(self):
        self._set_headers()
    def do_POST(self):
        Info= self.rfile.read(int(self.headers.getheader('Content-Length')))
        print Info
        #Info=json.loads(Info)
        self.send_response(200, "ok")

if __name__ == '__main__':
    server_address = ("0.0.0.0",8888)
    httpd = HTTPServer(server_address, DMTQServerHandler)
    httpd.serve_forever()
