import requests
import execjs
import sys
import time
import json
from urllib import parse


headers = {
        'origin': 'https://www.douyin.com',
        'accept': 'application/json, text/plain, */*',
        'accept-encoding': 'gzip, deflate, br',
        'accept-language': 'zh-CN,zh;q=0.9',
        'cookie' : 'ttwid=1%7C0_AzdEddJIMjhHiUEfnRj8lsRuYldVzNMlgWwSpAvys%7C1627268900%7Ce43c7e878a9fec92bc274add1e739890f6a931c61e1df18cac4e6e921a03e3c0',
        'referer': 'https://www.douyin.com/user/MS4wLjABAAAAAhCuW0qkQJRCrp45HfLw-Hpp8nsf9qYOf96RffY5FDo',
        'user-agent': 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        'withcredentials': 'true',
        # 'referer': 'https://www.douyin.com/search/%E5%AD%A6%E4%B9%A0%E5%BC%BA%E5%9B%BD?aid=41c7831d-222a-46f1-bb48-54551c612763&publish_time=0&sort_type=0&source=normal_search&type=video',
        
}


def get_url_exec(url):
    with open(r'/www/wwwroot/xunpang/node/signature.js', 'r', encoding='utf-8') as f:
        js = f.read()
    ct = execjs.compile(js,cwd=r'/www/wwwroot/xunpang/node/node_modules')
    url = ct.call('get_sign',url)
    # print(url.split('&_signature=')[1])
    return url


def get_res(douyin_url):
    url = 'http://127.0.0.1:8003/sign'
    data_sign = {'url': douyin_url.replace('https://www.douyin.com','')}
    # print(data_sign)
    new_url = requests.post(url=url, data=data_sign).text
    return new_url


def get_user_info(sec_user_id):
    params = {
        'device_platform': 'webapp',
        'aid': '6383',
        'channel': 'channel_pc_web',
        'publish_video_strategy_type': '2',
        'source': 'channel_pc_web',
        'sec_user_id': sec_user_id,
        'version_code': '160100',
        'version_name': '16.1.0',
        'cookie_enabled': 'true',
        'screen_width': '1920',
        'screen_height': '1080',
        'browser_language': 'zh-CN',
        'browser_platform': 'Win32',
        'browser_name': 'Mozilla',
        'browser_version': '5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        'browser_online': 'true',
    }
    uri = 'https://www.douyin.com/aweme/v1/web/user/profile/other/?'
    cookie_url = 'https://www.douyin.com/user/'+sec_user_id
    session = requests.session()
    session.get(cookie_url, headers=headers)
    # cookies = session.cookies.get_dict()
    url = get_res(uri+parse.urlencode(params))
    print(url)
    res = session.get(url, headers=headers)
    print(res.text)
    # print(json.dumps(res['user']))
    # print('昵称:',res['user']['nickname'],'粉丝:', res['user']['mplatform_followers_count'], '获赞:',res['user']['total_favorited'])

def get_user_video(sec_user_id,dcount):
    t = time.time()
    this_time = str(round(t * 1000))
    douyin_url = 'https://www.douyin.com/aweme/v1/web/aweme/post/?device_platform=webapp&aid=6383&channel=channel_pc_web&sec_user_id='+sec_user_id+'&max_cursor='+this_time+'&count='+dcount+'&publish_video_strategy_type=2&version_code=160100&version_name=16.1.0'
    sess = requests.session()
    sess.get('https://www.douyin.com/user/'+sec_user_id, headers=headers)
    new_url = get_res(douyin_url)
    res = sess.get(new_url,headers=headers)
    print(res.text)
    # print(json.dumps(res['aweme_list']))

def get_video_comment(aweme_id,cursor):
    t = time.time()
    this_time = str(round(t * 1000))
    douyin_url = 'https://www.douyin.com/aweme/v1/web/comment/list/?device_platform=webapp&aid=6383&channel=channel_pc_web&aweme_id='+aweme_id+'&version_code=160100&version_name=16.1.0&cursor='+cursor+'&count=50'
    sess = requests.session()
    new_url = get_res(douyin_url)
    res = sess.get(new_url,headers=headers).json()
    print(json.dumps(res['comments']))

if sys.argv[1] == 'user_video':
    get_user_video(sys.argv[2],sys.argv[3])
elif sys.argv[1] == 'user_info':
    get_user_info(sys.argv[2])
elif sys.argv[1] == 'video_comment':
    get_video_comment(sys.argv[2],sys.argv[3])
else:
    print("负数")

# print(get_user_video(sec_user_id))

# 用户信息
# sec_user_id='MS4wLjABAAAAg-FNvWWqPDHzDcC7zfumsDrlPzyYn9z0co5OUmXSgcM'
#get_user_info(sec_user_id)

# 用户视频
#douyin_url = 'https://www.douyin.com/aweme/v1/web/aweme/post/?device_platform=webapp&aid=6383&channel=channel_pc_web&sec_user_id=MS4wLjABAAAAYsGlaAlC63EwxXFJX-DkIdIcMNr5PxZy3h3PvIGobBFp8S11I-0xQMQ2i-Z182vk&max_cursor=1615597200000&count=10&publish_video_strategy_type=2&version_code=160100&version_name=16.1.0'

# 评论列表
#douyin_url = 'https://www.douyin.com/aweme/v1/web/comment/list/?device_platform=webapp&aid=6383&channel=channel_pc_web&aweme_id=6974719385269243143&version_code=160100&version_name=16.1.0&cursor=0&count=20'

# 搜索用户
#douyin_url = 'https://www.douyin.com/aweme/v1/web/discover/search/?device_platform=webapp&aid=6383&channel=channel_pc_web&search_channel=aweme_user_web&keyword=s&search_source=normal_search&query_correct_type=1&is_filter_search=0&offset=0&count=20&version_code=160100&version_name=16.1.0&cookie_enabled=true&screen_width=1536&screen_height=864&browser_language=zh-CN&browser_platform=Win32&browser_name=Mozilla&browser_version=5.0+(Windows+NT+6.3%3B+Win64%3B+x64)+AppleWebKit%2F537.36+(KHTML,+like+Gecko)+Chrome%2F91.0.4472.114+Safari%2F537.36&browser_online=true'

# 首页推荐信息流
#douyin_url = 'https://www.douyin.com/aweme/v1/web/channel/feed/?device_platform=webapp&aid=6383&channel=channel_pc_web&tag_id=&count=10&version_code=160100&version_name=16.1.0&cookie_enabled=true&screen_width=1920&screen_height=1080&browser_language=zh-CN&browser_platform=Win32&browser_name=Mozilla&browser_version=5.0+(Windows+NT+10.0%3B+Win64%3B+x64)+AppleWebKit%2F537.36+(KHTML,+like+Gecko)+Chrome%2F91.0.4472.124+Safari%2F537.36&browser_online=true'

# 推荐视频
# douyin_url = 'https://www.douyin.com/aweme/v1/web/aweme/post/?device_platform=webapp&aid=6383&channel=channel_pc_web&sec_user_id=MS4wLjABAAAAYsGlaAlC63EwxXFJX-DkIdIcMNr5PxZy3h3PvIGobBFp8S11I-0xQMQ2i-Z182vk&max_cursor=1615597200000&count=10&publish_video_strategy_type=2&version_code=160100&version_name=16.1.0'
# sess = requests.session()
# new_url = get_res(douyin_url)
# response = sess.get(new_url,headers=headers)
# print(response.text)

