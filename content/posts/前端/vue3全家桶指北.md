最后更新时间: 2021年5月20日 18:12:52

# Vue3全家桶指北

## 前言

`Vue3` 的出现完美的解决了 `Vue2` 在某些方面的缺陷，接下来让我们一起走进 `Vue3`，看它给我们带来了那些变化~

## Vue3与Vue2的比较

`Vue3` 比 `Vue2` 更快、更小，体积缩小了 `41%`，渲染速度提升 `33%`，内存用量下降 `54%`。更加灵活的 `Composition API` 以及完美支持 `TypeScript`。通过这些数字和优点，都是非常值得我们把 `Vue3`好好 学习一波！下面我们对 `Vue3` 里常见的 `Compsition API` 进行详解。

![img](static/img/vue3全家桶指北/1.jpg)

[Vue3中文文档](https://v3.cn.vuejs.org/)

### Composition API

[Composition API中文文档](https://v3.cn.vuejs.org/api/composition-api.html)

- setup

`setup` 函数是 **入口函数** ，在这个函数里我们可以定义变量、函数、生命周期等等，然后进行导出，就可以在页面上进行访问了。具体使用步骤如下：

```html
<template>
    <p>数字为：{{num}}</p>
    <p>两倍为：{{double}}</p>
    <button @click="sum">累加</button>
</template>
<script>
import { ref, onMounted, computed } from "vue"; // 导入Vue3中的核心方法
export default {
    ..., // 可以定义一些Vue2时的options
    setup() {
        const num = ref(666); // 定义一个响应式的常量
        
        const sum = (a, b) => a + b; // 定义一个方法
        
        const double = computed(() => num.value+1) // 定义一个计算属性
        
        onMounted(() => {
            console.log('页面加载完执行的生命周期钩子函数')
        })
        
        // ...等等都可以定义在setup函数中
        
        return { // 导出定义的变量和方法，在模板中使用
            num,
            sum,
            double
        }
    }
}
</script>
复制代码
```

**注意**：`setup` 函数可接受两个参数：`props` 、`context`；

1. `props` 表示父组件传递过来的属性，且值为响应式的，若修改其值页面将被更新。故，`props` 不能进行解构，但可以使用 `toRefs` 进行解构，否则它将失去响应式。
2. `context` 上下文，里面包含 `attrs` 、`slots`、`emit`等。它不是响应式的，故可以进行解构

当 `setup` 被执行时，组件实例未被创建，只能访问到以下属性：`props` 、`attrs`、`slots`、`emit`。不能访问到其他选项：`computed`、`methods`等。

> 接下来，我们将详细的解读一下 `Vue3` 中常见的核心方法！

- ref

> ref: 一般给基本数据类型的值设置为响应式的值

```html
<template>
    <p v-show="flag">是否显示</p>
    <p>我的名字：{{name}}</p>
    <p>我的年龄：{{age}}</p>
    <p ref="refDom">你好啊</p>
</template>
<script>
import { ref } from "vue";
export default {
    setup() {
        const flag   = ref(false); // 定义 Boolean 类型的变量
        const age    = ref(25);    // 定义 Number 类型的变量
        const name   = ref('tmc'); // 定义 String 类型的变量
        const refDom = ref(null);  // 可以访问到 Dom 元素
        
        return {
            flag,
            age,
            name,
            refDom
        }
    }
}
</script>
```

**注意**：`ref` 定义的变量，在模板中会被自动展开，故无需使用 `.value`；在 `setup` 函数中使用这些变量则不需要加 `.value`

- reactive

> reactive：一般给引用类型的值设置为响应式的值

```html
<template>
    <p>我的名字：{{state.name}}</p>
    <p>我的年龄：{{state.age}}</p>
</template>
<script>
import { reactive } from "vue";
export default {
    setup() {
        const state = reactive({
            name: 'tmc',
            age: 25
        })
        
        return {
            state
        }
    }
}
</script>
```

**注意**：

1. `reactive` 类似于 `Vue2` 中的 `Vue.observable()`
2. 若想在模块里使用简单，可使用 `toRefs` 进行导出
3. `ref(variable)` 等价于 `reactive({value: variable})`

- toRefs

> toRefs：将响应式对象转换成普通对象

```html
<template>
    <p>我的名字：{{name}}</p>
    <p>我的年龄：{{age}}</p>
</template>
<script>
import { toRefs, reactive } from "vue";
export default {
    setup() {
        const data = reactive({
            name: 'tmc',
            age: 25
        })
        
        return {
            ...toRefs(data)
        }
    }
}
</script>
```

**注意**：`toRefs` 返回时将属性都转换为 `ref` ;故，解构时也不会丢失其响应性

- toRaw

> `toRaw`：返回由 `reactive` 或 `readonly` 方法转换成响应式代理的普通对象

```html
<template>
    <!-- ... -->
</template>
<script>
import { toRaw, reactive, ref } from "vue";
export default {
    setup() {
        const data1 = reactive({
            name: 'tmc',
            age: 25
        })
        const data2 = ref(666)
        
        const changeData1 = toRaw(data1)
        const changeData2 = toRaw(data2.value)
        
        return {
            ...toRefs(data)
        }
    }
}
</script>
```

**注意**：当转换 `ref` 对象的时，需要传 `.value`

- provide & inject

> provide & inject：父组件通过provide选项提供数据，子组件通过inject选项接受并使用所提供的数据

![img](static/img/vue3全家桶指北/2.jpg)

```html
<!-- 父组件 -->
<template>
    <my-test></my-test>
</template>
<script>
import { provide } from "vue";
import MyTest from './MyTest';
export default {
    components: {
        MyTest
    },
    setup() {
        provide('name', 'tmc')
        // 可提供多个 provide
        return {
            // ...
        }
    }
}
</script>
```

**注意**：`provide` 接受两个参数，第一是 `key`，另一个是 `value`

```html
<!-- 子组件 -->
<template>
    <p> {{name}} </p>
</template>
<script>
import { inject } from "vue";
export default {
    components: {
        MyTest
    },
    setup() {
        const name = inject('name');
        // inject('name', 'xxx'); // 可指定默认值
        return {
            name
        }
    }
}
</script>
```

**注意**：`inject` 第一个参数是 `key`，第二个参数可指定默认值（可选）

**若想提供和注入响应式的值，可以在提供 `provide` 时使用 `ref` 和 `reactive`**

- computed

> computed：计算属性可参考上面的例子

- watch & watchEffect

> 用法：watch( source, cb, [options] )

1. `watch` 监听 `ref` 创建的响应式数据

   ```html
   <template>
       <!-- ... -->
   </template>
   <script>
   import { watch, ref } from "vue";
   export default {
       setup() {
           const name = ref('tmc');
              
           watch(name, (newVal, oldVal) => {
               console.log('新值：' + newVal)
               console.log('旧值：' + oldVal)
           })
              
       }
   }
   </script>
   ```

2. `watch` 监听 `reactive` 创建的响应式数据

   ```html
   <template>
       <!-- ... -->
   </template>
   <script>
   import { watch, reactive } from "vue";
   export default {
       setup() {
           const data = reactive({
               name: 'tmc',
               age: 25
           });
              
           // 监听单个属性
           watch(() => data.name, (newVal, oldVal) => {
               console.log('新值：' + newVal)
               console.log('旧值：' + oldVal)
           })
              
           // 监听多个属性
           watch(() => [data.name, data.age], ([newName, oldName], [newAge, oldAge]) => {
               console.log('新值：' + newName)
               console.log('旧值：' + oldName)
               console.log('新值：' + newAge)
               console.log('旧值：' + oldAge)
           })
              
       }
   }
   </script>
   ```


**`watch`、`watchEffect` 会返回一个用于停止这个监听的函数 `stop`，可用户停止监听。**

**注意**：`watch` 和 `watchEffect` 的区别？

1. `watch` 是需要传入监听的属性，而 `watchEffect` 是自动收集依赖
2. `watch` 可以看到属性前后变化的值，而 `watchEffect` 没有
3. `watch` 是属性改变的时候执行，而 `watchEffect` 默认就会执行一次，且属性变动也会执行

- ...

更多 `Composition API` 的用法和注意事项请参考 [Vue 组合式 API](https://vue3js.cn/vue-composition-api/)

### 生命周期

> 各生命周期的基本用法：

```html
<template>
    <!-- ... -->
</template>
<script>
import { onMounted, onUpdated, onUnmounted } from "vue";
export default {
    setup() {
        onMounted(() => {
          console.log('mounted!')   // 挂载
        })
        onUpdated(() => {
          console.log('updated!')   // 更新
        })
        onUnmounted(() => {
          console.log('unmounted!') // 销毁
        })
    }
}
</script>
```

> **与 2.x 版本** 的差异

- ~~beforeCreate~~ -> 使用 `setup`
- ~~created~~ -> 使用 `setup`
- `beforeMount` -> `onBeforeMount`
- `mounted` -> `onMounted`
- `beforeUpdate` -> `onBeforeUpdate`
- `updated` -> `onUpdated`
- `beforeDestroy` -> `onBeforeUnmount`
- `destroyed` -> `onUnmounted`
- `errorCaptured` -> `onErrorCaptured`

新增的钩子函数：

- onRenderTracked
- onRenderTriggered

### 自定义函数 Hooks

> 下拉加载更多

```js
// hooks/useLoadMore.ts
import { computed, onMounted, Ref } from 'vue';
import { IGlobalState } from '@/store';
import { Vuex } from 'vuex';
import _ from 'lodash';
export function useLoadMore(refreshEle: Ref<null | HTMLElement>, store: Store<IGlobalState>, type: string) {
    let element: HTMLElement; // 需要滚动的元素
    

    function _loadMore() {
        let containerHeight = element.clientHeight; // 获取可视区域的高度
        let scrollTop = element.scrollTop; // 获取滚动的高度
        let scrollHeight = element.scrollHeight; // 获取这个列表的高度
        
        if(containerHeight + scrollTop + 25 >= scrollHeight) {
            store.dispatch(type); // 派发action
        }
    }
    
    onMounted(() => {
        element = refreshEle.value as HTMLElement;
        
        element.addEventListener('scroll', _.debounce(_loadMore, 200)); // 防抖
    })
    
    // 可更改loading、hasMore等状态
    const isLoading = computed(() => {
        return store.state.home.homeList.loading
    })
    const hasMore = computed(() => {
        return store.state.home.homeList.hasMore
    })
}
```

在页面中使用

```html
// index.vue
<template>
	...
    <div ref="refreshEle">
        ...
        <HomeList :xxx="xxx"></HomeList>
        ...
    </div>
    ...
</template>
<script lang="ts">
import { defineComponent, ref } from 'vue';
import { Store, useStore } from 'vuex';
import { IGlobalState } from '@/store';
import { useLoadMore } from '@/hooks/useLoadMore';
export default defineComponent({
    ...
    setup() {
    	let store = useStore<IGlobalState>();
   		let refreshEle = ref<null | HTMLElement>(null);
    	const { isLoading, hasMore } = useLoadMore(refreshEle, store, `home/${types.SET_HOME_LIST}`);

    	return {
            refreshEle,
            isLoading,
            hasMore
        }
    }
    ...
})
</script>
```

### 内置组件

> Teleport 瞬移组件

- `Teleport` 可以将模块移动到当前 `DOM` 元素之外的其他位置的技术

```html

// index.html
<html>
    ...
    <div id="app"></div>
    <div id="teleport-toast"></div>
</html>
// components/index.vue
<button @click="showToast">显示toast</button>
<teleport to="#teleport-toast">
    <div v-show="showFlag">
        <div>
            显示 Toast 内容
        </div>
    </div>
</teleport>
```

```typescript
import { defineComponent, ref } from 'vue';
export default defineComponent({
	setup() {
        const showFlag = ref(false);
        const showToast = (() => {
        	showFlag.value = true;    
        });
        
        return {
            showFlag,
            showToast
        }
    }  
})
```

**总结**：使用 `teleport` 组件，通过 `to` 属性，手动指定该组件渲染的位置与 `<div id="app"></div>` 同级，但 `teleport` 的状态 `showFlag` 又是完全由内部 `Vue` 组件控制，这就很 Nice~啦！

> Suspense 异步加载组件

```html
<Suspense>
    <!-- #default可不写 -->
	<template #default>
    	<xxxx>某某组件</xxxx>
    </template>
    <template #fallback>
    	<div>Loading...</div>
    </template>
</Suspense>
```

**注意**：`#default`、`#fallback`是采用具名插槽的简写；例：`v-slot:tmc` === `#tmc`

**扩展**：`React` 中也包含 `<Suspense>` 组件，常与 `React.lazy()` 连用

```js
// 基本用法
import React, { Suspense } from 'react';

const Page = React.lazy(() => import('./Page'));

<Suspense fallback={<div> Loading... </div>}>
	<Page />
</Suspense>
```

`Vue3` 中的 `defineAsyncComponent` 与 `React.lazy()` 类似

> Fragement

在 `Vue2.x` 时，组件只能有一个根 `DOM` ，在 `Vue3` 中，组件可以存在多个根 `DOM`

### 全局 API

- getCurrentInstance
- 注册组件方式的改变

```typescript
// Vue2 使用 Vue.component 方法
import Vue from 'vue';
import Test from './Test.vue';

Vue.component('Test', Test);

// Vue3 使用 createApp().component 方式
import { createApp, h } from 'vue';
import Test from './Test.vue';

createApp(Test).component('Comp', { render: () => h('div', '自定义组件') })
```

- 部分 `API` 的使用方式改变（为了 `tree-shaking` ）

```typescript
// Vue2
import Vue from 'vue';

Vue.nextTick(() => {})

// Vue3
import { nextTick } from 'vue';

nextTick(() => {})
```

- 应用实例

```typescript
import { createApp } from 'vue';
const app = createApp(); // app 为应用实例
```

| Vue2.x全局API            | Vue3的应用实例API          |
| ------------------------ | -------------------------- |
| Vue.config               | app.config                 |
| Vue.config.productionTip | **移除**                   |
| Vue.use                  | app.config.isCustomElement |
| Vue.component            | app.use                    |
| ...                      | ...                        |

**注意**：

1. `Vue3` 移除了 `$on/$once/$off` 和 `Vue.filter`

## Vue-Router

[Vue-Router 官方地址](https://vue3js.cn/router4/)

### 基本用法

```js
import { createRouter, createWebHashHistory } from 'vue-router';
import Home from '@/views/home.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/about',
        name: 'About',
        component: () => import(/* webpackChunkName: "about" */ '../views/About.vue');
    }
]

const router = createRouter({
    histroy: createWebHashHistory(),
    routes
})

export default router;
```

## Vuex

[Vuex 官方地址](https://next.vuex.vuejs.org/)

### 基础用法

```js
// store
import { createStore } from 'vuex';

export default createStore({
	state: {}, // 状态
    getters: {}, // 获取状态
	mutations: {}, // 同步修改状态
    actions: {}, // 异步修改状态
    modules: {} // 模块
})
复制代码
// template
<template>
    ...
</template>
<script>
import { useStore } from 'vuex';
export default defineComponent({
    setup() {
        const store = useStore(); // 创建store实例
        ...
    }
})
</script>
```

### 完整 Store 的结构设计

> 若项目比较小，可参考这种目录结构

在 `store` 目录下创建四个子目录和一个文件，分别是：

1. `state`：存放项目中使用的状态
2. `getters`：将一些状态做一些处理在使用
3. `mutations`：同步的修改状态
4. `actions`：异步的修改状态
5. `index.js` 文件：用于整合 `state`、`getters`、`mutations`、`actions`

> 若项目比较大，可参考这种目录结构

在 `store` 目录下创建一个目录和一个文件，分别是：

1. `modules`：存放项目的某一个比较大的模块，如：首页、我的...
2. `index.js` 文件：用于整合 `modules` 模块

不熟练 `Vuex` 的小伙伴，可以阅读下这篇文章：[掌握工作中Vuex核心API用法以及基本原理](https://juejin.cn/post/6844904117135998983)

## Vue2.x & Vue3

1. `Vue2.0` 采用 `flow` 进行编写，而 `Vue3.0` 源码全部采用 `TypeScript` 进行开发，对TS支持友好（所有属性都放在 `this` 对象上，难以推到组件的数据类型）
2. 源码体积优化：移除部分 `api(filter)`，使用 `tree-shaking`（大量的 `API` 挂载在 `Vue` 对象的原型上，难以实现 `TreeShaking`）
3. 数据劫持优化：`Vue3` 采用 `Proxy`，性能大大提升
4. 编译优化：`Vue3` 实现了静态模板分析、重写diff算法
5. `Composition API`：整合业务代码的逻辑，提取公共逻辑（受 `React Hooks`启发。`Vue2` 采用 `mixin` - 命名冲突&数据来源不清晰）
6. 自定义渲染器：可以用来创建自定义的渲染器，改写Vue底层渲染逻辑
7. 新增 `Fragment`、`Teleport`、`Suspense` 等内置组件

## 总结

学一门新的技术最好的办法就是使用该技术自己写一个项目，慢慢的摸索，不断的爬坑就慢慢的都会了~