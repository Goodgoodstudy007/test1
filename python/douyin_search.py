# -*- coding: utf-8 -*-
import os,json,requests
from selenium import webdriver
PRO_DIR = os.path.dirname(os.path.abspath(__file__))
sign_js = os.path.join(PRO_DIR,'acrawler.js')
sign_html = os.path.join(PRO_DIR, 'douyin_sign_search.html')

# TODO 分享页面 UID 和 SEC_UID
keyword = '77777777777ge' 
# sec_uid = 'MS4wLjABAAAACV5Em110SiusElwKlIpUd-MRSi8rBYyg0NfpPrqZmykHY8wLPQ8O4pv3wPL6A-oz'

# TODO 修改 executable_path
executable_path = r'/www/wwwroot/xunpang/python/chromedriver'
ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.104 Safari/537.36'

headers = {
        'authority': 'www.douyin.com',
        'pragma': 'no-cache',
        'cache-control': 'no-cache',
        'sec-ch-ua': '" Not;A Brand";v="99", "Google Chrome";v="91", "Chromium";v="91"',
        'accept': 'application/json, text/plain, */*',
        'dnt': '1',
        'withcredentials': 'true',
        'sec-ch-ua-mobile': '?0',
        'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36',
        'sec-fetch-site': 'same-origin',
        'sec-fetch-mode': 'cors',
        'sec-fetch-dest': 'empty',
        'referer': 'https://www.douyin.com/search/%E5%AD%A6%E4%B9%A0%E5%BC%BA%E5%9B%BD?aid=41c7831d-222a-46f1-bb48-54551c612763&publish_time=0&sort_type=0&source=normal_search&type=video',
        #'referer': 'https://www.douyin.com/user/MS4wLjABAAAAYsGlaAlC63EwxXFJX-DkIdIcMNr5PxZy3h3PvIGobBFp8S11I-0xQMQ2i-Z182vk',
        'accept-language': 'zh-CN,zh;q=0.9',
}

s1 = """
    <!DOCTYPE html>
    <html style="font-size: 50px;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  <title>抖音_signature破解</title>
    </head>
    <body></body>

    <script type="text/javascript">
    """
s2 = """
    </script>
    </html>
    """

def driver_sig():
    option = webdriver.ChromeOptions()
    option.add_argument('start-maximized')
    option.add_argument('--disable-dev-shm-usage')
    option.add_argument('--disable-extensions')
    option.add_argument('--disable-gpu')
    option.add_argument('--no-sandbox')
    option.add_argument('headless')
    option.add_argument('disable-infobars')
    option.add_argument('--user-agent={}'.format(ua))
    # driver = webdriver.Chrome(chrome_options=option, executable_path=executable_path)
    driver = webdriver.Chrome(executable_path=executable_path, chrome_options=option)
    driver.execute_cdp_cmd("Page.addScriptToEvaluateOnNewDocument", {
        "source": """
            Object.defineProperty(navigator, 'webdriver', {
              get: () => undefined
            })
        """})
    driver.get('file:///' + PRO_DIR + '/douyin_sign_search.html')
    sig = driver.title
    driver.quit()
    return sig

with open(sign_js,'r',encoding='utf-8') as f:
    s_doc = f.read()
# s_doc = s_doc.replace('keyword : ""','keyword : "{}"'.format(keyword))
# s_doc = s_doc.replace("userAgent: ''","userAgent: '{}'".format(ua))
with open(sign_html, 'w', encoding='utf-8') as fw:
    fw.write(s1 + s_doc + s2)
sig = driver_sig()
print(sig)
detail_url = f'https://www.douyin.com/aweme/v1/web/comment/list/?device_platform=webapp&aid=6383&channel=channel_pc_web&aweme_id=6974719385269243143&version_code=160100&version_name=16.1.0&cursor=0&count=20&_signature={sig}'
data = requests.get(detail_url,headers=headers).text
# data = json.loads(requests.get(detail_url,headers=headers).text)
print(data)
