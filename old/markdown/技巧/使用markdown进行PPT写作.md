---
marp: true
size: 4:3
theme: default
paginate: true
backgroundColor: #fff
backgroundImage: url('https://marp.app/assets/hero-background.svg')
---

# 使用markdown进行PPT写作

## markdown在工作中的各种应用

> 作者: **retrocode**

---

# 前言

> 传统的word文档格式有什么不足?

 - 传统的word文档格式不够简洁，不利于版本控制，SVN不能看到文字级别的修改记录
 - word文档较多时会出现格式混乱，字体大小、字体、颜色、行间距不好统一
 - word文档格式不够灵活，不利于转换成其他格式分享
 - 没有wps/office就无法查看文档内容，还可能存在兼容问题

---

# markdown简介

> markdown是什么?相对于word文档有什么优势?什么场景下可以使用markdown?

 - 一个使用各种符号标记的文本格式，如: `#`、`*`、`-`、`>`等，以一个 `#` 开头就是一级标题，以 `##` 开头就是二级标题
 - 简单易懂，容易学习和使用，不需要进行任何设置，即使使用 `txt` 也可以使用markdown语法
 - 支持标题、段落、列表、表格、代码块、链接和图片等元素的标记

---

# markdown相对传统word文档的优势

 - 简洁明了：语法简单，易于学习。
 - 跨平台支持：因为是纯文本格式，任何平台只要可以输入文字就可以使用markdown语法。
 - 易于版本控制：可以通过版本控制工具（如 Git/SVN）进行管理，方便地跟踪文档的修改记录，更好地协作和备份。
 - 灵活性高：可以随心使用喜欢的编辑器写作。
 - 易于转换：文档可以轻松地转换成其他格式，如 PDF、HTML、Word、PPT等。

---

# markdown的应用场景

 - 博客写作
 - 文档经常变动需要进行版本控制
 - 知乎/公众号文章编写
 - 对文字大小、字体存在规定的文档编写
 - 生成PPT/PDF/WORD/HTML等各式文档
 - 其他需要同一篇文章发布到不同平台的场景

---

# 场景展示

---

![场景展示1](./img/使用markdown进行PPT写作/1.jpg)

---

![场景展示2](./img/使用markdown进行PPT写作/2.jpg)

---

![场景展示3](./img/使用markdown进行PPT写作/3.jpg)

---

![场景展示4](./img/使用markdown进行PPT写作/4.jpg)

---

# markdown 语法展示

---

## 标题

> Markdown 语法：

```
# 第一级标题 `<h1>`
## 第二级标题 `<h2>`
###### 第六级标题 `<h6>`
```
效果如下：
# 第一级标题 `<h1>`
## 第二级标题 `<h2>`
###### 第六级标题 `<h6>`

---

## 强调

Markdown 语法：

```
*这些文字会生成`<em>`*
_这些文字会生成`<u>`_

**这些文字会生成`<strong>`**
__这些文字会生成`<strong>`__

```

效果如下：

*这些文字会生成`<em>`*
_这些文字会生成`<u>`_

**这些文字会生成`<strong>`**
__这些文字会生成`<strong>`__

---

## 表格
Markdown 语法：
```
| 姓名 | 年龄 |
| ---- | ---- |
| 张三 | 18   |
| 王五 | 17   |
```

效果如下：

| 姓名 | 年龄 |
| ---- | ---- |
| 张三 | 18   |
| 王五 | 17   |

---

## 公式
Markdown 语法：
```
$$	x = \dfrac{-b \pm \sqrt{b^2 - 4ac}}{2a} $$
```
效果如下：
$$	x = \dfrac{-b \pm \sqrt{b^2 - 4ac}}{2a} $$

---

# markdown转换为其他格式

- 转公众号文章(https://doocs.gitee.io/md/)
- ppt制作(https://web.marp.app/)
- 本地编辑器typora(https://www.ghxi.com/typora.html)

---

# 谢谢大家!