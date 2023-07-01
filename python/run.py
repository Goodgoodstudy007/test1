import requests
import execjs
import sys
import time
import json
from urllib import parse

def dy_sign(method,kw=None):
    with open('/www/wwwroot/xunpang/python/signature.js','r',encoding='utf-8') as f:
        b = f.read()
    c = execjs.compile(b)
    d = c.call(method,kw)
    headers = {
        "Accept": "application/json, text/plain, */*",
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
        "Referer": "https://www.douyin.com/",
        "Accept-Language": "zh-CN,zh;q=0.9"
    }
    cookie_url = 'https://www.douyin.com/'
    session = requests.session()
    session.get(cookie_url, headers=headers)
    res = session.get(d, headers=headers).json()
    return res

def get_user_info(sec_user_id):
    res = dy_sign(method='user_profile',kw=sec_user_id)
    return json.dumps(res['user'])

def get_user_video(sec_user_id,dcount):
    print()

def get_video_comment(aweme_id,cursor):
    print()


# 首页推荐视频
#print(dy_sign(method='feed'))
# 搜索视频
#print(dy_sign(method='search_item',kw='Lx'))
# 评论
#print(dy_sign(method='cooment',kw='6989198974582263070'))
# 作品
# print(dy_sign(method='aweme_post',kw='MS4wLjABAAAAIWFmTfNJmRajbViR_rK6iGgQMIq0lAWdFmQ5z6iU9Vd4uo9KXOgcJE0o5Dn0JAmW'))
# TODO 其他的自行补充吧
# ...
if __name__ == "__main__":
    res = ''
    if sys.argv[1] == 'user_video':
        res = get_user_video(sys.argv[2],sys.argv[3])
    elif sys.argv[1] == 'user_info':
        res = get_user_info(sys.argv[2])
    elif sys.argv[1] == 'video_comment':
        res = get_video_comment(sys.argv[2],sys.argv[3])
    print(res)
