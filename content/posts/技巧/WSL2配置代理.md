+++
author = "cvooc"
title = "WSL2配置代理"
date = "2020-11-22 15:30:17"
description = "WSL2配置代理"
tags = [
    "技巧",
    "windows",
]
+++

因为 WSL2 是真正的虚拟机,所以不会于 WIN10 共享网络,故代理配置直接配置 127.0.0.1 或 localhost 是不行的,此时需要在 cmd 中执行 ipconfig 命令查看本地 IP,一般为 192.168.0.\*\*\*,之后修改 WSL 的.bashrc 文件配置即可.

```sh
# WSL2使用的是虚拟机技术和WSL第一版本不一样，和宿主windows不在同一个网络内
# 假设你的宿主windows代理端口是1080, 全面设置WSL内的代理
export HTTP_PROXY=192.168.0.***:10809
export http_proxy=192.168.0.***:10809
export HTTPS_PROXY=192.168.0.***:10809
export https_proxy=192.168.0.***:10809
```
