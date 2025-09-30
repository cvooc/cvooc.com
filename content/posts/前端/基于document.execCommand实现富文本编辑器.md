最后更新时间: 2018年6月28日 17:30:17

# 前言
对于我们往常的开发来说富文本编辑器是一个经常会碰到的功能,我们通常会选择集成各种开源框架来实现富文本功能.
不过对于一些小型项目、WEBAPP等项目我们反而会因为开源框架过于笨重或者美术风格不统一等原因而放弃集成开源框架.
那么为何我们尝试自己实现一个富文本编辑器呢?
# document.execCommand
该方法可以对可编辑器区域进行操作,比如加粗文字、改变字号、插入链接等.可编辑区域也就是设置了contentEditable属性的元素.
```js
bool = document.execCommand(commandName, showDefaultUI[, arg])
```
- commandName：String，命令的名称
- showDefaultUI：Boolean，是否展示用户界面（暂时没有发现“用户界面”指的是什么），一般为false
- arg：String，要传递的参数，比如插入链接需要传入一个 URL，可选
- 返回值：Boolean，表示操作是否支持或是否启用
---
假如要把选中的文字加粗，只需要这样:
```js
document.execCommand('bold', false)
```
可以使用如下方法检测,具体的属性操作在当前浏览器的兼容性.
```js
document.queryCommandSupported(commandName)
```

当文档对象被转换为设计模式的时候（选中，设置contentEditable等），文档对象提供了一个execCommand方法，通过给这这个方法传递参数命令可以操作可编辑区域的内容。这个方法的命令大多数是对文档选中区域的操作 (如bold, italics等), 也可以插入一个元素(如增加一个a链接) 或者修改一个完整行 (如缩进).。当元素被设置了contentEditable，通过执行execCommand 方法可以对当前活动元素进行很多操作。

## 语法
---
```js
bool = document.execCommand(aCommandName, aShowDefaultUI, aValueArgument)
```

### 返回值
---
一个 Boolean ，如果是 false 则表示操作不被支持或未被启用。

### 参数
---
|属性|介绍|
|-----|-----|
|aCommandName|一个 DOMString ，命令的名称。可用命令列表请参阅命令 。|
|aShowDefaultUI|一个 Boolean 是否展示用户界面，一般为 false。Mozilla 没有实现。|
|aValueArgument|一些命令需要一些额外的参数值（如insertimage需要提供这个image的url）。默认为null。|
### 命令
|属性|介绍|
|-----|-----|
|backColor|修改文档的背景颜色。在styleWithCss模式下，则只影响容器元素的背景颜色。这需要一个<color> 类型的字符串值作为参数传入。注意，IE浏览器用这个设置文字的背景颜色。|
|bold|开启或关闭选中文字或插入点的粗体字效果。IE浏览器使用 <strong>标签，而不是 <b>标签。|
|contentReadOnly|通过传入一个布尔类型的参数来使能文档内容的可编辑性。(IE浏览器不支持)|
|copy|拷贝当前选中内容到剪贴板。启用这个功能的条件因浏览器不同而不同，而且不同时期，其启用条件也不尽相同。使用之前请检查浏览器兼容表，以确定是否可用。|
|createLink|将选中内容创建为一个锚链接。这个命令需要一个HREF URI字符串作为参数值传入。URI必须包含至少一个字符，例如一个空格。（浏览器会创建一个空链接）|
|cut|剪贴当前选中的文字并复制到剪贴板。启用这个功能的条件因浏览器不同而不同，而且不同时期，其启用条件也不尽相同。使用之前请检查浏览器兼容表，以确定是否可用。|
|decreaseFontSize|给选中文字加上 <small> 标签，或在选中点插入该标签。(IE浏览器不支持)|
|delete|删除选中部分.|
|enableInlineTableEditing|启用或禁用表格行和列插入和删除控件。(IE浏览器不支持)|
|enableObjectResizing|启用或禁用图像和其他对象的大小可调整大小手柄。(IE浏览器不支持)|
|fontName|在插入点或者选中文字部分修改字体名称. 需要提供一个字体名称字符串 (例如："Arial")作为参数。|
|fontSize|在插入点或者选中文字部分修改字体大小. 需要提供一个HTML字体尺寸 (1-7) 作为参数。|
|foreColor|在插入点或者选中文字部分修改字体颜色. 需要提供一个颜色值字符串作为参数。|
|formatBlock|添加一个HTML块式标签在包含当前选择的行, 如果已经存在了，更换包含该行的块元素 (在 Firefox中, BLOCKQUOTE 是一个例外 -它将包含任何包含块元素). 需要提供一个标签名称字符串作为参数。几乎所有的块样式标签都可以使用(例如. "H1", "P", "DL", "BLOCKQUOTE"). (IE浏览器仅仅支持标题标签 H1 - H6, ADDRESS, 和 PRE,使用时还必须包含标签分隔符 < >, 例如 "<\h1>".)|
|forwardDelete|删除光标所在位置的字符。 和按下删除键一样。|
|heading|添加一个标题标签在光标处或者所选文字上。 需要提供标签名称字符串作为参数 (例如. "H1", "H6"). (IE 和 Safari不支持)|
|hiliteColor|更改选择或插入点的背景颜色。需要一个颜色值字符串作为值参数传递。 UseCSS 必须开启此功能。(IE浏览器不支持)|
|increaseFontSize|在选择或插入点周围添加一个BIG标签。(IE浏览器不支持)|
|indent|缩进选择或插入点所在的行， 在 Firefox 中, 如果选择多行，但是这些行存在不同级别的缩进, 只有缩进最少的行被缩进。|
|insertBrOnReturn|控制当按下Enter键时，是插入 br 标签还是把当前块元素变成两个。(IE浏览器不支持)|
|insertHorizontalRule|在插入点插入一个水平线（删除选中的部分）|
|insertHTML|在插入点插入一个HTML字符串（删除选中的部分）。需要一个个HTML字符串作为参数。(IE浏览器不支持)|
|insertImage|在插入点插入一张图片（删除选中的部分）。需要一个image SRC URI作为参数。这个URI至少包含一个字符。空白字符也可以（IE会创建一个链接其值为null）|
|insertOrderedList|在插入点或者选中文字上创建一个有序列表|
|insertUnorderedList|在插入点或者选中文字上创建一个无序列表。|
|insertParagraph|在选择或当前行周围插入一个段落。(IE会在插入点插入一个段落并删除选中的部分.)|
|insertText|在光标插入位置插入文本内容或者覆盖所选的文本内容。|
|italic|在光标插入点开启或关闭斜体字。 (Internet Explorer 使用 EM 标签，而不是 I )|
|justifyCenter|对光标插入位置或者所选内容进行文字居中。|
|justifyFull|对光标插入位置或者所选内容进行文本对齐。|
|justifyLeft|对光标插入位置或者所选内容进行左对齐。|
|justifyRight|对光标插入位置或者所选内容进行右对齐。|
|outdent|对光标插入行或者所选行内容减少缩进量。|
|paste|在光标位置粘贴剪贴板的内容，如果有被选中的内容，会被替换。剪贴板功能必须在 user.js 配置文件中启用。参阅 [1].|
|redo|重做被撤销的操作。|
|removeFormat|对所选内容去除所有格式|
|selectAll|选中编辑区里的全部内容。|
|strikeThrough|在光标插入点开启或关闭删除线。|
|subscript|在光标插入点开启或关闭下角标。|
|superscript|在光标插入点开启或关闭上角标。|
|underline|在光标插入点开启或关闭下划线。|
|undo|撤销最近执行的命令。|
|unlink|去除所选的锚链接的<a>标签|
|useCSS|切换使用 HTML tags 还是 CSS 来生成标记. 要求一个布尔值 true/false 作为参数。注: 这个属性是逻辑上的倒退 (例如. use false to use CSS, true to use HTML).(IE不支持)该属性已经废弃，使用 styleWithCSS 代替。|
|styleWithCSS|用这个取代 useCSS 命令。 参数如预期的那样工作, i.e. true modifies/generates 风格的标记属性, false 生成格式化元素。|
---
# 简易的富文本编辑器实现
```html
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
.editor-content {
	border: 1px solid red;
	width: 500px;
	height: 500px;
}
</style>
</head>
<body>
<div class="editor-tools">
	<button type="button" data-cmd="bold">加粗</button>
	<button type="button" data-cmd="italic">斜体</button>
	<button type="button" data-cmd="underline">下划线</button>
	<button type="button" data-cmd="strikeThrough">删除线</button>
	<button type="button" data-cmd="insertOrderedList">有序列表</button>
	<button type="button" data-cmd="insertUnorderedList">无序列表</button>
	<button type="button" data-cmd="createLink" data-input="请输入一个链接">链接</button>
	<button type="button" data-cmd="insertImage" data-input="请输入一个图片地址">插图</button>
	<button type="button" data-cmd="justifyCenter">居中</button>
	<button type="button" data-cmd="justifyLeft">左对齐</button>
	<button type="button" data-cmd="justifyRight">右对齐</button>
	<button type="button" data-cmd="formatBlock" data-arg="H1">H1</button>
	<button type="button" data-cmd="formatBlock" data-arg="H2">H2</button>
	<button type="button" data-cmd="formatBlock" data-arg="H3">H3</button>
	<button type="button" data-cmd="formatBlock" data-arg="H4">H4</button>
	<button type="button" data-cmd="formatBlock" data-arg="H5">H5</button>
	<button type="button" data-cmd="formatBlock" data-arg="H6">H6</button>
	<button type="button" data-cmd="formatBlock" data-arg="BLOCKQUOTE">引用</button>
	<button type="button" data-cmd="formatBlock" data-arg="PRE">PRE</button>
	<button type="button" data-cmd="insertHorizontalRule">HR</button>
</div>
<div class="editor-content" contenteditable="">
	这里是文本编辑框,因为是DIV.所以可以任意操作内部元素.
</div>
</body>
<script type="text/javascript">
(function () {
// https://developer.mozilla.org/zh-CN/docs/Web/API/Document/execCommand
var commands = [{
cmd: 'bold',
text: '加粗'
},{
cmd: 'italic',
text: '斜体'
},{
cmd: 'decreaseFontSize',
text: '小号'
},{
cmd: 'increaseFontSize',
text: '大号'
},{
cmd: 'underline',
text: '下划线'
},{
cmd: 'strikeThrough',
text: '删除线'
},{
cmd: 'insertOrderedList',
text: '有序列表'
},{
cmd: 'insertUnorderedList',
text: '无序列表'
},{
cmd: 'createLink',
text: '链接',
input: '请输入一个链接'
},{
cmd: 'insertImage',
text: '插图',
input: '请输入一个图片地址'
},{
cmd: 'justifyCenter',
text: '居中'
},{
cmd: 'justifyLeft',
text: '左对齐'
},{
cmd: 'justifyRight',
text: '右对齐'
},{
cmd: 'formatBlock',
text: 'H1',
arg: 'H1'
},{
cmd: 'formatBlock',
text: 'H2',
arg: 'H2'
},{
cmd: 'formatBlock',
text: 'H3',
arg: 'H3'
},{
cmd: 'formatBlock',
text: 'H4',
arg: 'H4'
},{
cmd: 'formatBlock',
text: 'H5',
arg: 'H5'
},{
cmd: 'formatBlock',
text: 'H6',
arg: 'H6'
},{
cmd: 'formatBlock',
text: '引用',
arg: 'BLOCKQUOTE'
},{
cmd: 'formatBlock',
text: 'PRE',
arg: 'PRE'
},{
cmd: 'insertHorizontalRule',
text: 'HR'
		}]
var $tools = document.querySelector('.editor-tools')
var $content = document.querySelector('.editor-content')
	$tools.innerHTML = commands.map(function (item) {
	return document.queryCommandSupported(item.cmd) ?
		'<button type="button"  data-cmd="' + item.cmd + '"' +
		(item.arg ? ' data-arg="' + item.arg + '"' : '') +
		(item.input ? 'data-input="' + item.input + '"' : '') +
		'>' + item.text + '</button>' : ''
		}).join('')
	$tools.addEventListener('click', function (e) {
var $this = e.target
		if ($this.tagName !== 'BUTTON') {
			return
		}
var data = $this.dataset
var arg = data.arg || (data.input && window.prompt(data.input))
	document.execCommand(data.cmd, true, arg)
		})
	})()
</script>
</html>

```
# 参考
- [MDN: document.execCommand](https://developer.mozilla.org/zh-CN/docs/Web/API/Document/execCommand)