+++
author = "cvooc"
title = "IE11下vw会使line-height失效的问题"
date = "2018-07-16 17:38:25"
description = "IE11下vw会使line-height失效的问题"
tags = [
    "踩坑",
    "css",
    "IE"
]
+++

# 前言

目前遇到了一个诡异的 BUG,在 IE11 下若 CSS 样式 line-height 使用的是 vw 单位,那么在地址栏输入地址后点击回车跳转,会发现 line-height 失效.此时若 F5 或者点击刷新键刷新,会发现样式恢复正常.

并且若点开开发者工具查看,会发现 line-height 样式是选中启用但未生效,若点击取消 line-height 样式后,再次点击启用,会发现样式恢复正常.

猜测可能是其他样式影响,暂时先做记录.之后在研究.
