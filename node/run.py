import requests
import execjs
import sys
import time
import json
import re
from urllib import parse
import http.cookiejar as cookielib


# 直接python获取
def dy_sign(method,kw=None):
    with open('/www/wwwroot/xunpang/python/signature.js','r',encoding='utf-8') as f:
        b = f.read()
    c = execjs.compile(b)
    url = c.call(method,kw)
    return get_res(url)
    
# 获取结果
def get_res(url,cookie="",proxy_ip="",proxy_port=""):
    headers = {
        "Accept": "application/json, text/plain, */*",
        "Accept-Encoding": '',
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
        "Referer": "https://www.douyin.com/",
        "Accept-Language": "zh-CN,zh;q=0.9",
    }
    cookie_url = 'https://www.douyin.com/'
    session = requests.session()
    # session.get(cookie_url, headers=headers)

    proxies = {
        "http"  : 'http://'+proxy_ip+':'+proxy_port,
    }
    if proxy_ip=="":
        proxies = {}
    res = session.get(url, headers=headers,proxies=proxies).text
    return res

# 获取用户信息
def get_user_info(sec_user_id):
    # res = dy_sign(method='user_profile',kw=sec_user_id)
    url = 'http://127.0.0.1:8003/user_profile'
    data_sign = {'kw': sec_user_id}
    new_url = requests.post(url=url, data=data_sign).text
    res = get_res(new_url)
    return json.dumps(res['user'])

# 获取用户作品
def get_user_video(sec_user_id,dcount,max_cursor,proxy_ip='',proxy_port=''):
    url = 'http://127.0.0.1:8003/aweme_post'
    data_sign = {'kw': sec_user_id,'count': dcount,'max_cursor': max_cursor,'proxy_ip':proxy_ip,'proxy_port':proxy_port}
    new_url = requests.post(url=url, data=data_sign).text
    res = get_res(new_url,proxy_ip,proxy_port)
    return json.dumps(res)
    # return json.dumps(res['aweme_list'])

# 获取评论
def get_video_comment(aweme_id,cursor,proxy_ip='',proxy_port=''):
    url = 'http://127.0.0.1:8003/comment'
    data_sign = {'kw': aweme_id,'offset': cursor,'count':50,'proxy_ip':proxy_ip,'proxy_port':proxy_port}
    proxies = {
        "http"  : 'http://'+proxy_ip+':'+proxy_port,
    }
    if proxy_ip=="":
        proxies = {}
    new_url = requests.post(url=url, data=data_sign,proxies=proxies).text
    res = get_res(new_url,'',proxy_ip,proxy_port)
    return json.dumps(res['comments'])

# 获取单视频详情
def get_video_info(aweme_id,proxy_ip='',proxy_port=''):
    headers = {
        "Accept": "application/json, text/plain, */*",
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
        "Referer": "https://www.douyin.com/",
        "Accept-Language": "zh-CN,zh;q=0.9"
    }
    url = 'https://www.iesdouyin.com/web/api/v2/aweme/iteminfo/?item_ids='+aweme_id
    proxies = {
        "http"  : 'http://'+proxy_ip+':'+proxy_port,
    }
    if proxy_ip=="":
        proxies = {}
    res = requests.get(url=url,headers=headers,proxies=proxies).json()
    return json.dumps(res['item_list'][0])

# 获取关键词视频
def get_search_item(kw,count,sort_type,publish_time,proxy_ip='',proxy_port=''):
    url = 'http://127.0.0.1:8003/search_item'
    data_sign = {'kw': kw,'count':count,'sort_type':sort_type,'publish_time':publish_time,'proxy_ip':proxy_ip,'proxy_port':proxy_port}
    new_url = requests.post(url=url, data=data_sign).text
    res = get_res(new_url,proxy_ip,proxy_port)
    return json.dumps(res['data'])

# 获取cookie
def get_cookie(token,proxy_ip='',proxy_port=''):
    headers = {
        "Accept": "application/json, text/plain, */*",
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
        "Referer": "https://www.douyin.com/",
        "Accept-Language": "zh-CN,zh;q=0.9"
    }
    url = 'https://sso.douyin.com/check_qrconnect/?service=https%3A%2F%2Fwww.douyin.com%2F&token='+token+'&need_logo=false&aid=6383'
    proxies = {
        "http"  : 'http://'+proxy_ip+':'+proxy_port,
    }
    if proxy_ip=="":
        proxies = {}
    session = requests.session()
    session.cookies = cookielib.LWPCookieJar(filename='/www/wwwroot/xunpang/node/cookies.txt')
    res = session.get(url, headers=headers,proxies=proxies).json()
    session.cookies.save()
    return session

# ...
if __name__ == "__main__":
    res = ''
    if sys.argv[1] == 'user_video':
        res = get_user_video(sys.argv[2],sys.argv[3],sys.argv[4],sys.argv[5],sys.argv[6])
    elif sys.argv[1] == 'user_info':
        res = get_user_info(sys.argv[2])
    elif sys.argv[1] == 'video_comment':
        res = get_video_comment(sys.argv[2],sys.argv[3],sys.argv[4],sys.argv[5])
    elif sys.argv[1] == 'video_info':
        res = get_video_info(sys.argv[2],sys.argv[3],sys.argv[4])
    elif sys.argv[1] == 'search_item':
        res = get_search_item(sys.argv[2],sys.argv[3],sys.argv[4],sys.argv[5],sys.argv[6],sys.argv[7])
    elif sys.argv[1] == 'proxy_php':
        res = get_res(sys.argv[2],sys.argv[3],sys.argv[4])
    elif sys.argv[1] == 'get_cookie':
        res = get_cookie(sys.argv[2],sys.argv[3],sys.argv[4])
    print(res)
