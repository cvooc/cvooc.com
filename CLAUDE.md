# CLAUDE.md

此文件为 Claude Code (claude.ai/code) 在此代码库中工作时提供指导。

## Hugo 静态网站命令

这是一个基于 Hugo 的静态网站博客。常用开发命令：

```bash
# 安装 Hugo（如果未安装）
# Windows: choco install hugo
# macOS: brew install hugo

# 启动开发服务器（支持热重载）
hugo server -D --buildDrafts

# 构建生产环境网站
hugo

# 创建新内容
hugo new posts/category/title.md

# 清理构建缓存和 public 目录
hugo --gc --cleanDestinationDir

# 指定环境运行
hugo server --environment=development

# 构建到指定目录
hugo --destination ./public

# 新建文章（推荐格式）
hugo new posts/分类/文章标题.md
```

## 项目架构

这是一个基于 **Hugo 静态网站生成器**的中文技术博客项目。架构遵循 Hugo 的标准约定：

### 核心配置
- **`config.toml`**: Hugo 主配置文件，包含网站元数据、菜单结构和构建设置
- **语言**: 中文内容 (zh-cn)，启用了 `buildFuture = true` 允许未来日期的文章
- **主题**: 自定义主题（未使用外部 Hugo 主题）

### 内容结构
- **`content/`**: 按章节组织的 Markdown 文件
  - `posts/`: 按主题分类的博客文章
    - `Java/`: Java 编程相关
    - `前端/`: 前端开发相关
    - `Cocos/`: Cocos 游戏开发
    - `踩坑/`: 问题解决记录
    - `花活/`: 创意实现
    - `技巧/`: 开发技巧
    - `杂记/`: 其他笔记
  - `pages/`: 静态页面（关于页面、备忘录等）
  - `_index.md`: 首页内容

### 布局系统
- **`layouts/`**: 自定义 HTML 模板（Hugo Go 模板）
  - `home.html`: 首页模板，显示最新文章
  - `single.html`: 单篇文章/页面模板
  - `list.html`: 列表页面模板（文章列表、标签列表等）
  - `_partials/`: 可重用组件
    - `head.html`: HTML 头部
    - `header.html`: 网站头部
    - `footer.html`: 网站底部
    - `comments.html`: 评论组件
    - `social-icons.html`: 社交媒体图标
  - `_shortcodes/`: 自定义短代码
    - `memos.html`: 备忘录组件
    - `tag_links.html`: 标签链接组件

### 样式系统
- **`assets/styles.scss`**: 使用 Gruvbox 主题的主 SCSS 样式文件
- **静态资源**: 存储在 `static/` 目录中
- **语法高亮**: 配置为 Gruvbox 主题

### 核心功能与集成
- **评论系统**: 基于 GitHub 的评论系统（giscus）已启用
- **分析统计**: 集成 Umami 网站分析
- **SEO 优化**: 结构化数据、网站地图、RSS/Atom 订阅源
- **社交媒体**: 社交媒体链接和分享功能
- **分类系统**: 标签系统用于内容分类

## 开发注意事项

### 内容创建
- 所有内容均为 Markdown 格式，包含 frontmatter 元数据
- 使用 `hugo new posts/分类/文章标题.md` 创建新文章
- 文章按子目录组织在 `content/posts/` 中
- 支持未来日期文章发布 (`buildFuture = true`)

### 构建流程
- Hugo 将 Markdown 内容通过 HTML 模板处理
- SCSS 文件通过 Hugo 资源管道处理
- 静态文件直接复制到输出目录
- 最终输出到 `public/` 目录

### 模板架构
- 使用 Hugo 模板层次结构和 Go 模板语法
- 大量使用 partials 进行组件化组织
- 提供自定义短代码用于特殊内容渲染
- 响应式设计，支持移动端友好布局

### 部署相关
- 静态网站部署（支持 GitHub Pages、Netlify 等）
- 构建输出在 `public/` 目录
- 包含 SEO 优化和分析追踪功能

### 本地开发工作流
1. 使用 `hugo server` 启动本地开发服务器
2. 编辑 Markdown 文件创建内容
3. 修改模板或样式文件进行定制
4. 使用 `hugo` 构建生产环境版本
5. 部署 `public/` 目录到静态托管服务