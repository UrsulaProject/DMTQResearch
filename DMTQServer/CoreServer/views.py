# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.shortcuts import render
from django.http import HttpResponse
def rpc(request):
    print request.POST
    print request.body
    return HttpResponse("THIS IS API INTERFACE")
