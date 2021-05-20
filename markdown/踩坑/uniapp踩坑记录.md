最后更新时间: {docsify-updated}

# 前言

本以为我对uniapp不说精通至少应该是熟悉了,不过最近接连踩坑,还是决定记录下目前我发现的在大前端开发中需要规避的问题.

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



[1]: /static/img/uniapp踩坑记录/1.png