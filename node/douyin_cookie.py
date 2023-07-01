# -*- coding: utf-8 -*-
# @Time    : 2021/9/15 13:11
# @Author  : lx
# @IDE ：PyCharm

import os
import cv2
import requests
import numpy as np
from selenium import webdriver
from urllib.parse import urlparse
from selenium.webdriver import ActionChains
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.keys import Keys
import time
import random
import bezier

class Slide(object):

    def __init__(self, gap, bg, gap_size=None, bg_size=None, out=None):
        """
        :param bg: 带缺口的图片链接或者url
        :param gap: 缺口图片链接或者url
        """
        self.img_dir = os.path.join(os.getcwd(), 'img')
        if not os.path.exists(self.img_dir):
            os.makedirs(self.img_dir)

        bg_resize = bg_size if bg_size else (340, 212)
        gap_size = gap_size if gap_size else (68, 68)
        self.bg = self.check_is_img_path(bg, 'bg', resize=bg_resize)
        self.gap = self.check_is_img_path(gap, 'gap', resize=gap_size)
        self.out = out if out else os.path.join(self.img_dir, 'out.jpg')

    @staticmethod
    def check_is_img_path(img, img_type, resize):
        if img.startswith('http'):
            headers = {
                "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;"
                          "q=0.8,application/signed-exchange;v=b3;q=0.9",
                "Accept-Encoding": "gzip, deflate, br",
                "Accept-Language": "zh-CN,zh;q=0.9,en-GB;q=0.8,en;q=0.7,ja;q=0.6",
                "Cache-Control": "max-age=0",
                "Connection": "keep-alive",
                "Host": urlparse(img).hostname,
                "Upgrade-Insecure-Requests": "1",
                "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) "
                              "Chrome/91.0.4472.164 Safari/537.36",
            }
            img_res = requests.get(img, headers=headers)
            if img_res.status_code == 200:
                img_path = f'./img/{img_type}.jpg'
                image = np.asarray(bytearray(img_res.content), dtype="uint8")
                image = cv2.imdecode(image, cv2.IMREAD_COLOR)
                if resize:
                    image = cv2.resize(image, dsize=resize)
                cv2.imwrite(img_path, image)
                return img_path
            else:
                raise Exception(f"保存{img_type}图片失败")
        else:
            return img

    @staticmethod
    def clear_white(img):
        """清除图片的空白区域，这里主要清除滑块的空白"""
        img = cv2.imread(img)
        rows, cols, channel = img.shape
        min_x = 255
        min_y = 255
        max_x = 0
        max_y = 0
        for x in range(1, rows):
            for y in range(1, cols):
                t = set(img[x, y])
                if len(t) >= 2:
                    if x <= min_x:
                        min_x = x
                    elif x >= max_x:
                        max_x = x

                    if y <= min_y:
                        min_y = y
                    elif y >= max_y:
                        max_y = y
        img1 = img[min_x:max_x, min_y: max_y]
        return img1

    def template_match(self, tpl, target):
        th, tw = tpl.shape[:2]
        result = cv2.matchTemplate(target, tpl, cv2.TM_CCOEFF_NORMED)
        # 寻找矩阵(一维数组当作向量,用Mat定义) 中最小值和最大值的位置
        min_val, max_val, min_loc, max_loc = cv2.minMaxLoc(result)
        tl = max_loc
        br = (tl[0] + tw, tl[1] + th)
        # 绘制矩形边框，将匹配区域标注出来
        # target：目标图像
        # tl：矩形定点
        # br：矩形的宽高
        # (0,0,255)：矩形边框颜色
        # 1：矩形边框大小
        cv2.rectangle(target, tl, br, (0, 0, 255), 2)
        cv2.imwrite(self.out, target)
        return tl[0]

    @staticmethod
    def image_edge_detection(img):
        edges = cv2.Canny(img, 100, 200)
        return edges

    def discern(self):
        img1 = self.clear_white(self.gap)
        img1 = cv2.cvtColor(img1, cv2.COLOR_RGB2GRAY)
        slide = self.image_edge_detection(img1)

        back = cv2.imread(self.bg, 0)
        back = self.image_edge_detection(back)

        slide_pic = cv2.cvtColor(slide, cv2.COLOR_GRAY2RGB)
        back_pic = cv2.cvtColor(back, cv2.COLOR_GRAY2RGB)
        x = self.template_match(slide_pic, back_pic)
        # 输出横坐标, 即 滑块在图片上的位置
        return x

def get_tracks888(distance, rate=0.6, t=0.2, v=0):
    tracks = []
    # 加速减速的临界值
    mid = rate * distance
    # 当前位移
    s = 0
    # 循环
    while s < distance:
        # 初始速度
        v0 = v
        if s < mid:
            a = 20
        else:
            a = -3
        # 计算当前t时间段走的距离
        s0 = v0 * t + 0.5 * a * t * t
        # 计算当前速度
        v = v0 + a * t
        # 四舍五入距离，因为像素没有小数
        tracks.append(round(s0))
        # 计算当前距离
        s += s0
    return tracks

def get_tracks777(distance, num_points=50):
    # 创建三次贝塞尔曲线的控制点
    nodes = np.asfortranarray([
        [0.0, distance * 0.4, distance * 0.6, distance],
        [0.0, distance * random.uniform(0.2, 0.3), distance * random.uniform(0.7, 0.8), 0.0],
    ])

    # 创建贝塞尔曲线
    curve = bezier.Curve(nodes, degree=3)

    # 生成滑动轨迹
    s_vals = np.linspace(0.0, 1.0, num_points)
    tracks = curve.evaluate_multi(s_vals)

    # 计算轨迹的累计距离
    tracks_diff = np.diff(tracks, axis=1)
    track_distances = [0]
    for i in range(1, tracks.shape[1]):
        track_distances.append(round(np.sqrt(tracks_diff[0, i-1]**2 + tracks_diff[1, i-1]**2)))

    return track_distances

def get_tracks(distance, num_points=11):
    nodes = np.asfortranarray([
        [0.0, distance * 0.4, distance * 0.6, distance],
        [0.0, distance * random.uniform(0.2, 0.3), distance * random.uniform(0.7, 0.8), 0.0],
    ])

    curve = bezier.Curve(nodes, degree=3)
    s_vals = np.linspace(0.0, 1.0, num_points)
    tracks = curve.evaluate_multi(s_vals)

    tracks_diff = np.diff(tracks, axis=1)
    track_distances = [0]
    for i in range(1, tracks.shape[1]):
        track_distances.append(round(np.sqrt(tracks_diff[0, i-1]**2 + tracks_diff[1, i-1]**2)))

    return track_distances        

def get_cookies():
    check_url = 'https://www.douyin.com'
    driver_path=r'/usr/local/chdriver/chromedriver'
    option = webdriver.ChromeOptions()
    option.add_argument('--headless')
    option.add_argument('--disable-gpu')  # 不需要GPU加速
    option.add_argument('--no-sandbox')   # 无沙箱
    option.add_experimental_option('useAutomationExtension', False)
    option.add_argument("disable-blink-features")
    option.add_argument("disable-blink-features=AutomationControlled")
    option.add_argument('--window-size=1920x1080')
    proxy = "47.122.47.69:6003"
    option.add_argument(f'--proxy-server={proxy}')
    option.add_argument("--remote-debugging-port=9333")
    option.add_argument("--remote-debugging-address=0.0.0.0")
    # driver = webdriver.Chrome(options=option,executable_path=driver_path)
    service = Service(executable_path=driver_path)
    driver = webdriver.Chrome(options=option, service=service)
    driver.get(check_url)
    time.sleep(5)
    for ck in driver.get_cookies():
        with open('sss.txt', 'a') as f:
            f.write(f'{ck}\n')
    with open('sss.txt', 'a') as f:
        f.write(f'下一个。。。下一个。。。。下一个。。。下一个。。。下一个。。。\n')
    # driver.save_screenshot("screenshot2.png")
    try:
        counter = 1
        while 1:
            try:
                p1 = driver.find_element(By.ID,'captcha-verify-image').get_attribute('src')
                p2 = driver.find_element(By.XPATH,'//*[@id="captcha_container"]/div/div[2]/img[2]').get_attribute('src')
                slide_app = Slide(gap=p2,bg=p1)
                distance = slide_app.discern()
                # print(f"相对距离: {distance}")
                slider = driver.find_element(By.XPATH,'//*[@id="secsdk-captcha-drag-wrapper"]/div[2]')
                # print("验证中...")
                ActionChains(driver).click_and_hold(slider).perform()
                _tracks = get_tracks(distance)
                new_1 = _tracks[-1]-(sum(_tracks) - distance)
                _tracks.pop()
                _tracks.append(new_1)
                # print(_tracks)
                slide_start_time = time.time()
                for index, mouse_x in enumerate(_tracks):
                    mouse_y = random.randint(-3, 3)  # 随机上下波动
                    ActionChains(driver).move_by_offset(mouse_x,mouse_y).perform()
                    if index < len(_tracks) - 1:
                        time.sleep(random.uniform(0.01, 0.03))  # 随机等待时间，使滑动速度变得不那么规律
                    # driver.save_screenshot(str(counter) + "screenshot" + str(index) +".png")
                slide_end_time = time.time()
                slide_duration = slide_end_time - slide_start_time
                # print(f"滑动操作所用时间: {slide_duration} 秒")    
                ActionChains(driver).move_by_offset(2,0).perform()    
                ActionChains(driver).release().perform()                
                time.sleep(3)
                counter += 1
            except Exception as d:
                # print(f"发生d异常: {d}")
                break
    except Exception as e:
        print(f"发生e异常: {e}")
    cks = ''
    for ck in driver.get_cookies():
        with open('sss.txt', 'a') as f:
            f.write(f'{ck}\n')
        k = ck['name']
        v = ck['value']
        cks +=f'{k}={v}; '
    with open('sss.txt', 'a') as f:
        f.write(f'下二个。。。下二个。。。。下二个。。。下二个。。。下二个。。。\n')
    cks = cks.replace(' =douyin.com; ',' ')

    time.sleep(2)

    try:
        close_element = driver.find_element(By.CLASS_NAME, 'dy-account-close')
        close_element.click()
    except NoSuchElementException:
        print("Close element not found")

    time.sleep(2)

    # 定位body元素
    body_element = driver.find_element(By.TAG_NAME, 'body')

    # 使用ActionChains模拟按下向下箭头
    actions = ActionChains(driver)
    actions.send_keys(Keys.ARROW_DOWN)
    actions.perform()
    time.sleep(2)

    cks = ''
    for ck in driver.get_cookies():
        with open('sss.txt', 'a') as f:
            f.write(f'{ck}\n')
        k = ck['name']
        v = ck['value']
        cks +=f'{k}={v}; '
    with open('sss.txt', 'a') as f:
        f.write(f'下二个。。。下二个。。。。下二个。。。下二个。。。下二个。。。\n')
    cks = cks.replace(' =douyin.com; ',' ')

    time.sleep(3)
    driver.close()
    driver.quit()
    return cks

print(get_cookies())