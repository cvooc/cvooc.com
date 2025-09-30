+++
author = "cvooc"
title = "shadowsocks使用obfs混淆插件教程"
date = "2020-02-10 17:32:10"
description = "shadowsocks使用obfs混淆插件教程"
tags = [
    "技巧",
    "vpn",
]
+++

## **客户端下载**

Just My Socks 在电脑 windows7,10 下需要下客户端 shadowsocks 才能使用.

-   [Just My Socks 购买链接 ](https://justmysocks.net/members/aff.php?aff=10673)

-   shadowsocks 官方下载:https://github.com/shadowsocks/shadowsocks-windows/releases
-   OBFS 插件官方下载地址:https://github.com/shadowsocks/simple-obfs/releases
-   justmysocks 提供的下载地址:https://www.justmysocks2.net/members/dist/windows-shadowsocks-4.1.6.zip
-   OBFS 插件下载地址:https://www.justmysocks2.net/members/dist/obfs-local.zip

## **安装**

先把 obfs 插件压缩包和 shadowsocks 压缩包分别解压,把文件放在一个文件夹下,shadowsocks 客户端不需要安装,直接点击 shadowsocks.exe 就好.

![1.png](. /static/img/shadowsocks 使用 obfs 混淆插件教程/1.png)

点击打开 shadowsocks.exe 在弹出的对话框里填写 justmysocks 里的账号信息.

![2.png](/static/img/shadowsocks使用obfs混淆插件教程/2.png)
填入下面账号信息.

![3.png](/static/img/shadowsocks使用obfs混淆插件教程/3.png)

启用 shadowsocks 代理.鼠标右键点击那个小火箭,弹出图示对话框选择”系统代理”选择”全局代理”即可(PAC 模式则是仅在访问特定网站时使用代理,日常使用建议使用 PAC 模式,你可以在 PAC 中编辑需要使用代理的网站).

![4.png](/static/img/shadowsocks使用obfs混淆插件教程/4.png)
最后在浏览器地址栏看看是否可以访问 google.com,twitter.com

![5.png](/static/img/shadowsocks使用obfs混淆插件教程/5.png)

有个坑必须说一下,如果不能访问可以查看下,打开 chrome 浏览器下的”设置”下的”高级”下的”系统”下的”打开您的代理设置”选择”局域网设置”去掉”代理服务器”下面选项的勾,并勾选”自动检测设置”,其他的浏览器类似.

![6.png](/static/img/shadowsocks使用obfs混淆插件教程/6.png)

如果你有耐心看到这一步说明你可以愉快滴 google,祝你翻墙愉快,哈哈哈哈哈
