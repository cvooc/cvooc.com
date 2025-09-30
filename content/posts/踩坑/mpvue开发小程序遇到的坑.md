最后更新时间: 2018年11月29日 17:38:10

# 前言 
此文章在于整理小程序开发中遇到的一些坑,,希望能帮助你们.

## 在app.json中添加tabBar时第一个一定是要是最先显示的，否则会出现tabBar消失的BUG!
第一个一般都是首页,故以首页为例.
```json
{
	"pages": [
		"pages/index/main",
		......
	],
	"window": {
		......
	},
	"tabBar": {
		"color": "#dddddd",
		"selectedColor": "#459ae9",
		"borderStyle": "black",
		"backgroundColor": "#ff0000",
		"position": "bottom",
		"list": [{
				"pagePath": "pages/index/main",
				"iconPath": "......",
				"selectedIconPath": "......",
				"text": "首页"
			}
			......
		]
	}
}
```

## 切记!这些vue组件名有坑!

这切组件名是mpvue,vue及小程序的保留关键字,万万不可起,当出现迷之BUG时,尽量先确认下这些问题!

### vue的保留关键字
```js
// 区分大小写
    var isHTMLTag = makeMap(
'html,body,base,head,link,meta,style,title,'+'address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,'+'div,dd,dl,dt,figcaption,figure,hr,img,li,main,ol,p,pre,ul,'+'a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,'+'s,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,'+'embed,object,param,source,canvas,script,noscript,del,ins,'+'caption,col,colgroup,table,thead,tbody,td,th,tr,'+'button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,'+'output,progress,select,textarea,'+'details,dialog,menu,menuitem,summary,'+'content,element,shadow,template'
    );
// 不区分大小写
    var isSVG = makeMap(
'svg,animate,circle,clippath,cursor,defs,desc,ellipse,filter,font,'+'font-face,g,glyph,image,line,marker,mask,missing-glyph,path,pattern,'+'polygon,polyline,rect,switch,symbol,text,textpath,tspan,use,view',true
    );
    var isReservedTag = function (tag) {
    return isHTMLTag(tag) || isSVG(tag)
    };
// 区分大小写
    var isBuiltInTag = makeMap('slot,component', true);
```
### mpvue的保留关键字
```css
a,canvas,cell,content,countdown,datepicker,div,element,embed,header,image,img,indicator,input,link,list,loading-indicator,loading,marquee,meta,
refresh,richtext,script,scrollable,scroller,select,slider-neighbor,
slider,slot,span,spinner,style,svg,switch,tabbar,tabheader,template,text,textarea,timepicker,trisition-group,trisition,video,view,web,
```

### 微信自带组件名

```css
view,scroll-view,swiper,movable-view,cover-view,icon,text,rich-text,
progress,button,checkbox,form,input,label,picker,picker-view,
radio,slider,switch,textarea,navigator,audio,image,video,camera,
live-player,live-pusher,map,open-data,web-view,ad,
```

