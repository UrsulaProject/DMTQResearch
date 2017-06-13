from django.conf.urls import url

from . import views

urlpatterns = [
    url(r'rpc/', views.rpc, name='rpc'),
]
