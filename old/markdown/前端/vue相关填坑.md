最后更新时间: 2019年6月12日 14:27:06

# 前言
此文章用于记录vue的填坑

## build后html无引号

vue-cli 3.0后项目结构发生了变化,故之前cli2.0的修改配置的方法已失效,而新的配置路径我暂时没有研究透彻.
目前发现的简单粗暴的方法为修改
```js
项目路径\node_modules\@vue\cli-service\lib\config\app.js
```
修改该js中的 removeAttributeQuotes: true,改为false .然后重新build,即可修复html无引号的问题

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