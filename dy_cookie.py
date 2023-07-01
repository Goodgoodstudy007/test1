from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.options import Options
from selenium.common.exceptions import NoSuchElementException
from time import sleep
import os


file_path = 'my003.txt'
if os.path.exists(file_path):
    os.remove(file_path)

chrome_options = Options()
chrome_options.add_argument('--ignore-certificate-errors')
chrome_options.add_argument('--ignore-urlfetcher-cert-requests')
chrome_options.add_argument('--ignore-ssl-errors')
chrome_options.add_argument('--no-sandbox')
# chrome_options.add_argument('--disable-gpu')
chrome_options.add_argument('--headless')
chrome_options.add_argument('--allow-insecure-localhost')
chrome_options.add_argument('--allow-running-insecure-content')
user_agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36"
chrome_options.add_argument(f'user-agent={user_agent}')
chrome_options.add_argument("window-size=1920x1080")
chrome_options.add_argument('--start-maximized')
chrome_options.add_experimental_option('excludeSwitches', ['enable-automation'])
chrome_options.add_argument('--disable-blink-features=AutomationControlled')
chrome_options.add_argument("--remote-debugging-port=9333")
chrome_options.add_argument("--remote-debugging-address=0.0.0.0")
# proxy = "182.61.13.33:3138"
# chrome_options.add_argument(f'--proxy-server={proxy}')

# 初始化webdriver
chromedriver_path = '/usr/local/chdriver/chromedriver'
s = Service(executable_path=chromedriver_path)
browser = webdriver.Chrome(service=s, options=chrome_options)

# 访问目标网站
browser.get('https://www.douyin.com/')

# 让网页加载完成
sleep(3)

try:
    close_element = browser.find_element(By.CLASS_NAME, 'dy-account-close')
    close_element.click()
except NoSuchElementException:
    pass
    # print("Close element not found")

sleep(2)

# 定位body元素
body_element = browser.find_element(By.TAG_NAME, 'body')

# 使用ActionChains模拟按下向下箭头
actions = ActionChains(browser)
actions.send_keys(Keys.ARROW_DOWN)
actions.perform()
sleep(3)

cookies = browser.get_cookies()
cook = ''
# 将 cookies 保存到当前目录下的 002.txt 文件中
for cookie in cookies:
    cook = cookie['name'] + '=' + cookie['value'] + '; ' + cook
cook = cook.replace(' =douyin.com; ',' ')
cook = cook[:-2]

print(cook)




