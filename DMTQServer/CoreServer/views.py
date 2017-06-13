# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.shortcuts import render
from django.http import HttpResponse
def rpc(request):
    return HttpResponse("THIS IS API INTERFACE")
