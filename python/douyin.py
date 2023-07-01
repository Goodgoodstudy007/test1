# -*- coding: utf-8 -*-
import os,json,requests
from selenium import webdriver
PRO_DIR = os.path.dirname(os.path.abspath(__file__))
sign_js = os.path.join(PRO_DIR,'signature2.js')
sign_html = os.path.join(PRO_DIR, 'douyin_sign.html')

headers = {
        'origin': 'https://www.douyin.com',
        'accept': 'application/json, text/plain, */*',
        'accept-encoding': 'gzip, deflate, br',
        'accept-language': 'zh-CN,zh;q=0.9',
        'cookie' : 'ttwid=1%7CDXReT3qWh0MoQFsbhjcANawiCcKyVqlkM_CNytE9y5M%7C1627294726%7Cb79935bbf707050bc6c5e17f24ac33cc24ddd79d192d20311f0baeca1eb0cfe2; MONITOR_WEB_ID=d460f4f4-72e1-4027-b07a-9fe0fbc8859d',
        'referer': 'https://www.douyin.com/user/MS4wLjABAAAAAhCuW0qkQJRCrp45HfLw-Hpp8nsf9qYOf96RffY5FDo',
        'user-agent': 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        'withcredentials': 'true',
        # 'referer': 'https://www.douyin.com/search/%E5%AD%A6%E4%B9%A0%E5%BC%BA%E5%9B%BD?aid=41c7831d-222a-46f1-bb48-54551c612763&publish_time=0&sort_type=0&source=normal_search&type=video',
}

# TODO 修改 executable_path
executable_path = r'/www/wwwroot/xunpang/python/chromedriver'
ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.104 Safari/537.36'

s1 = """
    <!DOCTYPE html>
    <html style="font-size: 50px;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  <title>_signature</title>
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
    driver.get('file:///' + PRO_DIR + '/douyin_sign.html')
    sig = driver.title
    driver.quit()
    return sig

with open(sign_js,'r',encoding='utf-8') as f:
    s_doc = f.read()
with open(sign_html, 'w', encoding='utf-8') as fw:
    fw.write(s1 + s_doc + s2)
sig = driver_sig()
print(sig)
detail_url = f'https://www.douyin.com/aweme/v1/web/user/profile/other/?device_platform=webapp&aid=6383&channel=channel_pc_web&publish_video_strategy_type=2&source=channel_pc_web&sec_user_id=MS4wLjABAAAAAhCuW0qkQJRCrp45HfLw-Hpp8nsf9qYOf96RffY5FDo&version_code=160100&version_name=16.1.0&cookie_enabled=true&screen_width=1920&screen_height=1080&browser_language=zh-CN&browser_platform=Win32&browser_name=Mozilla&browser_version=5.0+%28Windows+NT+10.0%3B+WOW64%29+AppleWebKit%2F537.36+%28KHTML%2C+like+Gecko%29+Chrome%2F69.0.3497.100+Safari%2F537.36&browser_online=true&_signature={sig}'
data = requests.get(detail_url,headers=headers).text
# data = json.loads(requests.get(detail_url,headers=headers).text)
print(data)
