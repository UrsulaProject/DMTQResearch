import json
foo=[
	{
		"result": {
			"api_url": "https://dmqglb.mb.pmang.com/DMQ/rpc",
			"service_type": "LIVE",
			"coupon_yn": "Y"
		},
		"error": None,
		"id": 0
	}
]
def BuildJSONString(InputList):
	SubStringList=list()
	for item in InputList:
		SS="{\"result\":"+json.dumps(item["result"],separators=(',', ':'))+",\"error\":"+json.dumps(item["error"],separators=(',', ':'))+",\"id\":"+str(item["id"])+"}"
		SubStringList.append(SS)
	return ("["+",".join(SubStringList)+"]").replace("/","\/")

print BuildJSONString(foo)
