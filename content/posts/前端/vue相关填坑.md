+++
author = "cvooc"
title = "vue相关填坑"
date = "2019-06-12 14:27:06"
description = "vue相关填坑"
tags = [
    "前端",
    "vue",
    "踩坑",
]
+++

# 前言

此文章用于记录 vue 的填坑

## build 后 html 无引号

vue-cli 3.0 后项目结构发生了变化,故之前 cli2.0 的修改配置的方法已失效,而新的配置路径我暂时没有研究透彻.
目前发现的简单粗暴的方法为修改

```js
项目路径\node_modules\@vue\cli-service\lib\config\app.js
```

修改该 js 中的 removeAttributeQuotes: true,改为 false .然后重新 build,即可修复 html 无引号的问题

## 获取兄弟,子,父元素

```js
<button @click = “clickfun($event)”>点击</button>

methods: {
clickfun(e) {
	// e.target 是你当前点击的元素
	// e.currentTarget 是你绑定事件的元素
    #获得点击元素的前一个元素
    e.currentTarget.previousElementSibling.innerHTML
    #获得点击元素的第一个子元素
    e.currentTarget.firstElementChild
    # 获得点击元素的下一个元素
    e.currentTarget.nextElementSibling
    # 获得点击元素中id为string的元素
    e.currentTarget.getElementById("string")
    # 获得点击元素的string属性
    e.currentTarget.getAttributeNode('string')
    # 获得点击元素的父级元素
    e.currentTarget.parentElement
    # 获得点击元素的前一个元素的第一个子元素的HTML值
    e.currentTarget.previousElementSibling.firstElementChild.innerHTML

    }
},
```
