+++
author = "cvooc"
title = "CSS常用标签"
date = "2018-04-20 11:29:44"
description = "CSS常用标签"
tags = [
    "前端",
    "CSS"
]
+++

# 前言

此文章在于对日常使用较为频繁的 CSS 标签进行整理,希望能帮助你们.

## CSS 自定义变量

```css
:root {
    --THEME_COLOR: ##ff9800; //主题颜色
}
```

```html
<style type="text/css">
    ##test {
        background-color: var(--THEME_COLOR);
    }
</style>
<div id="test" style="width: 50px;height: 20px;"></div>
```

## 禁止页面选中文字

```css
moz-user-select: -moz-none;
-moz-user-select: none;
-o-user-select: none;
-khtml-user-select: none;
-webkit-user-select: none;
-ms-user-select: none;
user-select: none;
```

## 设置圆角

```css
border-radius: 100%;
```

## textarea 禁止拉伸

```css
resize: none;
```

## 使 DIV 平行

```css
display: inline;
```

## 隐藏页面滚轮

```css
::-webkit-scrollbar {
    display: none;
}
```

## 使文字水平居中

```css
text-align: center;
```

## 使文字垂直居中

```css
height: 20px;
line-height: 20px;
```

## 使 DIV 垂直居中

```css
display: flex;
align-items: center;
```

## 将 DIV 固定到页面四周

```css
position: fixed;
top: 0;
/*或:right: 0;bottom: 0;left: 0;*/
```

## 去除 a 标签下划线

```css
text-decoration: none;
```

## 字体加粗

```css
font-weight: bold;
```

## 隐藏 DIV(占用空间)

```css
visibility: hidden;
visibility: visible; /*显示*/
```

## select 文字居中

```css
select {
    text-align: center;
    text-align-last: center;
}
```

## 隐藏 DIV(释放空间)

```css
display: none;
display: block; /*显示*/
```

## DIV 添加边框阴影

```css
box-shadow: h-shadow v-shadow blur spread color inset;
```

| 值       | 描述                                   |
| -------- | -------------------------------------- |
| h-shadow | 必需.水平阴影的位置.允许负值.          |
| v-shadow | 必需.垂直阴影的位置.允许负值.          |
| blur     | 可选.模糊距离.                         |
| spread   | 可选.阴影的尺寸.                       |
| color    | 可选.阴影的颜色.请参阅 CSS 颜色值.     |
| inset    | 可选.将外部阴影 (outset) 改为内部阴影. |

## 设置 table 边框合并为单一边框

```css
table {
    border-collapse: collapse;
}
```

## 取消 DIV 的浮动

```css
clear: both; /*在左右两侧不允许出现浮动元素*/
```

## DIV 文本超出后隐藏,并显示为...

```css
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
```

## 响应式

```css
.mario-col-xs-1,
.mario-col-xs-2,
.mario-col-xs-3,
.mario-col-xs-4,
.mario-col-xs-5,
.mario-col-xs-6,
.mario-col-xs-7,
.mario-col-xs-8,
.mario-col-xs-9,
.mario-col-xs-10,
.mario-col-xs-11,
.mario-col-5 {
    position: relative;
    float: left;
}
.mario-col-xs-12 {
    width: 100%;
    position: relative;
}
.mario-col-xs-11 {
    width: 91.66666667%;
}
.mario-col-xs-10 {
    width: 83.33333333%;
}
.mario-col-xs-9 {
    width: 75%;
}
.mario-col-xs-8 {
    width: 66.66666667%;
}
.mario-col-xs-7 {
    width: 58.33333333%;
}
.mario-col-xs-6 {
    width: 50%;
}
.mario-col-xs-5 {
    width: 41.66666667%;
}
.mario-col-xs-4 {
    width: 33.33333333%;
}
.mario-col-xs-3 {
    width: 25%;
}
.mario-col-xs-2 {
    width: 16.66666667%;
}
.mario-col-xs-1 {
    width: 8.33333333%;
}
```

## 选择器

| 选择器                     | 示例                  | 示例说明                                                     | CSS |
| -------------------------- | --------------------- | ------------------------------------------------------------ | --- |
| .class                     | .intro                | 选择所有 class="intro"的元素                                 | 1   |
| #id                        | #firstname            | 选择所有 id="firstname"的元素                                | 1   |
| \*                         | \*                    | 选择所有元素                                                 | 2   |
| element                    | p                     | 选择所有<p>元素                                              | 1   |
| element,element            | div,p                 | 选择所有<div>元素和<p>元素                                   | 1   |
| element element            | div p                 | 选择<div>元素内的所有<p>元素                                 | 1   |
| element>element            | div>p                 | 选择所有父级是 <div> 元素的 <p> 元素                         | 2   |
| element+element            | div+p                 | 选择所有紧接着<div>元素之后的<p>元素                         | 2   |
| [attribute]                | [target]              | 选择所有带有 target 属性元素                                 | 2   |
| [attribute=value]          | [target=-blank]       | 选择所有使用 target="-blank"的元素                           | 2   |
| [attribute~=value]         | [title~=flower]       | 选择标题属性包含单词"flower"的所有元素                       | 2   |
| [attribute&#124;=language] | [lang&#124;=en]       | 选择一个 lang 属性的起始值="EN"的所有元素                    | 2   |
| :link                      | a:link                | 选择所有未访问链接                                           | 1   |
| :visited                   | a:visited             | 选择所有访问过的链接                                         | 1   |
| :active                    | a:active              | 选择活动链接                                                 | 1   |
| :hover                     | a:hover               | 选择鼠标在链接上面时                                         | 1   |
| :focus                     | input:focus           | 选择具有焦点的输入元素                                       | 2   |
| :first-letter              | p:first-letter        | 选择每一个<P>元素的第一个字母                                | 1   |
| :first-line                | p:first-line          | 选择每一个<P>元素的第一行                                    | 1   |
| :first-child               | p:first-child         | 指定只有当<p>元素是其父级的第一个子级的样式。                | 2   |
| :before                    | p:before              | 在每个<p>元素之前插入内容                                    | 2   |
| :after                     | p:after               | 在每个<p>元素之后插入内容                                    | 2   |
| :lang(language)            | p:lang(it)            | 选择一个 lang 属性的起始值="it"的所有<p>元素                 | 2   |
| element1~element2          | p~ul                  | 选择 p 元素之后的每一个 ul 元素                              | 3   |
| [attribute^=value]         | a[src^="https"]       | 选择每一个 src 属性的值以"https"开头的元素                   | 3   |
| [attribute$=value]         | a[src$=".pdf"]        | 选择每一个 src 属性的值以".pdf"结尾的元素                    | 3   |
| [attribute\*=value]        | a[src*="runoob"]      | 选择每一个 src 属性的值包含子字符串"runoob"的元素            | 3   |
| :first-of-type             | p:first-of-type       | 选择每个 p 元素是其父级的第一个 p 元素                       | 3   |
| :last-of-type              | p:last-of-type        | 选择每个 p 元素是其父级的最后一个 p 元素                     | 3   |
| :only-of-type              | p:only-of-type        | 选择每个 p 元素是其父级的唯一 p 元素                         | 3   |
| :only-child                | p:only-child          | 选择每个 p 元素是其父级的唯一子元素                          | 3   |
| :nth-child(n)              | p:nth-child(2)        | 选择每个 p 元素是其父级的第二个子元素                        | 3   |
| :nth-last-child(n)         | p:nth-last-child(2)   | 选择每个 p 元素的是其父级的第二个子元素，从最后一个子项计数  | 3   |
| :nth-of-type(n)            | p:nth-of-type(2)      | 选择每个 p 元素是其父级的第二个 p 元素                       | 3   |
| :nth-last-of-type(n)       | p:nth-last-of-type(2) | 选择每个 p 元素的是其父级的第二个 p 元素，从最后一个子项计数 | 3   |
| :last-child                | p:last-child          | 选择每个 p 元素是其父级的最后一个子级。                      | 3   |
| :root                      | :root                 | 选择文档的根元素                                             | 3   |
| :empty                     | p:empty               | 选择每个没有任何子级的 p 元素（包括文本节点）                | 3   |
| :target                    | #news:target          | 选择当前活动的#news 元素（包含该锚名称的点击的 URL）         | 3   |
| :enabled                   | input:enabled         | 选择每一个已启用的输入元素                                   | 3   |
| :disabled                  | input:disabled        | 选择每一个禁用的输入元素                                     | 3   |
| :checked                   | input:checked         | 选择每个选中的输入元素                                       | 3   |
| :not(selector)             | :not(p)               | 选择每个并非 p 元素的元素                                    | 3   |
| ::selection                | ::selection           | 匹配元素中被用户选中或处于高亮状态的部分                     | 3   |
| :out-of-range              | :out-of-range         | 匹配值在指定区间之外的 input 元素                            | 3   |
| :in-range                  | :in-range             | 匹配值在指定区间之内的 input 元素                            | 3   |
| :read-write                | :read-write           | 用于匹配可读及可写的元素                                     | 3   |
| :read-only                 | :read-only            | 用于匹配设置 "readonly"（只读） 属性的元素                   | 3   |
| :optional                  | :optional             | 用于匹配可选的输入元素                                       | 3   |
| :required                  | :required             | 用于匹配设置了 "required" 属性的元素                         | 3   |
| :valid                     | :valid                | 用于匹配输入值为合法的元素                                   | 3   |
| :invalid                   | :invalid              | 用于匹配输入值为非法的元素                                   | 3   |
