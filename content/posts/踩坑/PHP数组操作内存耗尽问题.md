+++
author = "cvooc"
title = "PHP数组操作内存耗尽问题"
date = "2020-12-12 22:45:37"
description = "PHP数组操作内存耗尽问题"
tags = [
    "踩坑",
    "php",
]
+++

# PHP 数组内存耗尽问题

## 现象

目前在 php7.1 的开发中遇到一个问题,一个递归函数调用时,向临时数组添加数据,位置不同会导致内存耗尽.

```php
function _get_uid_children($p_company_id,$rows){
    $cids = [];
    // // 放在这里就会提示内存耗尽,why?暂不明白,赶时间后续研究
    // $cids[] = $p_company_id;
    foreach($rows as $v){
        if($v['parentid'] == $p_company_id || strpos($v['plugin_parentid_auth'],','.$p_company_id.',')){
            $cids[] = $v['id'];
        }
    }
    foreach($cids as $v){
        $cids = array_merge($cids, _get_uid_children($v,$rows));
    }
    // 放在这里就OK
    $cids[] = $p_company_id;
    return $cids;
}
```

当 push 操作放在报错位置时会提示内存耗尽

```sh

 Allowed memory size of 134217728 bytes exhausted (tried to allocate 20480 bytes)

```

## 原因

事后两天重新查看这个问题,反应过来了,因为这是一个递归操作,我在递归前将参数赋值进了临时变量中,在后续的

```php
$cids = array_merge($cids, _get_uid_children($v,$rows));
```

调用时又重新传入造成了无限递归,当时的确是脑袋浆糊了.这种蠢问题都没发现,居然还写了这个 markdown 记下来.
这个 markdown 就不删了,留下来提醒我敲代码时一定要静心,不然一急躁就会忽视一些很明显的问题.
特此警示!
