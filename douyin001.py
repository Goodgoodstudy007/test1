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
import sys

def click_expand_more():
    zhankai_elements = browser.find_elements(By.CSS_SELECTOR, 'button .SIAdR40d > span')
    for index, element in enumerate(zhankai_elements):
        actions = ActionChains(browser)
        actions.move_to_element(element).click().perform()
        sleep(1)

    max_clicks = 10
    click_count = 0
    while click_count < max_clicks:
        expand_more_elements = browser.find_elements(By.XPATH, '//div[@class="iRduembj"]/span[contains(text(), "展开更多")]')

        if len(expand_more_elements) > 0:
            for expand_more_element in expand_more_elements:
                expand_more_element.click()
                sleep(1)
            click_count += 1
        else:
            break
    print(f"Clicked '展开更多' {click_count} times.")


file_path = 'my005.txt'
if os.path.exists(file_path):
    os.remove(file_path)

chrome_options = Options()
chrome_options.add_argument('--ignore-certificate-errors')
chrome_options.add_argument('--ignore-urlfetcher-cert-requests')
chrome_options.add_argument('--ignore-ssl-errors')
chrome_options.add_argument('--no-sandbox')
chrome_options.add_argument("disable-blink-features")
chrome_options.add_argument("disable-blink-features=AutomationControlled")
# chrome_options.add_argument('--disable-gpu')
chrome_options.add_argument('--headless')
chrome_options.add_argument('--allow-insecure-localhost')
chrome_options.add_argument('--allow-running-insecure-content')
user_agent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36"
chrome_options.add_argument(f'user-agent={user_agent}')
chrome_options.add_argument("window-size=1920x1080")

# 初始化webdriver
s = Service()
browser = webdriver.Chrome(service=s, options=chrome_options)

# 访问目标网站
browser.get('https://www.douyin.com/')

# 让网页加载完成
sleep(10)

try:
    close_element = browser.find_element(By.CLASS_NAME, 'dy-account-close')
    close_element.click()
except NoSuchElementException:
    print("Close element not found")

sleep(2)

# 定位body元素
body_element = browser.find_element(By.TAG_NAME, 'body')

# 使用ActionChains模拟按下向下箭头
actions = ActionChains(browser)
actions.send_keys(Keys.ARROW_DOWN)
actions.perform()
sleep(5)

# with open("source.html", "w", encoding="utf-8") as f:
#     f.write(browser.page_source)

# sys.exit("Program interrupted after saving the source HTML.")

# 定位输入框
input_element = browser.find_element(By.CLASS_NAME, 'igFQqPKs')
# 输入字符串
input_element.send_keys('mcn机构')

# 定位搜索按钮
search_button = browser.find_element(By.XPATH, '//button[@data-e2e="searchbar-button"]')

# 等待搜索按钮可点击
WebDriverWait(browser, 10).until(EC.element_to_be_clickable((By.XPATH, '//button[@data-e2e="searchbar-button"]')))

# 保存当前窗口句柄
current_window = browser.current_window_handle

# 点击搜索按钮
search_button.click()
sleep(5)

# 获取所有窗口句柄
all_windows = browser.window_handles

# 关闭原始窗口
browser.switch_to.window(current_window)
browser.close()

# 切换到新窗口
for window_handle in all_windows:
    if window_handle != current_window:
        browser.switch_to.window(window_handle)
        break

sleep(5)

# 等待目标元素出现
wait = WebDriverWait(browser, 10)

# with open("source.html", "w", encoding="utf-8") as f:
#     f.write(browser.page_source)
# sys.exit("Program interrupted after saving the source HTML.")

target_element = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, '.tzVl3l7w')))

# 点击目标元素
actions = ActionChains(browser)
actions.move_to_element(target_element).click().perform()

sleep(3)


continue_reading_elements = browser.find_elements(By.XPATH, '//div[@class="related-video-card-login-guide__footer"]/div[contains(text(), "继续看评论")]')

if len(continue_reading_elements) > 0:
    continue_reading_element = continue_reading_elements[0]
    continue_reading_element.click()
else:
    print("Element not found, proceeding to the next step.")



# 使用ActionChains模拟按下向下箭头
actions = ActionChains(browser)
actions.send_keys(Keys.ARROW_DOWN)
actions.perform()
sleep(1)  # 等待页面滚动


# 定位评论区的一个元素
comment_container = browser.find_element(By.CSS_SELECTOR, '.comment-mainContent')

consecutive_no_scroll_change = 0
max_no_scroll_change = 2

scroll_down_count = 50  # 根据需要设置滚动次数
scroll_down_pixels = 500  # 每次滚动的像素数量
for i in range(scroll_down_count):
    previous_scroll_top = browser.execute_script("return arguments[0].scrollTop;", comment_container)
    browser.execute_script(f"arguments[0].scrollTop += {scroll_down_pixels};", comment_container)
    sleep(1)  # 等待页面滚动
    current_scroll_top = browser.execute_script("return arguments[0].scrollTop;", comment_container)
    if previous_scroll_top == current_scroll_top:
        consecutive_no_scroll_change += 1
    else:
        consecutive_no_scroll_change = 0

    if consecutive_no_scroll_change >= max_no_scroll_change:
        break

click_expand_more()

comment_yuansu_all = browser.find_elements(By.CSS_SELECTOR,'.VD5Aa1A1 .Nu66P_ba > span > span > span > span')

with open(file_path, 'w', encoding='utf-8') as file:
    for element in comment_yuansu_all:
        file.write(element.text + '\n')  # 在文件中为每个元素添加换行符

sleep(200)



