---
title: IE11下vw会使line-height失效的问题
tags:
  - IE
  - CSS
categories: 前端技术
date: 2018-10-28 15:12:50
---
# 前言

目前遇到了一个诡异的BUG,在IE11下若CSS样式 line-height 使用的是vw单位,那么在地址栏输入地址后点击回车跳转,会发现line-height失效.此时若F5或者点击刷新键刷新,会发现样式恢复正常.

并且若点开开发者工具查看,会发现line-height样式是选中启用但未生效,若点击取消line-height样式后,再次点击启用,会发现样式恢复正常.

猜测可能是其他样式影响,暂时先做记录.之后在研究.