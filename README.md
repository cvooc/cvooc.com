# cvooc.com
http://cvooc.com

```
hugo-project/
├── archetypes/        # 内容原型模板 hugo new命令使用
├── assets/            # 原始资源文件 通过Hugo管道处理
├── config/            # 配置文件目录
├── content/           # 网站内容文件 Hugo自动解析生成页面
├── data/              # 数据文件（JSON/YAML/CSV） 模板中可直接访问
├── docs/              # 项目文档
├── layouts/           # HTML模板文件 与内容结合生成HTML
├── public/            # 生成的静态网站
├── resources/         # 处理后的资源缓存
├── static/            # 静态资源文件 原样复制到public目录
├── themes/            # 主题目录 可继承和覆盖
├── .gitignore         # Git忽略文件
├── go.mod             # Go模块文件
├── go.sum             # Go模块依赖校验
├── hugo.toml          # Hugo主配置文件
└── README.md          # 项目说明文档
```