# -*- coding: utf-8 -*-
# @Time    : 2021/9/15 13:11
# @Author  : lx
# @IDE ：PyCharm
import re
import requests

def get_s_v_web_id():
    sess = requests.session()
    index_url = "https://www.douyin.com/user/MS4wLjABAAAACV5Em110SiusElwKlIpUd-MRSi8rBYyg0NfpPrqZmykHY8wLPQ8O4pv3wPL6A-oz?"
    index_headers = {
        "authority": "www.douyin.com",
        "method": "GET",
        "path": "/",
        "scheme": "https",
        "accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;"
                  "q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-language": "zh-CN,zh;q=0.9,en-GB;q=0.8,en;q=0.7,ja;q=0.6",
        "cache-control": "max-age=0",
        "upgrade-insecure-requests": "1",
        "user-agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) "
                      "Chrome/92.0.4515.107 Safari/537.36",
    }
    index_text = sess.get(index_url, headers=index_headers).text
    verify_data_pattern = re.findall("const verify_data = ({.*?})", index_text,re.S)
    if verify_data_pattern:
        verify_data = json.loads(verify_data_pattern[0].split(',"server_sdk_env"')[0]+'}')
        s_v_web_id = verify_data['fp']
        return s_v_web_id


print(get_s_v_web_id())

