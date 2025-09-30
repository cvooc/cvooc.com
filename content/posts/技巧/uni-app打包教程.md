+++
author = "cvooc"
title = "uni-app打包教程"
date = "2019-10-22 13:59:32"
description = "uni-app打包教程"
tags = [
    "技巧",
    "uni-app"
]
+++

# uni-app 打包教程

## 请按照步骤操作完成打包

1. 访问 https://www.dcloud.io/hbuilderx.html 下载 hbuilderx
2. 建议下载 App 开发版,或您可以下载标准版然后在打包过程中根据提示在(工具\插件安装)(这些插件可以随意安装删除,请放心)中安装所需要的插件
3. 解压即可直接使用
4. 根据提示注册 dcloud 账号
5. 点击屏幕左上角(文件\新建\项目),并选择 uni-app
   ![创建uni-app项目1.png](/static/img/uni-app打包教程/3560462644.png)
6. 创建成功之后,可在项目根目录 manifest.json 文件,查看 appid,若为空请点击右侧 重新获取 按钮
   ![查看appid.png](/static/img/uni-app打包教程/4228333237.png)
7. 请记下 appid, 第 5 步和第 6 步操作只需要进行一次即可,以后不在需要
8. 将 appid 填写到本项目源码下的 manifest.json 中第 3 行的 appid:"" 处即可
9. 将第 5\6\7 步中创建的项目删除
10. 再次点击(文件\导入\从本地目录导入)或(文件\打开目录),二者操作都可行
11. 导入成功后点击(发行\原生 App-云打包),此处若有上架 app 商店需求,请找专人生成证书并在此处导入,之后点击打包,等待打包完成即可
    ![云打包.png](/static/img/uni-app打包教程/1232654054.png)
12. 等待打包完成后,点击控制台的链接下载打包后的 apk 即可
    ![打包完成.png](/static/img/uni-app打包教程/1851187033.png)

### 后续

1. 如有二开需求,请访问 https://uniapp.dcloud.io/ 了解学习框架
