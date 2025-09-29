最后更新时间: 2020年10月24日 21:35:00

# 使用github action自动部署项目至服务器

`github action` 是基于 `GitHub` 的持续集成服务。 他提供一台服务器实例，再这个实例中允许通过 `actions` 来执行一个或者多个命令， 从而达到像抓取代码、运行测试、登录远程服务器、发布项目等功能。

## github action的组成

1. `workflow` (工作流): 每个需要单独运行的集成服务，就是一个 workflow
2. `job` (任务)： 一个 `workflow` 由一个或多个 `jobs` 构成，含义是一次持续集成的运行，可以完成多个任务。
3. `step` (步骤)：每个 `job` 由多个 `step` 构成，一步步完成。
4. `action` (动作)：每个 `step` 可以依次执行一个或多个命令（ `action` ）。

## git action 文件 - workflow

`github actions` 的配置文件是 `workflow` 文件, 存放在仓库中的 `.gihub/workflows` 目录中。

根据需求， `workflow` 可以创建多个。 `workflow` 规定使用 `YAML` 格式，文件名可以根据集成服务的功能任意取， 但是后缀必须使用 `.yml`。 `GitHub` 只要发现 `.github/workflows` 目录中存在就会自动运行这些文件。

## 常见的 workflow 配置字段

### name

`workflow` 的名称。如果省略该字段，默认为当前 `workflow` 的文件名。

```yml
name: GitHub Actions Demo
```

### on

定义触发事件的` git hook`, 可以是单个 `hook` 名称或多个

```yml
# push  时触发事件
on:push

# push 和 pull 时都出发事件
on: [push, pull_request]
```

定义事件时，还可以限定分支和标签

```yml
on:
  push:
    branches:
      - master
```

### jobs

`workflow` 文件的主体是 `jobs` 字段，表示要执行的一项或多项任务。

`jobs` 字段里面，需要写出每一项任务的 `job_id` ，具体名称自定义。 `job_id` 里面的 `name` 字段是任务的说明。

```yml
jobs:
  # 定义的第一个任务 
  my_first_job:
    name: My first job
  
  # 定义的第二个任务
  my_second_job:
    name: My second job
```

***jobs.<job_id>.needs*** needs字段指定当前任务的依赖关系，即运行顺序。

```yml
jobs:
  job1:
  job2:
    needs: job1
  job3:
    needs: [job1, job2]
```

上面代码中， `job1` 必须先于 `job2` 完成，而 `job3` 等待 `job1` 和 `job2` 的完成才能运行。因此，这个 `workflow` 的运行顺序依次为： `job1` `、job2` `、job3` 。

***jobs.<job_id>.runs-on*** runs-on 字段指定运行所需要的虚拟机环境，他是必填字段，目前可以选择：

```yml
ubuntu-latest，ubuntu-18.04或ubuntu-16.04

windows-latest，windows-2019或windows-2016

macOS-latest或macOS-10.14
```

***jobs.<job_id>.steps***

`steps` 字段指定每个 `Job` 的运行步骤，可以包含一个或多个步骤。每个步骤都可以指定以下三个字段。

```yml
jobs.<job_id>.steps.name：步骤名称。
jobs.<job_id>.steps.run：该步骤运行的命令。
jobs.<job_id>.steps.use：该步骤运行的 action。
jobs.<job_id>.steps.env：该步骤所需的环境变量。
```

> 每一个 `steps` 中必须存在一个 `run` 或者 一个 `action`

一个完整的 workflow 文件如下：

***。github/workflows/main.yml***

```yml
name: first github action workflow
on:
  push:
    branches:
      - master

jobs:
  first-job:
    name: my first job demo
    runs-on: ubuntu-latest
    steps:

    - name: first-action
      run:  |
        echo hello world
```

## 使用环境变量

配置环境变量的方式有两种：

1. 在 env 中直接定义变量和变量的值， 通过 $XXX 的方式使用。

```yml
# 这里是 steps 中的一个步骤

  - name： env-demo
    env:
      FIRSTNAME: hello
      LASTNAME: world
    run: |
      echo $FIRSTNAME  $LASTNAME
```

1. 通过项目中 Secrets 设置变量 XXX， 在配置中通过 ${{ XXX }}  的方式获取。这种变量定义适用于那些涉及到隐私数据的情况。

![img](./static/img/GithubAction自动部署/1.png)

```yml
# 这里是 steps 中的一个步骤

  - name： env-demo
    env:
      FIRSTNAME: hello
      LASTNAME: world
    run: |
      echo $ACCESS_TOKEN  
```

## 实现自动部署流程

1. 声明 `workflow` 名称、事件触发配置。
2. 配置 `job` 名称、依赖环境。
3. `steps` 配置。

以 `react` 项目为例， `steps` 应该按照以下步骤配置:

## 将项目部署到 GitHub Pages 配置

```yml
name: github actions build and deploy gh-pages
on:
  push: 
    branches:
      - master
jobs:
  build_and_deploy:
    runs-on: ubuntu-latest

    steps:
       # 1. 获取源码， 这里需要将仓库代码检出到虚拟机实例中
      - name: Checkout 🛎️
        uses: actions/checkout@v2.3.1
        with:
        # 来自官网：如果您正在使用actions/checkout@v2，那么在大多数情况下，您必须将持久凭证设置为false，才能使部署正确工作
          persist-credentials: false
      
      # 2. 执行 react 项目中的 依赖包安装和构建
      - name: Install and Build 🔧
        run: |
          npm install
          npm run build
        
      # 3. 将打包后的代码部署到 gh-pages 分支
      - name: Deploy 🚀
        uses: JamesIves/github-pages-deploy-action@3.5.7
        with:
          # 为了让 GitHub触发重新构建页面，您必须使用存储库提供的GitHub令牌来提供操作, GITHUB_TOKEN 是系统默认提供的  不需要单独配置环境变量
          GITHUB_TOKEN: ${{ secrets.GITHUB_TOKEN }}
          BRANCH: gh-pages 
          FOLDER: dist 
```

## 将项目部署到 私服

将项目部署到私服的步骤和部署的 `gh-pages` 的步骤差不多， 区别是我们需要配置更多的环境变量来配合服务器的登录。 这里使用 [ssh-deploy](https://github.com/easingthemes/ssh-deploy) `action` 进行私服的部署。

`ssh-deploy` 参数说明：

1. `SSH_PRIVATE_KEY`, `required`

`ssh-deploy` 使用 `ssh` 的方式登录远端服务器， 这里需要配置 ***已经存放到远端服务器 ~/.ssh/authorized_keys 文件中某条公钥记录对应的私钥***. 这里一定要配置对，否则 `github action` 进入不了服务器。

如果在服务器中没有 `authorized_keys` 文件，或者该文件中不存在记录，可以新建 `authorized_keys` 文件，并在文件中添加一个本地电脑的公钥信息。

本地公钥添加到服务器 `authorized_keys` 的方法

```bash
  ssh-copy-id user@host  # user@host 服务器的用户名和 host 地址
```

按照上面的方式，在服务器 `authorized_keys` 中添加了本地公钥，那么这里在 `GitHub` 中配置 `SSH_PRIVATE_KEY` 的值就是本地的私钥。

1. `REMOTE_HOST`,  `required`

服务器地址：比如 172.0.0.1

1. `REMOTE_USER` `required`

登陆服务器的用户名

1. `REMOTE_PORT`  default '22'

登录服务器的端口， 默认值 22

1. `ARGS` (optional, default '-`rltgoDzvO`')

这个暂时没有搞懂

1. `SOURCE`  default ''

源码文件路径，默认执行 `GITHUB_WORKSPACE` 仓库根目录, react 打包后的文件在根目录的 build 目录，这里可以配置成 `build/`

1. `TARGET` default '`/home/REMOTE_USER/`'

目标文件路径，即将 `SOURCE` 文件打包到服务器的哪个地址， 如果使用 `nginx` 作为项目的静态文件服务器， 这里就可以指向 `nginx` 配置的静态文件地址

> 重点一：  这里的 `SSH_PRIVATE_KEY` 是一个 `ssh` 私钥， 它对应的是已经在服务器中的 `ssh authorized_keys` 存在的公钥对应的私钥。

> 重点二： 虽然环境变量可以在 `steps` 中的 `env` 字段中定义， 但是 `ssh-deploy` 中涉及到服务器的隐私信息，这里要用  `secrets` 的方式配置

配置文件：

```yml
name: newBlog deploy shell

on:
  push:
    branches: 
      - new

jobs:
  setup-build-publish-deploy:
    name: Setup, Build, Publish, and Deploy
    runs-on: ubuntu-latest
    steps:

    - name: Checkout
      uses: actions/checkout@v2
      with:
        persist-credentials: false

    - name: Install and build 🔧
      run: |
        yarn 
        yarn build

 # 区别从这里开始       
    
    - name: Deploy to Server 🚀
      # 这里使用 ssh-deploy action
      uses: easingthemes/ssh-deploy@v2.1.5
      env: 
        SSH_PRIVATE_KEY: ${{ secrets.SSH_PRIVATE_KEY }}
        SOURCE: "build/"
        REMOTE_HOST: ${{ secrets.REMOTE_HOST }}
        REMOTE_USER: ${{ secrets.REMOTE_USER }}
        TARGET: ${{ secrets.REMOTE_TARGET }}
```

## 本站正在使用的部署配置

这是一个简单的示例,将源码模式的项目,如php文件部署至私有服务器


```yml
name: retrocode.io to cloud.tencent
on:
  push:
    branches:
      - main
jobs:
  build:
    # 运行环境:ubuntu
    runs-on: ubuntu-latest
    steps:
      - name: 获取项目源码
        uses: actions/checkout@main
      - name: use Node.js 10
        uses: actions/setup-node@v1
        with:
          node-version: 10
      - name: 校验源码目录
        run: |
          ls -l /home/runner/work/retrocode.io/retrocode.io
      - name: 导出源码至轻量云
        uses: easingthemes/ssh-deploy@v2.1.5
        env:
          SSH_PRIVATE_KEY: ${{ secrets.ACCESS_TOKEN }}
          # 使用--chown命令设置同步后的项目所有者
          ARGS: "-avz --chown=lighthouse:lighthouse --delete"
          # 直接部署整个项目
          SOURCE: ""
          REMOTE_HOST: ${{ secrets.REMOTE_HOST }}
          REMOTE_USER: ${{ secrets.REMOTE_USER }}
          TARGET: ${{ secrets.TARGET }}
```

