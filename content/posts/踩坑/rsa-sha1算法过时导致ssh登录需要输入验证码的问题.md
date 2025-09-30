最后更新时间: 2023年2月18日 11:57:24

# rsa-sha1算法过时导致ssh登录需要输入验证码的问题

## 现象

之前遇到一个问题, gitlab配置了ssh连接,但在git bash中直接拉取代码会提示输入密码, 但相同的ssh key配置到github上后却可以正常使用连接

![ssh无法连接](static/img/rsa-sha1算法过时导致ssh登录需要输入验证码的问题/1.png)

通过 ssh -vvvT 打印日志我发现问题所在

```shell

 ssh -vvvT git@git.dev.xxxxx.com

```

![ssh无法连接](static/img/rsa-sha1算法过时导致ssh登录需要输入验证码的问题/2.png)

看到这段输入, 我们可以确定问题了, 服务器没有找到对应的签名算法

```shell

debug1: send_pubkey_test: no mutual signature algorithm

```

## 原因

我想碰到这个问题的应该是CSDN和搜索引擎的受害者, 当我们在互联网搜索生成 ssh key 的各种教程时, 应该会看到下面这个命令. 绝大多数情况下, 他是没有问题的, 比如用来给github配置ssh.

```shell

ssh-keygen -t rsa -C 'xxx@xxx.com'

```

问题出在 rsa 签名算法上, 由于 rsa-sha1 算法在17年后被破解成功导致签名已经相对不安全了, **而 OpenSSH 已于2020年宣布将默认禁用 rsa-sha1 签名算法**.

问题就出在了这里, 在较新的系统中 rsa-sha1算法, 已经被禁用了, 而你百度到的各种乱七八糟的方式 均是围绕重新开启rsa签名算法解决的, 最离谱的还有让改linux配置的, 也是服了

> 其他错误的解决方法展示如下

1.

![ssh无法连接](static/img/rsa-sha1算法过时导致ssh登录需要输入验证码的问题/3.png)

2. 

![ssh无法连接](static/img/rsa-sha1算法过时导致ssh登录需要输入验证码的问题/4.png)

3. 

![ssh无法连接](static/img/rsa-sha1算法过时导致ssh登录需要输入验证码的问题/5.png)

## 解决方法

重新生成一个签名, 使用新的算法

> OpenSSH 团队表示，现在推荐的模式是 rsa-sha2-256/512（从 OpenSSH 7.2 开始支持）、ssh-ed25519（从 OpenSSH 6.5 开始支持）或 ecdsa-sha2-nistp256/384/521（从 OpenSSH 5.7 开始支持）。

```

ssh-keygen -t ed25519 -C 'xxx@xxx.com'

```

搞定!这个才是正确的解决方法!

