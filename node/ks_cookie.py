# -*- coding: utf-8 -*-

import requests,json
from lxpy import copy_headers_dict
from requests.utils import dict_from_cookiejar
import sys

index_url = 'https://www.kuaishou.com/'
graphql_url = 'https://www.kuaishou.com/graphql'

def get_did(proxy_ip,proxy_port):
    sess = requests.session()
    sess.headers = copy_headers_dict(f'''
    content-type: application/json
    Host: www.kuaishou.com
    Origin: https://www.kuaishou.com
    Pragma: no-cache
    Referer: https://www.kuaishou.com
    sec-ch-ua: "Chromium";v="92", " Not A;Brand";v="99", "Google Chrome";v="92"
    sec-ch-ua-mobile: ?0
    Sec-Fetch-Dest: empty
    Sec-Fetch-Mode: cors
    Sec-Fetch-Site: same-origin
    User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36
    ''')
    proxies = {
        "http"  : 'http://'+proxy_ip+':'+proxy_port,
    }
    if proxy_ip=="":
        proxies = {}
    sess.get(index_url,proxies=proxies)
    did = dict_from_cookiejar(sess.cookies)['did']
    payload = {"operationName": "graphqlSearchUser", "variables": {"keyword": "鞠婧祎"},"query": "query graphqlSearchUser($keyword: String, $pcursor: String, $searchSessionId: String) {\n  visionSearchUser(keyword: $keyword, pcursor: $pcursor, searchSessionId: $searchSessionId) {\n    result\n    users {\n      fansCount\n      photoCount\n      isFollowing\n      user_id\n      headurl\n      user_text\n      user_name\n      verified\n      verifiedDetail {\n        description\n        iconType\n        newVerified\n        musicCompany\n        type\n        __typename\n      }\n      __typename\n    }\n    searchSessionId\n    pcursor\n    __typename\n  }\n}\n"}
    payload=json.dumps(payload)

    data = sess.post(graphql_url,data=payload,proxies=proxies).json()

    if not data.get('captcha'):
        print(did)
        return did
    else:
        #data['captcha']['jsSdkUrl']
        captcha_url = data['captcha']['url']
        print(did)
        print(captcha_url)

get_did(sys.argv[1],sys.argv[2])
