最后更新时间: 2021年7月26日 12:29:10

# 前言

本以为我对uniapp不说精通至少应该是熟悉了,不过最近接连踩坑,还是决定记录下目前我发现的在大前端开发中需要规避的问题.

## 请在uni.scss中只定义scss变量,在App.vue中引入全局样式文件

正确

```css
/* App.vue */
<style lang="scss">
	/* 注意要写在第一行，否则如果class命名不规范,可能会造成样式污染问题 */
	@import "./common/index.scss";
</style>
/* uni.scss */
$u-theme-color: red;
```

错误

```css
/* uni.scss */
$u-theme-color: red;
@import "./common/index.scss";
```

**uni.scss会编译到每个scss文件中(请着重理解这一句话)**

uni.scss中所写的一切内容，都会注入到每个声明了scss的文件中(包括组件和页面)，这意味着，如果您的uni.scss如果有几百行，大小10k左右，那么这个10k都会被注入所有的 其他scss文件中，如果您的应用有50个页面和25个组件使用了scss，那么有可能因此导致整体的包体积多了75 * 10 = 750k的大小，这可能会导致小程序包太大超过2MB限制而无法预览和发布， 所以我建议只将scss变量相关的内容放到uni.scss中,同时通过App.vue引入全局变量。

## 不要在组件上直接添加class

```js
// 错误
<u-button class="m-30 p-30 bg-white">自定义组件</u-button>
// 正确
<view class="m-30 p-30 bg-white">
	<u-button>自定义组件</u-button>
</view>
```

这种写法在H5端没有问题,但小程序端渲染机制不一样,边距和背景色会出现异常渲染的情况,考虑到多端兼容,建议统一用正确写法.

## 不要在任何纯js文件中引入main.js

```js
// 如a.js中引入了main.js
import _this from "../main.js"; 
```

不管你有任何需求,不要这么做,这个坑埋了好久.在纯vue的uniapp项目中,这不是问题.

当业务需要引入nvue时会暴漏问题,当nvue文件import a.js时,由于a.js中引入了main.js,**即使你只是引入没有任何调用**,这将导致App.vue再次初始化,onLaunch/onShow等生命周期将再次执行,这将导致存在两个APP生命周期

经测试发现此时调用  uni.navigateTo 等方法打开两个页面

## 只要项目中有nvue需求,就不要在纯js文件中,引入vuex

```javascript
// 不要在a.js文件中这么做
import store from '@/store'
```

在纯vue的uniapp项目中,这不是问题.

但当nvue调用a.js时获取到的vuex将是初始值,我暂时没有找到解决方法,

**如有在js中调用vue与nvue共享变量的需求,目前可以使用的有globalData和Storage,或修改函数将需要的参数在nvue/vue中获取并传入**

![vue与nvue共享变量.png][1]

## 谨慎使用750rpx这个像素值

首先来看官方对rpx的定义

> rpx 即响应式px，一种根据屏幕宽度自适应的动态单位。**以750宽的屏幕为基准，750rpx恰好为屏幕宽度。**屏幕变宽，rpx 实际显示效果会等比放大，**但在 App 端和 H5 端屏幕宽度达到 960px 时，默认将按照 375px 的屏幕宽度进行计算。**

着重理解加粗文字,750rpx为屏幕宽.若你使用的是uniapp的默认配置,这时会有一个很有意思的现象,750为屏幕宽,则uniapp会在处理750rpx这个特殊值时强制将其归一为当前屏幕宽度.

![uniapp特殊处理的750rpx.png][2]

当然对于一般的移动端H5页面这个问题是不存在的,但当在PC端浏览时这个特殊处理的值就会引起一些意想不到的问题了,比如这个宽750rpx高720rpx的“长方形”.

![特殊的长方形.png][3]

实际上这一问题在uniapp官方文档"宽屏适配指南"已经做过提醒了.

![特殊的长方形.png][4]

![特殊的长方形.png][5]

换句话说,这是个feature,而不是bug😅,那该如何修正这个问题呢?

实际上uniapp已经为这一问题做了优化,根据官方文档"宽屏适配指南"指出我们可以在 pages.json 的 globeStyle 里配置 rpx的相关参数

```json

{  
	"globalStyle": {    
		"rpxCalcMaxDeviceWidth": 960, // rpx 计算所支持的最大设备宽度，单位 px，默认值为 960
		"rpxCalcBaseDeviceWidth": 375, // rpx 计算使用的基准设备宽度，设备实际宽度超出 rpx 计算所支持的最大设备宽度时将按基准宽度计算，单位 px，默认值为 375
		"rpxCalcIncludeWidth": 750 // rpx 计算特殊处理的值，始终按实际的设备宽度计算，单位 rpx，默认值为 750
	}, 
}

```

我们可以根据项目实际情况进行配置,则如果我们想取消掉750rpx这个特殊值我们可以将“rpxCalcIncludeWidth”设置为0即可.

```json

{  
	"globalStyle": {    
		"rpxCalcMaxDeviceWidth": 375, // rpx计算所支持的最大设备宽度，单位 px，默认值为 960
		"rpxCalcBaseDeviceWidth": 375, // 即当屏幕宽超出rpxCalcMaxDeviceWidth配置宽后，将使用此参数为基础适配rpx
          "maxWidth": 375, // 更多时候我们只是希望移动端页面在PC端不会显示异常，因此我建议上述参数配合maxWidth参数使用，该参数理论上应该与rpxCalcBaseDeviceWidth保持一致，这个参数可以限制body的最大宽度，单位 px，默认1190
		"rpxCalcIncludeWidth": 0 // 将其设置为0可以解决750强制为屏幕宽的feature问题
	}, 
}

```

### 参考链接

- [uniapp尺寸单位]:https://uniapp.dcloud.io/frame?id=%e5%b0%ba%e5%af%b8%e5%8d%95%e4%bd%8d
- [宽屏适配指南]:https://uniapp.dcloud.io/adapt?id=_3-%e5%86%85%e5%ae%b9%e7%bc%a9%e6%94%be%e6%8b%89%e4%bc%b8%e7%9a%84%e5%a4%84%e7%90%86

[1]: /static/img/uniapp踩坑记录/1.png
[2]: /static/img/uniapp踩坑记录/2.png
[3]: /static/img/uniapp踩坑记录/3.png
[4]: /static/img/uniapp踩坑记录/4.png
[5]: /static/img/uniapp踩坑记录/5.png