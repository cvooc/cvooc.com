+++
author = "cvooc"
title = "使用php为docsify添加阅读密码支持"
date = "2022-01-13 05:14:08"
description = "使用php为docsify添加阅读密码支持"
tags = [
    "技巧",
    "php",
    "docsify",
]
+++

# 使用 php 为 docsify 添加阅读密码支持

由于 docsify 是运行时库,出于安全考虑我使用了 php 对加密文件进行处理,否则加密没有存在意义了.

## DEMO

Password: 123

[https://retrocode.io/#/%E6%8A%80%E5%B7%A7/password-123.md.auth](https://retrocode.io/#/%E6%8A%80%E5%B7%A7/password-123.md.auth)

## 演示

![1](/static/img/使用php为docsify添加阅读密码支持/1.png)

![2](/static/img/使用php为docsify添加阅读密码支持/2.png)

## 使用方式

在 md 文件后缀追加 .password.auth 即可.

> filename.md.passwprd.auth

例如:

> testPassword.md.123.auth

同时请将**\_sidebar.md**中的文件路径修改为

> filename.md.auth

即**移除加密密码(加密密码只存在于源文件中)**

例如:

```markdown
-   category
    -   [testPassword](category/testPassword.md.auth)
```

## 配置 nginx 伪静态,将关于加密文件的请求转发给 auth.php

```yaml
location ~* \.(auth.md)$ {
if (!-e $request_filename){
rewrite  ^(.*)$  /auth.php?s=$1  last;   break;
}
}
```

## 创建 auth.php 并放置到与 docsify 的 index.html 同目录下

```php
<?php
function redirect($url) {
  header("Location: $url");
  exit();
}
function startWith($str, $needle) {
  return strpos($str, $needle) === 0;
}
function endWith($haystack, $needle) {
  $length = strlen($needle);
  if ($length == 0) {
    return true;
  }
  return (substr($haystack, -$length) === $needle);
}
function echoForm($requestUri) {
  echo <<<form
  <form action="$requestUri" onsubmit="location.reload();" target="nm_iframe" method='get'>
    阅读密码: <input type='text' name='auth'>
    <input type='submit' id="id_submit" value='提交'>
  </form>
  <iframe id="id_iframe" name="nm_iframe" style="display:none;"></iframe>
  form;
  exit;
}
$requestUri = urldecode($_SERVER['REQUEST_URI']);
$requestUri = parse_url($requestUri)['path'];
if (isset($_COOKIE['auth']) || isset($_GET['auth'])) {
  $cookieValue = $_COOKIE['auth'];
  if (isset($_GET['auth'])) {
    $cookieValue = md5($_GET['auth']);
    setcookie('auth', $cookieValue, time() + 3600 * 12);
  }
  $pathinfo = pathinfo($requestUri);
  $patharr = explode("/", $requestUri);
  $basename = str_replace(".auth.md", "", end($patharr));
  unset($patharr[count($patharr)-1]);
  $mdpath = __DIR__ . implode("/", $patharr);
  $files = scandir($mdpath);
  foreach ($files as $filename) {
    if (startWith($filename, $basename) && endWith($filename, '.auth')) {
      $password = str_replace($basename . ".", "", $filename);
      $password = str_replace(".auth", "", $password);
      if (md5($password) === $cookieValue) {
        echo $filecontent = file_get_contents($mdpath . "/" . $filename);
        exit;
      }
    }
  }
  echoForm($requestUri);
} else {
  echoForm($requestUri);
}
```

## 注意

如果你使用的**\_sidebar.md**,则需要在生成**\_sidebar.md**文件时对文件名进行处理.

例如:

```php
    $files = scandir($path);
    foreach ($files as $filename) {
        $suffix =  pathinfo($filename, PATHINFO_EXTENSION);
        if ($filename !== "." && $filename !== ".." && ($suffix === "md" || $suffix === "auth")) {
            // 移除文件名中的加密密码
            if ($suffix === "auth") {
              $tmpfns = explode(".", $filename);
              unset($tmpfns[count($tmpfns)-2]);
              $filename = implode(".",$tmpfns);
            }
            $fileRealPath = $categoryName . "/" . $filename;
            file_put_contents($GLOBALS['sidebarPath'], "    * [" . $filename . "](" . $fileRealPath . ")\r\n", FILE_APPEND);
        }
    }
```
