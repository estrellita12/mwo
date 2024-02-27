from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
import time
import sys
import os.path
import json

def isExistFile(filepath):
    if os.path.isfile(filepath):
        return True
    else:
        return False

def getChrome(url):
    options = webdriver.ChromeOptions()     # 브라우저 창 안 띄우겠다
    options.add_argument('headless')        # 보통의 FHD화면을 가정
    options.add_argument('window-size=1920x1080')   # gpu를 사용하지 않도록 설정
    options.add_argument("disable-gpu")             # headless탐지 방지를 위해 UA를 임의로 설정
    options.add_argument("user-agent=Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6)")
    #path='./chromedriver118/chromedriver'
    path='/home/mwo/public_html/selenium/chromedriver118/chromedriver'
    driver = webdriver.Chrome(path, options=options)
    driver.get(url)
    return driver

def signin(username,userpasswd):
    driver.find_element(By.NAME,'email').send_keys(username)
    driver.find_element(By.NAME,'password').send_keys(userpasswd)
    time.sleep(1)
    driver.find_element(By.CSS_SELECTOR,'[type=submit]').click()
    time.sleep(2)

def uploadVideo(filepath):
    driver.find_element(By.CLASS_NAME,'MuiButton-containedPrimary').click()
    time.sleep(2)
    driver.find_element(By.CSS_SELECTOR,'[type=file]').send_keys(filepath)
    time.sleep(30)
    driver.refresh()
    time.sleep(2)

def main():
    try:
        if len(sys.argv) <= 1:
            print("Argument does not exist.")
            return

        filepath = sys.argv[1]
        if not isExistFile(filepath):
            print("The file does not exist.")
            return

        pathlist = sys.argv[1].split("/")
        filename = pathlist[-1].split(".")[0]
    
        global driver

        # 사이트 접속
        url = "https://charlla.io/account/signin"
        driver = getChrome(url)
        
        # 로그인
        username = "dreego231@gmail.com"
        userpasswd = "major2023!!"
        signin(username,userpasswd)
        
        '''
        # 첫번째 파일 확인
        name = driver.find_element(By.CSS_SELECTOR,'tbody.MuiTableBody-root > tr.MuiTableRow-root > td.MuiTableCell-root div.MuiTypography-body1').text
        print(name.encode("utf-8"))
        '''

        # 동영상 업로드
        uploadVideo(filepath)

        # 업로드 확인
        flag = False
        for i in range(5):
            name = driver.find_element(By.CSS_SELECTOR,'tbody.MuiTableBody-root > tr.MuiTableRow-root > td.MuiTableCell-root div.MuiTypography-body1').text
            if filename == name:
                flag = True
                break;
            else:
                driver.refresh()
                time.sleep(2)
        if not flag:
            print("Equal 5th Try, File upload failed.")
            return 
 
        flag = False
        for i in range(5):
            try:
                driver.find_element(By.CSS_SELECTOR,'tbody.MuiTableBody-root > tr.MuiTableRow-root > td.MuiTableCell-root div.MuiTypography-body1').click()
                flag = True
                break;
            except Exception as e:
                driver.refresh()
                time.sleep(2)
        if not flag:
            print("Click 5th Try, File upload failed.")
            return 
        
        # 등록 URL 리턴
        time.sleep(5)
        frame = driver.find_element(By.TAG_NAME,"iframe")
        src = frame.get_attribute("src")
        print(1)
        print(src.split("?")[0])
    except Exception as e:
        print(e)

main()
print("end")
