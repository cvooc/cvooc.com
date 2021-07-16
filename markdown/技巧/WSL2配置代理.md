最后更新时间: 2020年11月22日 15:30:17

因为WSL2是真正的虚拟机,所以不会于WIN10共享网络,故代理配置直接配置127.0.0.1或localhost是不行的,此时需要在cmd中执行ipconfig命令查看本地IP,一般为192.168.0.***,之后修改WSL的.bashrc文件配置即可.

```sh
# WSL2使用的是虚拟机技术和WSL第一版本不一样，和宿主windows不在同一个网络内
# 假设你的宿主windows代理端口是1080, 全面设置WSL内的代理
export HTTP_PROXY=192.168.0.***:10809
export http_proxy=192.168.0.***:10809
export HTTPS_PROXY=192.168.0.***:10809
export https_proxy=192.168.0.***:10809
```

