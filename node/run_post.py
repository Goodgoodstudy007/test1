# -*- coding: utf-8 -*-
import os,json,requests
import sys
from selenium import webdriver
PRO_DIR = os.path.dirname(os.path.abspath(__file__))
sign_js = os.path.join(PRO_DIR,'signature_post.js')
sign_html = os.path.join(PRO_DIR, 'douyin_sign.html')

# TODO 分享页面 UID 和 SEC_UID
douyinShareId = '' 
# sec_uid = 'MS4wLjABAAAACV5Em110SiusElwKlIpUd-MRSi8rBYyg0NfpPrqZmykHY8wLPQ8O4pv3wPL6A-oz'
sec_uid = sys.argv[1]
count = sys.argv[2]
max_cursor = sys.argv[3]
proxy_ip = sys.argv[4]
proxy_port = sys.argv[5]

# TODO 修改 executable_path
executable_path = r'/usr/bin/chromedriver'
ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.104 Safari/537.36'

headers = {"user-agent": ua}
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
    driver = webdriver.Chrome(chrome_options=option, executable_path=executable_path)
    driver.execute_cdp_cmd("Page.addScriptToEvaluateOnNewDocument", {
        "source": """
            Object.defineProperty(navigator, 'webdriver', {
              get: () => undefined
            })
        """})
    driver.get('file:///' + PRO_DIR + '/douyin_sign.html')
    sig = driver.title
    driver.quit()
    return sig

with open(sign_js,'r',encoding='utf-8') as f:
    s_doc = f.read()
s_doc = s_doc.replace('nonce : ""','nonce : "{}"'.format(douyinShareId))
s_doc = s_doc.replace("userAgent: ''","userAgent: '{}'".format(ua))
with open(sign_html, 'w', encoding='utf-8') as fw:
    fw.write(s1 + s_doc + s2)
sig = driver_sig()
# print(sig)
detail_url = f'https://www.amemv.com/web/api/v2/aweme/post/?sec_uid={sec_uid}&count={count}&max_cursor={max_cursor}&aid=1128&_signature={sig}'
proxies = {
    "http"  : 'http://'+proxy_ip+':'+proxy_port,
}
if proxy_ip=="":
    proxies = {}
data = requests.get(detail_url,headers=headers,proxies=proxies).json()
# data = json.dumps(data)
print(json.dumps(data))

