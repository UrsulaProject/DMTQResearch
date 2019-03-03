# JSON
As the time of original writing this (2017-06-14). DMTQ uses a badly hand crafted JSON serializer on client side which only accepts reponses strictly matching the following format
```
[{"result":{"api_url":"https:\/\/dmqglb.mb.pmang.com\/DMQ\/rpc","service_type":"LIVE","coupon_yn":"Y"},"error":null,"id":0}]
```
