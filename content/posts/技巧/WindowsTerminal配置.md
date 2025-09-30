最后更新时间: 2020年4月10日 17:32:10

# 安装

到**Microsoft Store**中下载安装即可.

# 配置

## 打开配置文件

点击Windows Terminal菜单栏上的**下拉箭头**,然后选择Settings:
![这里有一张图片](/static/img/WindowsTerminal配置/1.png)

## 选择默认启动的终端

默认的配置信息如下:

```
// To view the default settings, hold "alt" while clicking on the "Settings" button.
// For documentation on these settings, see: https://aka.ms/terminal-documentation
{
    "$schema": "https://aka.ms/terminal-profiles-schema",
    "defaultProfile": "{61c54bbd-c2c6-5271-96e7-009a87ff44bf}",
    "profiles":
    [
        {
            // Make changes here to the powershell.exe profile
            "guid": "{61c54bbd-c2c6-5271-96e7-009a87ff44bf}",
            "name": "Windows PowerShell",
            "hidden": false
        },
        {
            // Make changes here to the cmd.exe profile
            "guid": "{0caa0dad-35be-5f56-a8ff-afceeeaa6101}",
            "name": "cmd",
            "commandline": "cmd.exe",
            "hidden": false
        },
        {
            "guid": "{c6eaf9f4-32a7-5fdc-b5cf-066e8a4b1e40}",
            "hidden": false,
            "name": "Ubuntu-18.04",
            "source": "Windows.Terminal.Wsl"
        },
        {
            "guid": "{b453ae62-4e3d-5e58-b989-0a998ec441b8}",
            "hidden": false,
            "name": "Azure Cloud Shell",
            "source": "Windows.Terminal.Azure"
        }
    ],
    // Add custom color schemes to this array
    "schemes": [],
    // Add any keybinding overrides to this array.
    // To unbind a default keybinding, set the command to "unbound"
    "keybindings":
    [
        // etc.
    ]
}
```

复制



“defaultProfile”这个配置项就是打开Terminal时默认启动的程序,可以看到defaultProfile配置的guid是:

```
"defaultProfile": "{61c54bbd-c2c6-5271-96e7-009a87ff44bf}",
```

复制



这正是PowerShell的guid:

```
"profiles":
[
    {
        // Make changes here to the powershell.exe profile
        "guid": "{61c54bbd-c2c6-5271-96e7-009a87ff44bf}",
        "name": "Windows PowerShell",
        "hidden": false
    },
```

复制



所以如果想启动Terminal时打开的是cmd,只需要修改”defaultProfile”的值为cmd的guid即可:

```
0caa0dad-35be-5f56-a8ff-afceeeaa6101
//"defaultProfile": "{61c54bbd-c2c6-5271-96e7-009a87ff44bf}",
"defaultProfile": "{0caa0dad-35be-5f56-a8ff-afceeeaa6101}",
```

复制



## 配置快捷键

快捷键配置项为”keybindings”,我配置如下:

```
"keybindings":
[
    { "command": "copy", "keys": ["ctrl+shift+c"] },
    { "command": "paste", "keys": ["ctrl+shift+v"] },
    { "command": "closePane", "keys": ["ctrl+shift+w"] },
    { "command": "newTab", "keys": ["ctrl+shift+t"] }
    // etc.
]
```

复制



- 其中command为功能,例如复制(copy),粘贴(paster)
- keys为对应的快捷键

## 在鼠标右键打开

### 下载Terminal图标

图标地址:https://raw.githubusercontent.com/microsoft/terminal/master/res/terminal.ico
下载这个图标后,保存到指定位置,我的是(“F:\软件\图标\terminal.ico”)

### 添加到鼠标右键

####  1. (自动方法)批处理修改注册表

复制下面的批处理代码,然后保存到.bat文件中,以管理员身份运行即可:

```
@echo off
reg.exe add "HKEY_CLASSES_ROOT\Directory\Background\shell\wt" /f /ve /d "Windows Terminal here"
reg.exe add "HKEY_CLASSES_ROOT\Directory\Background\shell\wt" /f /v "Icon" /t REG_EXPAND_SZ /d "F:\软件\图标\terminal.ico"
reg.exe add "HKEY_CLASSES_ROOT\Directory\Background\shell\wt\command" /f /ve /t REG_EXPAND_SZ /d "\"%%LOCALAPPDATA%%\Microsoft\WindowsApps\wt.exe\""
pause
```

复制



####  2.(手动方法) 手动修改注册表

按下Win+R快捷键打开运行,然后输入`regedit`打开**注册表编辑器**,然后在地址栏中输入:

```
HKEY_CLASSES_ROOT\Directory\Background\shell
```

复制



新建**项**:`wt`
然后**点击**wt,**双击**右边的**默认**,在里面输入鼠标右键选项的名称:`Windows Terminal here`
然后右键wt,选择新建字符串,名为为`Icon`,在里面输入下载好的图标的地址:`F:\软件\图标\terminal.ico`
![这里有一张图片](/static/img/WindowsTerminal配置/4.png)
然后右键wt,选择新建项,输入command
然后点击command,双击右边的默认,输入Terminal的地址`"%%LOCALAPPDATA%%\Microsoft\WindowsApps\wt.exe\"`即可
![这里有一张图片](/static/img/WindowsTerminal配置/5.png)

### 在当前目录打开

在每个终端的配置中添加`"startingDirectory" : ".",`这个配置即可:

```
"profiles":
[
    //......
    {
        // Make changes here to the cmd.exe profile
        "guid": "{0caa0dad-35be-5f56-a8ff-afceeeaa6101}",
        "name": "cmd",
        "commandline": "cmd.exe",
        "startingDirectory" : ".",
        "hidden": false
    },
    //......
```

复制



## 完整配置示例

```
// To view the default settings, hold "alt" while clicking on the "Settings" button.
// For documentation on these settings, see: https://aka.ms/terminal-documentation
{
    "$schema": "https://aka.ms/terminal-profiles-schema",
    // "defaultProfile": "{61c54bbd-c2c6-5271-96e7-009a87ff44bf}",
    "defaultProfile": "{0caa0dad-35be-5f56-a8ff-afceeeaa6101}",
    "profiles":
    [
        {
            // Make changes here to the powershell.exe profile
            "guid": "{61c54bbd-c2c6-5271-96e7-009a87ff44bf}",
            "name": "Windows PowerShell",
            "hidden": false
        },
        {
            // Make changes here to the cmd.exe profile
            "guid": "{0caa0dad-35be-5f56-a8ff-afceeeaa6101}",
            "name": "cmd",
            "commandline": "cmd.exe",
            // "startingDirectory" : "%USERPROFILE%",
            "startingDirectory" : ".",
            "hidden": false
        },
        {
            "guid": "{c6eaf9f4-32a7-5fdc-b5cf-066e8a4b1e40}",
            "hidden": false,
            "name": "Ubuntu-18.04",
            "source": "Windows.Terminal.Wsl"
        },
        {
            "guid": "{b453ae62-4e3d-5e58-b989-0a998ec441b8}",
            "hidden": false,
            "name": "Azure Cloud Shell",
            "source": "Windows.Terminal.Azure"
        }
    ],
    // Add custom color schemes to this array
    "schemes": [],
    // Add any keybinding overrides to this array.
    // To unbind a default keybinding, set the command to "unbound"
    "keybindings":
    [
        { "command": "copy", "keys": ["ctrl+shift+c"] },
        { "command": "paste", "keys": ["ctrl+shift+v"] },
        { "command": "closePane", "keys": ["ctrl+shift+w"] },
        { "command": "newTab", "keys": ["ctrl+shift+t"] }
        // etc.
    ]
}
```

复制

## 效果

在一个目录下按下鼠标右键,选择**`Window Terminal Here`**：
![这里有一张图片](/static/img/WindowsTerminal配置/2.png)
此时`Terminal`就会在当前目录下打开`cmd`:
![这里有一张图片](/static/img/WindowsTerminal配置/3.png)

# 参考资料

https://printempw.github.io/windows-terminal-setup-guide/
https://github.com/microsoft/terminal/blob/master/doc/user-docs/UsingJsonSettings.md