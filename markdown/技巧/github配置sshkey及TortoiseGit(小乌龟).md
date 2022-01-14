最后更新时间: 2021年7月16日 17:35:30

# github配置sshkey及TortoiseGit(小乌龟)

## 参考链接

>- [GitHub Help](https://help.github.com/articles/connecting-to-github-with-ssh/)
>- [github设置添加SSH](http://www.cnblogs.com/ayseeing/p/3572582.html)
>- [TortoiseGit(小乌龟)设置pageant开机自启动且自动加载SSH Key](https://blog.csdn.net/qq_41194534/article/details/86478627)

## 前言

很多朋友在用github管理项目的时候,都是直接使用https url克隆到本地,当然也有有些人使用 ssh url 克隆到本地.然而,为什么绝大多数人会使用https url克隆呢？

这是因为,使用https url克隆对初学者来说会比较方便,复制https url 然后到 git Bash 里面直接用clone命令克隆到本地就好了.而使用 ssh url 克隆却需要在克隆之前先配置和添加好 ssh key .

因此,如果你想要使用 ssh url 克隆的话,你必须是这个项目的拥有者.否则你是无法添加 ssh key 的.

### HTTPS 和 SSH 的区别

1. https可以随意克隆github上的项目,而不管是谁的;而ssh则是你必须是你要克隆的项目的拥有者或管理员,且需要先添加sshkey,否则无法克隆.
2. https url 在push的时候是需要验证用户名和密码的;而 ssh 在push的时候,是不需要输入用户名的,如果配置sshkey的时候设置了密码,则需要输入密码的,否则直接是不需要输入密码的.

## 1. github配置sshkey

### 1.1 配置git个人信息

配置个人用户信息和电子邮件地址

```javascript
git config --global user.name “用户名”
git config --global user.email “你的邮箱”
git config --list (查看所有配置项)
```

### 1.2 添加SSH密钥

#### 1.2.1 查看现有的SSH密钥

```javascript
$ ls -al ~/.ssh
```

#### 1.2.2 生成新SSH密钥

```javascript
// 安装git后,在你电脑上打开cmd或 git bash,输入命令
// your_email@example.com为登录GitHub仓库的邮箱
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"

//输入后会询问是否以输出额外文件去保存,这里推荐直接回车,
//直接回车会在.ssh文件夹 认生成id_rsa 和id_rsa.pub两个文件
//如果选择额外输出同样会生成类似的两个文件
Enter file in which to save the key (/c/Users/username/.ssh/id_rsa):

// 如果你曾经配置过,现在要重新生成,会询问你是否覆盖,如果你第一次配置,则不会出现此询问
/c/Users/username/.ssh/id_rsa already exists.
Overwrite (y/n)?

// 接下来它会询问是否需要密码,建议直接回车,回车默认没有密码
Enter passphrase (empty for no passphrase):

// 再次输入密码,建议直接回车
Enter same passphrase again:

// 提示生成成功,请在C盘>用户>你的用户名>.ssh 去查看
Your identification has been saved in /c/Users/username/.ssh/id_rsa
Your public key has been saved in /c/Users/bingq/.ssh/id_rsa.pub
SHA256:略
The key's randomart image is:略
```

### 1.3 将SSH密钥添加到ssh-agent

#### 1.3.1 在后台启动ssh-agent

```
$ eval "$(ssh-agent -s)"
> Agent pid 59566
```

#### 1.3.2 修改`~/.ssh/config`文件以自动将密钥加载到ssh-agent中并在密钥链中存储密码

```javascript
Host *
AddKeysToAgent yes
UseKeychain yes
IdentityFile ~/.ssh/id_rsa
```

#### 1.3.3 将SSH私钥添加到ssh-agent并将密码存储在密钥链中

```javascript
$ ssh-add -K ~/.ssh/id_rsa
```

## 2. 添加密钥到GitHub

1. 打开 /.ssh/id_rsa.pub 文件,将内容复制到剪贴板
2. 单击右上角头像
3. 单击`Settings`
4. 单击`SSH and GPG keys`
5. 单击 `New SSH Key`
6. 填写`Title`并将`/.ssh/id_rsa.pub`文件内容粘贴到`Key`
7. 单击`Add SSH Key`完成
8. 如果出现提示,请确认你的GitHub密码
9. 页面自动跳转后,你会发现你多了一个灰色的钥匙,这是因为你从未使用过这个Key

## 3. 测试SSH连接

```javascript
// 打开git bash 输入以下内容,通过该地址验证key
//git@github.com不用改成你的邮箱地址,验证地址就是这个
ssh -T git@github.com

// 询问你是否继续连接,输入yes
The authenticity of host 'github.com (xx.xxx.xxx.xx)' can't be established.
RSA key fingerprint is SHA256:略.
Are you sure you want to continue connecting (yes/no/[fingerprint])?

// 如果成功,他会发出以下内容
// 如果失败,请尝试在GitHub上删除生成的key,然后重新添加,注意复制时末尾不要有空格(可能会影响)
// 如果还是失败,可以联系我
Warning: Permanently added 'github.com,xx.xxx.xxx.xx' (RSA) to the list of known hosts
Hi yourname! You've successfully authenticated, but GitHub does not provide shell access.
```

## 4. 配置总结

> 到这一步,便完成了sshkey的配置,你可以到Setting>SSH and GPG keys看到钥匙变绿,在GitHub仓库中复制仓库ssh地址进行克隆尝试,如果你不使用小乌龟,那么本文看到这里便可以了.

## 5. TortoiseGit(小乌龟)设置pageant开机自启动且自动加载SSH Key

TortoiseGit无法使用git 生成的ssh-key 需要转化为ppk 公钥,然后就产生每天上班第一件事就是打开 Pageant ,然后去加载公钥,比较麻烦,现在我们把这件重复的事情设置为开机自启动

### 5.1 生成ppk文件

1. 首先找到TortoiseGit 的安装目录的bin目录,然后找到puttygen.exe 运行 或是 window键打开开始菜单,搜索puttygen 点击运行

![QQ图片20210716163403](./static/img/github配置sshkey及TortoiseGit(小乌龟)/1.png)

2. 点击conversions 中的 Import key 来加载git生成的ssh key 文件

![image-20210716163544968](./static/img/github配置sshkey及TortoiseGit(小乌龟)/2.png)

![image-20210716163635292](./static/img/github配置sshkey及TortoiseGit(小乌龟)/3.png)

3. 选择完毕后点击save private key 按钮保存生成的ppk文件下面要用

![image-20210716163734215](./static/img/github配置sshkey及TortoiseGit(小乌龟)/4.png)

### 5.2 加载PPK文件

1. 首先找到TortoiseGit 的安装目录的bin目录,然后找到pageant.exe 运行 或是 window键打开开始菜单,搜索pageant点击运行,他不会直接弹框,需要在任务栏中点击才有弹框

![image-20210716163838257](./static/img/github配置sshkey及TortoiseGit(小乌龟)/5.png)

![image-20210716163921293](./static/img/github配置sshkey及TortoiseGit(小乌龟)/6.png)

2. 点击add key 选择加载之前保存的ppk 文件,直接close就可以,这样就直接可以使用TortoiseGit提交代码

![image-20210716164034860](./static/img/github配置sshkey及TortoiseGit(小乌龟)/7.png)

4. **但是这不是我们现在的最终目的,我们的最终目的是能自动启动加载,咱们接着往下设置**

## 6. TortoiseGit(小乌龟)设置pageant开机自启动且自动加载SSH Key

1.首先找到TortoiseGit 的安装目录的bin目录,然后找到pageant.exe 运行 或是 window键打开开始菜单,搜索pageant右键打开文件夹所在位置创建并复制快捷方式

![image-20210716164222541](./static/img/github配置sshkey及TortoiseGit(小乌龟)/8.png)

2. window+r 输入shell:startup;点击确定将复制好的快捷方式放入该目录下

![image-20210716164326743](./static/img/github配置sshkey及TortoiseGit(小乌龟)/9.png)

3.右键属性中找到快捷方式,在目标后面拼上ppk 文件的目录

![image-20210716164442851](./static/img/github配置sshkey及TortoiseGit(小乌龟)/10.png)

![image-20210716164506990](./static/img/github配置sshkey及TortoiseGit(小乌龟)/11.png)

至此我们的生成ppk文件并设置开机自启动就完成了,之后我们就可以安心的使用小乌龟提交代码,而不需要其他验证了.